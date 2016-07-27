<?php



namespace Hazzard\Comments\Settings;

use Illuminate\Database\ConnectionInterface;
use Illuminate\Contracts\Cache\Repository as Cache;
use Illuminate\Contracts\Config\Repository as Config;

class Repository
{
    /**
     * @var string
     */
    protected $cacheKey = 'comments_settings';

    /**
     * @var string
     */
    protected $table = 'comments_settings';

    /**
     * @var array
     */
    protected $items = [];

    /**
     * @var \Illuminate\Database\ConnectionInterface
     */
    protected $conn;

    /**
     * @var \Illuminate\Contracts\Cache\Repository
     */
    protected $cache;

    /**
     * @var \Illuminate\Contracts\Config\Repository
     */
    protected $config;

    /**
     * Create a new settings repository instance.
     *
     * @param \Illuminate\Database\ConnectionInterface $conn
     * @param \Illuminate\Contracts\Config\Repository  $config
     * @param \Illuminate\Contracts\Cache\Repository   $cache
     */
    public function __construct(ConnectionInterface $conn, Config $config, Cache $cache)
    {
        $this->conn = $conn;
        $this->cache = $cache;
        $this->config = $config;
    }

    /**
     * Load the settings from database.
     *
     * @return void
     */
    public function load()
    {
        $items = $this->cache->rememberForever($this->cacheKey, function () {
            return $this->query()->get();
        });

        foreach ($items as $item) {
            $value = $this->castValue($item->value, $item->type);

            $this->config->set('comments.' . $item->key, $value);
        }
    }

    /**
     * Save the settings into database.
     *
     * @return void
     */
    public function save()
    {
        foreach ($this->items as $key => $value) {
            $this->updateOrInsert($key, $value);
        }

        $this->flush();
    }

    /**
     * Set a given configuration value.
     *
     * @param  array|string $key
     * @param  mixed $value
     * @return void
     */
    public function set($key, $value = null)
    {
        if (is_array($key)) {
            foreach ($key as $innerKey => $innerValue) {
                $this->items[$innerKey] = $innerValue;
            }
        } else {
            $this->items[$key] = $value;
        }
    }

    /**
     * Delete option from database.
     *
     * @param  string $key
     * @return void
     */
    public function delete($key)
    {
        $this->query()->where('key', $key)->limit(1)->delete();

        $this->flush();
    }

    /**
     * Clear all settings from database.
     *
     * @return void
     */
    public function clear()
    {
        $this->query()->delete();

        $this->flush();
    }

    /**
     * Update or insert item.
     *
     * @param  string $group
     * @param  string $key
     * @param  mixed  $value
     * @return void
     */
    protected function updateOrInsert($key, $value)
    {
        $type = gettype($value);

        if ($type === 'array' || $type === 'object') {
            $value = json_encode($value);
        }

        if ($this->query()->where('key', $key)->first()) {
            $this->query()->where('key', $key)->limit(1)
                ->update(compact('value', 'type'));
        } else {
            $this->query()->insert(compact('key', 'value', 'type'));
        }
    }

    /**
     * Create a new query.
     *
     * @return \Illuminate\Database\Query\Builder
     */
    public function query()
    {
        return $this->conn->table($this->table);
    }

    /**
     * Cast a value to a native PHP type.
     *
     * @param  string $value
     * @param  mixed  $type
     * @return mixed
     */
    protected function castValue($value, $type)
    {
        if (is_null($value)) {
            return $value;
        }

        switch ($type) {
            case 'int':
            case 'integer':
                return (int) $value;

            case 'real':
            case 'float':
            case 'double':
                return (float) $value;

            case 'string':
                return (string) $value;

            case 'bool':
            case 'boolean':
                return (bool) $value;

            case 'object':
                return json_decode($value);

            case 'array':
            case 'json':
                return json_decode($value, true);

            default:
                return $value;
        }
    }

    /**
     * Flush all cached settings.
     *
     * @return void
     */
    public function flush()
    {
        $this->cache->forget($this->cacheKey);
    }

    /**
     * @return array
     */
    public function config()
    {
        return $this->config['comments'];
    }
}

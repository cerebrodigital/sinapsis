<?php

/**
 * This file is part of Ajax Comment System for Laravel™.
 *
 * (c) HazzardWeb <hazzardweb@gmail.com>
 *
 * For the full copyright and license information, please visit:
 * http://codecanyon.net/licenses/standard
 */

namespace Hazzard\Comments\Formatter;

use s9e\TextFormatter\Unparser;
use s9e\TextFormatter\Configurator;
use Illuminate\Contracts\Cache\Repository;
use Hazzard\Comments\Events\FormatterConfigurator;
use s9e\TextFormatter\Configurator\Bundles\MediaPack;

class Formatter
{
    /**
     * @var array
     */
    protected $config;

    /**
     * @var \Illuminate\Contracts\Cache\Repository
     */
    protected $cache;

    /**
     * Create a new formatter instance.
     *
     * @param array $config
     */
    public function __construct(array $config, Repository $cache)
    {
        $this->cache = $cache;
        $this->config = $config;
    }

    /**
     * Parse the text into an XML document.
     *
     * @param  string $text
     * @return string
     */
    public function parse($text)
    {
        return $this->getParser()->parse($text);
    }

    /**
     * Transform the XML document into HTML.
     *
     * @param  string $xml
     * @return string
     */
    public function render($xml)
    {
        $render = $this->getRenderer();

        return $render->render($xml);
    }

    /**
     * Transform the XML document back into plain text.
     *
     * @param  string $xml
     * @return string
     */
    public function unparse($xml)
    {
        return Unparser::unparse($xml);
    }

    /**
     * Flush the text formatter cache.
     *
     * @return void
     */
    public function flush()
    {
        $this->cache->forget('comments.formatter.parser');

        $this->cache->forget('comments.formatter.renderer');
    }

    /**
     * Get the text parser instance.
     *
     * @return \s9e\TextFormatter\Parser
     */
    public function getParser()
    {
        return $this->getComponent('parser');
    }

    /**
     * Get the HTML renderer instance.
     *
     * @return \s9e\TextFormatter\Renderer
     */
    public function getRenderer()
    {
        spl_autoload_register(function ($class) {
            $file = storage_path('app') . DIRECTORY_SEPARATOR . $class . '.php';

            if (file_exists($file)) {
                include $file;
            }
        });

        return $this->getComponent('renderer');
    }

    /**
     * Get configurator component.
     *
     * @param  string $key
     * @return mixed
     */
    protected function getComponent($key)
    {
        $cacheKey = 'comments.formatter.' . $key;

        return $this->cache->rememberForever($cacheKey, function () use ($key) {
            return $this->getConfigurator()->finalize()[$key];
        });
    }

    /**
     * Get a new text formatter configurator instance.
     *
     * @return \s9e\TextFormatter\Configurator
     */
    protected function getConfigurator()
    {
        $configurator = new Configurator;
        $configurator->rootRules->enableAutoLineBreaks();

        $configurator->rendering->engine = 'PHP';
        $configurator->rendering->engine->cacheDir = storage_path('app');

        $configurator->Escaper;

        if ($this->config['censor']) {
            foreach ($this->config['censored_words'] as $word) {
                $configurator->Censor->add($word);
            }
        }

        if ($this->config['auto_email']) {
            $configurator->Autoemail;
        }

        if ($this->config['auto_link']) {
            $configurator->Autolink;
        }

        if ($this->config['auto_image']) {
            $configurator->Autoimage;
        }

        if ($this->config['media_embed']) {
            $configurator->MediaEmbed->createIndividualBBCodes = true;
            (new MediaPack)->configure($configurator);
        }

        if ($this->config['markdown']) {
            $configurator->Litedown;
        }

        if ($this->config['emoticons']) {
            $configurator->Emoticons->add(':)', '&#x1f604;');
            $configurator->Emoticons->add(':D', '&#x1f603;');
            $configurator->Emoticons->add(':P', '&#x1f61c;');
            $configurator->Emoticons->add(':(', '&#x1f61f;');
            $configurator->Emoticons->add(':|', '&#x1f610;');
            $configurator->Emoticons->add(';)', '&#x1f609;');
            $configurator->Emoticons->add(':*', '&#x1f618;');
            $configurator->Emoticons->add(':\'(', '&#x1f622;');
            $configurator->Emoticons->add(':\')', '&#x1f602;');
            $configurator->Emoticons->add(':O', '&#x1f62e;');
            $configurator->Emoticons->add('B)', '&#x1f60e;');
            $configurator->Emoticons->add('>:(', '&#x1f621;');
        }

        if ($this->config['bbcodes']) {
            $configurator->BBCodes->addFromRepository('B');
            $configurator->BBCodes->addFromRepository('I');
            $configurator->BBCodes->addFromRepository('U');
            $configurator->BBCodes->addFromRepository('S');

            if (! $this->config['markdown']) {
                if (! $this->config['auto_link']) {
                    $configurator->BBCodes->addFromRepository('URL');
                }

                if (! $this->config['auto_image']) {
                    $configurator->BBCodes->addFromRepository('IMG');
                }

                if (! $this->config['auto_email']) {
                    $configurator->BBCodes->addFromRepository('EMAIL');
                }

                $configurator->BBCodes->addFromRepository('QUOTE');
                $configurator->BBCodes->addFromRepository('LIST');
                $configurator->BBCodes->addFromRepository('*');

                $configurator->BBCodes->addCustom(
                    '[CODE lang={IDENTIFIER;optional}]{TEXT}[/CODE]',
                    '<pre><code class="language-{@lang}"><xsl:apply-templates /></code></pre>'
                );
            }
        }

        event(new FormatterConfigurator($configurator));

        return $configurator;
    }
}

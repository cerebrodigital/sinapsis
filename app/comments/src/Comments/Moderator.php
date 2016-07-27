<?php



namespace Hazzard\Comments\Comments;

use Hazzard\Comments\Support\Akismet;

class Moderator
{
    /**
     * @var array
     */
    protected $config;

    /**
     * @var \Hazzard\Comments\Support\Akismet
     */
    protected $akismet;

    /**
     * Create a new moderator instance.
     *
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * Get comment status.
     *
     * @param  array $data
     * @return string
     */
    public function getStatus(array $data)
    {
        if ($this->config['moderation']) {
            return Comment::PENDING;
        }

        if ($this->contains($data, 'moderation_keys')) {
            return Comment::PENDING;
        }

        if ($this->contains($data, 'blacklist_keys')) {
            return Comment::SPAM;
        }

        if ($this->hasTooManyLinks($data['content'])) {
            return Comment::PENDING;
        }

        if ($this->isSpam($data)) {
            return Comment::SPAM;
        }

        return Comment::APPROVED;
    }

    /**
     * Check if contains specific keys.
     *
     * @param  string $data
     * @param  string $type
     * @return bool
     */
    protected function contains($data, $type)
    {
        $keys = $this->config[$type];

        foreach ($keys as $key) {
            if (empty($key)) continue;

            if (is_array($data)) {
                foreach ($data as $field) {
                    if (preg_match('/\b'.$key.'\b/', $field)) {
                        return true;
                    }
                }
            } elseif (preg_match('/\b'.$key.'\b/', $data)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check if the comment content contains too many links.
     *
     * @param  string $content
     * @return boolean
     */
    protected function hasTooManyLinks($content)
    {
        if ($this->config['max_links']) {
            $xml = Comment::getFormatter()->parse($content);

            $html = Comment::getFormatter()->render($xml);

            $found = preg_match_all('/<a [^>]*href/i', $html);

            if ($found >= $this->config['max_links']) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check if the comment is spam.
     *
     * @param  array $data
     * @return boolean
     */
    protected function isSpam($data)
    {
        if (! $this->akismet) {
            return false;
        }

        if (! isset($data['referrer'])) {
            $data['referrer'] = '';
        }

        return $this->akismet->commentCheck([
            'user_ip' => $data['author_ip'],
            'referrer' => $data['referrer'],
            'permalink' => $data['permalink'],
            'user_agent' => $data['user_agent'],
            'comment_type' => 'comment',
            'comment_content' => $data['content'],
            'comment_author'  => $data['author_name'],
            'comment_author_url' => $data['author_url'],
            'comment_author_email' => $data['author_email'],
        ]);
    }

    /**
     * Set akismet instance.
     *
     * @param  \Hazzard\Comments\Support\Akismet $akismet
     * @return void
     */
    public function setAkismet(Akismet $akismet)
    {
        $this->akismet = $akismet;
    }
}

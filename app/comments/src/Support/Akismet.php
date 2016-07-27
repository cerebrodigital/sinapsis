<?php



namespace Hazzard\Comments\Support;

class Akismet
{
    /**
     * API key.
     *
     * @var string
     */
    protected $key;

    /**
     * Blog url.
     *
     * @var string
     */
    protected $blogUrl;

    /**
     * Create a new akismet instance.
     *
     * @param string $key
     */
    public function __construct($key)
    {
        $this->key = $key;
    }

    /**
     * Check if comment is spam.
     *
     * Comment parameters:
     * https://akismet.com/development/api/#comment-check
     *
     * @param  array $comment
     * @return bool  Returns true if the comment is spam, false otherwise.
     */
    public function commentCheck(array $comment)
    {
        $url = "https://{$this->key}.rest.akismet.com/1.1/comment-check";

        if (isset($this->blogUrl)) {
            $comment['blog'] = $this->blogUrl;
        }

        return $this->httpPost($url, $comment) === 'true';
    }

    /**
     * Set the blog url.
     *
     * @param  string $url
     * @return $this
     */
    public function setBlogUrl($url)
    {
        $this->blogUrl = $url;

        return $this;
    }

    /**
     * Perform a cURL post.
     *
     * @param  string $url
     * @param  array  $data
     * @return string
     */
    protected function httpPost($url, $data)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, count($data));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($ch);

        curl_close($ch);

        return $result;
    }
}

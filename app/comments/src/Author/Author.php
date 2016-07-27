<?php

namespace Hazzard\Comments\Author;

use Hazzard\Comments\Comments\Comment;
use Illuminate\Contracts\Support\Jsonable;

class Author implements Jsonable
{
    /**
     * @var array
     */
    protected $attributes;

    /**
     * Create a new author instance.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes)
    {
        $this->attributes = $attributes;
    }

    /**
     * Check the author is guest.
     *
     * @return boolean
     */
    public function guest()
    {
        return $this->get('guest', true);
    }

    /**
     * Get the author id.
     *
     * @return string
     */
    public function id()
    {
        return $this->get('id');
    }

    /**
     * Get the author name.
     *
     * @return string
     */
    public function name()
    {
        return $this->get('name');
    }

    /**
     * Get the author email address.
     *
     * @return string
     */
    public function email()
    {
        return $this->get('email');
    }

    /**
     * Get the author avatar url.
     *
     * @return string
     */
    public function avatar()
    {
        return $this->get('avatar');
    }

    /**
     * Get the author url.
     *
     * @return string
     */
    public function url()
    {
        return $this->get('url');
    }

    /**
     * Whether the author is admin.
     *
     * @return boolean
     */
    public function isAdmin()
    {
        return $this->get('admin') === true;
    }

    /**
     * Check if the author can edit the given comment.
     *
     * @param  \Hazzard\Comments\Comments\Comment $comment
     * @return boolean
     */
    public function canEdit(Comment $comment)
    {
        if ($this->guest()) {
            return false;
        }

        if ($this->isAdmin()) {
            return true;
        }

        if ((int) $this->id() !== $comment->user_id || $comment->status !== Comment::APPROVED) {
            return false;
        }

        $edit = config('comments.edit');

        if (is_numeric($edit)) {
            return $comment->created_at->getTimestamp() > time() - $edit;
        }

        return $edit === true;
    }

    /**
     * Get author attribute.
     *
     * @param  string $key
     * @param  string $default
     * @return mixed
     */
    public function get($key, $default = null)
    {
        if (array_key_exists($key, $this->attributes)) {
            return $this->attributes[$key];
        }

        return $default;
    }

    /**
     * Convert the author to its JSON representation.
     *
     * @return string
     */
    public function toJson($options = 0)
    {
        return json_encode($this->attributes);
    }
}

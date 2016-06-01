<?php

/**
 * This file is part of Ajax Comment System for Laravel™.
 *
 * (c) HazzardWeb <hazzardweb@gmail.com>
 *
 * For the full copyright and license information, please visit:
 * http://codecanyon.net/licenses/standard
 */

namespace Hazzard\Comments\Events;

use Hazzard\Comments\Comments\Comment;

class CommentWillBeDeleted
{
    /**
     * @var \Hazzard\Comments\Comments\Comment
     */
    public $comment;

    /**
     * Create a new event instance.
     *
     * @param \Hazzard\Comments\Comments\Comment $comment
     */
    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }
}

<?php



namespace Hazzard\Comments\Events;

use Hazzard\Comments\Comments\Comment;

class CommentWillBeSaved
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

<?php



namespace Hazzard\Comments\Events;

use Hazzard\Comments\Comments\Comment;
use Illuminate\Database\Eloquent\Collection;

class CommentsWereFetched
{
    /**
     * @var int
     */
    public $total;

    /**
     * @var \Illuminate\Database\Eloquent\Collection
     */
    public $comments;

    /**
     * Create a new event instance.
     *
     * @param \Illuminate\Database\Eloquent\Collection $comments
     * @param int $total
     */
    public function __construct(Collection $comments, $total)
    {
        $this->total = $total;
        $this->comments = $comments;
    }
}

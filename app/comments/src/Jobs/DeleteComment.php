<?php

/**
 * This file is part of Ajax Comment System for Laravel™.
 *
 * (c) HazzardWeb <hazzardweb@gmail.com>
 *
 * For the full copyright and license information, please visit:
 * http://codecanyon.net/licenses/standard
 */

namespace Hazzard\Comments\Jobs;

use Hazzard\Comments\Comments\Comment;
use Illuminate\Contracts\Bus\SelfHandling;
use Hazzard\Comments\Events\CommentWasDeleted;
use Hazzard\Comments\Events\CommentWillBeDeleted;

class DeleteComment extends Job implements SelfHandling
{
    /**
     * @var int
     */
    protected $id;

    /**
     * Create a new job instance.
     *
     * @param  int $id
     * @return void
     */
    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $comment = Comment::findOrFail($this->id);

        $this->fire(new CommentWillBeDeleted($comment));

        $comment->delete();

        $this->fire(new CommentWasDeleted($comment));
    }
}

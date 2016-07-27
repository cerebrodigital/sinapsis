<?php



namespace Hazzard\Comments\Jobs;

use Hazzard\Comments\Comments\Comment;
use Illuminate\Contracts\Bus\SelfHandling;
use Hazzard\Comments\Events\CommentWasDeleted;
use Hazzard\Comments\Events\CommentWillBeDeleted;

class BulkCommentUpdate extends Job implements SelfHandling
{
    /**
     * @var array
     */
    protected $ids;

    /**
     * @var string
     */
    protected $status;

    /**
     * Create a new job instance.
     *
     * @param  array $id
     * @return void
     */
    public function __construct($ids, $status)
    {
        $this->ids = $ids;
        $this->status = $status;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $query = Comment::whereIn('id', $this->ids)
                        ->limit(count($this->ids));

        if ($this->status === 'delete') {
            return $query->delete();
        }

        return $query->update(['status' => $this->status]);
    }
}

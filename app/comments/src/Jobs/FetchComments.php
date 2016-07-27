<?php



namespace Hazzard\Comments\Jobs;

use Hazzard\Comments\Author\Author;
use Hazzard\Comments\Comments\Comment;
use Hazzard\Comments\Comments\Paginator;
use Illuminate\Contracts\Bus\SelfHandling;
use Hazzard\Comments\Events\CommentsWereFetched;

class FetchComments extends Job implements SelfHandling
{
    const SORT_NEWEST = 1;
    const SORT_OLDEST = 2;
    const SORT_BEST   = 3;

    /**
     * @var array
     */
    protected $args;

    /**
     * Create a new job instance.
     *
     * @param  array $args
     * @return void
     */
    public function __construct(array $args)
    {
        $this->args = $args;

        $this->config = config('comments');
    }

    /**
     * Execute the job.
     *
     * @param  \Hazzard\Comments\Author\Author $author
     * @return \Hazzard\Comments\Comments\Paginator|array
     */
    public function handle(Author $author)
    {
        $this->author = $author;

        $page   = isset($this->args['page'])    ? $this->args['page']    : 1;
        $pageId = isset($this->args['page_id']) ? $this->args['page_id'] : 0;
        $target = isset($this->args['target'])  ? $this->args['target']  : null;
        $sortby = isset($this->args['sort'])    ? $this->args['sort']    : null;
        $email  = isset($this->args['email'])   ? $this->args['email']   : null;

        $perPage = $this->config['per_page'];

        list($column, $direction) = $this->getOrderBy($sortby);

        if ($target && $perPage) {
            $page = $this->getPageNumber($target) ?: $page;
        }

        $query = Comment::where('page_id', $pageId);

        $this->whereStatus($query, Comment::APPROVED, $email);

        $count = $query->count('id');

        $query->whereNull('parent_id');

        $total = $query->count('id');

        $query->orderBy($column, $direction)
              ->loadUser($author->id());

        if ($perPage) {
            $query->forPage($page, $perPage);
        }

        if ($this->config['replies']) {
            $query->with(['replies' => function ($query) use ($column, $direction, $email) {
                $query->orderBy($column, $direction)
                      ->loadUser($this->author->id());

                $this->whereStatus($query, Comment::APPROVED, $email);
            }]);
        }

        $comments = $query->get();

        $this->fire(new CommentsWereFetched($comments, $total));

        if ($perPage) {
            return new Paginator($comments, $total, $perPage, $page, compact('count'));
        }

        return ['comments' => $comments, 'total' => $total];
    }

    /**
     * Get page number by comment id.
     *
     * @param  int $commentId
     * @return int|null
     */
    protected function getPageNumber($commentId)
    {
        list($column, $direction) = $this->getOrderBy(null);

        $operator = $direction === 'DESC' ? '>' : '<';

        $perPage = $this->config['per_page'];

        if (! $comment = Comment::find($commentId)) {
            return;
        }

        if ($comment->root_id) {
            $value = $comment->root()->value($column);
        } else {
            $value = $comment->{$column};
        }

        if ($value) {
            $count = Comment::query()
                        ->where($column, $operator, $comment->fromDateTime($value))
                        ->whereNull('root_id')
                        ->count('id');

            $page = intval(floor($count / $perPage)) + 1;

            if ($page > 1) {
                return $page;
            }
        }
    }

    /**
     * Get order by column and direction.
     *
     * @param  int $sortBy
     * @return array
     */
    protected function getOrderBy($sortBy)
    {
        $order = [
            static::SORT_NEWEST => ['created_at', 'DESC'],
            static::SORT_OLDEST => ['created_at', 'ASC'],
            static::SORT_BEST   => ['upvotes', 'DESC'],
        ];

        if (isset($order[$sortBy])) {
            return $order[$sortBy];
        }

        return $this->getOrderBy($this->config['default_sort']);
    }

    /**
     * Filter by status.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param  string $status
     * @param  string $email
     * @return void
     */
    protected function whereStatus($query, $status, $email)
    {
        $query->where('status', '!=', Comment::TRASH);

        $query->where(function ($query) use ($status, $email) {
            $query->where('status', $status);

            if ($this->author->guest()) {
                $query->authorEmail($email, 'or');
            } elseif ($email) {
                $query->userId($this->author->id(), 'or');
            }
        });
    }
}

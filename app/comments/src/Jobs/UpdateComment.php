<?php



namespace Hazzard\Comments\Jobs;

use Illuminate\Support\Arr;
use Hazzard\Comments\Author\Author;
use Hazzard\Comments\Comments\Comment;
use Hazzard\Comments\Comments\Moderator;
use Illuminate\Contracts\Bus\SelfHandling;
use Hazzard\Comments\Events\CommentWasUpdated;
use Hazzard\Comments\Events\CommentWillBeSaved;

class UpdateComment extends Job implements SelfHandling
{
    /**
     * @var \Hazzard\Comments\Comments\Comment
     */
    protected $comment;

    /**
     * @var array
     */
    protected $input;

    /**
     * Create a new job instance.
     *
     * @param  \Hazzard\Comments\Comments\Comment  $comment
     * @param  array $input
     * @return void
     */
    public function __construct($comment, array $input)
    {
        $this->input = $input;
        $this->comment = $comment;
    }

    /**
     * Execute the job.
     *
     * @param  \Hazzard\Comments\Author\Author $author
     * @param  \Hazzard\Comments\Comments\Moderator $moderator
     * @return void
     */
    public function handle(Author $author, Moderator $moderator)
    {
        if ($author->isAdmin()) {
            unset($this->input['author_ip'], $this->input['user_agent']);

            if ($this->comment->user_id) {
                $this->input = Arr::only($this->input, ['status', 'content']);
            }

            foreach ($this->input as $key => $value) {
                $this->comment->{$key} = $value;
            }
        } else {
            $this->comment->content = $this->input['content'];

            $this->input['permalink'] = $this->comment->permalink;
            $this->input['author_url'] = $this->comment->author_url;
            $this->input['author_name'] = $this->comment->author_name;
            $this->input['author_email'] = $this->comment->author_email;

            $this->comment->status = $moderator->getStatus($this->input);
        }

        $this->fire(new CommentWillBeSaved($this->comment));

        $this->comment->save();

        $this->fire(new CommentWasUpdated($this->comment));
    }
}

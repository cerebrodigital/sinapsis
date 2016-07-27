<?php



namespace Hazzard\Comments\Jobs;

use Hazzard\Comments\Author\Author;
use Hazzard\Comments\Comments\Comment;
use Hazzard\Comments\Comments\Moderator;
use Illuminate\Contracts\Bus\SelfHandling;
use Hazzard\Comments\Events\CommentWasPosted;
use Hazzard\Comments\Events\CommentWillBeSaved;

class PostComment extends Job implements SelfHandling
{
    /**
     * @var array
     */
    protected $input;

    /**
     * Create a new job instance.
     *
     * @param  array $input
     * @return void
     */
    public function __construct(array $input)
    {
        $this->input = $input;
    }

    /**
     * Execute the job.
     *
     * @param  \Hazzard\Comments\Author\Author $author
     * @param  \Hazzard\Comments\Comments\Moderator $moderator
     * @return \Hazzard\Comments\Comments\Comment
     */
    public function handle(Author $author, Moderator $moderator)
    {
        $input = $this->input;

        if (! $author->guest()) {
            $input = array_merge($input, [
                'user_id'      => $author->id(),
                'author_name'  => $author->name(),
                'author_email' => $author->email(),
                'author_url'   => $author->url(),
            ]);
        }

        if (! $author->isAdmin()) {
            $input['status'] = $moderator->getStatus($input);
        }

        if (! $author->guest()) {
            unset($input['author_email'], $input['author_name'], $input['author_url']);
        }

        $comment = new Comment($input);

        $this->fire(new CommentWillBeSaved($comment));

        $comment->save();

        $comment = Comment::find($comment->id);

        $this->fire(new CommentWasPosted($comment));

        return $comment;
    }
}

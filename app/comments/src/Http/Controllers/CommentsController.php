<?php

/**
 * This file is part of Ajax Comment System for Laravel™.
 *
 * (c) HazzardWeb <hazzardweb@gmail.com>
 *
 * For the full copyright and license information, please visit:
 * http://codecanyon.net/licenses/standard
 */

namespace Hazzard\Comments\Http\Controllers;

use Response;
use Illuminate\Http\Request;
use Illuminate\Cache\RateLimiter;
use Hazzard\Comments\Author\Author;
use Illuminate\Routing\Controller;
use Hazzard\Comments\Comments\Comment;
use Hazzard\Comments\Jobs\VoteComment;
use Hazzard\Comments\Comments\Comments;
use Hazzard\Comments\Jobs\PostComment;
use Hazzard\Comments\Http\ThrottlesPosts;
use Hazzard\Comments\Jobs\FetchComments;
use Hazzard\Comments\Jobs\UpdateComment;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Hazzard\Comments\Http\Middleware\Author as AuthorMiddleware;

class CommentsController extends Controller
{
    use ValidatesRequests, ThrottlesPosts, DispatchesJobs;

    /**
     * @var array
     */
    protected $config;

    /**
     * @var \Hazzard\Comments\Author\Author
     */
    protected $author;

    /**
     * @var \Illuminate\Cache\RateLimiter
     */
    protected $rateLimiter;

    /**
     * Create a new controller instance.
     *
     * @param \Hazzard\Comments\Author\Author $author
     * @param \Illuminate\Cache\RateLimiter $rateLimiter
     */
    public function __construct(Author $author, RateLimiter $rateLimiter)
    {
        $this->config = app('comments');

        $this->author = $author;
        $this->rateLimiter = $rateLimiter;

        $this->maxAttempts = $this->config['throttle_max_attempts'];
        $this->lockoutTime = $this->config['throttle_lockout_time'];

        $this->middleware('auth', ['only' => ['update', 'vote']]);
        $this->middleware(AuthorMiddleware::class, ['only' => 'store']);
    }

    /**
     * Fetch all comments.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $args = $request->only('page', 'page_id', 'target', 'sort');

        if ($email = $request->cookie($this->cookieName())) {
            $args['email'] = $email;
        }

        return Response::json($this->dispatch(new FetchComments($args)));
    }

    /**
     * Post a new comment.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $this->validateStoreRequest($request);

        $throttle = $this->config['throttle'] && ! $this->author->isAdmin();

        if ($throttle && $this->hasTooManyPostAttempts($request)) {
            return Response::json($this->getLockoutErrorMessage($request), 423);
        }

        $comment = $this->dispatch(new PostComment($this->getStoreInput($request)));

        if ($throttle) {
            $this->incrementPostAttempts($request);
        }

        if (! $this->author->guest()) {
            return Response::json($comment, 201);
        }

        return Response::json($comment, 201)
                    ->withCookie($this->cookieName(), $comment->author_email, 2628000);
    }

    /**
     * Update a specified comment.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $max = $this->config['max_length'];

        $this->validate($request, [
            'content' => 'required|min:2'.($max ? "|max:$max" : ''),
        ]);

        $comment = Comment::findOrFail($id);

        if (! $this->author->canEdit($comment)) {
            return Response::json('Forbidden.', 403);
        }

        $this->dispatch(new UpdateComment($comment, [
            'content'    => $request->input('content'),
            'author_ip'  => $request->server('REMOTE_ADDR'),
            'user_agent' => $request->server('HTTP_USER_AGENT'),
        ]));

        return Response::json($comment);
    }

    /**
     * Vote a specified comment.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function vote(Request $request, $id)
    {
        if (! $this->config['votes'] || ! $comment = Comment::find($id)) {
            return Response::json('Not found.', 404);
        }

        $this->dispatch(new VoteComment($comment, $request->input('type')));

        return Response::json();
    }

    /**
     * Validate the store request.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    protected function validateStoreRequest(Request $request)
    {
        if ($this->author->guest()) {
            $rules['author_name']  = 'required|max:100';
            $rules['author_email'] = 'required|email|max:255';
            $rules['author_url']   = 'url|max:255';
        }

        if ($this->config['captcha_required']) {
            $rules['g-recaptcha-response'] = 'required|recaptcha';
        }

        $rules['page_id'] = 'required';
        $rules['content'] = 'required|min:2';
        $rules['root_id'] = 'exists:comments,id,parent_id,NULL';
        $rules['parent_id'] = 'exists:comments,id';

        if ($max = $this->config['max_length']) {
            $rules['content'] .= "|max:$max";
        }

        if (! $this->author->isAdmin()) {
            $rules['parent_id'] .= ',status,approved';

            if ($this->config['duplicate']) {
                $rules['content'] .= '|duplicate';
            }

            if ($this->config['max_pending']) {
                $rules['content'] .= '|max_pending';
            }

            $this->registerValidators($request);
        }

        $this->validate($request, $rules, trans('comments::all.validation'));
    }

    /**
     * Get the input for the store request.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    protected function getStoreInput(Request $request)
    {
        $input = [
            'page_id'      => e($request->input('page_id')),
            'author_ip'    => $request->server('REMOTE_ADDR'),
            'user_agent'   => $request->server('HTTP_USER_AGENT'),
            'root_id'      => $request->input('root_id'),
            'parent_id'    => $request->input('parent_id'),
            'content'      => $request->input('content'),
            'permalink'    => e($request->input('permalink')),
            'referrer'     => $request->input('referrer'),
            'author_name'  => e($request->input('author_name')),
            'author_email' => $request->input('author_email'),
            'author_url'   => e($request->input('author_url')),
        ];

        if (empty($input['root_id']) || ! $this->config['replies']) {
            unset($input['root_id'], $input['parent_id']);
        }

        return $input;
    }

    /**
     * Register some custom validators.
     *
     * @param  \Illuminate\Http\Request $request
     * @return void
     */
    protected function registerValidators(Request $request)
    {
        $factory = $this->getValidationFactory();

        $factory->extend('duplicate', function () use ($request) {
            return ! $this->duplicate($request);
        });

        $factory->extend('max_pending', function () use ($request) {
            return ! $this->maxPending($request);
        });
    }

    /**
     * Check for duplicate comments.
     *
     * @param  \Illuminate\Http\Request $request
     * @return bool
     */
    protected function duplicate(Request $request)
    {
        $input = $request->only('content', 'page_id', 'email');

        $query = Comment::where([
            'content' => $input['content'],
            'page_id' => $input['page_id']
        ]);

        if ($this->author->guest()) {
            $query->authorEmail($input['email']);
        } else {
            $query->userId($this->author->id());
        }

        return $query->value('id') ? true : false;
    }

    /**
     * Check max pending comments.
     *
     * @param  \Illuminate\Http\Request $request
     * @return bool
     */
    protected function maxPending(Request $request)
    {
        if ($this->author->guest()) {
            $query = Comment::authorEmail($request->input('author_email'));
        } else {
            $query = Comment::userId($this->author->id());
        }

        $count = $query->where('status', '!=', Comment::APPROVED)->count('id');

        return $count >= $this->config['max_pending'];
    }

    /**
     * Get author email cookie name.
     *
     * @return string
     */
    public function cookieName()
    {
        return 'email_'.md5(get_class($this));
    }

    /**
     * Format the validation errors to be returned.
     *
     * @param  \Illuminate\Contracts\Validation\Validator $validator
     * @return array
     */
    protected function formatValidationErrors(Validator $validator)
    {
        return $validator->errors()->all();
    }
}

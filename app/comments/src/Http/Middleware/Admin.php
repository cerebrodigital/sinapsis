<?php



namespace Hazzard\Comments\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Hazzard\Comments\Author\Author;

class Admin
{
    /**
     * @var \Hazzard\Comments\Author\Author $author
     */
    protected $author;

    /**
     * @param \Hazzard\Comments\Author\Author $author
     */
    public function __construct(Author $author)
    {
        $this->author = $author;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (! $this->author->isAdmin()) {
            if ($request->ajax()) {
                return response()->json('Unauthorized.', 401);
            } else {
                return redirect('/');
            }
        }

        return $next($request);
    }
}

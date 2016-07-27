<?php



namespace Hazzard\Comments\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Http\Request;

class Author
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (! config('comments.guest') && Auth::guest()) {
            return response()->json('Forbidden.', 403);
        }

        return $next($request);
    }
}

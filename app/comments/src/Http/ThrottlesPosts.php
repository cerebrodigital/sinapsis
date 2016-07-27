<?php



namespace Hazzard\Comments\Http;

use Illuminate\Http\Request;

trait ThrottlesPosts
{
    /**
     * Determine if the user has too many comment post attempts.
     *
     * @param  \Illuminate\Http\Request $request
     * @return bool
     */
    public function hasTooManyPostAttempts(Request $request)
    {
        return $this->rateLimiter->tooManyAttempts(
            $this->getKey($request),
            $this->maxPostAttempts(), $this->lockoutTime() / 60
        );
    }

    /**
     * Increment the comment post attempts.
     *
     * @param  \Illuminate\Http\Request $request
     * @return int
     */
    protected function incrementPostAttempts(Request $request)
    {
        $this->rateLimiter->hit($this->getKey($request));
    }

    /**
     * Get the comment posts lockout error message.
     *
     * @param  \Illuminate\Http\Request $request
     * @return string
     */
    protected function getLockoutErrorMessage(Request $request)
    {
        $seconds = $this->rateLimiter->availableIn($this->getKey($request));

        return trans('comments::all.throttle', compact('seconds'));
    }

    /**
     * Clear the comment post locks.
     *
     * @param  \Illuminate\Http\Request $request
     * @return void
     */
    protected function clearAttempts(Request $request)
    {
        $this->rateLimiter->clear($this->getKey($request));
    }

    /**
     * Get rate limiter key.
     *
     * @param  \Illuminate\Http\Request $request
     * @return string
     */
    protected function getKey(Request $request)
    {
        if (app('auth')->check()) {
            return app('auth')->id().$request->ip();
        }

        return $request->ip();
    }

    /**
     * Get the maximum number of post attempts for delaying further attempts.
     *
     * @return int
     */
    protected function maxPostAttempts()
    {
        return property_exists($this, 'maxPostAttempts') ? $this->maxPostAttempts : 5;
    }

    /**
     * The number of seconds to delay further post attempts.
     *
     * @return int
     */
    protected function lockoutTime()
    {
        return property_exists($this, 'lockoutTime') ? $this->lockoutTime : 60;
    }
}

<?php

/**
 * This file is part of Ajax Comment System for Laravel™.
 *
 * (c) HazzardWeb <hazzardweb@gmail.com>
 *
 * For the full copyright and license information, please visit:
 * http://codecanyon.net/licenses/standard
 */

namespace Hazzard\Comments\Support;

class Gravatar
{
    /**
     * Get Gravatar image by email.
     *
     * @param  string $email
     * @param  int    $size
     * @param  int    $rating [g|pg|r|x]
     * @return string
     */
    public static function image($email, $size = 200, $rating = 'g')
    {
        $id = md5(strtolower(trim($email)));

        $default = config('comments.default_gravatar') ?: 'monsterid';

        return "http://www.gravatar.com/avatar/{$id}/?d={$default}&s={$size}&r=$rating";
    }
}

<?php

/**
 * This file is part of Ajax Comment System for Laravel™.
 *
 * (c) HazzardWeb <hazzardweb@gmail.com>
 *
 * For the full copyright and license information, please visit:
 * http://codecanyon.net/licenses/standard
 */

namespace Hazzard\Comments\Comments;

use Hazzard\Comments\Author\Author;
use Hazzard\Comments\Support\Gravatar;
use Illuminate\Database\Eloquent\Model;
use Hazzard\Comments\Formatter\Formatter;

class Comment extends Model
{
    const PENDING  = 'pending';
    const APPROVED = 'approved';
    const SPAM     = 'spam';
    const TRASH    = 'trash';

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'comments';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'page_id', 'root_id', 'parent_id', 'user_id', 'author_name', 'author_url',
        'author_email', 'author_ip', 'user_agent', 'content', 'status', 'permalink',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id'        => 'integer',
        'upvotes'   => 'integer',
        'downvotes' => 'integer',
        'root_id'   => 'integer',
        'parent_id' => 'integer',
        'user_id'   => 'integer',
    ];

    /**
     * The text formatter instance.
     *
     * @var \Hazzard\Comments\Formatter\Formatter
     */
    protected static $formatter;

    /**
     * Whether is running in the admin panel.
     *
     * @var boolean
     */
    public static $admin = false;

    /**
     * @var \Hazzard\Comments\Author\Author
     */
    protected $author = null;

    /**
     * Parse the content before it is saved to the database.
     *
     * @param string $value
     */
    public function setContentAttribute($value)
    {
        $this->attributes['content'] = static::$formatter->parse($value);
    }

    /**
     * Unparse the parsed content.
     *
     * @param  string $value
     * @return string
     */
    public function getContentAttribute($value)
    {
        return static::$formatter->unparse($value);
    }

    /**
     * Get the content rendered as HTML.
     *
     * @return string
     */
    public function getContentHtmlAttribute()
    {
        return static::$formatter->render($this->attributes['content']);
    }

    /**
     * Permalink accessor.
     *
     * @param  string $value
     * @return string
     */
    public function getPermalinkAttribute($value)
    {
        return "{$value}#!comment={$this->id}";
    }

    /**
     * Admin edit link accessor.
     *
     * @return string
     */
    public function getEditLinkAttribute()
    {
        return route('comments.admin.index').'#!edit='.$this->id;
    }

    /**
     * Author name accessor.
     *
     * @param  string $value
     * @return string
     */
    public function getAuthorNameAttribute($value)
    {
        return $this->getAuthor()->name();
    }

    /**
     * Author email accessor.
     *
     * @param  string $value
     * @return string
     */
    public function getAuthorEmailAttribute($value)
    {
        return $this->getAuthor()->email();
    }

    /**
     * Author avatar accessor.
     *
     * @return string
     */
    public function getAuthorAvatarAttribute()
    {
        return $this->getAuthor()->avatar();
    }

    /**
     * Author url accessor.
     *
     * @return string
     */
    public function getAuthorUrlAttribute()
    {
        return $this->getAuthor()->url();
    }

    /**
     * Get the comment author.
     *
     * @return \Hazzard\Comments\Author\Author
     */
    public function getAuthor()
    {
        if ($this->author) {
            return $this->author;
        }

        if (config('comments.user_model') && $this->user) {
            $attrs = $this->user->getAuthor();
        } else {
            $attrs = [
                'url'    => $this->attributes['author_url'],
                'name'   => $this->attributes['author_name'],
                'email'  => $this->attributes['author_email'],
                'avatar' => 'gravatar',
            ];
        }

        if (isset($attrs['avatar']) && $attrs['avatar'] === 'gravatar') {
            $attrs['avatar'] = Gravatar::image($attrs['email']);
        }

        return $this->author = new Author($attrs);
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        $data = [
            'id'          => $this->id,
            'page_id'     => $this->page_id,
            'root_id'     => $this->root_id,
            'parent_id'   => $this->parent_id,
            'content'     => $this->content,
            'contentHTML' => $this->contentHTML,
            'status'      => $this->status,
            'created_at'  => $this->created_at->toIso8601String(),
            'updated_at'  => $this->updated_at->toIso8601String(),
            'upvotes'     => $this->upvotes,
            'downvotes'   => $this->downvotes,
            'voted'       => isset($this->userVote) ? $this->userVote->type : null,
            'author'      => [
                'name'    => $this->author_name,
                'url'     => $this->author_url,
                'avatar'  => $this->author_avatar,
            ],
            'user_id'     => $this->user_id,
            'canEdit'     => app('comments.author')->canEdit($this),
            'replies'     => isset($this->replies) ? $this->replies : [],
            'edit_link'   => $this->editLink,
            'permalink'   => $this->permalink,
            'uid'         => session('comments_uid'),
        ];

        if (static::$admin) {
            $data['created_at'] = [
                'timestamp' => $data['created_at'],
                'diff' => $this->created_at->diffForHumans(),
            ];

            $data['user_agent'] = $this->user_agent;
            $data['author']['ip'] = $this->author_ip;
            $data['author']['email'] = $this->author_email;
            $data['parent'] = isset($this->parent) ? $this->parent : null;
        }

        return $data;
    }

    /**
     * Eager load the comment user and vote for the given user id.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param  int|null $userId
     * @param  \Illuminate\Database\Eloquent\Builder
     */
    public function scopeLoadUser($query, $userId = null)
    {
        if (! config('comments.user_model')) {
            return $query;
        }

        $query->with('user');

        if ($userId) {
            $query->with(['userVote' => function ($query) use ($userId) {
                $query->where('user_id', $userId);
            }]);
        }

        return $query;
    }

    /**
     * Add where "user_id" clause.
     *
     * @param  \Illuminate\Database\Query\Builder $query
     * @param  int $id
     * @param  string $boolean
     * @return \Illuminate\Database\Query\Builder
     */
    public function scopeUserId($query, $id, $boolean = 'and')
    {
        return $query->where($this->table.'.user_id', '=', $id, $boolean);
    }

    /**
     * Add where "author_email" clause.
     *
     * @param  \Illuminate\Database\Query\Builder $query
     * @param  string $email
     * @param  string $boolean
     * @return \Illuminate\Database\Query\Builder
     */
    public function scopeAuthorEmail($query, $email, $boolean = 'and')
    {
        return $query->where('author_email', '=', $email, $boolean);
    }

    /**
     * Get the user relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function user()
    {
        return $this->belongsTo(config('comments.user_model'), 'user_id', 'id');
    }

    /**
     * Get the user vote relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOneOrMany
    */
    public function userVote()
    {
        return $this->hasOne(Vote::class);
    }

    /**
     * Get the votes relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOneOrMany
    */
    public function votes()
    {
        return $this->hasMany(Vote::class);
    }

    /**
     * Get the replies relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOneOrMany
     */
    public function replies()
    {
        return $this->hasMany(Comment::class, 'root_id');
    }

    /**
     * Get the parent comment relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOneOrMany
    */
    public function parent()
    {
        return $this->hasOne(Comment::class, 'id', 'parent_id');
    }

    /**
     * Get the root comment relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOneOrMany
    */
    public function root()
    {
        return $this->hasOne(Comment::class, 'id', 'root_id');
    }

    /**
     * Get the text formatter instance.
     *
     * @return \Hazzard\Comments\Formatter\Formatter
     */
    public static function getFormatter()
    {
        return static::$formatter;
    }

    /**
     * Set the text formatter instance.
     *
     * @param  \Hazzard\Comments\Formatter\Formatter $formatter
     * @return void
     */
    public static function setFormatter(Formatter $formatter)
    {
        static::$formatter = $formatter;
    }
}

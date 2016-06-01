<?php

namespace App\models;
use Conner\Likeable\LikeableTrait;

use Illuminate\Database\Eloquent\Model;

class Post extends Model

{
    use LikeableTrait;
    protected $table = 'posts';
    protected $fillable = array('title', 'slug', 'body', 'tags', 'status', 'user_id');

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }


    public function comments()
    {
        return $this->hasMany('App\models\PostComment', 'comment_id');
    }
    
    public function categories()
    {
        return $this->belongsToMany('App\models\Category',  'post_categories');
    }
    public function postCategory () {
        return $this->belongsTo('App\models\PostCategory', 'post_id');
    }


    public function scopeByAuthor($query, $user_id)
    {
        return $query->where("user_id", $user_id);
    }
}

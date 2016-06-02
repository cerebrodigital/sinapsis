<?php

namespace App\models;
use Conner\Likeable\LikeableTrait;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    {
    use LikeableTrait;
    protected $table = 'pages';
    protected $fillable = array('title', 'slug', 'body', 'tags', 'status', 'user_id');

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    
    public function categories()
    {
        return $this->belongsToMany('App\models\Category',  'post_categories');
    }



    public function scopeByAuthor($query, $user_id)
    {
        return $query->where("user_id", $user_id);
    }
}
}

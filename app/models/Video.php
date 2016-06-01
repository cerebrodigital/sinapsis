<?php

namespace App\models;
use Conner\Likeable\LikeableTrait;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
      use LikeableTrait;
      protected $table = 'videos';
      protected $fillable = array('title', 'description', 'media_url', 'tags', 'user_id', 'views', 'likes', 'shares', 'comment_id');

      public function comments()
      {
          return $this->hasMany('App\models\VideoComment', 'video_id', 'id');
      }
      public function user(){
        return $this->belongsTo('App\User', 'user_id', 'id');
      }
      public function categories()
      {
          return $this->belongsToMany('App\models\Category',  'video_categories');
      }
}

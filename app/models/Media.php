<?php

namespace App\models;
use Conner\Likeable\LikeableTrait;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
      use LikeableTrait;
      protected $table = 'media';
      protected $guarded = array();

      public static $rules = array(
        'user_id' => 'required',
        'title' => 'required'
      );

      public function category(){
        return $this->belongsTo('App\models\Category');
      }

      public function user(){
        return $this->belongsTo('App\User')->first();
      }

      public function totalFlags(){
        return DB::table('media_flags')->where('media_id', '=', $this->id)->count();
      }

      public function totalLikes(){
        return DB::table('media_likes')->where('media_id', '=', $this->id)->count();
      }

      public function media_likes(){
        return $this->hasMany('App\models\MediaLike');
      }
}

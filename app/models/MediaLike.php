<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class MediaLike extends Model
{
      protected $table = 'media_likes';
      protected $guarded = array();
      public static $rules = array();

      public function user(){
        return $this->belongsTo('App\User')->first();
      }

      public function media(){
        return $this->belongsTo('App\models\Media')->first();
      }
}

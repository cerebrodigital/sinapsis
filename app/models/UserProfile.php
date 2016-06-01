<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    protected $table = 'user_profile';
    protected $fillable = array('descripcion', 'titulo', 'instagram', 'youtube', 'facebook', 'googleplus');

    public function user() 
    {
      return $this->belongsTo('App\User', 'user_id', 'id');
    }
}

<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Hootlex\Friendships\Traits\Friendable;

class User extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword, Friendable;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'username', 'email', 'password'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    
    public function getProfile() 
    {
        return $this->hasOne('App\models\Profile');
    }

    public function shouts() 
    {
        return $this->hasMany('App\models\Shout');
    }
    public function posts() 
    {
        return $this->hasMany('App\models\Post', 'user_id');
    }

    public function videos() 
    {
        return $this->hasMany('App\models\Video', 'user_id');
    }

    public function topics() 
    {
        return $this->hasMany('App\models\ForumTopic', 'user_id');
    }

    public function replies() 
    {
        return $this->hasMany('App\models\ForumMessage', 'user_id');
    }

    public function user_profile() 
    {
      return $this->belongsTo('App\models\UserProfile', 'id', 'user_id');
    }




    public function getAuthor()
    {
        return [
            'id'     => $this->id,
            'name'   => $this->name,
            'email'  => $this->email,
            'url'    => $this->url,  // Optional
            'avatar' => 'gravatar',
            'admin'  => $this->role === 'admin', // bool
        ];
    }
}



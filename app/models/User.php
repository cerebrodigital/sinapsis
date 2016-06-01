<?php

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * User
 *
 * @property-read \Organisation $organisation
 * @property-read \Illuminate\Database\Eloquent\Collection|\Stats[] $stats
 * @property-read \Illuminate\Database\Eloquent\Collection|\CashoutHistory[] $cashouthistory
 * @property integer $id
 * @property string $email
 * @property string $password
 * @property string $permissions
 * @property string $last_login
 * @property string $first_name
 * @property string $last_name
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $organisation_id
 * @method static \Illuminate\Database\Query\Builder|\User whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\User whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\User wherePassword($value)
 * @method static \Illuminate\Database\Query\Builder|\User wherePermissions($value)
 * @method static \Illuminate\Database\Query\Builder|\User whereLastLogin($value)
 * @method static \Illuminate\Database\Query\Builder|\User whereFirstName($value)
 * @method static \Illuminate\Database\Query\Builder|\User whereLastName($value)
 * @method static \Illuminate\Database\Query\Builder|\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\User whereOrganisationId($value)
 */

class User extends BaseModel implements AuthenticatableContract, CanResetPasswordContract
{

  use Authenticatable, CanResetPassword, SoftDeletes;

  public $owned_by = array('organisation');

  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'users';

  protected $dates = ['deleted_at'];

  public static $rules = array(
    'email' => 'email|unique:users,email',
    'password' => 'confirmed'
  );

  protected $hidden = array('password', 'remember_token', 'code', 'is_admin', 'is_admin', 'is_activated');

  protected $fillable = array('is_activated','code','first_name','last_name','is_admin','email','password','avatar');

  public static function dropdownList() {
          return array('' => 'Seleccionar Usuario') + User::orderBy('name', 'asc')->owns()->get()->lists('name', 'id');
    }

  public function IsAdmin(){
    return $this->is_admin;
  }

  public function getRules(){
    $rules = User::$rules;
    $rules['email'] .= ','.$this->id;
    return $rules;
  }

  public function stats()
  {
    return $this->hasMany('Stats');
  }

  public function cashouthistory()
  {
    return $this->hasMany('CashoutHistory');
  }

  public function isOnline()
  {
    $session = \UserSession::whereUserId($this->id)->first();
    if(is_null($session))
      return false;
    else
      return (\Carbon\Carbon::now()->timestamp - $session->last_activity > 600 ? false : true);
  }

  public function GetAvatarImage($size = false){
    if($this->avatar!=''){
      return '<img class="img-responsive img-circle" alt="" src="/uploads/users/'.$this->id.'/images/'.$this->avatar.'" '.($size!== false ? 'width="'.$size.'"' : '').'>';
    }
  }



  public function setPasswordAttribute($value){
    if(!empty($value))
      $this->attributes['password'] = Hash::make($value);
  }




}
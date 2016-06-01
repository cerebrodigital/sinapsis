<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;

class GAUserBadges extends Model
{
    
    protected $table = 'ga_user_badges';
   
    protected $primaryKey = 'userid';
    
    public $timestamps = false;
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [];

	

}

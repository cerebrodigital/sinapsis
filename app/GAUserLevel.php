<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;

class GAUserLevel extends Model
{
    
    protected $table = 'ga_user_levels';
    
    protected $primaryKey = 'userid';
    
    public $timestamps = false;
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [];

	

}

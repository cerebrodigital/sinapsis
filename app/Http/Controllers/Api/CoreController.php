<?php namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\GALevelAssociate;
use App\GABadges;
use App\GAUserAchievements;
use App\GAUserBadges;
use App\GAUserLevel;
use App\GARewards;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Auth;
use Response;
use File;
use DB;

class GACoreController extends ApiController {

	/**
	 * Core gamify trigger function
	 *
	 * @return Response
	 */
	public function process($userid, $itemid)
	{
        $addNotification = false;
	    /*'******************************************************************'
        ' Check whether user exist in ga_user_levels
        '******************************************************************'*/
        $count_user_record = GAUserLevel::where('userid', $userid)->count();
        if($count_user_record == 0)
        {
        	  // user not exist
        	  // add user in ga_user_level table
              $obj = new GAUserLevel();
              $obj->userid = $userid;
              $obj->levels = 1;
              $obj->points = 0;
              $obj->credits = 0;
              $obj->init_points = 0;
              $obj->max_points = 0;
              $obj->level_id = 0;
              $obj->save();
        }
        /*'******************************************************************'
        ' LOAD BADGE INFORMATION'
        '******************************************************************'*/
		$badge_info = GABadges::orderBy("id", "desc")->where("id", $itemid)->first();
	
        /*'******************************************************************'
        ' PROCESS USER LEVELS, CREDITS,
        '******************************************************************' */
        $user_info = GAUserLevel::orderBy("userid", "desc")->where("userid", $userid)->first();
	    
	    if($badge_info->type == 3)
	    {
	    	 /*'******************************************************************'
            ' LEVEL UP'
            '*******************************************************************/
              $obj = GAUserLevel::where("userid", $userid)->first(); 
              $obj->levels = $badge_info->ilevel;
              $obj->init_points = 0; //'reset to zero for new level calculation'
              $obj->max_points = $badge_info->xp; // 'maximum points required to cross this level'
              $obj->level_id = $badge_info->id;  // ' assign allocated id for future processing'
              $obj->save();
            
		      $addNotification = true;
		      
		      /*'******************************************************************'
              ' Check whether there is any reward associated with this level
              '*******************************************************************/
			  $level_associate_output = GALevelAssociate::orderBy("id", "desc")->where("levelid", $badge_info->id)->get();
			  if(count($level_associate_output) > 0)
			  {
					foreach($level_associate_output as $item)
					{					
						// recursive call this function to award this reward
						$this->trigger_item($userid, $item->rewardid);
					}
			  }
	    }
	    else if($badge_info->type == '4')
	    {
	    	/******************************************************************'
            ' POINTS'
            '******************************************************************' */
            $currentpoints = $user_info->points;
			$initpoints = $user_info->init_points;
			if($badge_info->isdeduct == 1)
			{
				// 'Deduct Points'
				$currentpoints = $currentpoints - $badge_info->xp;
				$initpoints = $initpoints - $badge_info->xp;
				if($currentpoints < 0)
				  $currentpoints =0;
				if($initpoints < 0)
				  $initpoints = 0; 
			}
			else
			{
				// increment points
				$currentpoints = $currentpoints + $badge_info->xp;
				$initpoints = $initpoints + $badge_info->xp;
			}
			// update user points
			$user_info->points = $currentpoints;
			$user_info->init_points = $initpoints;
            $user_info->save();
            
			$addNotification = true;
			
			
			if($initpoints >= $user_info->max_points) 
			{
				 /*'******************************************************************'
	            ' LEVEL UP'
	            '*******************************************************************/
				$currentlevel = $user_info->levels;
				$nextlevel = $currentlevel+2;
				
				$next_badge_info = GABadges::orderBy("id", "desc")->where("ilevel", $nextlevel)->get();
        if(count($next_badge_info) > 0)
				{
					 /*'******************************************************************'
	                 ' LEVEL AVAILABLE'
	                 '*******************************************************************/
                    $user_info->levels = $nextlevel;
                    $user_info->init_points = 0; //'reset to zero for new level calculation'
                    $user_info->max_points = $next_badge_info[0]->xp; // 'maximum points required to cross this level'
                    $user_info->level_id = $next_badge_info[0]->id;  // ' assign allocated id for future processing'
                    $user_info->save();
				
					/*'******************************************************************'
					' Check whether there is any reward associated with new level
					'******************************************************************/
					$level_associate_output = GALevelAssociate::orderBy("id", "desc")->where("levelid", $next_badge_info[0]->id)->get();
					if(count($level_associate_output) > 0)
					{
						foreach($level_associate_output as $item)
						{					
							// recursive call this function to award this reward
							$this->trigger_item($userid, $item->rewardid);
						}
					}
				}
			}
	    }
	    else if($badge_info->type == '5')
	    {
	     	/******************************************************************'
        ' CREDITS '
        '*******************************************************************/
			$currentcredits = $user_info->credits;
			if($badge_info->isdeduct == 1)
			{
				$currentcredits = $currentcredits -$badge_info->credits;
				if($currentcredits < 0)
				  $currentcredits = 0;
			}
			else
			{
				$currentcredits = $currentcredits + $badge_info->credits;
			}
			// update user credits
			$user_info->credits = $currentcredits;
            $user_info->save();
			$addNotification = true;

	    }
	    else
	    {
	    	/*******************************************************************'
            ' BADGE, REWARD, PACKAGE '
            '******************************************************************'

            '******************************************************************'
            ' Associate Badge or Reward or Package with User
            '******************************************************************'*/
            
            $badge_data = new GAUserBadges();
            $badge_data->userid = $userid;
			$badge_data->badge_id = $badge_info->id;
            switch($badge_info->type)
			{
				case '1':
				    // type : badge
                   $badge_data->type = 1;
				break;
				case '2':
				   // type : reward
                   $badge_data->type = 2;
				break;
				case '6':
				   // type : package
                   $badge_data->type = 3;
				break;
			}
			$badge_data->added_date = date("Y-m-d H:i:s");

			// check whether user already award badge, if not marketd as multiple (award multiple times)
			if($badge_info->ismultiple == 1)
			{
				$addNotification = true;
			    // award multiple times
			    $isExist = GAUserBadges::where("userid", $userid)->where("badge_id", $badge_info->id)->count();
			    
				if($isExist == 0)
				{
					// badge not yet awarded before
					$badge_data->save();
				}
				else
				{
					// update occurences of existing awarded badge if exist
					$current_badge_info = GAUserBadges::where("userid", $userid)->where("badge_id", $badge_info->id)->first();
					$current_badge_info->repeated = $current_badge_info->repeated + 1;
					$current_badge_info->save();
					
  			    }
				// process physical code related to selected reward.
				$this->call_phycical_function($badge_info->type, $badge_info->id, $userid);
			} 
			else
			{
				// award single time
				$isExist = GAUserBadges::where("userid", $userid)->where("badge_id", $badge_info->id)->count();
				if($isExist == 0)
				{
					$badge_data->save();
					$this->call_phycical_function($badge_info->type, $badge_info->id, $userid);
					$addNotification = true;
				}
			}
			
			if($badge_info->type == '6')
			{
				// package, credit package allocated credits to user
				$user_info->credits = $user_info->credits + $badge_info->credits;
                $user_info->save();
				$addNotification = true;
			}
	    }
	    
	    /*******************************************************************'
        ' Update User Achievements / History
        '******************************************************************'*/
		if($addNotification)
		{
			if($badge_info->notification != "") 
			{
				$user_history_data = array();
				$value = "";
				switch($badge_info->type)
				{
					 case '1':
					 // type: badge
					 $value = $badge_info->title; // ' badge name as value'
					 break;
					 case '2':
					 // type: reward
					 $value = $badge_info->title; // ' reward name as value'
					 break;
					 case '3':
					 // type level
					 $value = $badge_info->ilevel; // ' level ilevel as value'
					 break;
					 case '4':
					 // type points
					 $value = $badge_info->xp; // ' xp as point value'
					 break;
					 case '5':
					 // type credits
					  $value = $badge_info->credits; // ' credits as value'
					 break;
					 case '6':
					 // type package
					  $value = $badge_info->title; // ' packages as title'
					 break;
				}
				
				$user_history_data = new GAUserAchievements();
				$user_history_data->userid = $userid;
				$user_history_data->description = preg_replace("/\[value\]/", $value, $badge_info->notification);
				$user_history_data->added_date = date("Y-m-d H:i:s");
				$user_history_data->type = $badge_info->type;
				$user_history_data->save();
			}
		}
		
		
        /*'******************************************************************'
        ' Process Completed
        '******************************************************************'*/
        return true;
	    
	}
	
	public function call_phycical_function($type, $rewardid, $userid)
	{
		if($type == 2)
	  {
				// unlocked reward
				// call physical feature to process user own code for selected reward.
				$obj = new GACoreController();
				$obj->process_rewards($rewardid, $userid);
	   }
	}
	
	/*********************************************************************
	 *  Adjust $reward_id cases according to reward it in manage application 
	 *  here you can process custom actions with each reward awarded
	 * e.g with reward_id : 32, you can increase discount for user or unlock any hidden feature based on your project
	 * requirements
	 * *******************************************************************/
	 
	public function process_rewards($rewardid, $userid) {
		  switch($reward_id) {
           
           /*********************************
           -> Unlock -> Level 5 Reward 3
           -> +2 Skills for your profile
           **********************************/
           case 32:
              /* Put your custom code here associated with Level 5 Reward 3 reward. */
              break;
          
           /*********************************
           -> Unlock -> Level 5 Reward 2
           -> +2.5% Faster bid refresh rate
           **********************************/
           case 31:
              /* Put your custom code here associated with Level 5 Reward 2 reward. */
              break;
          
           /*********************************
           -> Unlock -> Level 5 Reward 1
           -> +1 Extra bids per month
           **********************************/
           case 30:
              /* Put your custom code here associated with Level 5 Reward 1 reward. */
              break;
          
           /*********************************
           -> Unlock -> Skills
           -> Increase the total number of skills allowed for your profile
           **********************************/
           case 19:
              /* Put your custom code here associated with Skills reward. */
              break;
          
           /*********************************
           -> Unlock -> Bids
           -> Increase the number of bids you received per month.
           **********************************/
           case 18:
              /* Put your custom code here associated with Bids reward. */
              break;
          
           /*********************************
           -> Unlock -> The Network Slot
           -> Increase the number of network slots in your contact list.
           **********************************/
           case 17:
              /* Put your custom code here associated with The Network Slot reward. */
              break;
          
        }
	}
  
  public function award(Request $request) {
  	    $req = $request::instance();
        $data = json_decode($req->getContent());
        $userid = 0;
        $badge_id = 0;
        foreach($data as $item)
        {
           if(isset($item->userid))
              $userid = $item->userid;
           if(isset($item->badge_id))
              $badge_id = $item->badge_id;
         
        }
   
        $obj = new GACoreController();
        $obj->process($userid,  $badge_id);
        
        return Response::json(['status' => 'success', 'message' => 'item processed']);
  }
  
  public function loaduserlevels(Request $request) {
  	
  	    $req = $request::instance();
        $data = json_decode($req->getContent());
        $userid = 0;
        foreach($data as $item)
        {
           if(isset($item->userid))
              $userid = $item->userid;
           
        }
        
        $user_info = GAUserLevel::orderBy("userid", "desc")->where("userid", $userid)->get();
        
        return Response::json(['status' => 'success', 'Records' => $user_info]);
  }
  
  public function loaduserinfo(Request $request) {
  	
  	    $req = $request::instance();
        $data = json_decode($req->getContent());
        $userid = 0;
        foreach($data as $item)
        {
           if(isset($item->userid))
              $userid = $item->userid;
           
        }
        
        $info = $query = DB::table('ga_users')->where("userid", $userid)->get();
        
        
        
        return Response::json(['status' => 'success', 'Records' => $info]);
  }
  
    public function loadachievements(Request $request) {
  	
  	    $req = $request::instance();
        $data = json_decode($req->getContent());
        $userid = 0;
        $type = 0;
        foreach($data as $item)
        {
           if(isset($item->userid))
              $userid = $item->userid;
            if(isset($item->type))
              $type = $item->type;
        }
        
        $query = GAUserAchievements::orderBy("id", "desc");
        if($userid > 0)
          $query = $query->where("userid", $userid);
        if($type > 0)
         $query = $query->where("type", $type);
         
         $info = $query->get();
        
        return Response::json(['status' => 'success', 'query' => $query->toSql(), 'Records' => $info]);
  }
}

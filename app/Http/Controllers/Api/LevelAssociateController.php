<?php namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\GALevelAssociate;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Auth;
use Response;
use File;


class GALevelAssociateController extends ApiController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index($page)
	{
       
	}
    
    
    /**
	 * Display a listing of categories from json output.
	 *
	 * @return Response
	 */
	public function load(Request $request)
	{
        $req = $request::instance();
        $data = json_decode($req->getContent());
        
        $levelid = 0;
        $order = "id";
        $direction = "desc";
        //exit;
        foreach($data as $item)
        {
           if(isset($item->levelid))
              $levelid = $item->levelid;
          
           
        }
        
        $query = GALevelAssociate::orderBy($order, $direction);
              
        
        if ($levelid > 0)
          $query->where('levelid', $levelid);
      
        
        $data =  $query->get();
       
        return Response::json(['status' => 200, 'Records' => $data]);
	}
	
    public function getinfo(Request $request)
    {
        $req = $request::instance();
        $data = json_decode($req->getContent());
        
        $id = 0;
        
        foreach($data as $item)
        {
           if(isset($item->id))
              $id = $item->id;
           
        }
      
        return Response::json(['status' => 200, 'posts' =>  GALevelAssociate::find($id)]);
    }
    

    public function proc(Request $request)
    {
        $req = $request::instance();
        $data = json_decode($req->getContent());
        
        /* default values */
        $levelid = 0;
        $rewardid = 0;  
        $description = "";
        $isremoved = false;
        foreach($data as $item)
        {
           if(isset($item->levelid))
              $levelid = $item->levelid;
           if(isset($item->rewardid))
              $rewardid = $item->rewardid;  
           if(isset($item->description))
              $description = $item->description;  
           
           if(!$isremoved) {
               GALevelAssociate::where("levelid", $levelid)->delete();
               $isremoved = true;
           }
           $obj = new GALevelAssociate();
           $obj->levelid = $levelid;
           $obj->rewardid = $rewardid;
           $obj->description = $description;
           $obj->save();
        }
        
        return Response::json(['status' => 'success', 'message' => "Record processed successfully"]);
    }


}

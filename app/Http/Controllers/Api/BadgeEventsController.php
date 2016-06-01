<?php namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\GABadgeEvents;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Auth;
use Response;
use File;


class GABadgeEventsController extends ApiController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index($page)
	{
       
	}
    
    public function proc(Request $request)
    {
        $req = $request::instance();
        $data = json_decode($req->getContent());
       
        $isremoved = false;
        foreach($data as $item)
        {
           if(isset($item->event_id)) {
               $event_id = $item->event_id;
               $badge_id = $item->badge_id;
               if(!$isremoved) {
                   GABadgeEvents::where("event_id", $event_id)->delete();
                   $isremoved = true;
               }
               $obj = new GABadgeEvents();
               $obj->event_id = $event_id;
               $obj->badge_id = $badge_id;
               $obj->save();
           }
        }
        
        return Response::json(['status' => 'success', 'message' => "Record processed successfully"]);
    }

}

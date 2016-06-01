<?php namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\GAEvents;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Auth;
use Response;
use File;


class GAEventsController extends ApiController {

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
        
        $id = 0;
        $type = 0;  
        $category_id = 0;
        $order = "priority";
        $direction = "desc";
      
        //return Response::json(['status' => 200,'posts' => $data]);
        //exit;
        foreach($data as $item)
        {
           if(isset($item->id))
              $id = $item->id;
           if(isset($item->type))
              $type = $item->type;
           if(isset($item->category_id))
              $category_id = $item->category_id;
           if(isset($item->order))
              $order = $item->order;  
           if(isset($item->direction))
              $direction =$item->direction;  

        }
        
        $query = GAEvents::orderBy($order, $direction);
              
        
        if ($id > 0)
          $query->where('id', $id);
        if ($type > 0)
          $query->where('type', $type);
        if ($category_id > 0)
          $query->where('category_id', $category_id);
       
        $records = $query->count();
        
        $data =  $query->get();
       
        return Response::json(['status' => 200, 'records' => $records, 'Records' => $data]);
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
      
        return Response::json(['status' => 200, 'posts' =>  GAEvents::find($id)]);
    }
    
    public function remove(Request $request)
    {
        $req = $request::instance();
        $data = json_decode($req->getContent());
        
        $id = 0;
        foreach($data as $item)
        {
           if(isset($item->id))
              $id = $item->id;
           
        }
        if($id > 0) {
            $obj = GAEvents::find($id);
            if (!is_null($obj)) {
              $obj->delete();
            } 
        }
       
        return Response::json(['status' => 200, 'message' =>  'record deleted successfully']);
    }
    
   

    public function proc(Request $request)
    {
        $req = $request::instance();
        $data = json_decode($req->getContent());
        
        /* default values */
        $id = 0;
        $title = "";  
        $description = "";
        $event_key = "";
        $category_id = 0;
       
	
        foreach($data as $item)
        {
           if(isset($item->id))
              $id = $item->id;
           if(isset($item->title))
              $title = $item->title;  
           if(isset($item->description))
              $description = $item->description;  
           if(isset($item->event_key))
              $event_key =$item->event_key;  
          
           if(isset($item->category_id))
              $category_id = $item->category_id; 
           
        }
        
        if($title == "")
        {
            return Response::json(['status' => 'error','message' => "Please enter title"]);
        }
        
        $obj = new GAEvents();
        if($id > 0)
           $obj = GAEvents::find($id); 
           
        $obj->title = $title;
        $obj->description = $description;
        $obj->event_key = $event_key;
        $obj->category_id = $category_id;
        
        $obj->save();
        $insert_id = $obj->id;
        
        return Response::json(['status' => 'success', 'message' => "Record processed successfully"]);
    }
    

}

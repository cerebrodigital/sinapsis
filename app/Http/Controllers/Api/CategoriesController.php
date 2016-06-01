<?php namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\GACategories;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Auth;
use Response;
use File;


class GACategoriesController extends ApiController {

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
          
           if(isset($item->order))
              $order = $item->order;  
              
           if(isset($item->direction))
              $direction =$item->direction;  

        }
        
        $query = GACategories::orderBy($order, $direction);

        if ($id > 0)
          $query->where('id', $id);
        if ($type > 0)
          $query->where('type', $type);
      
        //$records = $query->count();
      
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
      
        return Response::json(['status' => 200, 'posts' =>  GACategories::find($id)]);
    }
    
    public function remove(Request $request)
    {
        $req = $request::instance();
        $data = json_decode($req->getContent());
        
        $id = 0;
        foreach($data as $item)
        {
           if(isset($item->id)) {
              if($item->id > 0) {
                $obj = GACategories::find($item->id);
                    if (!is_null($obj)) {
                      $obj->delete();
                    } 
                }  
           }
        }
        return Response::json(['status' => 'success', 'message' =>  'record deleted successfully']);
    }
    
   

    public function proc(Request $request)
    {
        $req = $request::instance();
        $data = json_decode($req->getContent());
        
        /* default values */
        $id = 0;
        $title = "";  
        $shorttitle = "";
        $description = "";
        $type = 0;
        $priority = 0;
        
        foreach($data as $item)
        {
           if(isset($item->id))
              $id = $item->id;
           if(isset($item->type))
              $type = $item->type;  
           if(isset($item->title))
              $title = $item->title;  
           if(isset($item->shorttitle))
              $shorttitle =$item->shorttitle;  
           if(isset($item->description))
              $description = $item->description;  
           if(isset($item->priority))
              $priority = $item->priority;  
        }
        
        if($title == "")
        {
            return Response::json(['status' => 'error','message' => "Please enter title"]);
        }
       
        $obj = new GACategories();
        if($id > 0)
           $obj = GACategories::find($id); 
           
        $obj->title = $title;
        $obj->shorttitle = $shorttitle;
        $obj->description = $description;
        $obj->priority = $priority;
        $obj->type = $type;
        $obj->save();
        $insert_id = $obj->id;
        
        return Response::json(['status' => 'success', 'message' => "Record processed successfully"]);
    }

}

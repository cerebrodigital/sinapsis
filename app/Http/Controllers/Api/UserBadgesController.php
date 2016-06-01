<?php namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\GABadges;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Auth;
use Response;
use File;
use DB;

class GAUserBadgesController extends ApiController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index($page)
	{
        // Show the page
        //return view('admin.newscategory.index');
        /* return Response::json(['status' => 200,'posts' => Blog::skip(($page - 1) * 5)
              ->take(5)
              ->get(['id', 'description', 'introduction'])->toArray()
        ]); */
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
        $userid = 0; // filter records based on user id
        $type = 0;  // 0: all
        $pagesize = 100;
        $pagenumber = 1;
        $order = "priority";
        $direction = "desc";
        
        foreach($data as $item)
        {
           if(isset($item->id))
              $id = $item->id;
           if(isset($item->userid))
              $userid = $item->userid;
           if(isset($item->type))
              $type = $item->type;  
           if(isset($item->pagenumber))
              $pagenumber = $item->pagenumber;
           if(isset($item->pagesize))
              $pagesize = $item->pagesize;
           if(isset($item->order))
              $order = $item->order;  
           if(isset($item->direction))
              $direction = $item->direction;  
        }
        
        $query = DB::table('ga_user_badges')->join('ga_badges', 'ga_badges.id', '=', 'ga_user_badges.badge_id');
        if ($id > 0)
          $query->where('ga_user_badges.id', $id);
        if ($userid > 0)
          $query->where('ga_user_badges.userid', $userid);
        
        if ($type > 0)
          $query->where('ga_user_badges.type', $type);
       
        
        $query->skip(($pagenumber - 1) * $pagesize)
              ->take($pagesize);
        // total records
        
        $data = $query->get();
       
        return Response::json(['status' => 200, 'query' => $query->toSql(), 'Records' => $data]);
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
      
        return Response::json(['status' => 200, 'posts' =>  Blog::find($id)]);
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
           if(isset($item->file)) {
               $file = $item->file;
               if($file != "none" || $file != "") {
                    File::delete('/contents/blog/' . $file);
                }
           }
        }
        if($id > 0) {
            $obj = Blog::find($id);
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
        $type = 0;  
        $status = 1; // 0: enable, 1: disabled
        $isapproved = 1; // 0: un approved, 1: approved
        $title = "";
        $introduction = "";
        $description = "";
        $categories = "";
        $tags = "";
        $url_caption = "";
        
        $priority = 0;
        $parentid = 0;
        $mode = 0;
        
        foreach($data as $item)
        {
           if(isset($item->id))
              $id = $item->id;
           if(isset($item->type))
              $type = $item->type;  
           if(isset($item->status))
              $status = $item->status;  
           if(isset($item->title))
              $title =$item->title;  
           if(isset($item->introduction))
              $introduction = $item->introduction;  
           if(isset($item->description))
              $description = $item->description;  
           if(isset($item->categories))
              $categories = $item->categories; 
           if(isset($item->tags))
              $tags = $item->tags;
           if(isset($item->url_caption))
              $url_caption = $item->url_caption; 
           if(isset($item->mode))
              $mode = $item->mode;  
           if(isset($item->parentid))
              $parentid =$item->parentid;  
          
        }
        
        if($title == "")
        {
            return Response::json(['status' => 'error','message' => "Please enter title"]);
        }
        
        if($parentid == "")
          $parentid = 0;
        
        $obj = new Blog();
        if($id > 0)
           $obj = Blog::find($id); 
           
        $obj->title = $title;
        $obj->introduction = $introduction;
        $obj->description = $description;
        $obj->categories = $categories;
        $obj->tags = $tags;
        $obj->status = $status;
        $obj->url_caption = $url_caption;
        $obj->type = $type;
        $obj->mode = $mode;
        $obj->parentid = $parentid;
        $obj->save();
        $insert_id = $obj->id;
        
        return Response::json(['status' => 200, 'message' => "Record processed successfully"]);
    }
    
    public function updatethumb(Request $request)
    {
        $req = $request::instance();
        $data = json_decode($req->getContent());
        
        foreach($data as $item)
        {
            if(isset($item->id))
            {
                 $uobj = Blog::find($item->id);    
                 if(isset($item->icon))
                 $uobj->picturename = $item->icon;
                 $uobj->save();
            }
        }
        return Response::json(['status' => 'success', 'message' => "File Updated"]);
    }
    
    public function removethumb(Request $request)
    {
        $req = $request::instance();
        $data = json_decode($req->getContent());
        
        foreach($data as $item)
        {
            if(isset($item->icon))
            {
                $filePath = public_path() . '/contents/blog/' . $item->icon;
                if (File::exists($filePath)) 
                {
                    File::delete($filePath);
                }
                   
            }
        }
        return Response::json(['status' => 'success', 'message' => "File Updated"]);
    }
    
    public function action(Request $request)
    {
        $req = $request::instance();
        $data = json_decode($req->getContent());
        
        $action = "";
        foreach($data as $item)
        {
           if(isset($item->id)) {
              if(!isset($item->status)) {
                  return Response::json(['status' => 'error', 'message' =>  'please select type of action to perform']);
              }
              
              switch($item->status)
              {
                  case 'enable':
                     $uobj = Blog::find($item->id); 
                     if($uobj->status==0) {
                          $uobj->status = 1;
                          $uobj->save();
                     }
                     $action= "enabled";
                     break;
                     
                  case 'disable':
                     $uobj = Blog::find($item->id); 
                     if($uobj->status==1) {
                          $uobj->status = 0;
                          $uobj->save();
                     }
                     $action = "disabled";
                     break;
                     
                  case 'approve':
                     $uobj = Blog::find($item->id); 
                     if($uobj->isapproved==1) {
                          $uobj->isapproved = 1;
                          $uobj->save();
                     }
                     $action = "approved";
                     break;
                  
                  case 'featured':
                     $uobj = Blog::find($item->id); 
                     if($uobj->isfeatured !=1) {
                          $uobj->isfeatured = 1;
                          $uobj->save();
                     }
                     $action = "marked as featured";
                     break;
                 
                  case 'premium':
                     $uobj = Blog::find($item->id); 
                     if($uobj->isfeatured !=2) {
                          $uobj->isfeatured = 2;
                          $uobj->save();
                     }
                     $action = "marked as premium";
                     break;
                  
                  case 'normal':
                     $uobj = Blog::find($item->id); 
                     if($uobj->isfeatured !=0) {
                          $uobj->isfeatured = 0;
                          $uobj->save();
                     }
                     $action = "marked as normal";
                     break;
                     
                  case 'ecomments':
                     $uobj = Blog::find($item->id); 
                     if($uobj->iscomments !=1) {
                          $uobj->iscomments = 1;
                          $uobj->save();
                     }
                     $action = "enabled comments";
                     break;
                  
                  case 'dcomments':
                     $uobj = Blog::find($item->id); 
                     if($uobj->iscomments !=0) {
                          $uobj->iscomments = 0;
                          $uobj->save();
                     }
                     $action = "disabled comments";
                     break;
                     
                   case 'adult':
                     $uobj = Blog::find($item->id); 
                     if($uobj->isadult !=1) {
                          $uobj->isadult = 1;
                          $uobj->save();
                     }
                     $action = "marked as adult";
                     break;
                  
                   case 'nadult':
                     $uobj = Blog::find($item->id); 
                     if($uobj->isadult !=0) {
                          $uobj->isadult = 0;
                          $uobj->save();
                     }
                     $action = "marked as non adult";
                     break;
                     
                  case 'delete':
                     $uobj = Blog::find($item->id); 
                     if($uobj->picturename != 'none') {
                         $filePath = public_path() . '/contents/blog/' . $item->picturename;
                         if (File::exists($filePath)) 
                            File::delete($filePath);
                     }
                     if (!is_null($uobj)) {
                        $uobj->delete();
                     } 
                     $action = "deleted";
                     break;
              }
           }
        }
       
        return Response::json(['status' => 200, 'message' =>  'Records ' . $action . ' successfully']);
    }
    
   
    
    public function upload() 
    {
       
        // HTTP headers for no cache etc
        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header("Cache-Control: no-store, no-cache, must-revalidate");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        
        try
        {
        	// Settings
        	
        	$targetDir = public_path() . '/contents/blog';
        		
        	$cleanupTargetDir = true; // Remove old files
        	$maxFileAge = 5 * 3600; // Temp file age in seconds
        	
        	// 5 minutes execution time
        	@set_time_limit(5 * 60);
        	
        	// Uncomment this one to fake upload time
        	// usleep(5000);
        	
        	// Get parameters
        	$chunk = isset($_REQUEST["chunk"]) ? intval($_REQUEST["chunk"]) : 0;
        	$chunks = isset($_REQUEST["chunks"]) ? intval($_REQUEST["chunks"]) : 0;
        	$fName = isset($_REQUEST["name"]) ? $_REQUEST["name"] : '';
        	
        	// filename preparation
        	
        	// avoid duplication
        	$oFileName = preg_replace('/[^\w\._]+/', '_', $fName);
        	$fileName = mt_rand(0,mt_getrandmax()) . "_" . $oFileName;
        
        	// Make sure the fileName is unique but only if chunking is disabled
        	if ($chunks < 2 && file_exists($targetDir . DIRECTORY_SEPARATOR . $fileName)) {
        		$ext = strrpos($fileName, '.');
        		$fileName_a = substr($fileName, 0, $ext);
        		$fileName_b = substr($fileName, $ext);
        	
        		$count = 1;
        		while (file_exists($targetDir . DIRECTORY_SEPARATOR . $fileName_a . '_' . $count . $fileName_b))
        			$count++;
        	
        		$fileName = $fileName_a . '_' . $count . $fileName_b;
        	}
        	
        	$filePath = $targetDir . DIRECTORY_SEPARATOR . $fileName;
        	
        	// Create target dir
        	if (!file_exists($targetDir))
        		@mkdir($targetDir);
        	
        	// Remove old temp files	
        	if ($cleanupTargetDir) {
        		if (is_dir($targetDir) && ($dir = opendir($targetDir))) {
        			while (($file = readdir($dir)) !== false) {
        				$tmpfilePath = $targetDir . DIRECTORY_SEPARATOR . $file;
        	
        				// Remove temp file if it is older than the max age and is not the current file
        				if (preg_match('/\.part$/', $file) && (filemtime($tmpfilePath) < time() - $maxFileAge) && ($tmpfilePath != "{$filePath}.part")) {
        					@unlink($tmpfilePath);
        				}
        			}
        			closedir($dir);
        		} else {
        			die('{"jsonrpc" : "2.0", "error" : {"code": 100, "message": "Failed to open temp directory."}, "id" : "id"}');
        		}
        	}	
        	
        	// Look for the content type header
        	if (isset($_SERVER["HTTP_CONTENT_TYPE"]))
        		$contentType = $_SERVER["HTTP_CONTENT_TYPE"];
        	
        	if (isset($_SERVER["CONTENT_TYPE"]))
        		$contentType = $_SERVER["CONTENT_TYPE"];
        	
        	// Handle non multipart uploads older WebKit versions didn't support multipart in HTML5
        	if (strpos($contentType, "multipart") !== false) {
        		if (isset($_FILES['file']['tmp_name']) && is_uploaded_file($_FILES['file']['tmp_name'])) {
        			// Open temp file
        			$out = @fopen("{$filePath}.part", $chunk == 0 ? "wb" : "ab");
        			if ($out) {
        				// Read binary input stream and append it to temp file
        				$in = @fopen($_FILES['file']['tmp_name'], "rb");
        	
        				if ($in) {
        					while ($buff = fread($in, 4096))
        						fwrite($out, $buff);
        				} else
        					die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
        				@fclose($in);
        				@fclose($out);
        				@unlink($_FILES['file']['tmp_name']);
        			} else
        				die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
        		} else
        			die('{"jsonrpc" : "2.0", "error" : {"code": 103, "message": "Failed to move uploaded file."}, "id" : "id"}');
        	} else {
        		// Open temp file
        		$out = @fopen("{$filePath}.part", $chunk == 0 ? "wb" : "ab");
        		if ($out) {
        			// Read binary input stream and append it to temp file
        			$in = @fopen("php://input", "rb");
        	
        			if ($in) {
        				while ($buff = fread($in, 4096))
        					fwrite($out, $buff);
        			} else
        				die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
        	
        			@fclose($in);
        			@fclose($out);
        		} else
        			die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
        	}
        	
        	// Check if file has been uploaded
        	if (!$chunks || $chunk == $chunks - 1) {
        		// Strip the temp .part suffix off 
        		rename("{$filePath}.part", $filePath);
        	}
        			
        	//$url = Request::root() . "contents/" . $fileName;
        	$url =  Request::root() . "image/get/150x100/" . $fileName;
        	
        	$fileType = ".jpg";
        	 
        	die('{"jsonrpc" : "2.0", "result" : "OK", "id" : "id", "fname" : "' . $fileName . '", "url" : "' . $url . '", "filetype" : "' . $fileType . '", "filename" : "' . $fileName . '"}');
        }
        catch (Exception $e) 
        {
        	die('{"jsonrpc" : "2.0", "error" : {"code": 1000, "message": ' . $e->getMessage() . '"}, "id" : "id"}');
        }
    }	
	


}

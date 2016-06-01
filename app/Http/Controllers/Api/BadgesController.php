<?php namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\GABadges;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Auth;
use Response;
use File;


class GABadgesController extends ApiController {

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
        $isdeduct = 2;
        $ilevel = 0;
        $ishide = 2;
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
           if(isset($item->isdeduct))
              $isdeduct =$item->isdeduct;  
           if(isset($item->ilevel))
              $ilevel =$item->ilevel;  
           if(isset($item->ishide))
              $ishide =$item->ishide;  
        }
        
        $query = GABadges::orderBy($order, $direction);

        if ($id > 0)
          $query->where('id', $id);
        if ($type > 0)
          $query->where('type', $type);
        if ($category_id > 0)
          $query->where('category_id', $category_id);
        if ($isdeduct != 2)
          $query->where('isdeduct', $isdeduct);
        if ($ilevel > 0)
          $query->where('ilevel', $ilevel);
        if ($ishide != 2)
          $query->where('ishide', $ishide);
          
       // $records = $query->count();
        
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
      
        return Response::json(['status' => 200, 'posts' =>  GABadges::find($id)]);
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
           if(isset($item->icon)) {
               $file = $item->icon;
               if($file != "none" || $file != "") {
                    File::delete('/contents/badges/' . $file);
                }
           }
        }
        if($id > 0) {
            $obj = GABadges::find($id);
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
        $icon = "";
        $icon_sm = "";
        $icon_lg = "";
        $category_id = 0;
        $type = 0;
        $icon_css = "";
        $priority = "";
        $credits = 0;
        $xp = 0;

        $price = 0;
        $notification = "";
        $isdeduct = "";
        $ilevel = 0;
        $ishide = 0;
	
        foreach($data as $item)
        {
           if(isset($item->id))
              $id = $item->id;
           if(isset($item->title))
              $title = $item->title;  
           if(isset($item->description))
              $description = $item->description;  
           if(isset($item->icon))
              $icon =$item->icon;  
           if(isset($item->icon_sm))
              $icon_sm = $item->icon_sm;  
           if(isset($item->icon_lg))
              $icon_lg = $item->icon_lg;  
           if(isset($item->category_id))
              $category_id = $item->category_id; 
           if(isset($item->type))
              $type = $item->type;
           if(isset($item->icon_css))
              $icon_css = $item->icon_css; 
           if(isset($item->priority))
              $priority = $item->priority;  
           if(isset($item->credits))
              $credits =$item->credits;  
              
           if(isset($item->xp))
              $xp = $item->xp; 
           if(isset($item->price))
              $price = $item->price;  
           if(isset($item->notification))
              $notification =$item->notification;  
              
            if(isset($item->isdeduct))
              $isdeduct = $item->isdeduct; 
           if(isset($item->ilevel))
              $ilevel = $item->ilevel;  
           if(isset($item->ishide))
              $ishide =$item->ishide; 
          
        }
        
        if($title == "")
        {
            return Response::json(['status' => 'error','message' => "Please enter title"]);
        }
        
        $obj = new GABadges();
        if($id > 0)
           $obj = GABadges::find($id); 
           
        $obj->title = $title;
        $obj->description = $description;
        $obj->icon = $icon;
        $obj->icon_sm = $icon_sm;
        $obj->icon_lg = $icon_lg;
        $obj->category_id = $category_id;
        $obj->type = $type;
        $obj->icon_css = $icon_css;
        $obj->priority = $priority;
        $obj->credits = $credits;
        
        $obj->xp = $xp;
        $obj->price = $price;
        $obj->notification = $notification;
        $obj->isdeduct = $isdeduct;
        $obj->ilevel = $ilevel;
        $obj->ishide = $ishide;
        $obj->save();
        $insert_id = $obj->id;
        
        return Response::json(['status' => 'success', 'id' => $insert_id, 'message' => "Record processed successfully"]);
    }
    
    public function updatethumb(Request $request)
    {
        $req = $request::instance();
        $data = json_decode($req->getContent());
        
        foreach($data as $item)
        {
            if(isset($item->id))
            {
                 $uobj = GABadges::find($item->id);    
                 if(isset($item->icon))
                 $uobj->icon = $item->icon;
                 
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
                $filePath = public_path() . '/contents/badges/' . $item->icon;
                if (File::exists($filePath)) 
                {
                    File::delete($filePath);
                }
                   
            }
        }
        return Response::json(['status' => 'success', 'message' => "File Updated"]);
    }
    
    public function getmax()
    {
        $ilevel = GABadges::max('ilevel');
        $ilevel++;
        return Response::json(['status' => 200, 'level' =>  $ilevel]);
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
        	
        	$targetDir = public_path() . '/contents/badges';
        		
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

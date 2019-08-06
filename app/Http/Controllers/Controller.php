<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function fileuploadProjectsActivity($key){
	
        $destinationPath = 'images/'.date('Y').'/'.date('M');
        $filename = time().'_'.$key->getClientOriginalName();
        $upload_success = $key->move($destinationPath, $filename);
        $uploaded_file = 'images/'.date('Y').'/'.date('M').'/'.$filename;        
        return $uploaded_file;
    }
}

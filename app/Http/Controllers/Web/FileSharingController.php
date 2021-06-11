<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Model\FileSharing;
use App\Model\SiteProperty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class FileSharingController extends Controller
{
public function index(){
    $site_props = new SiteProperty();
    $max_size_file = ($site_props->getByPropName('MAX_FILE_SHARING_SIZE'))->prop_value;

    return view('web.fileSharing.index', compact([
        'max_size_file'
    ]));
}

public function managePage(){
if(Auth::check() && Auth::user()->role_id == 1){
    $site_props = new SiteProperty();
    $max_size_file = ($site_props->getByPropName('MAX_FILE_SHARING_SIZE'))->prop_value;

    return view('admin.file-sharing.index', compact([
        'max_size_file'
    ]));
}
}


public function editFileShareSettings(Request $request){
if(Auth::check() && Auth::user()->role_id == 1){
    if($request->ajax()) {
        $site_props = new SiteProperty();
        $input = $request->all();
        $propVal = trim(htmlspecialchars($input['title']));
        $max_size_file = $site_props->setByPropName('MAX_FILE_SHARING_SIZE', $propVal);

        return Response::json([
            'maxFileSize' => $max_size_file,
        ], 200);

    }
}
}



public function uploadFile(Request $request){
    if ($request->ajax())
    {

        $forum = new FileSharing();
        $result = $forum->uploadFile($request);

        return Response::json($result, 200);
    }
}

public function downloadPage($fileName){

    $file = FileSharing::where(['file_name' => $fileName])->get()->first();

    return view('web.fileSharing.download_file', compact([
        'file'
    ]));

}


}

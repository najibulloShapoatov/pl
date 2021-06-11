<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class BookLicense extends Model
{

    protected $fillable = [
        'title',
        'image',
        'descr'
    ];
    //

    public  function getListLic(){
        return $this->orderBy('title', 'asc')->get();
    }



    public function getList()
    {
        if (Auth::check() && Auth::user()->role_id == 4){
            return $this->orderBy('title', 'asc')->paginate(10);
        }
        else{
            return $this->orderBy('title', 'asc')->get();
        }
    }

    public  function getByID($id){
        return $this->where('id', $id)->get()->first();
    }

    public function  remove($id){
        $lic = $this->getByID($id);
        $path = public_path('/uploads/books/licenses/' . $lic->id) ;
        if (is_dir($path)) {
            File::deleteDirectory($path);
        }
        return $lic->delete();
    }

    public function create(Request $request){

        $input = $request->all();
        $title = trim(htmlspecialchars($input['title']));
        $descr = trim(htmlspecialchars($input['descr']));

        if(empty($title)){ return [ 'sts' => 1, 'error' => __('lang.enter_name_lic')];}
        if(empty($file = $request->file('file'))){ return [ 'sts' => 1, 'error' => __('lang.add_image_lic')];}
        $lic = new BookLicense();
        $lic->title = $title;
        $lic->descr = $descr;
        $lic->save();


        if($file = $request->file('file')) {
            $path = public_path('/uploads/books/licenses/' . $lic->id) ;
            mkdir($path, 0777, true);

            $image = $request->file('file');
            $extension = $file->getClientOriginalExtension();
            $imageName = time() . '_' . uniqid() . '.' . $extension;
            $img = Image::make($image);
            $img->save($path . '/' . $imageName);
            $img->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $lic->image = $imageName;
            $result = $lic->save();
            return [ 'sts' => 0, 'error' => ''];
        }
        return [ 'sts' => 0, 'error' => ''];

    }

    public function updateEdit(Request $request)
    {
        $input = $request->all();
        $id = trim(htmlspecialchars($input['id']));
        $title = trim(htmlspecialchars($input['title']));
        $descr = trim(htmlspecialchars($input['descr']));

        if(empty($title)){ return [ 'sts' => 1, 'error' => __('lang.enter_name_lic')];}
        $lic = $this->getByID($id);
        $lic->title = $title;
        $lic->descr = $descr;
        $lic->save();

        if($file = $request->file('file')) {
            $path = public_path('uploads/books/licenses/' . $lic->id) ;
            if (is_dir($path)) {
                File::deleteDirectory($path);
            }
            mkdir($path, 0777, true);

            $image = $request->file('file');
            $extension = $file->getClientOriginalExtension();
            $imageName = time() . '_' . uniqid() . '.' . $extension;
            $img = Image::make($image);
            $img->save($path . '/' . $imageName);
            $img->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $lic->image = $imageName;
            $result = $lic->save();
            return [ 'sts' => 0, 'error' => ''];
        }
        return [ 'sts' => 0, 'error' => ''];
    }
}

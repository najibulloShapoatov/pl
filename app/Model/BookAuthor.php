<?php

namespace App\Model;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;


class BookAuthor extends Model
{
    protected $fillable = [
        'name',
        'image',
        'descr'
    ];
    //
    public function getListAuthor()
    {
        return $this->orderBy('name', 'asc')->get();
    }


    public function getList()
    {
        if (Auth::check() && Auth::user()->role_id == 4){
            return $this->orderBy('name', 'asc')->paginate(10);
        }
        else{
            return $this->orderBy('name', 'asc')->get();
        }
    }

    public  function getByID($id){
        return $this->where('id', $id)->get()->first();
    }

    public function  remove($id){
        $author = $this->getByID($id);
        $path = public_path('/uploads/books/authors/' . $author->id) ;
        if (is_dir($path)) {
          File::deleteDirectory($path);
        }
        return $author->delete();
    }

    public function create(Request $request){

        $input = $request->all();
        $name = trim(htmlspecialchars($input['name']));
        $descr = trim(htmlspecialchars($input['descr']));

        if(empty($name)){ return [ 'sts' => 1, 'error' => __('lang.enter_name_author')];}
        $author = new BookAuthor();
        $author->name = $name;
        $author->descr = $descr;
        $author->save();

        if($file = $request->file('file')) {
            $path = public_path('/uploads/books/authors/' . $author->id) ;
            mkdir($path, 0777, true);

            $image = $request->file('file');
            $extension = $file->getClientOriginalExtension();
            $imageName = time() . '_' . uniqid() . '.' . $extension;
            $img = Image::make($image);
            $img->save($path . '/' . $imageName);
            $img->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $author->image = $imageName;
            $result = $author->save();
            return [ 'sts' => 0, 'error' => ''];
        }
        return [ 'sts' => 0, 'error' => ''];

    }

    public function updateEdit(Request $request)
    {
        $input = $request->all();
        $id = trim(htmlspecialchars($input['id']));
        $name = trim(htmlspecialchars($input['name']));
        $descr = trim(htmlspecialchars($input['descr']));

        if(empty($name)){ return [ 'sts' => 1, 'error' => __('lang.enter_name_author')];}
        $author = $this->getByID($id);
        $author->name = $name;
        $author->descr = $descr;
        $author->save();

        if($file = $request->file('file')) {
            $path = public_path('uploads/books/authors/' . $author->id) ;
            if (is_dir($path)) {
                File::deleteDirectory($path);
                mkdir($path, 0777, true);
            }
            if (!is_dir($path)) {
                mkdir($path, 0777, true);
            }



            $image = $request->file('file');
            $extension = $file->getClientOriginalExtension();
            $imageName = time() . '_' . uniqid() . '.' . $extension;
            $img = Image::make($image);
            $img->save($path . '/' . $imageName);
            $img->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $author->image = $imageName;
            $result = $author->save();
            return [ 'sts' => 0, 'error' => ''];
        }
        return [ 'sts' => 0, 'error' => ''];
    }
}

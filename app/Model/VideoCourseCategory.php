<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

class VideoCourseCategory extends Model
{
    protected $fillable = [
        'title',
        'description',
    ];


    public function courses(){
        return $this->hasMany('App\Model\VideoCourse', 'category_id');
    }


    //get list category
    public function getList()
    {
        return $this->orderBy('title', 'asc')->get();
    }

    //get category by ID
    public function getByID($id)
    {
        return $this->where(['id' => $id])->get()->first();
    }








    /*=====================================================================*/

    //get list category
    public function getListAdm()
    {
        return $this->orderBy('updated_at', 'desc')->paginate(15);
    }

    //remove
    public function removeCategory($ID)
    {
        $cat =  $this->getByID($ID);

        foreach ($cat->courses as $course){
            if (is_dir('public/uploads/videocourse/' . $course->id)) {
                File::deleteDirectory(public_path('uploads/videocourse/' . $course->id));
            }
            $course->galeries()->delete();
        }
        $cat->courses()->delete();

        return $cat->delete();
    }

    //create
    public function createCategory($input)
    {
        $title = htmlspecialchars($input['title']);

        $cat = new VideoCourseCategory();

        $cat->title = $title;
        $cat->save();
        return $cat;
    }



    //update category info
    public function updateCategory($input)
    {
        $ID = htmlspecialchars($input['id']);
        $title = htmlspecialchars($input['title']);

        $f_cat = $this->where(['id' => $ID])->get()->first();
        $f_cat->title = $title;
        $f_cat->save();

        return $f_cat;

    }

}

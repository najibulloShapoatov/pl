<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

use Intervention\Image\Facades\Image;

class VideoCourse extends Model
{
    protected $fillable = [
        'category_id',
        'title',
        'description',
        'image',
        'duration',
        'file',
        'is_active',
    ];

    public function galeries(){
        return $this->hasMany('App\Model\VideoCourseGallery');
    }


    public function category(){
        return $this->belongsTo('App\Model\VideoCourseCategory');
    }


    //get Course By ID
    public function getByID($id)
    {
        return $this->where(['is_active' => 1, 'id' => $id])->get()->first();
    }


    //get course by User Id
    public function getByUserID($id)
    {
        return $this->where(['is_active'=> 1, 'user_id' => $id])->orderBy('title', 'asc')->get();
    }


    //remove course
    public function removeCourse($userID, $id)
    {
        $course =$this->where(['id' => $id, 'user_id' => $userID])->get()->first();

        $course->galeries()->delete();

        if (is_dir('public/uploads/videocourse/' . $id)) {
            File::deleteDirectory(public_path('uploads/videocourse/' . $id));
        }
       $result = $course->delete();
       return $result;
    }
    //edit course page
    public function editCoursePage($userID, $id)
    {
       return $this->where(['id' => $id, 'is_active' => 1, 'user_id' => $userID])->get()->first();
    }

    //save edited course
    public function saveEditedCourse( Request $request, $userID)
    {
        $input = $request->all();
        $catID = trim(htmlspecialchars($input['category_id']));
        $courseID = trim(htmlspecialchars($input['course_id']));
        $title = trim(htmlspecialchars($input['title']));
        $descr = trim(htmlspecialchars($input['descr']));

        $course = $this->where(['id' => $courseID, 'user_id' => $userID])->get()->first();

        $course->category_id = $catID;
        $course->title = $title;
        $course->description = $descr;

        $path = public_path('uploads/videocourse/' . $course->id);
        if($file = $request->file('file')) {
        if(File::exists( $path . '/'.  $course->id . '/' . $course->image)){
            File::delete($path  . '/'. $course->id . '/' . $course->image);}
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

            $course->image = $imageName;


        }

        return $course->save();
    }

    //create new course
    public function createCourse(Request $request, $userID)
    {
        $input = $request->all();

        $categoryID = trim(htmlspecialchars($input['category_id']));
        $title = trim(htmlspecialchars($input['title']));
        $duration = trim(htmlspecialchars($input['duration']));
        $descr = trim(htmlspecialchars($input['descr']));

        $course = new VideoCourse();




        $course->category_id = $categoryID;
        $course->user_id = $userID;
        $course->title = $title;
        $course->description = $descr;
        $course->duration = $duration;
        $course->is_active = 1;
        $course->save();
        $path = public_path('uploads/videocourse/' . $course->id);
        if($file = $request->file('file')) {
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

            $course->image = $imageName;
            $course->save();

        }


        return [
            'id' => $course->id,
        ];

    }


    /*===================Admin=======================================================*/

    public function getListAdm()
    {
        return $this->orderBy('updated_at', 'desc')->paginate(15);
    }

    //change active news
    public function changeActive($input)
    {
        $ID = htmlspecialchars($input['id']);

        $course = $this->where('id', $ID)->get()->first();

        if($course->is_active == 1){
            $course->is_active = 0;
        }else{
            $course->is_active = 1;
        }
        $course->save();

        return $course->is_active;

    }


    //remove course
    public function removeCourseAdm( $id)
    {
        $course =$this->where(['id' => $id])->get()->first();

        $course->galeries()->delete();

        if (is_dir('public/uploads/videocourse/' . $id)) {
            File::deleteDirectory(public_path('uploads/videocourse/' . $id));
        }
        $result = $course->delete();
        return $result;
    }

    public function search($search)
    {
        $data = VideoCourse::where('title', 'like','%'.$search.'%')
            ->orWhere('description', 'like', '%'.$search.'%')
            ->orderBy('created_at', 'desc')
            ->get();


        return $data;
    }

}

<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Model\VideoCourse;
use App\Model\VideoCourseCategory;
use App\Model\VideoCourseGallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;

class VideoCourseController extends Controller
{
public function index(){

    $videoCategory = new VideoCourseCategory();
    $categories = $videoCategory->getList();

    return view('web.video_course.index', compact([
        'categories'
    ]));
}


//my Courses
public function myCourses(){
    if(Auth::check() && ( Auth::user()->role->id == 2 || Auth::user()->role->id == 1) ) {
        $course = new VideoCourse();
        $mycourse = $course->getByUserID(Auth::user()->id);

        return view('web.video_course.my-courses', compact([
            'mycourse'
        ]));
    }
    return redirect('/');
}

//my Courses
public function deleteCourse($id){

    if(Auth::check() && ( Auth::user()->role->id == 2 || Auth::user()->role->id == 1) ) {

        $course = new VideoCourse();
        $res = $course->removeCourse(Auth::user()->id, $id);

        if($res) {
            $course = new VideoCourse();
            $mycourse = $course->getByUserID(Auth::user()->id);

            return view('web.video_course.my-courses', compact([
                'mycourse'
            ]));
        }
    }
    return redirect('/');
}



public function addCourse(){
    if(Auth::check() && ( Auth::user()->role->id == 2 || Auth::user()->role->id == 1) ) {
        $videoCategory = new VideoCourseCategory();
        $categories = $videoCategory->getList();

        return view('web.video_course.add-course', compact([
            'categories',
        ]));
    }
}

//single videocourse
public function singleCourse($id){

    $videocourses = new VideoCourse();
    $videocourse = $videocourses->getByID($id);
    if($videocourse != null) {
        return view('web.video_course.single-course', compact([
            'videocourse',
        ]));
    }
    else{
        return redirect('/video-course');
    }
}


// get By Category ID
public function catCourse($id){

    $videoCategory = new VideoCourseCategory();
    $categories = $videoCategory->getList();
    $categorySelected = $videoCategory->getByID($id);

    return view('web.video_course.course-cat', compact([
        'categories',
        'categorySelected',
    ]));
}



public function editCourse($id){

    if(Auth::check() && ( Auth::user()->role->id == 2 || Auth::user()->role->id == 1) ) {
            $course = new VideoCourse();
            $mycourse = $course->editCoursePage(Auth::user()->id, $id);

            $videoCategory = new VideoCourseCategory();
            $categories = $videoCategory->getList();

            return view('web.video_course.edit-course', compact([
                'mycourse',
                'categories',
            ]));

    }
    return redirect('/');

}

//play video in modal
    public function playVideo(Request $request)
    {
        if ($request->ajax())
        {
            $input = $request->all();
            $forum = new VideoCourseGallery();
            $result = $forum->playVideo($input);

            return Response::json($result, 200);
        }
    }

//delete video in video course
    public function deleteVideo(Request $request)
    {
        if(Auth::check() && ( Auth::user()->role->id == 2 || Auth::user()->role->id == 1) ) {
            if ($request->ajax()) {
                $input = $request->all();
                $forum = new VideoCourseGallery();
                $result = $forum->deleteVideo($input);

                return Response::json($result, 200);
            }
        }
    }

//save edited course
public function saveEditedCourse(Request $request)
    {
        if(Auth::check() && ( Auth::user()->role->id == 2 || Auth::user()->role->id == 1) ) {
            if ($request->ajax()) {

                $course = new VideoCourse();
                $result = $course->saveEditedCourse($request, Auth::user()->id);

                return Response::json($result, 200);
            }
        }
    }

//create course
public function createCourse(Request $request)
{
    if(Auth::check() && ( Auth::user()->role->id == 2 || Auth::user()->role->id == 1) ) {
        if ($request->ajax()) {

            $course = new VideoCourse();
            $result = $course->createCourse($request, Auth::user()->id);

            return Response::json($result, 200);
        }
    }
}

//add course voideo
    public function addCourseVideo(Request $request)
    {
        if(Auth::check() && ( Auth::user()->role->id == 2 || Auth::user()->role->id == 1) ) {

            if ($request->ajax()) {
                $course = new VideoCourseGallery();
                $result = $course->addVideoOnCourse($request);

                return Response::json($result, 200);
            }
        }
    }




    /*====================Admin========================================================*/

    public function indexAdm(){
        if(Auth::check() && Auth::user()->role_id == 1){

            $VideoCourse = new VideoCourse();
            $courses = $VideoCourse->getListAdm();

            return view('admin.videocourse.index',compact([
                'courses'
            ]));
        }
        return redirect('/video-course');

    }

    //change forum active
    public function changeActiveAdm(Request $request){

        if(Auth::check() && Auth::user()->role_id == 1){
            if ($request->ajax())
            {
                $input = $request->all();
                $course = new VideoCourse();
                $data = $course->changeActive($input);
                return Response::json($data, 200);
            }

        }
        return redirect('/video-course');

    }

    //delete forum
    public function removeCourseAdm(Request $request){

        if(Auth::check() && Auth::user()->role_id == 1){
            if ($request->ajax())
            {
                $input = $request->all();
                $id =  htmlspecialchars($input['id']);
                $forum = new VideoCourse();
                $data = $forum->removeCourseAdm($id);
                return Response::json($data, 200);
            }

        }
        return redirect('/video-course');

    }





    public function indexAdmCat(){

        if(Auth::check() && Auth::user()->role_id == 1){

            $VideoCat = new VideoCourseCategory();
            $cat = $VideoCat->getListAdm();

            return view('admin.videocourse.category',compact([
                'cat'
            ]));
        }
        return redirect('/video-course');

    }



    //remove Forum Category
    public function removeCatCourse(Request $request){

        if(Auth::check() && Auth::user()->role_id == 1){

            $input =$request->all();
            $ID = htmlspecialchars($input['id']);
            $VideoCat = new VideoCourseCategory();
            $Cat = $VideoCat->removeCategory($ID);


            return Response::json($Cat, 200);

        }
        return redirect('/video-course');

    }


    //create Course Category
    public function createCatCourse(Request $request){

        if(Auth::check() && Auth::user()->role_id == 1){

            $input =$request->all();
            $VideoCat = new VideoCourseCategory();
            $cat = $VideoCat->createCategory($input);

            $html = View::make('admin.videocourse._cat', compact('cat'))->render();

            return Response::json([ 'html' => $html, 'id' => $cat->id], 200);

        }
        return redirect('/video-course');

    }




        //cancel Edit
        public function cancelCatCourse(Request $request){

            if(Auth::check() && Auth::user()->role_id == 1){

                $input =$request->all();
                $ID = htmlspecialchars($input['id']);
                $VideoCat = new VideoCourseCategory();
                $cat = $VideoCat->getByID($ID);

                $html = View::make('admin.videocourse._cat', compact('cat'))->render();

                return Response::json($html, 200);

            }
            return redirect('/video-course');

        }


            //save Edit
            public function saveCatCourse(Request $request){

                if(Auth::check() && Auth::user()->role_id == 1){

                    $input =$request->all();
                    $VideoCat = new VideoCourseCategory();
                    $cat = $VideoCat->updateCategory($input);

                    $html = View::make('admin.videocourse._cat', compact('cat'))->render();

                    return Response::json($html, 200);

                }
                return redirect('/video-course');

            }






}

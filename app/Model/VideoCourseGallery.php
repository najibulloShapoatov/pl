<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class VideoCourseGallery extends Model
{
    protected $fillable = [
        'video_course_id',
        'title',
        'image',
        'video',
        'video_duration',
    ];



    //play video on course
    public function playVideo($input)
    {
        $videoID = trim(htmlspecialchars($input['video_id']));
        $courseID = trim(htmlspecialchars($input['course_id']));

        $video = $this->where(['id' => $videoID, 'video_course_id' => $courseID])->get()->first();

        $vImage=null;
        if($video->image) {
            $vImage ='/public/uploads/videocourse/' . $courseID . '/' . $video->id . '/' . $video->image;
        }
        return [
            'image' => $vImage,
            'video' => '/public/uploads/videocourse/' . $courseID. '/' . $video->id . '/' . $video->video,
        ];


    }

    //delete video on course
    public function deleteVideo( $input)
    {
        $videoID = trim(htmlspecialchars($input['video_id']));
        $courseID = trim(htmlspecialchars($input['course_id']));


        $video = $this->where(['id' => $videoID, 'video_course_id' => $courseID])->get()->first();

        if (is_dir('public/uploads/videocourse/' . $courseID. '/' . $video->id)) {
            File::deleteDirectory(public_path('uploads/videocourse/' . $courseID. '/' . $video->id));
        }


        $course = VideoCourse::where(['id' =>$courseID, 'user_id' => Auth::user()->id])->get()->first();
        $course->duration = (int)$course->duration - (int)$video->duration_video;
        $course->save();
        $video->delete();
        return [
            'duration_course' => $course->duration,
        ];
    }

//--------------------------------------------------------------------------------------------------------//
    //add video on course
    public function addVideoOnCourse(Request $request)
    {
        $input = $request->all();
        $corseID = trim(htmlspecialchars($input['course_id']));
        $videoName = trim(htmlspecialchars($input['title']));
        $dursec = trim(htmlspecialchars($input['dur_sec']));


        if(empty($corseID) && empty($request->file('file')) && empty($videoName)){ return false;}



        $vid = new VideoCourseGallery();
        $vid->video_course_id = $corseID;
        $vid->title = $videoName;
        $vid->video = $videoName;
        $vid->duration_video = $dursec;
        $vid_saved = $vid->save();

        $path = public_path('uploads/videocourse/' . $corseID. '/' . $vid->id . '/');
        if($vid_saved) {
            if ($file = $request->file('file')) {
                if (!is_dir($path)) {
                    mkdir($path, 0777, true);
                }

                $myfile = $request->file('file');
                $extension = $file->getClientOriginalExtension();
                $fileName = time() . '_' . uniqid() . '.' . $extension;
                $myfile->move($path, $fileName);

                $vid->video = $fileName;
                $result = $vid->save();

            }
        }

        $has_image = null;
        if($file = $request->file('image')) {
            if (!is_dir($path)) {
                mkdir($path, 0777, true);
            }
            $image = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $imageName = time() . '_' . uniqid() . '.' . $extension;
            $img = Image::make($image);

            $img->save($path . '/' . $imageName);

            $img->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $vid->image = $imageName;
            $has_image = $vid->save();

        }


        $course = VideoCourse::where(['id' =>$corseID, 'user_id' => Auth::user()->id])->get()->first();
        $course->duration = (int)$course->duration + (int)$dursec;
        $course->save();

        return [
            'video_id' => $vid->id,
            'has_image' => $has_image,
            'image' => '/public/uploads/videocourse/' . $corseID . '/' . $vid->id . '/' . $vid->image ,
            'duration_course' => $course->duration,

        ];
    }




}

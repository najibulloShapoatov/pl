<?php

namespace App\Model;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

use FFMpeg;
use FFMpeg\FFProbe;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use Symfony\Component\Console\Input\Input;


require 'vendor/autoload.php';
class Community extends Model
{




    public function posts()
    {
        return $this->hasMany('App\Model\CommunityPost');
    }
    public function paricipants(){
        return $this->hasMany('App\Model\CommunityParticipant');
    }
    public function moderable(){
        return $this->belongsTo('App\Model\CommunityCommentModerable', 'community_id');
    }


    public function getList()
    {
        return $this->where('is_active', 1)->orderBy('created_at', 'desc')->get();
    }

    public function getCommunityByID($id)
    {
        return $this->where(['id' => $id, 'is_active' => 1])->get()->first();
    }


    public function updateInfo($userID,  $communityID,  $communityTitle,  $communityText)
    {
        $community = $this->where(['id' => $communityID, 'user_id' => $userID])->get()->first();

        $community->title = $communityTitle;
        $community->description = $communityText;

        $result = $community->save();
        if ($result){
            return $result;
        }


    }

    //update Image Community
    public static function updateImg(Request $request)
    {
        if($file = $request->file('file')) {

            $input = $request->all();
            $communityID = trim(htmlspecialchars($input['id']));

            if (!is_dir('public/uploads/communities/' . $communityID)) {
                mkdir('public/uploads/communities/' . $communityID, 0777, true);
            }

            $path = public_path() . '/uploads/communities/' . $communityID . '/';
            $image = $request->file('file');
            $extension = $file->getClientOriginalExtension();
            $imageName = time() . '_' . uniqid() . '.' . $extension;

            $img = Image::make($image);
            $img->save($path . $imageName);
            $img->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $community = new Community();
            $communityData = $community->where(['id' => $communityID, 'user_id' => Auth::user()->id])->get()->first();

            if(File::exists(public_path('/uploads/communities/' . $communityID . '/' . $communityData->image))){
                File::delete(public_path('/uploads/communities/' . $communityID . '/' . $communityData->image));
            }
            $communityData->image = $imageName;
            $communityData->save();
            return [ 'img' => $imageName];
        }

    }


    //remove Community wuth posts
    public static function removeCommunity(Request $request)
    {
        $input = $request->all();
        $communityID = trim(htmlspecialchars($input['id']));
        $community= Community::find($communityID);

        $community->paricipants()->delete();
        foreach($community->posts as $item){
            $item->likes()->delete();
            $item->comments()->delete();
        }
        $community->posts()->delete();
        (new CommunityCommentModerable())->removeByCommID($community->id);
        if (is_dir('public/uploads/communities/' . $communityID)) {
            File::deleteDirectory(public_path('uploads/communities/' . $communityID));
        }

         $result = $community->delete();



        if($result){
            return $result;
        }


    }

    //Add new Community
    public static function createCommunity(Request $request)
    {
        $input = $request->all();
        $title = trim(htmlspecialchars($input['title']));
        $m_id = trim(htmlspecialchars($input['moderator_id']));
        $text = trim(htmlspecialchars($input['text']));

        $community = new Community();

        $community->user_id = ($m_id == 1)? Auth::user()->id: $m_id;
        $community->title = $title;
        $community->description = $text;
        $result = $community->save();

        if($file = $request->file('file')) {
            $path = public_path('/uploads/communities/' . $community->id) ;
                mkdir($path, 0777, true);

            $image = $request->file('file');
            $extension = $file->getClientOriginalExtension();
            $imageName = time() . '_' . uniqid() . '.' . $extension;

            $img = Image::make($image);
            $img->save($path . '/' . $imageName);
            $img->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            });

            $community->image = $imageName;
             $result = $community->save();
            return $result;
        }
        return $result;
    }

    // is user subscribed
    public function isUserSubscribed($id, $userID)
    {
        return CommunityParticipant::where(['community_id' => $id, 'user_id' => $userID])->count();
    }

    /*===================aAdmin========================*/
    public function getListAdm()
    {
        return $this->orderBy('updated_at', 'desc')->paginate(15);
    }

    //change active
    public  function changeActive($input)
    {

        $ID = htmlspecialchars($input['comm_id']);

        $comm = $this->where('id', $ID)->get()->first();

        if($comm->is_active == 1){
            $comm->is_active = 0;
        }else{
            $comm->is_active = 1;
        }
        $comm->save();

        return $comm->is_active;
    }


    public function search($search)
    {
        $data = Community::where('title', 'like','%'.$search.'%')
            ->orWhere('description', 'like', '%'.$search.'%')
            ->orderBy('created_at', 'desc')
            ->get();

        return $data;
    }

    //get Comms for home page
    public function getHomeComs()
    {
        return $this->where(['is_active' => 1])
            ->orderBy('updated_at', 'desc')
            ->take(16)
            ->get();
    }

    public function getByID($id)
    {
        return $this->where('id', $id)->get()->first();
    }

    public function changeModerator($mod_id, $id)
    {
        $comm = $this->getByID($id);
        $comm->user_id = $mod_id;
        return $comm->save();
    }


}

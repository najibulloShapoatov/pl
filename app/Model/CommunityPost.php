<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Intervention\Image\Facades\Image;

class CommunityPost extends Model
{




    public function likes(){
        return $this->hasMany('App\Model\CommunityPostLike');
    }
    public function Userlikes(){
        return $this->belongsTo('App\Model\CommunityPostLike');
    }

    public function comments(){
        return $this->hasMany('App\Model\CommunityPostComment', 'post_id');
    }




    public function getCommunityPostsByCommID($id)
    {

        //return $this->where(['community_id' => $id])->orderBy('created_at', 'desc')->get();
        return $this->where(['community_id' => $id])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
    }
     public function getCommunityPostsByCommIDWithoutPaginate($id)
    {

        //return $this->where(['community_id' => $id])->orderBy('created_at', 'desc')->get();
        return $this->where(['community_id' => $id])
            ->orderBy('created_at', 'desc')
            ->get();
    }


    //add new post in community
    public static function addNewPost(\Illuminate\Http\Request $request)
    {

        $input = $request->all();
        $communityID = trim(htmlspecialchars($input['id']));
        $text = trim(htmlspecialchars($input['text']));

        if(empty($text) && empty($request->file('file')) && empty($request->file('image'))){ return false;}

        $comm_post = new CommunityPost();
        $comm_post->community_id = $communityID;
        $comm_post->text = $text;
        $comm_post_saved = $comm_post->save();

        if($comm_post_saved) {

            if ($file = $request->file('file')) {

                if (!is_dir('public/uploads/communities/' . $communityID . '/posts/' . $comm_post->id)) {
                    mkdir('public/uploads/communities/' . $communityID . '/posts/' . $comm_post->id, 0777, true);
                }
                $path = public_path('/uploads/communities/' . $communityID . '/posts/' . $comm_post->id);

                $myfile = $request->file('file');
                $extension = $file->getClientOriginalExtension();
                $fileName = time() . '_' . uniqid() . '.' . $extension;
                $myfile->move($path, $fileName);



                $comm_post->video = $fileName;
                $result = $comm_post->save();

            }

            if($file = $request->file('image')) {

                if (!is_dir('public/uploads/communities/' . $communityID . '/posts/' . $comm_post->id)) {
                    mkdir('public/uploads/communities/' . $communityID . '/posts/' . $comm_post->id, 0777, true);
                }
                $path = public_path('/uploads/communities/' . $communityID . '/posts/' . $comm_post->id);

                $image = $request->file('image');
                $extension = $file->getClientOriginalExtension();
                $imageName = time() . '_' . uniqid() . '.' . $extension;
                $img = Image::make($image);

                $img->save($path . '/' . $imageName);

                $img->resize(300, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $comm_post->image = $imageName;
                $result = $comm_post->save();

            }

        }

        return true;
    }

    public function getByID($id)
    {
        return $this->where('id', $id)->get()->first();
    }



}

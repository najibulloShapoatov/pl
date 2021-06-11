<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class CommunityPostLike extends Model
{
    public function user(){
        return $this->belongsTo('App\Model\User');
    }

    public function changeLikeCommunityPost(Request $request, $userID)
    {
        $input = $request->all();
        $communityPostID = trim(htmlspecialchars($input['id']));
        $sts =  trim(htmlspecialchars($input['sts']));
        $isUserLiked = CommunityPostLike::where([ 'community_post_id' => $communityPostID, 'user_id' => $userID])->count();
        if( $isUserLiked == 0){
            $community_post_like = new CommunityPostLike();
            $community_post_like->community_post_id = $communityPostID;
            $community_post_like->user_id = $userID;
            $community_post_like->sts = $sts;
            $result = $community_post_like->save();
           /* return [ 'sts' => 1, 'countlike' => $this->where(['community_post_id' => $communityPostID])->count()];*/
        }
        else{
            $community_post_like = $this->where([ 'community_post_id' => $communityPostID, 'user_id' => $userID])->get()->first();
            $community_post_like->sts = $sts;
            $result = $community_post_like->save();
           /* return [ 'sts' => 0, 'countlike' =>  $this->where(['community_post_id' => $communityPostID])->count()];*/
        }
        return [
            'sts' => 0,
            'countLike' =>  $this->where(['community_post_id' => $communityPostID, 'sts' => 1])->count(),
            'countDisLike' =>  $this->where(['community_post_id' => $communityPostID, 'sts' => 0])->count()
        ];

    }
}

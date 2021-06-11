<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ForumLike extends Model
{


    protected  $fillable = [
        'forum_id',
        'user_id',
    ];


    public function changeLikeForum( $userID, $forumID)
    {


        $isUserLiked = $this::where([ 'forum_id' => $forumID, 'user_id' => $userID])->count();

        if( $isUserLiked == 0){
            $like = new ForumLike();
            $like->forum_id = $forumID;
            $like->user_id = $userID;
            $result = $like->save();
            return [ 'sts' => 1, 'countlike' => $this->where(['forum_id' => $forumID])->count()];
        }
        else{
            $like = $this->where([ 'forum_id' => $forumID, 'user_id' => $userID])->get()->first();
            $result = $like->delete();

            return [ 'sts' =>0, 'countlike' =>  $this->where(['forum_id' => $forumID])->count()];
        }

    }
}

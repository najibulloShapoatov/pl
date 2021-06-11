<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class ForumAnswerLike extends Model
{
    protected  $fillable = [
        'forum_answer_id',
        'user_id',
    ];


    public function changeLikeForumAnswer( $userID, $forumAnswerID)
    {


        $isUserLiked = $this::where([ 'forum_answer_id' => $forumAnswerID, 'user_id' => $userID])->count();

        if( $isUserLiked == 0){
            $like = new ForumAnswerLike();
            $like->forum_answer_id = $forumAnswerID;
            $like->user_id = $userID;
            $result = $like->save();
            return [ 'sts' => 1, 'countlike' => $this->where(['forum_answer_id' => $forumAnswerID])->count()];
        }
        else{
            $like = $this->where([ 'forum_answer_id' => $forumAnswerID, 'user_id' => $userID])->get()->first();
            $result = $like->delete();

            return [ 'sts' =>0, 'countlike' =>  $this->where(['forum_answer_id' => $forumAnswerID])->count()];
        }

    }
}

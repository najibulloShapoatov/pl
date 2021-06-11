<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ForumAnswer extends Model
{
    public function user(){
        return $this->belongsTo('App\Model\User');
    }

    public function likes(){
        return $this->hasMany('App\Model\ForumAnswerLike');
    }

    //
    public function getByForumID($id)
    {
        return $this->where(['forum_id' => $id])->get();
    }
    public function addForumAnswer($userID, $text, $forum_id, $parent_id){

        $forumAnswer = new ForumAnswer();
        $forumAnswer->user_id = $userID;
        $forumAnswer->forum_id = $forum_id;
        $forumAnswer->parent_id = $parent_id;
        $forumAnswer->text = $text;
        $result = $forumAnswer->save();
        if($result){
            return $forumAnswer;
        }
    }

    public function addForumAnswerLike($userID,  $forumAnswerID)
    {
        $forumAnswer =$this->where(['id' => $forumAnswerID])->get()->first();
        $forumAnswer->f_like += 1;
        $result = $forumAnswer->save();
        if($result) {
            return $forumAnswer;
        }
    }

    public function changeLikeForum($userID,  $forumID)
    {
    }

}

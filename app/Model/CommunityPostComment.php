<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CommunityPostComment extends Model
{
    protected $fillable =[
        'is_active',
        'user_id',
        'post_id',
        'text'
    ];

    public function user(){
        return $this->belongsTo('App\Model\User');
    }
    //
    public function getByCommunityID($id)
    {
        $comPost = new CommunityPost();
        $comPosts = $comPost->getCommunityPostsByCommID($id);
        $arr =[];
        foreach($comPosts as $p){
            $arr [] = $p->id;
        }

        return $this->whereIn('post_id', $arr)->orderBy('created_at', 'desc')->get();
    }

    public function addComment($uId, $input)
    {
        $id = trim(htmlspecialchars($input['id']));
        $cid = trim(htmlspecialchars($input['c_id']));
        $msg =  trim(htmlspecialchars($input['msg']));
        $comP = new CommunityPostComment();
        $comModerable = new CommunityCommentModerable();
        $isModerable = $comModerable->checkIsModerable($cid);

        $comP->is_active = $isModerable;
        $comP->user_id = $uId;
        $comP->post_id = $id;
        $comP->text = $msg;
        $comP->save();
        return $comP;
    }

    public function addCommentReply($uId,  $input)
    {
        $id = trim(htmlspecialchars($input['postID']));
        $cid = trim(htmlspecialchars($input['c_id']));
        $pid = trim(htmlspecialchars($input['parentID']));
        $msg =  trim(htmlspecialchars($input['msg']));
        $comP = new CommunityPostComment();

        $comModerable = new CommunityCommentModerable();
        $isModerable = $comModerable->checkIsModerable($cid);

        $comP->is_active = 1;
        $comP->user_id = $uId;
        $comP->parent_id = $pid;
        $comP->post_id = $id;
        $comP->text = $msg;
        $comP->save();
        return $comP;
    }

    public function getByCommentID($id)
    {
        return $this->where('parent_id', $id)->orderBy('created_at', 'desc')->get();
    }

    public function getById($id)
    {
        return $this->where('id', $id)->get()->first();
    }

    public function getByCommunityIDWithPaginate($id)
    {
        $comPost = new CommunityPost();
        $comPosts = $comPost->getCommunityPostsByCommIDWithoutPaginate($id);
        $arr =[];
        foreach($comPosts as $p){
            $arr [] = $p->id;
        }

        return $this->whereIn('post_id', $arr)->orderBy('created_at', 'desc')->paginate(10);
    }

    public function changeActiveComment($id)
    {
        $cm = $this->getById($id);
        ($cm->is_active == 0)? $cm->is_active = 1 : $cm->is_active = 0;
        $cm->save();
        return $cm->is_active;
    }

    public function deleteComment($id)
    {
        $cm = $this->getById($id);
        if($cm->parent_id == 0){
            $cms = $this->where('parent_id', $id)->delete();
        }else{
            $cm->delete();
        }
        return true;
    }


}

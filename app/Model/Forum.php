<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Forum extends Model
{
    public function user(){
        return $this->belongsTo('App\Model\User');
    }

    public function answers(){
        return $this->hasMany('App\Model\ForumAnswer');
    }
    public function answert(){
        return $this->hasMany('App\Model\ForumAnswer');
    }
    public function forum_answers(){
        return $this->belongsToMany('App\Model\ForumAnswer');
    }

    public function category(){
        return $this->belongsTo('App\Model\ForumCategory');
    }

    public  function likes(){
     return $this->hasMany('App\Model\ForumLike');
    }

    public function getList()
    {
        return $this->where(['is_active' => 1])->orderBy('created_at', 'desc')->paginate(10);
    }

    public function getByUserID($id)
    {
        return $this->where(['user_id' => $id, 'is_active' => 1])->orderBy('created_at', 'desc')->get();
    }

    public function getByID($id)
    {
        return $this->where(['id' => $id, 'is_active' => 1])->get()->first();
    }

    public function getListCategoryID($id)
    {
        return $this->where(['category_id' => $id])->orderBy('created_at', 'desc')->get();


    }

    public function addForum($userID,  $title,  $category,  $descr)
    {
        $siteProp = new SiteProperty();
        $forum = new Forum();
        $forum->user_id = $userID;
        $forum->category_id = $category;
        $forum->title = $title;
        $forum->is_active = ($siteProp->getByPropName('IS_MODELABLE_FORUM'))->prop_value;
        $forum->text = $descr;
        $result = $forum->save();
        if($result){
            return $result;
        }

    }

    //search
    public function searchForum($search)
    {

        $forum = Forum::whereHas('answers', function($query) use ($search)
        {
            $query->where('text', 'like','%'.$search.'%');
        })->orWhere('title', 'like', '%'.$search.'%')
            ->orWhere('text', 'like', '%'.$search.'%')
            ->where("is_active", 1)
            ->with('answers')
            ->orderBy('created_at', 'desc')
            ->get();


        return $forum;
    }

    public function saveEditedForum( $input)
    {
        $forum_id = trim(htmlspecialchars($input['forum_id']));
        $forum_title = trim(htmlspecialchars($input['forum_title']));
        $forum_cat = trim(htmlspecialchars($input['forum_cat']));
        $forum_descr = trim(htmlspecialchars($input['forum_descr']));

        $forum = Forum::where(['id' => $forum_id, 'user_id' => Auth::user()->id])->get()->first();
        $forum->category_id = $forum_cat;
        $forum->title = $forum_title;
        $forum->text = $forum_descr;
        return $forum->save();
    }


    public function removeEditedForum( $input)
    {
        $forum_id = trim(htmlspecialchars($input['forum_id']));


        $forum = Forum::where(['id' => $forum_id, 'user_id' => Auth::user()->id])->get()->first();


        if( count($forum->answert) > 0 ) {
            foreach ($forum->answert as $ans) {
                $ans->likes()->delete();
            }
            $forum->answert()->delete();
        }
        if(count($forum->likes) > 0 ) {
            $forum->likes()->delete();
        }

        return $forum->delete();

    }


    public function deleteForum($id){

        $forum = $this->where(['id' => $id])->get()->first();

        foreach ($forum->answers as $ans){
            $ans->likes()->delete();
        }
        $forum->answers()->delete();
        $forum->likes()->delete();

        return $forum->delete();
    }

    /*===================Admin=======================================================*/

    public function getListAdm()
    {
        return $this->orderBy('updated_at', 'desc')->paginate(20);
    }

    //change active news
    public function changeActive($input)
    {
        $ID = htmlspecialchars($input['forum_id']);

        $forum = $this->where('id', $ID)->get()->first();

        if($forum->is_active == 1){
            $forum->is_active = 0;
        }else{
            $forum->is_active = 1;
        }
        $forum->save();

        return $forum->is_active;

    }



}

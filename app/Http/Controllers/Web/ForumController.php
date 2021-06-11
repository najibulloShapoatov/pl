<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Model\Forum;
use App\Model\ForumAnswer;
use App\Model\ForumAnswerLike;
use App\Model\ForumCategory;
use App\Model\ForumLike;
use App\Model\ForumPermissions;
use App\Model\Role;
use App\Model\SiteProperty;
use App\Model\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;

class ForumController extends Controller
{
    public function index(){

        $forum_category = new ForumCategory();
        $f_category = $forum_category->getList();

        $forum = new Forum();
        $forums = $forum->getList();

        $myforums = [];
        if(Auth::check()){
        $myforums = $forum->getByUserID(Auth::user()->id);
        }


        return view('web.forum.index', compact([
            'f_category',
            'forums',
            'myforums'
            ]));
    }


    public function getCategory($id){

        $forum_category = new ForumCategory();
        $f_category = $forum_category->getList();

        $forum = new Forum();
        $forums = $forum->getListCategoryID($id);

        $myforums = [];
        if(Auth::check()){
            $myforums = $forum->getByUserID(Auth::user()->id);
        }


        return view('web.forum.index', compact([
            'f_category',
            'forums',
            'myforums'
        ]));
    }

    //Single Forum
    public function single($id){
        $f_c = new ForumCategory();
        $forum = new Forum();
        $forum_answers = new ForumAnswer();
        $f_category = $f_c->getList();
        $forumData = $forum->getByID($id);
        $forumData->viewed = $forumData->viewed += 1;
        $forumData->save();
        $f_answers = $forum_answers->getByForumID($forumData->id);

        $ans = $f_answers->toArray();

        $myforums = [];
        if(Auth::check()){
            $myforums = $forum->getByUserID(Auth::user()->id);
        }

        return view('web.forum.single-forum', compact([
            'f_category',
            'forumData',
            'myforums',
            'f_answers',
            'ans',
        ]));
    }

    public function search(){

        return view('web.forum.search-forum');
    }

    //add Forum
    public function addForum(Request $request)
    {
        if ($request->ajax())
        {
            $forumPer = new ForumPermissions();

            $isPermited = $forumPer->checkPermission(Auth::user()->role_id);

            if($isPermited) {
                $input = $request->all();
                $title = trim(htmlspecialchars($input['title']));
                $category = trim(htmlspecialchars($input['category']));
                $descr = trim(htmlspecialchars($input['descr']));

                $forum = new Forum();
                $forumData = $forum->addForum(Auth::user()->id, $title, $category, $descr);
                return Response::json([
                    'err' => 0,
                    'formData' => $forumData
                ], 200);
            }
            return Response::json([
                'err' => 1,
                'msg' => 'У вас нет доступа на создание темы'
            ], 200);
        }
    }

    //add Forum Like
    public function addForumLike(Request $request)
    {
        if ($request->ajax())
        {
            $input = $request->all();
            $forumID = trim(htmlspecialchars($input['forum_id']));
            $forum = new ForumLike();
            $forumData = $forum->changeLikeForum(Auth::user()->id, $forumID);
            return Response::json(['formData' => $forumData], 200);
        }
    }

    //add Forum Answer Like
    public function addForumAnswerLike(Request $request)
    {
        if ($request->ajax())
        {
            $input = $request->all();

            $forumAnswerID = trim(htmlspecialchars($input['forum_answer_id']));

            $forum = new ForumAnswerLike();
            $forumData = $forum->changeLikeForumAnswer(Auth::user()->id, $forumAnswerID);

            return Response::json(['formData' => $forumData], 200);
        }
    }

    //add Forum Answer
    public function addForumAnswer(Request $request)
    {
        if ($request->ajax())
        {
            $input = $request->all();
            $text = trim(htmlspecialchars($input['forum_answer_text']));
            $forum_id= trim(htmlspecialchars($input['forum_id']));
            $p_id= trim(htmlspecialchars($input['parent_id']));

            $forum = new ForumAnswer();
            $forumData = $forum->addForumAnswer(Auth::user()->id, $text, $forum_id, $p_id);
            return Response::json(['formData' => $forumData], 200);
        }
    }


    //search Forum
    public function searchForum(Request $request)
    {
        if ($request->ajax())
        {
            $input = $request->all();
            $search = trim(htmlspecialchars($input['text']));

            $forum = new Forum();
            $data = $forum->searchForum($search);

            $html = View::make('web.forum._search', compact([
                'data',
                'search',
            ]))->render();

            return Response::json(['html' => $html, 'info' => $data], 200);
        }
    }

    //edit forum modal show
    public function editForum(Request $request)
    {
        if ($request->ajax())
        {
            $input = $request->all();
            $forum_id = trim(htmlspecialchars($input['forum_id']));

            $f_c = new ForumCategory();
            $f_category = $f_c->getList();
            $data = Forum::where(['id'=> $forum_id, 'user_id' => Auth::user()->id ])->get()->first();

            $html = View::make('web.forum._edit-forum', compact([
                'data',
                'f_category',
            ]))->render();

            return Response::json(['html' => $html, 'info' => $data], 200);
        }
    }

    //save edited forum modal
    public function editForumSave(Request $request)
    {
        if ($request->ajax())
        {
            $input = $request->all();
            $forum = new Forum();
            $result = $forum->saveEditedForum($input);
            return Response::json($result, 200);
        }
    }

    //remove edited forum modal
    public function editForumRemove(Request $request)
    {
        if ($request->ajax())
        {
            $input = $request->all();
            $forum = new Forum();
            $result = $forum->removeEditedForum($input);
            return Response::json($result, 200);
        }
    }





    /*====================Admin========================================================*/

    public function indexAdm(){
        if(Auth::check() && Auth::user()->role_id == 1){
            $siteProp = new SiteProperty();
            $role = new Role();
            $roles = $role->getList();
            $f_perm = new ForumPermissions();
            $f_perms = $f_perm->getList();

            $rs = $siteProp->checkPropName('IS_MODELABLE_FORUM');
            if($rs) {
                $isModerable = ($siteProp->getByPropName('IS_MODELABLE_FORUM'))->prop_value;
            }else{
                $isModerable = $siteProp->createProp('IS_MODELABLE_FORUM', 0);
            }
            return view('admin.forum.index', compact([
                'roles',
                'f_perms',
                'isModerable',
            ]));
        }
        return redirect('/');

    }



    public function forums(){
        if(Auth::check() && Auth::user()->role_id == 1){

            $Forum = new Forum();
            $forum = $Forum->getListAdm();

            return view('admin.forum.forums',compact([
                'forum'
            ]));
        }
        return redirect('/');

    }





    //change forum active
    public function changeActiveForum(Request $request){

        if(Auth::check() && Auth::user()->role_id == 1){
            if ($request->ajax())
            {
                $input = $request->all();
                $forum = new Forum();
                $data = $forum->changeActive($input);
                return Response::json($data, 200);
            }

        }
        return redirect('/forum');

    }




    //delete forum
    public function deleteForum(Request $request){

        if(Auth::check() && Auth::user()->role_id == 1){
            if ($request->ajax())
            {
                $input = $request->all();
                $forum_id = trim(htmlspecialchars($input['forum_id']));
                $forum = new Forum();
                $data = $forum->deleteForum($forum_id);
                return Response::json($data, 200);
            }

        }
        return redirect('/forum');

    }





    public function adminCategory(){

        if(Auth::check() && Auth::user()->role_id == 1){

            $Forum = new ForumCategory();
            $forumCat = $Forum->getListADM();

            return view('admin.forum.category',compact([
                'forumCat'
            ]));
        }
        return redirect('/forum');

    }

    //cancel Edit
    public function getForumCategory(Request $request){

        if(Auth::check() && Auth::user()->role_id == 1){

            $input =$request->all();
            $ID = htmlspecialchars($input['forum_cat_id']);
            $Forum = new ForumCategory();
            $forumCat = $Forum->getByID($ID);

            $html = View::make('admin.forum._cat', compact('forumCat'))->render();

            return Response::json($html, 200);

        }
        return redirect('/forum');

    }


    //save Edit
    public function saveForumCategory(Request $request){

        if(Auth::check() && Auth::user()->role_id == 1){

            $input =$request->all();
            $Forum = new ForumCategory();
            $forumCat = $Forum->updateCategory($input);

            $html = View::make('admin.forum._cat', compact('forumCat'))->render();

            return Response::json($html, 200);

        }
        return redirect('/forum');

    }

    //remove Forum Category
    public function removeForumCategory(Request $request){

        if(Auth::check() && Auth::user()->role_id == 1){

            $input =$request->all();
            $ID = htmlspecialchars($input['forum_cat_id']);
            $Forum = new ForumCategory();
            $forumCat = $Forum->removeCategory($ID);


            return Response::json($forumCat, 200);

        }
        return redirect('/forum');

    }

    //create Forum Category
    public function createForumCategory(Request $request){

        if(Auth::check() && Auth::user()->role_id == 1){

            $input =$request->all();
            $Forum = new ForumCategory();
            $forumCat = $Forum->createCategory($input);


            $html = View::make('admin.forum._cat', compact('forumCat'))->render();
            return Response::json(['html' => $html, 'id' => $forumCat->id], 200);
        }
        return redirect('/forum');

    }



    public function changePermission($id){
        $forumP = new ForumPermissions();
        $f_per = $forumP->changePermission($id);

        return $f_per;

    }

    public function changeModerable($sts){
        if(Auth::check() && Auth::user()->role_id == 1) {
            $sprp = new SiteProperty();
            $rs = $sprp->checkPropName('IS_MODELABLE_FORUM');

            if (!$rs) {
                $res = $sprp->createProp('IS_MODELABLE_FORUM', $sts);
            } else {
                $res = $sprp->setByPropName('IS_MODELABLE_FORUM', $sts);
            }
            return $res;
        }
        return redirect('/');
    }



}

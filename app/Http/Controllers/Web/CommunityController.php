<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Model\Community;
use App\Model\CommunityCommentModerable;
use App\Model\CommunityParticipant;
use App\Model\CommunityPost;
use App\Model\CommunityPostComment;
use App\Model\CommunityPostLike;
use App\Model\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;

class CommunityController extends Controller
{
    public function index(){
        $community = new Community();
        $communities = $community->getList();
        $usrs = [];
        if(Auth::check() && Auth::user()->role->id == 1){
            $user = new User();
            $usrs = $user->getList();
        }

        return view('web.community.index',compact([
            'communities',
            'usrs'
        ]));
    }
    public function single($id){

    $community = new Community();
    $communityData = $community->getCommunityByID($id);

    $communityPosts = new CommunityPost();
    $posts = $communityPosts->getCommunityPostsByCommID($id);

    $postComment = new CommunityPostComment();
    $postsComs = $postComment->getByCommunityID($id);

    $isUserSubscribed=false;
    if (Auth::check()) {
        $isUserSubscribed = $community->isUserSubscribed($id, Auth::user()->id);
    }
    return view('web.community.single',compact([
        'communityData',
        'posts',
        'isUserSubscribed',
        'postsComs',
    ]));



}


public function addComment(Request $request){
        if(Auth::check()){
            if($request->ajax()){
                $input = $request->all();
                $comPost = new CommunityPostComment();
                $data = $comPost->addComment(Auth::user()->id,$input);
                 $html = View::make('web.community._comment', compact('data'))->render();

                return Response::json($html, 200);
            }
        }
        return Response::json([], 404);
}

public function addCommentReply(Request $request){
        if(Auth::check()){
            if($request->ajax()){
                $input = $request->all();
                $comPost = new CommunityPostComment();
                $data = $comPost->addCommentReply(Auth::user()->id,$input);
                 $html = View::make('web.community._comment-reply', compact('data'))->render();

                return Response::json($html, 200);
            }
        }
        return Response::json([], 404);
}


public function managePosts($id){
        if(Auth::check() && Auth::user()->id == ((new Community())->getByID($id))->user_id){
            $isModerable = 0;
            if((new CommunityCommentModerable())->checkCommunity($id)){
            $isModerable = ((new CommunityCommentModerable())->getByCommunityID($id))->sts;
            }
            $coments =(new CommunityPostComment())->getByCommunityIDWithPaginate($id);

            return \view('web.community.admin.index', compact([
                'coments',
                'isModerable',
            ]));
        }
        return redirect('/');
}

public function changeModerableComments(Request $request){
        if ($request->ajax()) {
            $input = $request->all();
            $sts = trim(htmlspecialchars($input['id']));
            $cid = trim(htmlspecialchars($input['cid']));
            if(Auth::check() && Auth::user()->id == ((new Community())->getByID($cid))->user_id) {
                $CommunityModerable = new CommunityCommentModerable();
                $rs = $CommunityModerable->changeModerableCommunityById($cid, $sts);
                return true;
            }else{
                return false;
            }
        }
}

public function viewComment($id){
        $comment = ((new CommunityPostComment())->getById($id))->text;
        return Response::json($comment, 200);
}
public function changeActiveComment($id){
    $post = (new CommunityPost())->getByID(((new CommunityPostComment())->getById($id))->post_id);
    if(Auth::check() && Auth::user()->id == ((new Community())->getByID($post->community_id))->user_id) {
       $data = (new CommunityPostComment())->changeActiveComment($id);
       return Response::json($data, 200);
    }
}
public function deleteComment($id){

    $post = (new CommunityPost())->getByID(((new CommunityPostComment())->getById($id))->post_id);
    if(Auth::check() && Auth::user()->id == ((new Community())->getByID($post->community_id))->user_id) {


       $data = (new CommunityPostComment())->deleteComment($id);

       return Response::json($data, 200);
    }
}





/*

public function managePostsComents($id){
            $com = new Community();
            $comPost = new CommunityPost();
            $commP = $comPost->getByID($id);
            $comm = $com->getByID($commP->community_id);
        if(Auth::check() && Auth::user()->id == $comm->user_id){
            $communityPostComment = new CommunityPostComment();
            $comComentData = $communityPostComment->getByCommunityID($comm->id);
            return \view('web.community.admin.comments', compact([
                'comComentData',
            ]));
        }
        return redirect('/');
}



public function managePostsComentsReplies($id){

        if(Auth::check() ){
            $communityPostComment = new CommunityPostComment();
            $comComentData = $communityPostComment->getByCommentID($id);
            $coment = $communityPostComment->getById($id);
            return \view('web.community.admin.comment-replies', compact([
                'comComentData',
                'coment',
            ]));
        }
        return redirect('/');
}*/



/*public function chat(){
        return \view('web.community.chat.index');
}*/


    //update info community
    public function updateInfoCommunity(Request $request){
        if ($request->ajax())
        {
            $input = $request->all();
            $communityID = trim(htmlspecialchars($input['community_id']));
            $communityTitle = trim(htmlspecialchars($input['community_title']));
            $communityText = trim(htmlspecialchars($input['community_text']));

            $community = new Community();
            $communityData = $community->updateInfo(Auth::user()->id, $communityID, $communityTitle, $communityText);
            return Response::json(['responseData' => $communityData], 200);
        }
    }

    //update image community
    public function updateImgCommunity(Request $request){
        if( $request->ajax() ) {
            $result = Community::updateImg($request);
            return response()->json($result, 200);
        }
    }

    //community remove
    public function communityRemove(Request $request){

        if( $request->ajax() ) {
            $result = Community::removeCommunity($request);
            return response()->json($result, 200);
        }

    }

    //new community community
    public function addNewCommunity(Request $request){
        if( $request->ajax() ) {
            $result = Community::createCommunity($request);
            return response()->json($result, 200);
        }
    }

    //change subscribe community
    public function changeSubscribeCommunity(Request $request){
        if( $request->ajax() ) {
            $communityParticipant = new CommunityParticipant();
            if (Auth::check()) {
                $result = $communityParticipant->changeSubscribeCommunity($request, Auth::user()->id);
                return response()->json($result, 200);
            }else{
                return response()->json([
                    'err' => 1,
                    'msg' => __('lang.because_subscribe')
                ], 200);
            }
        }
    }

    //change like community post
    public function changeLikeCommunityPost(Request $request){
        if( $request->ajax() ) {
            $community_post_like = new CommunityPostLike();
            $result = $community_post_like->changeLikeCommunityPost($request, Auth::user()->id);
            return response()->json($result, 200);
        }
    }

    //create post
    public function addNewPost(Request $request){

        if( $request->ajax() ) {

            $result = CommunityPost::addNewPost($request);

            return response()->json($result, 200);
        }
    }







    /*================Admin============================================*/

    public function indexAdm(){
        if(Auth::check() && Auth::user()->role_id == 1){

            $Comm = new Community();
            $community = $Comm->getListAdm();

            return view('admin.community.index',compact([
                'community'
            ]));
        }
        return redirect('/community');

    }


    public function changeActiveCommunity(Request $request){
        if(Auth::check() && Auth::user()->role_id == 1){

            if( $request->ajax() ) {

                $input = $request->all();
                $comm = new Community();
                $result = $comm->changeActive($input);

                return response()->json($result, 200);
            }
        }
        return redirect('/community');

    }



    public function getModerator($id){
        if(Auth::check() && Auth::user()->role_id == 1){
            $user = new User();
            $comm = new Community();

            $usrs = $user->getListAll();
            $com_user = ($comm->getByID($id))->user_id;

            $html = View::make('admin.community._users', compact([
                'usrs',
                'com_user'
            ]))->render();
            return Response::json([
                'html' => $html,
                'info' => $usrs,
                'comuse'=>$com_user
            ], 200);

        }
        return redirect('/');

    }


    public function setModerator(Request $request){
        if(Auth::check() && Auth::user()->role_id == 1){
            if ($request->ajax()) {
                $input = $request->all();
                $mod_id = trim(htmlspecialchars($input['com_moderarot']));
                $id = trim(htmlspecialchars($input['id']));

                $comm = new Community();
                $res = $comm->changeModerator($mod_id, $id);
                return Response::json( $res, 200);
            }

        }
        return redirect('/');

    }




}

<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Model\Notice;
use App\Model\NoticeResult;
use App\Model\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\View;

class NoticeController extends Controller
{


    public function getOne(Request $request){
        $Mnotices = new Notice();
        $input = $request->all();
        $id = trim(htmlspecialchars($input['id']));
        $notice = $Mnotices->getByID($id);

        $m_not_res = new NoticeResult();
        $notice_res = $m_not_res->checkViewed(Auth::user()->id, $notice->id);

        return Response::json([
            'title'=>$notice->title,
            'descr'=>$notice->description,
            'sts'=>$notice_res
        ], 200);
    }


    public function index(){
        if(Auth::check() && Auth::user()->role_id == 1) {
            $notice = new Notice();
            $notices = $notice->getList();

            $role = new Role();
            $roles = $role->getList();

            return view('admin.notice.index', compact([
                'notices',
                'roles',
            ]));
        }
        return redirect('/');
    }

    public function single($id){
        if(Auth::check() && Auth::user()->role_id == 1) {
        $notices = new Notice();
        $notice = $notices->getByID($id);

        return Response::json([
            'title'=> $notice->title,
            'descr'=> $notice->description,
        ], 200);
        }
        return redirect('/');
    }

    public function deleteNotice(Request $request){
        if(Auth::check() && Auth::user()->role_id == 1) {
            if ($request->ajax()){
                $input = $request->all();
                $id = trim(htmlspecialchars($input['id']));
                $notices = new Notice();
                $notice = $notices->deleteByID($id);

                return Response::json($notice, 200);
            }
        }
        return redirect('/');

    }

    public function createNotice(Request $request){
        if(Auth::check() && Auth::user()->role_id == 1) {
            if ($request->ajax()){

                $input = $request->all();
                $notices = new Notice();
                $notice = $notices->createNotice($input);

                return Response::json($notice, 200);
            }
        }
        return redirect('/');

    }

    public function updateNotice(Request $request){
        if(Auth::check() && Auth::user()->role_id == 1) {
            if ($request->ajax()){

                $input = $request->all();
                $notices = new Notice();
                $notice = $notices->updateNotice($input);

                return Response::json($notice, 200);
            }
        }
        return redirect('/');

    }

    public function filterNotice(Request $request){
        if(Auth::check() && Auth::user()->role_id == 1) {

            if ($request->ajax()){
                $input = $request->all();
                $id = trim(htmlspecialchars($input['notice_role']));
                $notice = new Notice();
                if($id == 0){$data = $notice->getList();}
                else{$data = $notice->getByRoleADM($id);}


                $html = View::make('admin.notice._notices', compact('data'))->render();

                return Response::json($html, 200);
            }
        }
        return redirect('/');

    }

    public function editNotice($id){
        if(Auth::check() && Auth::user()->role_id == 1) {

                $notice = new Notice();
                $data = $notice->getByID($id);

                return Response::json($data, 200);
        }
        return redirect('/');

    }

}

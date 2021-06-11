<?php

namespace App\Http\Controllers;

use App\Model\Faculty;
use App\Model\FedbackTo;
use App\Model\Feedback;
use App\Model\SiteCustomization;
use App\Model\SiteProperty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;


class FeedbackController extends Controller
{
    public function index(){

        $S_Customize = new SiteCustomization();
        $Infodata = $S_Customize->getListAdm();
//        $fedTo = (new FedbackTo())->getList();
        $fac = (new Faculty())->getList();

        $sts=0;
        return view('web.contacts.index', compact([
            'Infodata',
            'fac',
            'sts',
        ]));
    }



    public function captchaValidate(Request $request)
    {
      $res =  $request->validate([
            'fio' => 'required',
            'email_phone' => 'required',
            'topic' => 'required',
            'fed-to' => 'required',
            'text' => 'required',
            'captcha' => 'required|captcha'
        ]);

      if($res){

          $this->saveFeedback($request);

          return redirect('/contacts');
      }

    }

    public function saveFeedback(Request $request){
            $input = $request->all();
            $feedback = new Feedback();
            $Feed =$feedback->createFeedback($input);
    }



    public function refreshCaptcha()
    {
        return response()->json(['captcha'=> captcha_img()]);
    }




    /*=========================================*/
    public function fedbackToIndex(){
        if (Auth::check() && Auth::user()->role_id == 1){
            $fed = (new FedbackTo())->getList();
            $fac = (new Faculty())->getList();
            $adminMail = (new SiteProperty())->getByPropName('ADMIN_EMAIL')->prop_value;
            $bookerMail = (new SiteProperty())->getByPropName('BOOKER_EMAIL')->prop_value;
            return view('admin.fedback.index', compact([
                'fed',
                'adminMail',
                'bookerMail',
                'fac'
            ]));
        }
        return redirect('/');
    }
    public function createFedTo(Request $request){
        if (Auth::check() && Auth::user()->role_id == 1){
            if ($request->ajax()) {
                $in = $request->all();
                $fID = trim(htmlspecialchars($in['f_id']));
                $place = trim(htmlspecialchars($in['place']));
                $name = trim(htmlspecialchars($in['name']));
                $email = trim(htmlspecialchars($in['email']));
                if(empty($fID) || empty($place) || empty($name) || empty($email)){ return Response::json(['err'=>1, 'msg'=>__('lang.fill_in_all_the_fields')],200);}
                $data = (new FedbackTo())->createFedTo($fID, $place, $name, $email);
                $html = View::make('admin.fedback._add-fed-to', compact('data'))->render();
                return Response::json(['html' => $html, 'info' => $data], 200);
            }
        }
        return redirect('/');
    }



      public function updateFedTo(Request $request){
        if (Auth::check() && Auth::user()->role_id == 1){
            if ($request->ajax()) {
                $in = $request->all();
                $ID = trim(htmlspecialchars($in['id']));
                $fID = trim(htmlspecialchars($in['f_id']));
                $place = trim(htmlspecialchars($in['place']));
                $name = trim(htmlspecialchars($in['name']));
                $email = trim(htmlspecialchars($in['email']));
                if(empty($fID) || empty($place) || empty($name) || empty($email)){ return Response::json(['err'=>1, 'msg'=>__('lang.fill_in_all_the_fields')],200);}
                $data = (new FedbackTo())->updateFedTo($ID,$fID, $place, $name, $email);
                $html = View::make('admin.fedback._update', compact('data'))->render();
                return Response::json(['html' => $html, 'info' => $data], 200);
            }
        }
        return redirect('/');
    }


      public function updateAdminMail(Request $request){
        if (Auth::check() && Auth::user()->role_id == 1){
            if ($request->ajax()) {
                $in = $request->all();
                $pv = trim(htmlspecialchars($in['propVal']));
                $rs = (new SiteProperty())->setByPropName('ADMIN_EMAIL', $pv);
                return Response::json( $rs, 200);
            }
        }
        return redirect('/');
    }



      public function updateBookerMail(Request $request){
        if (Auth::check() && Auth::user()->role_id == 1){
            if ($request->ajax()) {
                $in = $request->all();
                $pv = trim(htmlspecialchars($in['propVal']));
                $rs = (new SiteProperty())->setByPropName('BOOKER_EMAIL', $pv);
                return Response::json( $rs, 200);
            }
        }
        return redirect('/');
    }




    public function getEdit($id){
        if (Auth::check() && Auth::user()->role_id == 1){

                $data = (new FedbackTo())->getByID($id);
                $fac = (new Faculty())->getList();
                $html = View::make('admin.fedback._edit-fed-to', compact([
                    'data',
                    'fac'
                ]))->render();
                return Response::json(['html' => $html, 'info' => $data], 200);

        }
        return redirect('/');
    }

    public function getByFacFedTo($id){
        if (Auth::check() && Auth::user()->role_id == 1){

                $data = (new FedbackTo())->getListByFaculty($id);
                $html = View::make('admin.fedback._to-whoms', compact([
                    'data',
                ]))->render();
                return Response::json(['html' => $html, 'info' => $data], 200);

        }
        return redirect('/');
    }

    public function removeFedTo($id){
        if (Auth::check() && Auth::user()->role_id == 1){

                $data = (new FedbackTo())->removeById($id);
                $fac = (new Faculty())->getList();

                return Response::json($data, 200);

        }
        return redirect('/');
    }

  /*  public function indexAdmin(){
        if(Auth::check() && Auth::user()->role_id == 1){

            $F = new Feedback();
            $data = $F->getListAdm();


            return view('admin.about.index',compact([
                'data',
            ]));
        }
        return redirect('/');

    }

    public function singleAbout($id){
        if(Auth::check() && Auth::user()->role_id == 1){

            $F = new Feedback();
            $data = $F->getById($id);

            if($data->sts == 0){
                $data->sts = 1;
                $data->save();
            }

            return view('admin.about.single',compact([
                'data'
            ]));
        }
        return redirect('/elon');

    }

    public function removesingleAbout(Request $request){
        if(Auth::check() && Auth::user()->role_id == 1){

            if ($request->ajax())
            {
                $input = $request->all();
                $ID = htmlspecialchars($input['id']);
                $F = new Feedback();
                $data = $F->removeFeedback($ID);
                return Response::json($data, 200);
            }
        }
        return redirect('/elon');

    }*/

}

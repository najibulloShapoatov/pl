<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Model\Course;
use App\Model\Faculty;
use App\Model\Special;
use App\Model\Ticket;
use App\Model\User;
use App\Model\UserProperty;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;

class UserController extends Controller
{
    public function profile(){
        if(Auth::check()){
            // user info
            $user = new User();
            $userData = $user->getByID(Auth::user()->id);
            //user role
            $usrProps = null;
            if(Auth::user()->role_id == 3){
                $userProp = new UserProperty();
                $usrProps = $userProp->getByUserID(Auth::user()->id);
            }


            return view('web.user.profile', compact([
                'userData',
                'usrProps',
            ]));
        }
        return redirect('/');
    }

    // profile: change password
    public function profileChangePassword(Request $request)
    {
        if ($request->ajax()) {
            $input = $request->all();
            $user = new User();
            $result = $user->changePassword($input);
            return Response::json($result);
        }
    }

    // profile: change info
    public function profileChangeInfo(Request $request)
    {
        if ($request->ajax()) {
            $user = new User();
            $result = $user->updateProfileInfo($request);
            return Response::json($result);
        }
    }

    public function login()
    {
        if(Auth::check()){
            return redirect('/');
        }
        return view('web.auth.login');
    }

    public function loginData(Request $request)
    {
        if ($request->ajax()) {
            $input = $request->all();
            $user = new User();

            $login = htmlspecialchars(trim($input['login']));
            $password = htmlspecialchars(trim($input['password']));
            $user_type = htmlspecialchars(trim($input['user_type']));



            if($user_type == '1'){
                $res = $this->loginStudent($login, $password, $user_type);

                return Response::json($res, 200);
            }

            elseif ($user_type == '0'){

                $user->email =$login;
                $user->password = $password;

                // validate
                $result = $user->validateLoginFields();
                // if it is not ok, then msg error
                if ($result['error_code'] != 0) {
                    return response()->json(['input' => $result], 200);
                }

                if ($user->checkUser($request))
                {
                    return response()->json([
                        'err' => 0,
                        'msg' => __('lang.succes_logining')
                    ], 200);
                }

                return response()->json([
                    'err' => 1,
                    'msg' => __('lang.not_correct_login_or_pass')
                ], 200);
            }




        }
    }





    public function loginStudent($login, $pass, $u_type){
        $user = new User();
        $client = new Client();
        $rs = $client->request('POST', 'http://77.95.1.139:7777/api/v1/auth?login=' . $login .'&password=' . $pass, ['http_errors' => false]);
        if($rs->getStatusCode() != 200) {
            return [
                'err' => 1,
                'msg' => __('lang.not_correct_enter_login_or_pass')
            ];
        }
        $resdec = json_decode($rs->getBody());

        $rs = $client->request('GET', 'http://77.95.1.139:7777/api/v1/student/profile',
            ['headers' => [
                    'token' => $resdec->message,
                ]]);

        $resStdDec = json_decode($rs->getBody());

        $name = $resStdDec->FullName->TJ;


        $hasUserStudent = $user->checkHasStudTeach($login);
        if (!$hasUserStudent){
            $usr = $user->createStudent($login, $pass, $name);
            $usrProp = (new UserProperty())->createStudentProps($resStdDec, $usr->id);
        }else{
            $usr = $user->updateStudent($login, $pass, $name);
            $usrProp = (new UserProperty())->updateStudentProps($resStdDec, $usr->id);
            $usr = $user->getByLogin($login);
        }


        $user->makeAuth($usr->id);

        return [
            'err' => 0,
            'studentInfo'=>$resStdDec
        ];
    }






    public function register()
    {
        if(Auth::check()){
            return redirect('/');
        }
        return view('web.auth.register');
    }

    public function registerData(Request $request)
    {
        if ($request->ajax())
        {
            $input = $request->all();

            $user = new User();
            $user->name = htmlspecialchars(trim($input['fio']));
            $user->role_id = 5;
            $user->email = htmlspecialchars(trim($input['login'])) ;
            $user->password = htmlspecialchars(trim($input['pass']));
            $user->confirm_password = htmlspecialchars(trim($input['cpass']));

            $result = $user->validateSignUpFields();

            // if it is not ok, then msg error
            if( $result['error_code'] != 0 ){
                return response()->json(['input' => $result], 200);
            }

            // add user to db
            $data = $user->createUser();
            //create Folder for user
            $path = public_path('/uploads/users/' . str_replace('@tspu.tj', '', $user->email) . '/avatar');

            if(!File::isDirectory($path)){
                File::makeDirectory($path, 0777, true, true);
            }

            if($data){
                // auth user
                $result = $user->makeAuth($user->id);
                if($result){
                    return response()->json([
                        'input' => [
                            'error_code' => 0,
                            'msg' => __('lang.succes')
                        ]
                    ], 200);
                }
            }
            else{
                return response()->json([
                    'input' => [
                        'error_code' => 1,
                        'msg' => __('lang.error_auth')
                    ]
                ], 200);
            }
        }
    }

    public function logout(){
        Auth::logout();
        return redirect('/');
    }


    public function updateName(Request $request){
        if($request->ajax()){
            $input = $request->all();
            $usID = trim(htmlspecialchars($input['id']));
            $usName = trim(htmlspecialchars($input['name']));
            if(Auth::check() && Auth::user()->id == $usID){
                $data = (new User())->updateNameUser(Auth::user()->id, $usName);
                return Response::json($data->name, 200);
            }
        }
    }

/*    public function myAppeal(){
        if(Auth::check()){
            return view('web.user.my-appeal');
        }

		return redirect('/');
    }

    public function singleAppeal(){
		if(Auth::check()){
            return view('web.user.single-appeal');
        }

		return redirect('/');

    }*/

    public function uploadIMG(Request $request)
    {
        if($request->ajax())
        {
            $image_data = $request->image;
            $image_array_1 = explode(";", $image_data);
            $image_array_2 = explode(",", $image_array_1[1]);
            $data = base64_decode($image_array_2[1]);
            $image_name = time() . '.png';
            $u_login = str_replace('@tspu.tj', '', Auth::user()->email);
            $path = public_path('uploads/users/' . $u_login . '/avatar/');
            if(!File::isDirectory($path)){File::makeDirectory($path, 755, true, true);}
            File::cleanDirectory($path);
            $upload_path = $path . $image_name;
            file_put_contents($upload_path, $data);
            $user = new User();
            $user_data = $user->changeIMG(Auth::user()->id, $image_name);


            return response()->json(['path' => '/public/uploads/users/' . $u_login . '/avatar/' . $image_name]);
        }
    }




    public function viewUserInfo($id){

        $data = (new User())->getByID($id);

        $props = [];
        //student
        if($data->role_id == 3){
            $props = (new UserProperty())->getByUserID($id);
        }
        //malim

        $html = View::make('web.user._view-user-info', compact(['data', 'props']))->render();

        return Response::json(['html'=> $html], 200);


    }



}

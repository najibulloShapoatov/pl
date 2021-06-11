<?php

namespace App\Model;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


use Illuminate\Support\Facades\Session;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'password',
        'email',
        'image',
        'is_active',
        'role_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    /**
     * @var string
     */
    public function changePassword($input)
    {
        $userID = Auth::user()->id;
        $old_password = trim(htmlspecialchars($input['old_password']));
        $new_password = trim(htmlspecialchars($input['new_password']));

        if(!empty($old_password) && !empty($new_password))
        {

            if(Hash::check($old_password,Auth::user()->password))
            {
                $user = $this->getByID($userID);
                $user->password = bcrypt($new_password);
                $user->save();
                $msg = ['error' => 0, 'errorMsg' => ''];
            }
            else
            {
                $msg = ['error' => 1, 'errorMsg' => __('lang.not_correct_entered_old_pass')
                     ];
            }
        }
        else{
            $msg = ['error' => 1, 'errorMsg' => __('lang.enter_pass')];
        }

        return $msg;
    }

public function role(){
    return $this->belongsTo('App\Model\Role');
}

public function isAdmin(){
    if($this->role->id == 1 && $this->is_active == 1){
        return true;
    }
    return false;


}

public function isBooker(){
    if($this->role->id == 4 && $this->is_active == 1){
        return true;
    }
    return false;
}

public function getByEmail($email){
    return $this->where('email', ($email . '@tspu.tj'))->get()->first();
}

public function getByID($id){
    return $this->where('id', $id)->get()->first();
}

// validate sign up fields
public function validateSignUpFields()
{

    if(empty($this->name) || strlen($this->name) < 3){
        $error = ['error_code' => 1, 'msg' => __('lang.fio_3_symbol')];
        return $error;
    }
    if(empty($this->role_id)){
        $error = ['error_code' => 1, 'msg' => __('lang.who')];
        return $error;
    }
    if(empty($this->email) || strlen($this->email) < 3){
        $error = ['error_code' => 1, 'msg' => __('lang.login_3_symbol')];
        return $error;
    }
    if($this->getByEmail($this->email)){
        $error = ['error_code' => 1, 'msg' => __('lang.user_already_exists')];
        return $error;
    }

    if (!preg_match("/^[\w\d\s.,-]*$/", $this->email)) {
        $error = ['error_code' => 1, 'msg' => __('lang.login_english_symbol')];
        return $error;
    }

    if(empty($this->password) || strlen($this->password) < 3){
        $error = ['error_code' => 1, 'msg' =>__('lang.pass_3_symbol')];
        return $error;
    }
    if($this->password != $this->confirm_password){
        $error = ['error_code' => 1, 'msg' => __('lang.passws_not')];
        return $error;
    }
    return ['error_code' => 0, 'msg' => ''];
}

public function validateLoginFields()
{
    if(empty($this->email) || $this->email == ''){
        $error = ['error_code' => 1, 'msg' => __('lang.enter_login')];
        return $error;
    }
    if(empty($this->password) || $this->password == ''){
        $error = ['error_code' => 1, 'msg' => __('lang.enter_pass')];
        return $error;
    }
    return ['error_code' => 0, 'msg' => ''];
}

public function createUser()
{
    $this->email = $this->email . '@tspu.tj';
    $this->confirm_password = '';
    $this->password = Hash::make($this->password);
    return $this->save();
}

public function createStudent($login, $pass, $name)
{
    $user = new User();
    $user->email = $login . '@tspu.tj';
    $user->name = $name;
    $user->role_id = 3 ;
    $user->confirm_password = '';
    $user->password = Hash::make($pass);
    $user->save();

    return $user;
}



public function changeIMG($id, $img_name){
        $user = $this->where(['id' => $id])->get()->first();
        $user->image = $img_name;
        $result = $user->save();
        if($result){
            return true;
        }
}

public function checkUser(Request $request)
{
    $input = $request->all();
    $email = $this->email . '@tspu.tj';
    $user = $this->where(['email' => $email])->get()->first();
    if(!empty($user)){
        if(Hash::check($this->password, $user->password))
        {
            if($input['remember_me'] == 1){
                Auth::loginUsingId($user->id, true);
            }
            else{
                Auth::loginUsingId($user->id);
            }
            return true;
        }
        return false;
    }
    return false;
}

public function makeAuth($id){
    Auth::loginUsingId($id);
    return true;
}

    public function updateProfileInfo(Request $request)
    {
        $input = $request->all();

        $userID = Auth::user()->id;
        $u_name = trim(htmlspecialchars($input['name']));
        $facult_id = trim(htmlspecialchars($input['facult_id']));
        $special_id = trim(htmlspecialchars($input['special_id']));


        // get user info
        $user = $this->getByID($userID);
        $msg = ['image' => $user->image];          // default user image

        // upload image
//        if($file = $request->file('image')){
//            $image_name = time() . '.' . $file->getClientOriginalExtension();
//            $file->move('public/uploads/users/', $image_name);
//            $user->image = $image_name;
//            $msg = ['image' => $image_name];        // changed user image (after upload)
//        }

        // update user info
        $user->name = !empty($u_name) ? $u_name : 'Без имени';
        $user->facult_id = !empty($facult_id) ? $facult_id : 0;
        $user->special_id = !empty($special_id) ? $special_id : 0;
        $user->save();

        return $msg;
    }

    public function getList()
    {
        return $this->whereNotIn('role_id', ['1'])->orderBy('name', 'asc')->get();
    }

    public function getListAll()
    {
        return $this->orderBy('name', 'asc')->get();

    }

    public function checkHasStudTeach($login)
    {
        return $this->where(['email' => $login . '@tspu.tj'])->exists();
    }

    public function getByLogin($login)
    {
        return $this->where(['email' => $login . '@tspu.tj'])->get()->first();
    }

    public function updateNameUser($id, $usName)
    {
        $us = $this->getByID($id);
        $us->name = $usName;
        $us->save();
        return $us;
    }

    public function updateStudent($login, $pass, $name)
    {

        $user = $this->getByLogin($login);
        $user->email = $login . '@tspu.tj';
        $user->name = $name;
        $user->role_id = 3 ;
        $user->confirm_password = '';
        $user->password = Hash::make($pass);
        $user->save();

    }

}

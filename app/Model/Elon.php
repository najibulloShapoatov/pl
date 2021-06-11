<?php

namespace App\Model;

use DateTime;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class Elon extends Model
{
    protected $fillable = [
        'title',
        'category_id',
        'user_id',
        'description',
        'price',
        'phone_no',
        'image',
        'status',
        'published_at',
    ];



    public function user(){
        return $this->belongsTo('App\Model\User');
    }
    public function category(){
        return $this->belongsTo('App\Model\ElonCategory');
    }
    //
    public function getElons()
    {
        return $this->where(['status' => 1])->orderBy('published_at', 'desc')->paginate(10);
    }

    public function getByCategoryID($id)
    {
        return $this->where(['status' => 1, 'category_id' => $id ])->orderBy('published_at', 'desc')->paginate(10);
    }

    public function getByUserID($userID)
    {
        return $this->where(['status' => 1, 'user_id' => $userID ])->orderBy('published_at', 'desc')->paginate(10);
    }


    public function getByID($id)
    {
        return $this->where(['status' => 1, 'id' => $id ])->get()->first();
    }


    // validate sign up fields
    public function validateElonFields()
    {
        $patternPhoneCode = ['50','55','77','88','90','91','92','93','98','99','11'];
        $mobileregex = "/[0-9]{9}$/";
        $fl_array = preg_grep('/^'.substr($this->phone_no, 0, 2).'/', $patternPhoneCode);

        if(empty($this->category_id) ){
            $error = ['error_code' => 1, 'msg' => __('lang.select_a_category')];
            return $error;
        }
        if(empty($this->title) || strlen($this->title) < 6){
            $error = ['error_code' => 1, 'msg' => __('lang.polya_zag_dol_6')];
            return $error;
        }

        if(empty($this->phone_no) || strlen($this->phone_no) != 9 || preg_match($mobileregex,$this->phone_no) === 0){
            $error = ['error_code' => 1, 'msg' => __('lang.enter_phone_number_example')];
            return $error;
        }

        return ['error_code' => 0, 'msg' => ''];
    }




    //create new elon
    public static function createElon(Request $request)
    {

        $input = $request->all();
        $categoryID = trim(htmlspecialchars($input['category_id']));
        $title = trim(htmlspecialchars($input['title']));
        $price = trim(htmlspecialchars($input['price']));
        $descr = trim(htmlspecialchars($input['descr']));
        $phone_no = trim(htmlspecialchars($input['phone_no']));

        $now = new DateTime();
        $elon = new Elon();
        $elon->category_id = $categoryID;
        $elon->user_id = Auth::user()->id;
        $elon->title = $title;
        $elon->price = $price;
        $elon->description = $descr;
        $elon->published_at = $now;
        $elon->phone_no = $phone_no;

        $result = $elon->validateElonFields();
        // if it is not ok, then msg error
        if( $result['error_code'] != 0 ){
            return $result;
        }

        $res = $elon->save();

        if($file = $request->file('file')) {
            $path = public_path('/uploads/elons/' . $elon->id) ;
            mkdir($path, 0777, true);

            $image = $request->file('file');
            $extension = $file->getClientOriginalExtension();
            $imageName = time() . '_' . uniqid() . '.' . $extension;
            $img = Image::make($image);
            $img->save($path . '/' . $imageName);
            $img->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $elon->image = $imageName;
            $result = $elon->save();
            return ['error_code' => 0, 'msg' => ''];
        }
        return ['error_code' => 0, 'msg' => ''];
    }

    //update elon
    public static function updateElon(\Illuminate\Http\Request $request)
    {

        $input = $request->all();
        $elonID = trim(htmlspecialchars($input['id']));
        $categoryID = trim(htmlspecialchars($input['category_id']));
        $title = trim(htmlspecialchars($input['title']));
        $price = trim(htmlspecialchars($input['price']));
        $descr = trim(htmlspecialchars($input['descr']));
        $phone_no = trim(htmlspecialchars($input['phone_no']));

        $now = new DateTime();
        $elon = Elon::where(['id' => $elonID, 'user_id' => Auth::user()->id])->get()->first();
        $elon->category_id = $categoryID;
        $elon->user_id = Auth::user()->id;
        $elon->title = $title;
        $elon->price = $price;
        $elon->description = $descr;
        $elon->published_at = $now;
        $elon->phone_no = $phone_no;


        $res = $elon->save();

        if($file = $request->file('file')) {


            $path = public_path('/uploads/elons/' . $elon->id) ;
            if (!is_dir($path)) {
                mkdir($path, 0777, true);
            }

            $image = $request->file('file');
            $extension = $file->getClientOriginalExtension();
            $imageName = time() . '_' . uniqid() . '.' . $extension;
            $img = Image::make($image);
            $img->save($path . '/' . $imageName);
            $img->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            if(File::exists(public_path('/uploads/elons/' . $elonID . '/' . $elon->image))){
                File::delete(public_path('/uploads/elons/' . $elonID . '/' . $elon->image));
            }
            $elon->image = $imageName;
            $result = $elon->save();
            return ['error_code' => 0, 'msg' => ''];
        }
        return ['error_code' => 0, 'msg' => ''];
    }



    //remove Elon

    public static function removeElon(Request $request)
    {
        $input = $request->all();
        $elonID = trim(htmlspecialchars($input['id']));
        $elon= Elon::where(['id' => $elonID, 'user_id' => Auth::user()->id])->get()->first();
        if (is_dir('public/uploads/elons/' . $elonID)) {
            File::deleteDirectory(public_path('uploads/elons/' . $elonID));
        }
        $result = $elon->delete();
        if($result){
            return $result;
        }
    }

    public function loadByCategory(Request $request)
    {
        $input = $request->all();
        $catID = trim(htmlspecialchars($input['id']));
        if($catID == 0){
            return $this->getElons();
        }
        else{
            return $this->getByCategoryID($catID);
        }

    }

    //search
    public function searchElon($search)
    {
        return $this->where('title', 'like', '%'.$search.'%')
            ->orWhere('description', 'like', '%'.$search.'%')
            ->orWhere('price', 'like', '%'.$search.'%')
            ->orWhere('phone_no', 'like', '%'.$search.'%')
            ->orderBy('elons.published_at', 'desc')
            ->get();
    }



    /*===================aAdmin========================*/
    public function getListAdm()
    {
        return $this->orderBy('updated_at', 'desc')->paginate(15);
    }

    //change active
    public  function changeActive($input)
    {

        $ID = htmlspecialchars($input['elon_id']);

        $elon = $this->where('id', $ID)->get()->first();

        if($elon->status == 1){
            $elon->status = 0;
        }else{
            $elon->status = 1;
        }
        $elon->save();

        return $elon->status;
    }

    public  function removeAdmElon(Request $request)
    {
        $input = $request->all();
        $elonID = trim(htmlspecialchars($input['id']));
        $elon= Elon::where(['id' => $elonID])->get()->first();
        if (is_dir('public/uploads/elons/' . $elonID)) {
            File::deleteDirectory(public_path('uploads/elons/' . $elonID));
        }
        $result = $elon->delete();
        if($result){
            return $result;
        }
    }

    public function deleteElon($id){

        $elon= Elon::where(['id' => $id])->get()->first();
        if (is_dir('public/uploads/elons/' . $id)) {
            File::deleteDirectory(public_path('uploads/elons/' . $id));
        }
        $result = $elon->delete();
    }




}

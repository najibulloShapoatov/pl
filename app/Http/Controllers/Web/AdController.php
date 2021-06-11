<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Model\Elon;
use App\Model\ElonCategory;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;

class AdController extends Controller
{
public function index( Request $request){

     $elon = new Elon();
     $elon_cat = new ElonCategory();
     $elon_cats = $elon_cat->getList();
     $id_active = 0;

     if($request->search){
         $elon_data = $elon->searchElon($request->search);

         return view('web.ads.index', compact([
             'elon_data',
             'elon_cats',
             'id_active',
         ]));
     }

     $elon_data = $elon->getElons();

    return view('web.ads.index', compact([
        'elon_data',
        'elon_cats',
        'id_active',
    ]));
}

public function loadByCatElon($id){

    $elon = new Elon();
    $elon_cat = new ElonCategory();

    $elon_cats = $elon_cat->getList();
    $elon_data = $elon->getByCategoryID($id);

    $id_active = $id;
    return view('web.ads.index', compact([
        'elon_data',
        'elon_cats',
        'id_active',

    ]));
}

// Single Elons
public function single($id){
    $elon = new Elon();
    $elons = $elon->getByID($id);

    return view('web.ads.single-elon', compact([
        'elons',
    ]));
}

// MY Elons
public function myElon(){
    if(Auth::check()) {
        $elon = new Elon();
        $elons = $elon->getByUserID(Auth::user()->id);

        return view('web.ads.my-elon', compact([
            'elons',
            ]));
    }
    return redirect('/ads');
}

//Stranitsa dobavlenie
public function addElon(){
    if(Auth::check()) {
        $elon_cat = new ElonCategory();
        $elon_cats = $elon_cat->getList();
        return view('web.ads.add-elon', compact([
            'elon_cats',
        ]));
    }
    return redirect('/ads');
}

//Stranitsa redaktirovanie
public function editElon($id){
    if(Auth::check()) {
        $elon_cat = new ElonCategory();
        $elon_cats = $elon_cat->getList();
        $elon = new Elon();
        $elonData = $elon->getByID($id);

        if($elonData->user_id == Auth::user()->id) {
            return view('web.ads.edit-elon', compact([
                'elonData',
                'elon_cats',
            ]));
        }
        return redirect('/ads');
    }
    return redirect('/ads');
}


//Create New Elon In DB
public function createElon(Request $request){

    if(Auth::check()) {
        if( $request->ajax() ) {

            $result = Elon::createElon($request);

            return response()->json($result, 200);
        }
    }
    return redirect('/ads');
}

//Update Elon In DB
    public function updateElonPost(Request $request){

        if(Auth::check()) {
            if( $request->ajax() ) {
                $elon = new Elon();
                $input = $request->all();
                $elon->category_id = trim(htmlspecialchars($input['category_id']));
                $elon->title = trim(htmlspecialchars($input['title']));
                $elon->phone_no = trim(htmlspecialchars($input['phone_no']));
                $result = $elon->validateElonFields();
                // if it is not ok, then msg error
                if( $result['error_code'] != 0 ){
                    return $result;
                }

                $result = Elon::updateElon($request);

                return response()->json($result, 200);
            }
        }
        return redirect('/ads');
    }

    //community remove
    public function removeElon(Request $request){

        if(Auth::check()) {
            if ($request->ajax()) {
                $result = Elon::removeElon($request);
                return response()->json($result, 200);
            }
        }

    }

    /*===============Admin========================*/

    public function indexAdm(){
        if(Auth::check() && Auth::user()->role_id == 1){

            $Elon = new Elon();
            $elon = $Elon->getListAdm();

            return view('admin.elon.index',compact([
                'elon'
            ]));
        }
        return redirect('/elon');

    }


    public function changeActiveElon(Request $request){
        if(Auth::check() && Auth::user()->role_id == 1){

            if( $request->ajax() ) {

                $input = $request->all();
                $Elon = new Elon();
                $result = $Elon->changeActive($input);

                return response()->json($result, 200);
            }
        }
        return redirect('/elon');

    }

    public function removeAdmElon(Request $request){
        if(Auth::check() && Auth::user()->role_id == 1){

            if( $request->ajax() ) {

                $Elon = new Elon();
                $result = $Elon->removeAdmElon($request);

                return response()->json($result, 200);
            }
        }
        return redirect('/elon');

    }


    public function indexAdmCat(){
        if(Auth::check() && Auth::user()->role_id == 1){

            $Elon = new ElonCategory();
            $elon = $Elon->getList();

            return view('admin.elon.category',compact([
                'elon'
            ]));
        }
        return redirect('/');

    }


    public function cancelEditCat(Request $request){
        if(Auth::check() && Auth::user()->role_id == 1){

            if( $request->ajax() ) {

                $input=$request->all();
                $id = trim(htmlspecialchars($input['id']));
                $Elon = new ElonCategory();
                $data = $Elon->getByID($id);
                $html = View::make('admin.elon._cat', compact('data'))->render();

                return response()->json([
                    'html'=>$html
                ], 200);
            }
        }
        return redirect('/');

    }

    //save Edit
    public function saveEditCat(Request $request){

        if(Auth::check() && Auth::user()->role_id == 1){

            $input =$request->all();
            $Forum = new ElonCategory();
            $data = $Forum->updateCategory($input);

            $html = View::make('admin.elon._cat', compact('data'))->render();

            return Response::json($html, 200);

        }
        return redirect('/');

    }

    //remove Forum Category
    public function removeCategory(Request $request){

        if(Auth::check() && Auth::user()->role_id == 1){

            $input =$request->all();
            $ID = htmlspecialchars($input['id']);
            $elonCat = new ElonCategory();
            $cat = $elonCat->removeCategory($ID);


            return Response::json($cat, 200);

        }
        return redirect('/');

    }

    //create Forum Category
    public function createCategory(Request $request){

        if(Auth::check() && Auth::user()->role_id == 1){

            $input =$request->all();
            $Forum = new ElonCategory();
            $data = $Forum->createCategory($input);


            $html = View::make('admin.elon._cat', compact('data'))->render();
            return Response::json(['html' => $html, 'id' => $data->id], 200);
        }
        return redirect('/');

    }








}

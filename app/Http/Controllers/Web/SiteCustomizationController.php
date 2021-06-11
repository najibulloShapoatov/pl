<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Model\SiteCustomization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SiteCustomizationController extends Controller
{

    public function indexAdmin(){
        if(Auth::check() && Auth::user()->role_id == 1){

            $S_Customize = new SiteCustomization();
            $data = $S_Customize->getListAdm();

            return view('admin.sitecustomize.index',compact([
                'data'
            ]));
        }
        return redirect('/');

    }
 public function editindexAdmin(){
        if(Auth::check() && Auth::user()->role_id == 1){

            $S_Customize = new SiteCustomization();
            $data = $S_Customize->getListAdm();
            return view('admin.sitecustomize.edit',compact([
                'data'
            ]));
        }
        return redirect('/');

    }

    public function saveEditedAdmin(Request $request){
        if(Auth::check() && Auth::user()->role_id == 1){
            if(Auth::check()) {
                    if ($request->ajax()) {
                        $result = SiteCustomization::saveEdit($request);
                        return response()->json($result, 200);
                    }
                }

            }

        return redirect('/');

    }
}

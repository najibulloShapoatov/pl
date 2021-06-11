<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Model\Cafedra;
use App\Model\Faculty;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;

class FacultController extends Controller
{

    public function index(){
        if(Auth::check() && Auth::user()->role_id == 1) {
            $facs = (new Faculty())->getList();
            return view('admin.faculty.index', compact([
                'facs'
            ]));
        }
        return redirect('/');
    }

     public function cafedra($id){
        if(Auth::check() && Auth::user()->role_id == 1) {
            $fac = (new Faculty())->getByID($id);
            return view('admin.faculty.cafedra.index', compact([
                'fac'
            ]));
        }
        return redirect('/');
    }







    public function removeFac($id){
        if(Auth::check() && Auth::user()->role_id == 1) {
            $data = (new Faculty())->removeFacult($id);
            return Response::json($data, 200);
        }
        return redirect('/');
    }

    public function createFac(Request $request){
        if(Auth::check() && Auth::user()->role_id == 1) {
            if ($request->ajax()){
                $in = $request->all();
                $title = trim(htmlspecialchars($in['title']));
                $data = (new Faculty())->createFacult($title);
                $html = View::make('admin.faculty._add', compact('data'))->render();
                return Response::json($html, 200);
            }
        }
        return redirect('/');
    }

    public function updateFac(Request $request){
        if(Auth::check() && Auth::user()->role_id == 1) {
            if ($request->ajax()){
                $in = $request->all();
                $id = trim(htmlspecialchars($in['id']));
                $title = trim(htmlspecialchars($in['title']));
                $data = (new Faculty())->updateFacult($id, $title);
                $html = View::make('admin.faculty._update', compact('data'))->render();
                return Response::json($html, 200);
            }
        }
        return redirect('/');
    }

//cafedra
    public function removeCaf($id){
        if(Auth::check() && Auth::user()->role_id == 1) {
            $data = (new Cafedra())->removeCafedra($id);
            return Response::json($data, 200);
        }
        return redirect('/');
    }

    public function createCaf(Request $request){
        if(Auth::check() && Auth::user()->role_id == 1) {
            if ($request->ajax()){
                $in = $request->all();
                $title = trim(htmlspecialchars($in['title']));
                $fid = trim(htmlspecialchars($in['fid']));
                $data = (new Cafedra())->createCafedra($fid, $title);
                $html = View::make('admin.faculty.cafedra._add', compact('data'))->render();
                return Response::json($html, 200);
            }
        }
        return redirect('/');
    }

    public function updateCaf(Request $request){
        if(Auth::check() && Auth::user()->role_id == 1) {
            if ($request->ajax()){
                $in = $request->all();
                $id = trim(htmlspecialchars($in['id']));
                $title = trim(htmlspecialchars($in['title']));
                $data = (new Cafedra())->updateCafedra($id, $title);
                $html = View::make('admin.faculty.cafedra._update', compact('data'))->render();
                return Response::json($html, 200);
            }
        }
        return redirect('/');
    }


}

<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Model\Faq;
use App\Model\FaqCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;

class FaqController extends Controller
{


    public function index(){

        $FaqCat =  new FaqCategory();
       $faqCat = $FaqCat->getList();

        return view('web.faq.index', compact([
            'faqCat'
        ]));
    }




    /*====================Admin========================================================*/

    public function indexAdm(){
        if(Auth::check() && Auth::user()->role_id == 1){

            $Faq = new Faq();
            $faqs = $Faq->getList();

            return view('admin.faq.index',compact([
                'faqs'
            ]));
        }
        return redirect('/faq');

    }

    public function catFaqPage(){
        if(Auth::check() && Auth::user()->role_id == 1){

            $FaqCat = new FaqCategory();
            $faqCats = $FaqCat->getListAdm();

            return view('admin.faq.category',compact([
                'faqCats'
            ]));
        }
        return redirect('/faq');

    }


    public function addFaqPage(){
        if(Auth::check() && Auth::user()->role_id == 1){
            $FaqCat =  new FaqCategory();
            $faqCats = $FaqCat->getList();

            return view('admin.faq.add',compact([
                'faqCats',
            ]));
        }
        return redirect('/faq');

    }

     public function editFaqPage($id){
        if(Auth::check() && Auth::user()->role_id == 1){
            $FaqCat =  new FaqCategory();
            $faqCats = $FaqCat->getList();
            $faq = Faq::where(['id' => $id])->get()->first();

            return view('admin.faq.edit',compact([
                'faqCats',
                'faq',
            ]));
        }
        return redirect('/faq');

    }

    //delete faq
    public function removeAdmFaq(Request $request){

        if(Auth::check() && Auth::user()->role_id == 1){
            if ($request->ajax())
            {
                $input = $request->all();
                $faq = new Faq();
                $data = $faq->removeFaq($input);
                return Response::json($data, 200);
            }

        }
        return redirect('/faq');

    }


    //delete faq
    public function removeFaqCat(Request $request){

        if(Auth::check() && Auth::user()->role_id == 1){
            if ($request->ajax())
            {
                $input = $request->all();
                $faq = new FaqCategory();
                $data = $faq->removeFaqCat($input);
                return Response::json($data, 200);
            }

        }
        return redirect('/faq');

    }

    //save edited faq
    public function createFaq(Request $request){

        if(Auth::check() && Auth::user()->role_id == 1){
            if ($request->ajax())
            {
                $input = $request->all();
                $faq = new Faq();
                $data = $faq->createFaq($input);
                return Response::json($data, 200);
            }

        }
        return redirect('/faq');

    }

    //save edited faq
    public function saveEditedFaq(Request $request){

        if(Auth::check() && Auth::user()->role_id == 1){
            if ($request->ajax())
            {
                $input = $request->all();
                $faq = new Faq();
                $data = $faq->saveFaq($input);
                return Response::json($data, 200);
            }

        }
        return redirect('/faq');

    }


    //create Forum Category
    public function createFaqCat(Request $request){

        if(Auth::check() && Auth::user()->role_id == 1){

            $input =$request->all();
            $Forum = new FaqCategory();
            $faqCat = $Forum->createCategory($input);

            $html = View::make('admin.faq._cat', compact('faqCat'))->render();
            return Response::json(['html' => $html, 'id' => $faqCat->id], 200);
        }
        return redirect('/faq');

    }



    //cancel Edit
    public function cancelFaqCat(Request $request){

        if(Auth::check() && Auth::user()->role_id == 1){

            $input =$request->all();
            $ID = htmlspecialchars($input['id']);
            $FaqCat = new FaqCategory();
            $faqCat = $FaqCat->getByID($ID);

            $html = View::make('admin.faq._cat', compact('faqCat'))->render();

            return Response::json($html, 200);

        }
        return redirect('/faq');

    }



    //save Edit
    public function saveFaqCat(Request $request){

        if(Auth::check() && Auth::user()->role_id == 1){

            $input =$request->all();
            $FaqCat = new FaqCategory();
            $faqCat = $FaqCat->updateEdited($input);

            $html = View::make('admin.faq._cat', compact('faqCat'))->render();

            return Response::json($html, 200);

        }
        return redirect('/faq');

    }


}

<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Model\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;

class NewsController extends Controller
{
    public function index(){
        $newss = new News();
        $news = $newss->getList();
        return view('web.news.index', compact([
            'news'
        ]));



    }

    //single news
    public function single(Request $request, $news_id){

        //$clientIP = $request->ip();
        //print_r($clientIP);

        $newss=new News();
        $news=$newss->getDetail($news_id);
        return view('web.news.single-news', compact([
            'news'
        ]));
    }

    //load more news
    public function loadMore(Request $request)
    {
        if ($request->ajax())
        {
            $input = $request->all();
            $news = new News();
            $data = $news->loadMoreNews($input);
            $html = View::make('web.news._load', compact('data'))->render();
            return Response::json(['html' => $html, 'info' => $data], 200);
        }
    }

    //load by year news
    public function loadByYear(Request $request){
        $input = $request->all();
        $news = new News();
        $data = $news->loadByYear($input);
        $html = View::make('web.news._load', compact('data'))->render();
        return Response::json(['html' => $html, 'info' => $data], 200);
    }




    /*======================================Admin===================================================*/

    public function indexAdmin(){
        if(Auth::check() && Auth::user()->role_id == 1){

            $News = new News();
            $news = $News->getListAdm();

            return view('admin.news.index',compact([
                'news'
            ]));
        }
        return redirect('/news');

    }

    public function editNews($id){
        if(Auth::check() && Auth::user()->role_id == 1){

            $News = new News();
            $news = $News->getByID($id);

            return view('admin.news.edit-news',compact([
                'news'
            ]));
        }
        return redirect('/news');

    }



   //change news active
    public function changeActiveNews(Request $request){

        if(Auth::check() && Auth::user()->role_id == 1){
            if ($request->ajax())
            {
                $input = $request->all();
                $news = new News();
                $data = $news->changeActive($input);
                return Response::json($data, 200);
            }

        }
        return redirect('/news');

    }


   //delete News
    public function deleteNews(Request $request){

        if(Auth::check() && Auth::user()->role_id == 1){
            if ($request->ajax())
            {
                $input = $request->all();
                $news = new News();
                $data = $news->deleteNews($input);
                return Response::json($data, 200);
            }

        }
        return redirect('/news');

    }


   //update News
    public function updateNews(Request $request){

        if(Auth::check() && Auth::user()->role_id == 1){
            if ($request->ajax())
            {

                $news = new News();
                $data = $news->updateNews($request);
                return Response::json($data, 200);
            }

        }
        return redirect('/news');

    }




   //update News
    public function createNewsPage(Request $request){

        if(Auth::check() && Auth::user()->role_id == 1){
               return view('admin.news.add-news');
        }
        return redirect('/news');

    }



   //update News
    public function createNews(Request $request){

        if(Auth::check() && Auth::user()->role_id == 1){
            if ($request->ajax())
            {

                $news = new News();
                $data = $news->createNews($request);
                return Response::json($data, 200);
            }

        }
        return redirect('/news');

    }


    /*===============================================================================================*/

}

<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Model\Book;
use App\Model\Community;
use App\Model\Elon;
use App\Model\Forum;
use App\Model\News;
use App\Model\VideoCourse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;

class SearchController extends Controller
{
    public function search(){

        return view('web.search.search');
    }




/*    public function index( Request $request)
    {


        $id_active = 1;

        if ($request->search_text) {

            $id = htmlspecialchars($request->search_cat);
            $id_active = $id;
            $search = htmlspecialchars($request->search_text);


            $news = new News();
            $data = $news->searchGlobal($search);
            //print_r($data);
            return view('web.search.search', compact([
                'data',
                'id_active',
                'search'
            ]));
        }
    }*/















    public function searchData(Request $request){


        if ($request->ajax())
        {
            $input = $request->all();
            $id_active = htmlspecialchars($input['id']);
            $search = htmlspecialchars($input['title']);
            $data =[];
            $html=[];

            switch ($id_active){
                case 1:
                    $news = new News();
                    $data = $news->searchGlobal($search);
                    $html = View::make('web.search._search', compact([
                        'data',
                        'search',
                        'id_active',
                    ]))->render();
                    break;
                case 2:
                    $news = new Book();
                    $data = $news->searchGlobal($search);
                    $html = View::make('web.search._search-lib', compact([
                        'data',
                        'search',
                        'id_active',
                    ]))->render();
                    break;
                case 3:
                    $forum = new Forum();
                    $data = $forum->searchForum($search);
                    $html = View::make('web.search._search-forum', compact([
                        'data',
                        'search',
                        'id_active',
                    ]))->render();
                    break;
                case 4:
                    $comm = new Community();
                    $data = $comm->search($search);
                    $html = View::make('web.search._search-comm', compact([
                        'data',
                        'search',
                        'id_active',
                    ]))->render();
                    break;
                case 5:
                    $elon = new Elon();
                    $data = $elon->searchElon($search);
                    $html = View::make('web.search._search-elon', compact([
                        'data',
                        'search',
                        'id_active',
                    ]))->render();
                    break;
                case 6:
                    $course = new VideoCourse();
                     $data = $course->search($search);
                    $html = View::make('web.search._search-course', compact([
                        'data',
                        'search',
                        'id_active',
                    ]))->render();
                    break;
                default:
                    $data=[];
            }

            return Response::json(['html' => $html, 'info' => $data], 200);
        }

    }

}

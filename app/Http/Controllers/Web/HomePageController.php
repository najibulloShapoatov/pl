<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Model\Book;
use App\Model\BookCategory;
use App\Model\Community;
use App\Model\CommunityParticipant;
use App\Model\News;
use App\Model\Pool;
use App\Model\PoolAnswer;
use App\Model\PoolResult;
use App\Model\VideoCourse;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;


use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;
use phpDocumentor\Reflection\Location;


class HomePageController extends Controller
{


    public function setLang($locale)
    {
        App::setLocale($locale);
        session()->put('locale', $locale);
        return redirect()->back();
    }



    public function index(Request $request){

        // news
        $news = new News();
        $homeNews = $news->getHomeNews();

        // videocourse
        $videocourse = VideoCourse::orderBy('created_at', 'desc')->take(12)->get();

        //book
        $book=new Book();
        $books=$book->getBookHome();

        //community
        $comm = new Community();
        $community = $comm->getHomeComs();

        //community participants
        $c_P = new CommunityParticipant();
        $com_parts_user = [];
       /* if(Auth::check()){ $com_parts_user = $c_P->getByUserID(Auth::user());}*/

        // poll
        $Pool = new Pool();
        $pool = $Pool->getHome();
        //$ip = $request->ip();
        $ip = request()->cookie('ip_cookie');

        $p_res = $Pool->getPoolResults($pool->id);
        $isPolled = false;
        foreach ($pool->answers as $answer) {
            foreach ($answer->poolres as $item) {
                if ($item->ip_cookie == $ip) {
                    $isPolled = true;
                    break;
                }
            }
        }



       /* $to_name = 'Nachibullo';
        $to_email = 'abduholiq007@gmail.com';
        $subject = 'Duzdi';
        $data = array('name'=>"Sam Jose", "body" => "Test mail");
        Mail::send('mail.mail-template', compact(['data']), function($message) use ($subject, $to_name, $to_email) {
            $message->to($to_email, $to_name)->subject($subject);
            $message->from('tspuportal@gmail.com','TSPU PORTAL');
        });*/





        return view('web.index', compact([
            'homeNews',
            'books',
            'pool',
            'p_res',
            'isPolled',
            'videocourse',
            'community',
        ]));
    }

    public function bitrix(){
        return view('web.bitrix.index');
    }



}

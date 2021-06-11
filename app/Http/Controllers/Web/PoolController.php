<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Model\Pool;
use App\Model\PoolAnswer;
use App\Model\PoolResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;

class PoolController extends Controller
{

    public function index(Request $request){
        $Pool = new Pool();
        $pools = $Pool->getList();

        //$ip = $request->ip();
        $ip = request()->cookie('ip_cookie');
        /*echo "<pre>";
        print_r($pools);
        echo "</pre>";*/


         return view('web.pool.index', compact([
             'pools',
             'ip',
         ]));
    }



    public function pooling(Request $request){
        if ($request->ajax()){
            $poolR = new PoolResult();
            $input = $request->all();
            $id = htmlspecialchars($input['id']);
            $ips = request()->cookie('ip_cookie');


            $rs =false;
            if($ips == null) {
                $ip5 = time() . '_' . uniqid();
                Cookie::queue('ip_cookie', $ip5, 3600 * 64);
                $ip = $ip5;
            }
            if($ips != null) {
                $rs = $poolR->isPolled($id, $ips);
                $ip = $ips;
            }
            if(!$rs) {

                //$ips = request()->cookie('ip_cookie');
                //$ip = $request->ip();

                $pool_res = $poolR->addpool($id, $ip);

                $PoolA = new PoolAnswer();
                $pool_ans = $PoolA->getByID($id);
                $Pool = new Pool();
                $pool = $Pool->getByID($pool_ans->pool_id);
                $p_res = $Pool->getPoolResults($pool->id);

                $html = View::make('web._pool-res', compact(['pool', 'p_res']))->render();

                return Response::json([
                    'err' => 0,
                    'html' => $html,
                ], 200);
            }
            else{
                Response::json([
                    'err' => 1,
                    'msg' => "Вы уже голосовали",
                ], 200);
            }
        }
    }


    public function poolingGet(Request $request){
        if ($request->ajax()){
            $input = $request->all();
            $id = htmlspecialchars($input['id']);

            $Pool = new Pool();
            $pool =$Pool->getByID($id);
            $p_res = $Pool->getPoolResults($pool->id);

            $html = View::make('web._pool-res', compact(['pool','p_res']))->render();

            return Response::json([
                'html'=>$html,
            ], 200);
        }
    }

    public function indexADMPool(){
        if (Auth::check() && Auth::user()->role_id == 1){
            $pool = new Pool();
            $data = $pool->getListADM();
            return view('admin.pool.index', compact([
                'data'
            ]));
        }
        return redirect('/');
    }

    public function addADMPool(){
        if (Auth::check() && Auth::user()->role_id == 1){
            return view('admin.pool.add');
        }
        return redirect('/');
    }

    public function editADMPool($id){
        if (Auth::check() && Auth::user()->role_id == 1){
            $pool = new Pool();
            $data = $pool->getByID($id);
            return view('admin.pool.edit', compact([
                'data'
            ]));
        }
        return redirect('/');
    }

    public function createPool(Request $request){
        if (Auth::check() && Auth::user()->role_id == 1){
            if ($request->ajax()){
                $pool = new Pool();
                $input = $request->all();
                $n_pool = $pool->create($input);
                return Response::json($n_pool, 200);
            }
        }
        return Response::json("error", 404);

    }


    public function updatePool(Request $request){
        if (Auth::check() && Auth::user()->role_id == 1){
            if ($request->ajax()){
                $pool = new Pool();
                $input = $request->all();
                $n_pool = $pool->updatePool($input);
                return Response::json($n_pool, 200);
            }
        }
        return Response::json("error", 404);

    }


    public function removePool(Request $request){
        if (Auth::check() && Auth::user()->role_id == 1){
            if ($request->ajax()){
                $pool = new Pool();
                $input = $request->all();
                $n_pool = $pool->removePool($input);
                return Response::json($n_pool, 200);
            }
        }
        return Response::json("error", 404);
    }



    public function changeActivePool(Request $request){
        if (Auth::check() && Auth::user()->role_id == 1){
            if ($request->ajax()){
                $pool = new Pool();
                $input = $request->all();
                $n_pool = $pool->changeActivePool($input);
                return Response::json($n_pool, 200);
            }
        }
        return Response::json("error", 404);
    }




}

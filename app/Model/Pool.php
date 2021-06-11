<?php

namespace App\Model;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Pool extends Model
{
    protected $fillable =[
        'title',
        'is_active',
    ];

    public function answers(){
        return $this->hasMany('App\Model\PoolAnswer');
    }

    public function getByID($id){
        return $this->where('id', $id)->get()->first();
    }
    public function getHome(){
        return $this->where('is_active', 1)->get()->first();
    }

    public function getList(){

        /*$data =  DB::table('pools')
            ->select('pools.*', 'pool_results.*')
            ->join('pool_answers', 'pool_answers.pool_id', '=', 'pools.id')
            ->join('pool_results', 'pool_results.pool_answer_id', '=', 'pool_answers.id')
            ->get()
            ->toArray();

        return $data;*/

        return $this->whereDate('start_date','<=', Carbon::now())->get();




    }
    public function getListADM(){
        return $this->orderBy('updated_at', 'desc')->paginate(15);
    }
    public function getPoolResults($id){

        $p_answer = PoolAnswer::where(['pool_id' => $id])->get();
        $arrIds = [];
        foreach ($p_answer as $rs){ $arrIds[] = $rs->id;}
        $arr = PoolResult::whereIn('pool_answer_id', $arrIds)->count();
        return $arr;
    }

    public function create($input)
    {
        $title = htmlspecialchars($input['title']);
        $start_date = htmlspecialchars($input['start_date']);
        $end_date = htmlspecialchars($input['end_date']);
        $answersStr = htmlspecialchars($input['answers']);
        $answers = explode(',', $answersStr);
        $rs = $this->validate($title, $answers);
        if ($rs['err'] != 0){ return $rs;}
        $pool = new Pool();
        $pool->title = $title;
        $pool->start_date = $start_date;
        $pool->end_date = $end_date;
        $pool->save();
        foreach ($answers as $ans){
            $p_ans = new PoolAnswer();
            $p_ans->pool_id = $pool->id;
            $p_ans->title = $ans;
            $p_ans->save();
        }
        return $rs;
    }

    public function updatePool($input)
    {
        $id = htmlspecialchars($input['id']);
        $title = htmlspecialchars($input['title']);
        $answersStr = htmlspecialchars($input['answers']);
        $start_date = htmlspecialchars($input['start_date']);
        $end_date = htmlspecialchars($input['end_date']);
        $answers = explode(',', $answersStr);
        $rs = $this->validate($title, $answers);
        if ($rs['err'] != 0){ return $rs;}
        $pool = $this->getByID($id);
        $pool->title = $title;
        $pool->start_date = $start_date;
        $pool->end_date = $end_date;
        $pool->save();

        $pool_ans = new PoolAnswer();
        $p_ans = $pool_ans->getByPoolID($id);

        $i=0;
        foreach ($p_ans as $item){
            $item->title = $answers[$i];
            $item->save();
            $i++;
        }

        return $rs;
    }

    public function validate($title, $answers){
        $res = [
            'err'=>0
        ];

        foreach ($answers as $item){
            if (empty($item)){
                $res = [
                    'err'=>1,
                    'msg'=> __('lang.enter_variants_answer')
                ];
            }
        }
        if (empty($title)){
            $res = [
                'err'=>1,
                'msg'=>__('lang.enter_questions')
            ];
        }
        return $res;
    }


    public function removePool( $input)
    {
        $id = htmlspecialchars($input['id']);
        $pool = $this->getByID($id);
        $pool->answers()->delete();
        $pool->delete();
        return true;
    }

    public function changeActivePool($input)
    {
        $id = htmlspecialchars($input['id']);
        $pool = $this->getByID($id);

        if($pool->is_active != 1) {
            $pools_active = $this->where('is_active', 1)->get();
            foreach ($pools_active as $item) {
                $item->is_active = 0;
                $item->save();
            }
            $pool->is_active = 1;
            $pool->save();
        }
        return true;

    }


}

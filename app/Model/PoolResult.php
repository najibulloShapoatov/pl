<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PoolResult extends Model
{
    protected $fillable = [
        'pool_answer_id',
        'ip_cookie',
    ];
    public function addpool($id, $ip)
    {
        $rs = $this->where(['ip_cookie'=> $ip, 'pool_answer_id'=>$id])->exists();

        if($rs){
            $poolR = $this->where('ip_cookie', $ip)->get()->first();
        }
        else{
            $poolR = new PoolResult();
            $poolR->ip_cookie = $ip;
        }
        $poolR->pool_answer_id = $id;
        $poolR->save();
        return $poolR;
    }

    public function isPolled($id, $ips)
    {
        $rs = $this->where(['ip_cookie'=> $ips, 'pool_answer_id'=>$id])->exists();
        if($rs){
            return true;
        }else{
            return false;
        }
    }


}

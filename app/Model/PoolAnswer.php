<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PoolAnswer extends Model
{
    protected $fillable = [
        'pool_id',
        'title',
    ];
    public function poolres(){
        return $this->hasMany('App\Model\PoolResult');
    }
    public function getByID($id){
        return $this->where(['id'=> $id])->get()->first();
    }

    public function getByPoolID( $id)
    {
        return $this->where(['pool_id'=> $id])->get();
    }
}

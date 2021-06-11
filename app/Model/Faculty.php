<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Faculty extends Model
{
    public function cafedra(){
        return $this->hasMany('App\Model\Cafedra', 'facult_id');
    }


    public function getList(){
        return $this->orderBy('title', 'asc')->get();
    }
    public function getByID($id){
        return $this->where('id', $id)->get()->first();
    }

    public function createFacult(string $title)
    {
        $f = new Faculty();
        $f->sort_order = (Faculty::all()->last()->sort_order)+1;
        $f->title = $title;
        $f->save();
        return $f;

    }

    public function removeFacult($id)
    {
        $f = $this->getByID($id);
        $f->cafedra()->delete();
        return $f->delete();

    }

    public function updateFacult(string $id, string $title)
    {
        $f = $this->getByID($id);
        $f->title = $title;
        $f->save();
        return $f;
    }
}

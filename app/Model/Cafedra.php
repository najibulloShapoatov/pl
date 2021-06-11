<?php

namespace App\Model;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Response;

class Cafedra extends Model
{



    public function getList(){
        return $this->orderBy('title', 'asc')->get();
    }
    public function getByID($id){
        return $this->where('id', $id)->get()->first();
    }

    public function createCafedra($fid, $title)
    {
        $f = new Cafedra();
        $f->facult_id = $fid;
        $f->title = $title;
        $f->save();
        return $f;

    }

    public function removeCafedra($id)
    {
        $f = $this->getByID($id);
        return $f->delete();

    }

    public function updateCafedra(string $id, string $title)
    {
        $f = $this->getByID($id);
        $f->title = $title;
        $f->save();
        return $f;
    }

    public function getByFacultID($id)
    {
        return $this->where('facult_id', $id)->orderBy('title', 'asc')->get();
    }
}

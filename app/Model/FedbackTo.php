<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class FedbackTo extends Model
{
    protected $fillable =[
        'facult_id',
        'place',
        'name'
    ];

    public function facultet(){
        return $this->belongsTo('App\Model\Faculty', 'facult_id');
    }
    public function getByID($id){
        return $this->where('id', $id)->get()->first();
    }
    public function getList(){
        return $this->orderBy('created_at', 'desc')->paginate(15);
    }
    public function getListWithoutPag(){
        return $this->orderBy('created_at', 'desc')->get();
    }
    public function getListByFaculty($facult_id){
       return $this->where(['facult_id'=>$facult_id])->orderBy('name', 'asc')->get();
    }

    public function createFedTo(string $fID, string $place, string $name,  $email)
    {
        $f = new FedbackTo();
        $f->facult_id = $fID;
        $f->place = $place;
        $f->name = $name;
        $f->email = $email;
        $f->save();
        return $f;
    }
    public function updateFedTo($id, $fID, $place, $name,  $email)
    {
        $f = $this->getByID($id);
        $f->facult_id = $fID;
        $f->place = $place;
        $f->name = $name;
        $f->email = $email;
        $f->save();
        return $f;
    }

    public function removeById($id)
    {
        $f = $this->getByID($id);
        return $f->delete();
    }
}

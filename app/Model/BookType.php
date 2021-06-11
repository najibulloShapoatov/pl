<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class BookType extends Model
{

    protected $fillable =[
        'title'
    ];

    public function getList()
    {
        return $this->orderBy('title', 'asc')->get();
    }

    public function getByID($id){
        return $this->where('id', $id)->get()->first();
    }

    public function create( $input)
    {
        $title = htmlspecialchars($input['title']);

        $L = new BookType();

        $L->title = $title;
        $L->save();
        return $L;
    }

    public function remove( $ID)
    {
        $lang = $this->getByID($ID);
        return $lang->delete();
    }

    public function saveEdited( $ID, $title)
    {
        $lang =$this->getByID($ID);
        $lang->title = $title;
        $lang->save();
        return $lang;
    }
}

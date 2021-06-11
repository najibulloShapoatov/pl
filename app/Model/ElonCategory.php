<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ElonCategory extends Model
{

    public function elons(){
        return $this->hasMany('App\Model\Elon', 'category_id');
    }
    //
    public function getList()
    {
        return $this->orderBy('created_at', 'asc')->get();
    }

    public function getByID($id)
    {
        return $this->where('id', $id)->get()->first();
    }

    //update category info
    public function updateCategory($input)
    {
        $ID = htmlspecialchars($input['id']);
        $title = htmlspecialchars($input['title']);

        $cat = $this->where(['id' => $ID])->get()->first();
        $cat->title = $title;
        $cat->save();

        return $cat;

    }


    public function removeCategory($ID)
    {
        $cat =  $this->getByID($ID);
        $elon =new Elon();
        foreach ($cat->elons as $item){
            $elon->deleteElon($item->id);
        }

        return $cat->delete();
    }

    //create
    public function createCategory($input)
    {
        $title = htmlspecialchars($input['title']);

        $cat = new ElonCategory();

        $cat->title = $title;
        $cat->save();
        return $cat;
    }


}

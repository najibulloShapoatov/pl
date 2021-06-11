<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ForumCategory extends Model
{
    protected  $fillable = [
        'title'
    ];



    public function catqnt(){
        return $this->hasMany('App\Model\Forum', 'category_id');
    }

    public function getList()
    {
        return $this->orderBy('created_at', 'desc')->get();
    }
    public function getListADM()
    {
        return $this->orderBy('updated_at', 'desc')->paginate(15);
    }


    //get By ID
    public function getByID($id)
    {
        return $this->where('id', $id)->get()->first();
    }

    //update category info
    public function updateCategory($input)
    {
        $ID = htmlspecialchars($input['forum_cat_id']);
        $title = htmlspecialchars($input['title']);

        $f_cat = $this->where(['id' => $ID])->get()->first();
        $f_cat->title = $title;
        $f_cat->save();

        return $f_cat;

    }

    public function removeCategory($ID)
    {
        $f_cat =  $this->getByID($ID);
        $Forum = new Forum();
        $forums = $Forum->getListCategoryID($f_cat->id);
        foreach ($forums as $item){
            $Forum->deleteForum($item->id);
        }

        return $f_cat->delete();
    }

    //create
    public function createCategory($input)
    {
        $title = htmlspecialchars($input['title']);

        $f_cat = new ForumCategory();

        $f_cat->title = $title;
        $f_cat->save();
        return $f_cat;
    }


}

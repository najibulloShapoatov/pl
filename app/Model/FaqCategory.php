<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class FaqCategory extends Model
{

    protected $fillable = [
        'title'
    ];

    public  function faqs(){
        return $this->hasMany('App\Model\Faq', 'category_id');
    }
    public function getList(){
       return $this->orderBy('title', 'asc')->get();
    }


    public function getListAdm(){
       return $this->orderBy('title', 'asc')->paginate(15);
    }



    /*===================================================*/
    //create
    public function createCategory($input)
    {
        $title = htmlspecialchars($input['title']);

        $f_cat = new FaqCategory();

        $f_cat->title = $title;
        $f_cat->save();
        return $f_cat;
    }

    public function removeFaqCat($input)
    {
        $faqCat_id = trim(htmlspecialchars($input['id']));
        $faqCat = $this->where(['id' => $faqCat_id])->get()->first();
        $faqCat->faqs()->delete();
        return $faqCat->delete();
    }


    public function getByID( $ID)
    {
        return $this->where('id', $ID)->get()->first();
    }


    //update category info
    public function updateEdited($input)
    {
        $ID = htmlspecialchars($input['id']);
        $title = htmlspecialchars($input['title']);

        $f_cat = $this->getByID($ID);
        $f_cat->title = $title;
        $f_cat->save();

        return $f_cat;

    }



}

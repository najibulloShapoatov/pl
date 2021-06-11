<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    //
    protected $fillable = [
        'category_id',
        'title',
        'description'
    ];

    public function category(){
        return $this->belongsTo('App\Model\FaqCategory');
    }

    public function getList()
    {
        return $this->orderBy('updated_at', 'desc')->paginate(15);
    }
//remove faq
    public function removeFaq( $input)
    {
        $faq_id = trim(htmlspecialchars($input['id']));
        $faq = $this->where(['id' => $faq_id])->get()->first();

        return $faq->delete();
    }


    public function createFaq($input)
    {

        $cat_id = trim(htmlspecialchars($input['cat_id']));
        $title = trim(htmlspecialchars($input['title']));
        $descr = trim(htmlspecialchars($input['descr']));

        $faq = new Faq();

        $faq->category_id = $cat_id;
        $faq->title = $title;
        $faq->description = $descr;

        return $faq->save();
    }


    public function saveFaq( $input)
    {
        $faq_id = trim(htmlspecialchars($input['id']));
        $cat_id = trim(htmlspecialchars($input['cat_id']));
        $title = trim(htmlspecialchars($input['title']));
        $descr = trim(htmlspecialchars($input['descr']));

        $faq = $this->where(['id' => $faq_id])->get()->first();

        $faq->category_id = $cat_id;
        $faq->title = $title;
        $faq->description = $descr;

        return $faq->save();
    }


}

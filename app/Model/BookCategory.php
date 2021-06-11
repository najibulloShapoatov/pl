<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class BookCategory extends Model
{
    protected $fillable =[
        'parent_id',
        'title',
        'is_active'
    ];

    public function books(){
        return $this->hasMany('App\Model\Book');
    }

    public function getByID($id)
    {
        return $this->where(['id' => $id])->get()->first();
    }

    public function getByIDCats($id)
    {
        if (Auth::check() && Auth::user()->role_id == 4)
            return $this->where([ 'parent_id'=> $id])->orderBy('updated_at', 'desc')->paginate(10);
        else{
            return $this->where([ 'parent_id'=> $id])->orderBy('title', 'asc')->get();
        }
    }

    public function getList()
    {
        if (Auth::check() && Auth::user()->role_id == 4)
            return $this->where(['parent_id'=> 0 ])->orderBy('updated_at', 'desc')->paginate(10);
        else{
            return $this->where(['parent_id'=> 0, 'is_active'=> 1 ])->orderBy('title', 'asc')->get();
        }
    }

    //create
    public function createCategory( $input)
    {
        $title = htmlspecialchars($input['title']);

        $Cat = new BookCategory();

        $Cat->title = $title;
        $Cat->is_active = 1;
        $Cat->save();
        return $Cat;

    }

    //create
    public function createPCategory( $input)
    {
        $pid = htmlspecialchars($input['parent_id']);
        $title = htmlspecialchars($input['title']);

        $Cat = new BookCategory();

        $Cat->parent_id = $pid;
        $Cat->title = $title;
        $Cat->is_active = 1;
        $Cat->save();
        return $Cat;

    }


    //change active
    public function changeActive($input)
    {
        $ID = htmlspecialchars($input['id']);

        $data = $this->where('id', $ID)->get()->first();

        if($data->is_active == 1){
            $data->is_active = 0;
        }else{
            $data->is_active = 1;
        }
        $data->save();

        return $data->is_active;

    }

    public function remove( $ID)
    {
        $Cat =  $this->where(['id' =>$ID])->get()->first();

        if($Cat->parent_id == 0){
            $pCats = $this->where(['parent_id' =>  $ID])->get();
           foreach ($pCats as $item){
            $item->delete();}
        }
        return $Cat->delete();


    }

    public function saveEdited( $ID, $title_new)
    {
        $data = $this->getByID($ID);
        $data->title = $title_new;
        $data->save();
        return $data;
    }

    public function getListCategory(){
        return $this->where([ 'parent_id'=> 0])->orderBy('title', 'asc')->get();
    }

    public static function getListSection($id){
        return BookCategory::where([ 'parent_id'=> $id])->orderBy('title', 'asc')->get();
    }

    public function getBooksWithCats()
    {
        $cats = $this->getListCategory();

        $arr = [];
        foreach ($cats as $item){

            $ids = [];
            $cat2lvl = $this->where([ 'parent_id'=> $item->id ])->orderBy('title', 'asc')->get('id'); // [47,48]
            foreach ($cat2lvl as $b){
                $ids[] = $b->id;
            }

            $arr[$item->id] = $item;
            $arr[$item->id]['cats2lvl'] = $ids;
            $arr[$item->id]['books'] = Book::whereIn('book_category_id', $ids)->get();

        }

        return $arr;
    }



    public function getBooksByCats($id)
    {
        $cat = [];
        $cat = $this->getByID($id);

        $arr = [];

            $ids = [];
            $cat2lvl = $this->where([ 'parent_id'=> $cat->id ])->orderBy('title', 'asc')->get(); // [47,48]
            foreach ($cat2lvl as $b){
                $ids[] = $b->id;
            }

            $arr[0] = $cat;
            $arr[0]['cats2lvl'] = $cat2lvl;
            $arr[0]['books'] = Book::whereIn('book_category_id', $ids)->paginate(15);
            $ids = [];
            foreach ($arr[0]['books'] as $b){
                $ids[] = $b->id;
            }
//            $arr[0]['books']['authors'] = BookAuthorList::whereIn('book_id', $ids)->get();
            //$arr[0]['books']['authors'] = $ids;




        return $arr;
    }

    public function getListSubCats($id)
    {
        return $this->where(['parent_id' => $id])->get();
    }

}

<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class BookAuthorList extends Model
{
    protected $fillable = [
        'book_id',
        'author_id',
    ];

    public function author(){
       return $this->belongsTo('App\Model\BookAuthor', 'author_id');
    }
    public static function getlistAuthorsByBookID($id)
    {
        return BookAuthorList::where('book_id', $id)->get();
    }

}

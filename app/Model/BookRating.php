<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class BookRating extends Model
{
    protected $fillable =[
        'book_id',
        'user_id',
        'point',
    ];
    public function getListRateByBookID($id)
    {
        return $this->where('book_id', $id)->get();
    }

    public function rateBook($UserID,  $b_id, $point)
    {
        $sts = $this->where(['book_id'=>$b_id, 'user_id'=>$UserID])->exists();

        if ($sts){
            $br = $this->where(['book_id'=>$b_id, 'user_id'=>$UserID])->get()->first();
        }else{
            $br = new BookRating();
        }
        $br->book_id = $b_id;
        $br->user_id = $UserID;
        $br->point = $point;

        return $br->save();
    }
}

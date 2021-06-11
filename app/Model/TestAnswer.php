<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class TestAnswer extends Model
{
    //
    public function removeAns( $answerID)
    {
        $testAnswer = $this->where(['id' => $answerID])->get()->first();

         return $testAnswer->delete();
    }
}

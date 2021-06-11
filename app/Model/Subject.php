<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    public function getList(){
        return $this->orderBy('id', 'asc')->get();
    }
}

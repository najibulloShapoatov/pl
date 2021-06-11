<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = [
        'name'
    ];


    public function forum_permission(){
        return $this->belongsTo('App\Model\ForumPermissions', 'role_id');
    }


    public function getList()
    {
        return $this->whereNotIn('role', ['Admin'])->orderBy('role', 'asc')->get();
    }

}

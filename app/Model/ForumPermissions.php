<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ForumPermissions extends Model
{
    protected $fillable = [
        'role_id',
        'sts',
    ];

    public function getByRoleID($id){
        return $this->where('role_id', $id)->get()->first();
    }

    public  function getList(){
        return $this->get();
    }

    public function changePermission($id)
    {
        $res = $this->where('role_id', $id)->exists();

        if($res){
            $f_per = $this->getByRoleID($id);
            if($f_per->sts == 0) {
                $f_per->sts = 1;
            }else{
                $f_per->sts = 0;
            }
        }else{
            $f_per = new ForumPermissions();
            $f_per->role_id = $id;
            $f_per->sts = 1;
        }
        $f_per->save();

        return $f_per;

    }

    public function checkPermission($role_id)
    {
        $res = $this->where('role_id', $role_id)->exists();
        if($res){
            $fr =$this->getByRoleID($role_id);
            if($fr->sts == 1){
                return true;
            }
        }
        return false;

    }
}

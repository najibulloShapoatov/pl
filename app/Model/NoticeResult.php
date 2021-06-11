<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class NoticeResult extends Model
{
    protected $fillable =[
        'user_id',
        'notice_id',
        'status',
    ];

    public function getByUserID($userId){
        return $this->where('user_id', $userId)->get();
    }


    public function checkViewed($UserId, $NoticeId)
    {
        $rs = $this->where([
            'user_id'=>$UserId,
            'notice_id'=>$NoticeId
        ])->exists();

        if (!$rs){
            $noticeRes = new NoticeResult();
            $noticeRes->user_id = $UserId;
            $noticeRes->notice_id = $NoticeId;
            $noticeRes->status = 1;
            $noticeRes->save();
            return true;
        }
        else{
            return false;
        }
    }
    public function checkNotice($UserId, $NoticeId)
    {
        $rs = $this->where([
            'user_id'=>$UserId,
            'notice_id'=>$NoticeId
        ])->exists();

        if (!$rs){
           return 0;
        }
        else{
            return 1;
        }
    }
}

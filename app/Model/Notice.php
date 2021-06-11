<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\View;

class Notice extends Model
{
    protected $fillable = [
        'title',
        'who_can_see',
        'description',
    ];

    public function resluts(){
        return $this->hasMany('App\Model\NoticeResult');
    }

    public function role(){
        return $this->belongsTo('App\Model\Role', 'who_can_see');
    }

    public function getByID($id){
        return $this->where('id', $id)->get()->first();
    }
    public function getList(){
        return $this->orderBy('created_at', 'desc')->get();
    }
    public function getByRole($id){
        if($id == 1){
            return $this->getList();
        }
        return $this->where(['who_can_see' => $id ])
            ->orWhere(['who_can_see' => 0 ])
            ->orderBy('created_at', 'desc')->get();
    }

    public function deleteByID( $id)
    {
        $notice = $this->getByID($id);
        $notice->resluts()->delete();
        return $notice->delete();
    }

    public function createNotice(array $input)
    {
        $title = trim(htmlspecialchars($input['title']));
        $role = trim(htmlspecialchars($input['role']));
        $descr = trim(htmlspecialchars($input['descr']));

        $rs = $this->validateNotice($title, $descr);

        if ($rs['err'] != 0){ return $rs;}

        $notice = new Notice();

        $notice->title = $title;
        $notice->who_can_see = $role;
        $notice->description = $descr;
        $notice->save();

        $data = $notice;

        $html = View::make('admin.notice._notice', compact('data'))->render();
        return [
            'err'=> 0,
            'html' => $html,
            ];
    }




    public function updateNotice(array $input)
    {
        $id = trim(htmlspecialchars($input['id']));
        $title = trim(htmlspecialchars($input['title']));
        $role = trim(htmlspecialchars($input['role']));
        $descr = trim(htmlspecialchars($input['descr']));

        $rs = $this->validateNotice($title, $descr);

        if ($rs['err'] != 0){ return $rs;}

        $notice = $this->getByID($id);
        $notice->resluts()->delete();


        $notice->title = $title;
        $notice->who_can_see = $role;
        $notice->description = $descr;
        $notice->save();

        $data = $notice;

        $html = View::make('admin.notice._update', compact('data'))->render();
        return [
            'err'=> 0,
            'html' => $html,
            ];
    }

    private function validateNotice($title, $descr){
        $res = [
            'err'=>0
        ];
        if (empty($descr)){
            $res = [
                'err'=> 1,
                'msg'=> __('lang.text_not_empty')
            ];
        }
        if (empty($title) || strlen($title)> 255){
            $res = [
                'err'=> 1,
                'msg'=> __('lang.header_not_empty_and_not_255_sym')
            ];
        }
        return $res;

    }


    public function getByRoleADM($id)
    {
        return $this->where(['who_can_see' => $id ])->orderBy('created_at', 'desc')->get();

    }
}

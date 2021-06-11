<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CommunityCommentModerable extends Model
{

    protected $fillable =[
        'community_id',
        'sts'
    ];
    public function checkIsModerable($cid)
    {
        if($this->checkCommunity($cid)){
            return ($this->getByCommunityID($cid))->sts;
        }else{
            return 0;
        }
    }

    public function checkCommunity($id){
        return $this->where('community_id', $id)->exists();
    }


    public function getByCommunityID($id)
    {
        return $this->where('community_id', $id)->get()->first();
    }

    public function changeModerableCommunityById($id, $sts)
    {
        if($this->checkCommunity($id)){
            $cm = $this->getByCommunityID($id);
            $cm->sts = $sts;
            $cm->save();
        }else{
            $cm = new CommunityCommentModerable();
            $cm->community_id = $id;
            $cm->sts = $sts;
            $cm->save();
        }
        return true;
    }

    public function removeByCommID($id)
    {
        if($this->checkCommunity($id)) {
            $c = $this->getByCommunityID($id);
            $c->delete();
        }
    }


}

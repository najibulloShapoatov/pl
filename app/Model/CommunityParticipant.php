<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommunityParticipant extends Model
{
    public function user(){
        return $this->belongsTo('App\Model\User');
    }


    public function changeSubscribeCommunity(Request $request, $userID)
    {
        $input = $request->all();
        $communityID = trim(htmlspecialchars($input['id']));
        $isUserSubscribed = CommunityParticipant::where([ 'community_id' => $communityID, 'user_id' => $userID])->count();

        if( $isUserSubscribed == 0){
            $communityParticipant = new CommunityParticipant();
            $communityParticipant->community_id = $communityID;
            $communityParticipant->user_id = $userID;
            $result = $communityParticipant->save();
            return [
                'err' => 0,
                'sts' => 1
            ];
        }
        else{
            $communityPart = $this->where([ 'community_id' => $communityID, 'user_id' => $userID])->get()->first();
            $result = $communityPart->delete();
            return [
                'err' => 0,
                'sts' => 0
            ];
        }

    }
}

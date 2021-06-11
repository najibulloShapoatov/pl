<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Ticket extends Model
{
    protected $fillable = [
        'parent_id',
        'user_id',
        'title',
        'status'
    ];

    //get 10 tickets
    public function getTickets()
    {
        return $this->where(['parent_id' => 0, 'user_id' => Auth::user()->id])
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();
    }

    //lod more tickets
    public function loadMoreTicket($input)
    {


        $page = 0;
        if(isset($input['page'])){
            $page = (int)htmlspecialchars($input['page']);
        }

        $ticket= $this->where(['parent_id' => 0, 'user_id' => Auth::user()->id])
            ->orderBy('created_at', 'desc')
            ->skip(($page*10))
            ->take(10)
            ->get();
        foreach ($ticket as $item){
            (mb_strlen($item->title) > 100)?
                $item->title = mb_substr($item->title, 0, 100) . '...':
                $item->title = $item->title;
        }

        $data['tickets'] = $ticket;

        $data['ticket_qnt'] = count($data['tickets']);

        return $data;

    }

    //get ticket detail
    public function getTicketInfo($id)
    {
        return [
            'ticket' => $this->where(['parent_id' => 0, 'user_id' => Auth::user()->id, 'id' => $id])->get()->first(),
            'ticket_childs' => $this->where(['parent_id' => $id ])->orderBy('created_at', 'asc')->get()
        ];
    }

    //AddTicket Message
    public function addTicketMsg($userID, $ticket_id,  $content)
    {
        $ticket = new Ticket();
        $ticket->parent_id = $ticket_id;
        $ticket->user_id = $userID;
        $ticket->title = $content;
        $result = $ticket->save();
        if($result){
            return $ticket;
        }
    }

    //change status Ticket
    public function ticketClose($userID,  $ticket_id, $sts)
    {
        $ticket = $this->where(['parent_id' => 0, 'user_id' => Auth::user()->id, 'id' => $ticket_id])->get()->first();
        $ticket->status = $sts;
        $result = $ticket->save();
        if($result){
            return $result;
        }
    }

    //AddTicket
    public function addTicket($userID, $req_ticket,  $content)
    {
        $ticket = new Ticket();
        $ticket->parent_id = 0;
        $ticket->user_id = $userID;
        $ticket->title = $req_ticket;
        $result = $ticket->save();
        if($result){
            $ticket_cont = new Ticket();
            $ticket_cont->parent_id = $ticket->id;
            $ticket_cont->user_id = $userID;
            $ticket_cont->title = $content;
            $res = $ticket_cont->save();
            if($res){
                return $ticket;
            }

        }
    }
}

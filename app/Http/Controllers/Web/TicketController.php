<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Model\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;

class TicketController extends Controller
{
    public function index()
    {
        if(Auth::check()) {
            $ticket = new Ticket();
            $myTickets = $ticket->getTickets();

            //print_r($myTickets->toArray());
            foreach ($myTickets as $item){
                (mb_strlen($item->title) > 100)?
                    $item->title = mb_substr($item->title, 0, 100) . '...':
                    $item->title = $item->title;
            }

            return view('web.ticket.index', compact([
                'myTickets'
            ]));
        }
        return redirect('/');

    }

    public function loadMoreTicket(Request $request)
    {
        if ($request->ajax())
        {
            $input = $request->all();
            $news = new Ticket();
            $data = $news->loadMoreTicket($input);
            $html = View::make('web.ticket._load', compact('data'))->render();
            return Response::json(['html' => $html, 'info' => $data], 200);
        }
    }

    public function ticketInfo($id)
    {
        if(Auth::check()) {
            $ticket = new Ticket();
            $ticketData = $ticket->getTicketInfo($id);
            //print_r($ticketData['ticket_childs']->toArray());

            return view('web.ticket.single-ticket', compact([
                'ticketData'
            ]));

        }
        return redirect('/');
    }

    public function addTicketMsg(Request $request)
    {
        if ($request->ajax())
        {
            $input = $request->all();
            $content = trim(htmlspecialchars($input['content']));
            $ticket_id = trim(htmlspecialchars($input['t_id']));

            $todo = new Ticket();
            $ticket_msg = $todo->addTicketMsg(Auth::user()->id, $ticket_id, $content);
            return Response::json(['ticket_msg' => $ticket_msg], 200);
        }
    }

    public function addTicket(Request $request)
    {
        if ($request->ajax())
        {
            $input = $request->all();
            $content = trim(htmlspecialchars($input['content']));
            $req_ticket = trim(htmlspecialchars($input['ticket']));

            $todo = new Ticket();
            $ticket = $todo->addTicket(Auth::user()->id, $req_ticket, $content);
            return Response::json(['ticket' => $ticket], 200);
        }
    }

    public function ticketClose(Request $request)
    {
        if ($request->ajax())
        {
            $input = $request->all();
            $sts = trim(htmlspecialchars($input['sts']));
            $ticket_id = trim(htmlspecialchars($input['t_id']));

            $todo = new Ticket();
            $ticket = $todo->ticketClose(Auth::user()->id, $ticket_id, $sts);
            return Response::json(['sts' => $ticket], 200);
        }
    }
}

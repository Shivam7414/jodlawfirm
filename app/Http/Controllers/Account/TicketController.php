<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\Ticket;

class TicketController extends Controller
{
    public function index()
    {
        $tickets = Ticket::where('user_id', auth()->user()->id)->orderBy('updated_at', 'desc')->get();
        return view('account.ticket.index', compact('tickets'));
    }

    public function create()
    {
        return view('account.ticket.create');
    }

    public function store(Request $request)
    {
        do {
            $id = mt_rand(10000000, 99999999);
        } while (Ticket::find($id));

        $ticket = new Ticket;
        $ticket->id = $id;
        $ticket->user_id = auth()->user()->id;
        $ticket->subject = $request->subject;
        $ticket->status = 'open';
        $ticket->save();

        $message = new Message;
        $message->ticket_id = $id;
        $message->content = $request->content;
        $message->sender_type = 'user';
        $message->save();

        return redirect()->route('account.ticket.index')->with('success', 'Ticket created successfully.');
    }

    public function detail($id)
    {
        $ticket = Ticket::where('id', $id)->with('messages')->first();
        if (!$ticket) {
            return back()->with('error', 'Ticket not found.');
        }
        return view('account.ticket.detail', compact('ticket'));
    }

    public function sendMessage(Request $request)
    {
        $message = new Message;
        $message->ticket_id = $request->ticket_id;
        $message->content = $request->content;
        $message->sender_type = 'user';
        $message->save();

        return back()->with('success', 'Message sent successfully.');
    }
}

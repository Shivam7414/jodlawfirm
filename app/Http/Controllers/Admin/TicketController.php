<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\Ticket;
use App\Models\User;

class TicketController extends Controller
{
    public function index(Request $request)
    {
        $status = request('status');
        $searchQuery = request('search');
        $perPage = request('per_page', 10);

        $tickets = Ticket::orderBy('updated_at', 'desc')
        ->with('user')
        ->when($searchQuery, function ($query, $searchQuery) {
            return $this->applySearchFilters($query, $searchQuery);
        })
        ->when($status, function ($query, $status) {
            return $query->where('status', $status);
        })
        ->paginate($perPage);
        return view('admin.ticket.index', compact('tickets', 'request'));
    }

    private function applySearchFilters($query, $searchQuery) 
    {
        return $query->where('subject', 'LIKE', '%' . $searchQuery . '%')
            ->orWhere('id', $searchQuery)
            ->orWhereHas('user', function ($query) use ($searchQuery) {
                $query->where('full_name', 'LIKE', '%' . $searchQuery . '%')
                    ->orWhere('email', 'LIKE', '%' . $searchQuery . '%')
                    ->orWhere('phone_no', 'LIKE', '%' . $searchQuery . '%');
            });
    }

    public function create(Request $request)
    {
        $users = User::select('id', 'full_name', 'email')->get();
        $users = $users->map(function ($user) {
            return [
                'id' => $user->id,
                'email' => $user->email,
                'name' => $user->full_name,
                'nameorEmail' => $user->full_name . ' - ' . $user->email,
            ];
        })->toArray();
        return view('admin.ticket.create', compact('users'));
    }

    public function store(Request $request)
    {
        do {
            $id = mt_rand(10000000, 99999999);
        } while (Ticket::find($id));

        $ticket = new Ticket;
        $ticket->id = $id;
        $ticket->user_id = $request->user_id;
        $ticket->subject = $request->subject;
        $ticket->status = 'open';
        $ticket->save();

        $message = new Message;
        $message->ticket_id = $id;
        $message->content = $request->content;
        $message->sender_type = 'admin';
        $message->save();

        return redirect()->route('admin.ticket.index')->with('success', 'Ticket created successfully.');
    }

    public function detail($id)
    {
        $ticket = Ticket::where('id', $id)->with(['messages', 'user'])->first();
        if (!$ticket) {
            return back()->with('error', 'Ticket not found.');
        }
        return view('admin.ticket.detail', compact('ticket'));
    }

    public function sendMessage(Request $request)
    {
        $message = new Message;
        $message->ticket_id = $request->ticket_id;
        $message->content = $request->content;
        $message->sender_type = 'admin';
        $message->save();

        return back()->with('success', 'Message sent successfully.');
    }

    public function changeStatus(Request $request){
        $ticket = Ticket::find($request->ticket_id);
        if(!$ticket){
            return response()->json(['success' => false, 'message' => 'Ticket not found.']);
        }
        $ticket->status = $request->status;
        $ticket->save();

        return response()->json(['success' => true, 'message' => 'Ticket status updated successfully.']);
    }
}

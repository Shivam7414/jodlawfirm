@extends('account.layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between mb-4">
                    <h3>Tickets</h3>
                    <a href="{{ route('account.ticket.create') }}" class="btn btn-primary">Create New Ticket</a>
                </div>
                <div class="table-responsive">
                    <h5>Your ticket history</h5>
                    <table class="table">
                        <thead>
                            <th>Ticket Id</th>
                            <th>Subject</th>
                            <th>Status</th>
                            <th>Last updated</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                            @forelse($tickets as $ticket)
                                <tr class="text-sm font-weight-bold">
                                    <td >{{ $ticket->id }}</td>
                                    <td>
                                        <span class="text-dark">{{ $ticket->subject }}</span>
                                    </td>
                                    <td>{!! $ticket->status_badge !!}</td>
                                    <td>{{ $ticket->updated_at->diffForHumans() }}</td>
                                    <td>
                                        <a href="{{ route('account.ticket.detail', $ticket->id) }}" class="btn btn-primary btn-sm">View</a>
                                    </td>
                                </tr>
                            @empty
                                <tr class="text-center">
                                    <td colspan="5">No tickets found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
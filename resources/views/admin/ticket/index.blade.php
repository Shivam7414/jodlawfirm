@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <div class="row mb-4">
                    <h3 class="col-md-auto">Tickets</h3>
                    <div class="col-md-auto ms-auto">
                        <div class="row g-0">
                            <form action="{{ request()->fullUrl() }}" method="get" class="d-flex col-md-auto">
                                <input type="text" class="form-control rounded-end-0" placeholder="Search" name="search" value="{{ $request->search }}">
                                <button class="btn btn-primary mb-0 rounded-start-0">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                </button>
                            </form>
                            <div class="dropdown col-md-auto my-2 my-md-0 mx-md-2">
                                <button class="btn btn-info dropdown-toggle mb-0 w-100" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Select Status
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="{{ route('admin.ticket.index') }}">All</a></li>
                                    <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['status' => 'open']) }}">Open</a></li>
                                    <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['status' => 'closed']) }}">Closed</a></li>
                                    <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['status' => 'on_hold']) }}">On Hold</a></li>
                                    <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['status' => 'resolved']) }}">Resolved</a></li>
                                    <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['status' => 'in_progress']) }}">In progress</a></li>
                                    <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['status' => 'reopened']) }}">Re opened</a></li>
                                </ul>
                            </div>
                            <div class="col-md-auto">
                                <a href="{{ route('admin.ticket.create') }}" class="btn btn-primary mb-0 w-100">Create New Ticket</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <h5>Your ticket history</h5>
                    <table class="table align-items-center">
                        <thead>
                            <th>Ticket Id</th>
                            <th>User</th>
                            <th>Subject</th>
                            <th class="ps-3">Status</th>
                            <th>Last updated</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                            @forelse($tickets as $ticket)
                                <tr>
                                    <td>{{ $ticket->id }}</td>
                                    <td>
                                        <h6 class="mb-0">{{ $ticket->user->full_name }}</h6>
                                        <span class="text-sm font-weight-bold">{{ $ticket->user->email }}</span>
                                    </td>
                                    <td>
                                        <span class="text-sm font-weight-bold">{{ $ticket->subject }}</span>
                                    </td>
                                    <td>{!! $ticket->status_badge !!}</td>
                                    <td>
                                        <span class="text-sm font-weight-bold">{{ $ticket->updated_at->diffForHumans() }}</span>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.ticket.detail', $ticket->id) }}" class="btn btn-primary btn-sm mb-0">View</a>
                                    </td>
                                </tr>
                            @empty
                                <tr class="text-center">
                                    <td colspan="5">No tickets found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{ $tickets->links('common.custom') }}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    
@endpush
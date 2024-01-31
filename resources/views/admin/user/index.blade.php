@extends('admin.layouts.app')

@section('content')
    @section('breadcrumb')
        <li class="breadcrumb-item text-sm"><a class="opacity-5 text-white" href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item text-sm text-white active">Users</li>
    @endsection
    <div class="mt-4 mx-4">
        <div class="card mb-4">
            <div class="card-header d-flex align-items-center justify-content-between pb-0">
                <h3>Registered Users</h3>
                <a href="{{ url('admin/user/add') }}" class="btn btn-primary">Add</a>
            </div>
            <div class="card-body">
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">S.No.</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Name or Email</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Phone No</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"> Create Date</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $user)
                                <tr>
                                    <td class="px-4">{{ $loop->iteration }}</td>
                                    <td>
                                        <div class="d-flex px-3 py-1">
                                            <div>
                                                <img src="{{  asset($user->profile) }}" class="avatar me-3" alt="image">
                                            </div>
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0">{{ $user->full_name }}</h6>
                                                <span class="text-sm">{{ $user->email }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-sm font-weight-bold mb-0">{{ $user->phone_no }}</p>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <p class="text-sm font-weight-bold mb-0">{{ $user->created_at->format('d/m/Y') }}</p>
                                    </td>
                                    <td class="align-middle text-end">
                                        <div class="d-flex px-3 py-1 justify-content-center align-items-center">
                                            <a href="{{ url('admin/user/edit/'.$user->id) }}" class="btn btn-primary">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                            <button type="button" href="" class="btn btn-danger mx-2">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                            <button type="button" class="btn btn-info">
                                                <i class="fa-solid fa-circle-info"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">No users registered.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                {{ $users->links('common.custom') }}
            </div>
        </div>
    </div>
@endsection
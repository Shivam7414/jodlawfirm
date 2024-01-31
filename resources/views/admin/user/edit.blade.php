@extends('admin.layouts.app')

@section('content')
    @section('breadcrumb')
        <li class="breadcrumb-item text-sm"><a class="opacity-5 text-white" href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item text-sm"><a class="opacity-5 text-white" href="{{ route('admin.user.index') }}">Users</a></li>
        <li class="breadcrumb-item text-sm text-white active">{{ $user->id ? 'Edit' :'Add' }}</li>
    @endsection
    <div class="mt-4 mx-4">
        <div class="card mb-4">
            <div class="card-header">
                <h3>User {{ $user->id ? 'Edit' :'Add' }}</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <form action="{{ route('admin.user.store') }}" method="POST">
                        @csrf
                        <div class="col-md-7 mx-auto">
                            <input type="hidden" id="{{ $user->id }}">
                            <div class="mb-3">
                                <label>Full Name</label>
                                <input type="text" name="full_name" class="form-control" value="{{ $user->full_name }}" required>
                            </div>
                            <div class="mb-3">
                                <label>Email</label>
                                <input type="text" name="email" class="form-control" value="{{ $user->email }}" required>
                            </div>
                            <div class="mb-3">
                                <label>Password</label>
                                <input type="text" name="password" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label>Phone No.</label>
                                <input type="text" name="phone_no" class="form-control" value="{{ $user->phone_no }}" required>
                            </div>
                            <div class="mb-3">
                                <label>Address</label>
                                <input type="text" name="address" class="form-control" value="{{ $user->address }}">
                            </div>
                            <div class="mb-3">
                                <label>city</label>
                                <input type="text" name="city" class="form-control" value="{{ $user->city }}">
                            </div>
                            <div class="mb-3">
                                <label>Postal Code</label>
                                <input type="text" name="postal_code" class="form-control" value="{{ $user->postal_code }}">
                            </div>
                            <div class="mt-4 d-flex justify-content-between">
                                <a href="{{ url('admin/user/index') }}" class="btn btn-danger">Cancel</a>
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
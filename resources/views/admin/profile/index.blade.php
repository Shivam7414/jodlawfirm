@extends('admin.layouts.app')

@section('content')
    @section('breadcrumb')
        <li class="breadcrumb-item text-sm"><a class="opacity-5 text-white" href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item text-sm text-white active">Profile settings</li>
    @endsection

    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3>Update Profile</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.profile.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control" placeholder="Enter your name" value="{{ auth()->guard('admin')->user()->name }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" placeholder="Enter your email" value="{{ auth()->guard('admin')->user()->email }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Password (If you want to change)</label>
                            <input type="password" name="password" class="form-control" placeholder="Enter your password">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Confirm Password</label>
                            <input type="password" name="password_confirmation" class="form-control" placeholder="Enter your password again">
                        </div>
                        <div class="col mt-4 text-end">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function(){
            $("form").on("submit", function(event){
                let password = $("input[name='password']").val();
                let confirmPassword = $("input[name='password_confirmation']").val();

                if(password && !confirmPassword) {
                    showToast("error", "Please enter confirm password.");
                    event.preventDefault();
                }
                if(!password && confirmPassword) {
                    showToast("error", "Please enter your password.");
                    event.preventDefault();
                }

                if(password && confirmPassword) {
                    event.preventDefault();
                    if(password !== confirmPassword) {
                        showToast("error", "Passwords do not match.");
                        event.preventDefault();
                    }
                    if(password.length < 8) {
                        showToast("error", "Password must be at least 8 characters long.");
                        event.preventDefault();
                    }
                }
            });
        });
    </script>
@endpush
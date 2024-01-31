@extends('frontend.layouts.app')

@section('content')
    <div class="row align-items-center g-0">
        <div class="col-md-7">
            <img src="{{ asset('img/illustrations/login.jpg') }}" class="w-100">
        </div>
        <div class="col-md-5 mx-auto">
            <div class="p-md-5 mx-md-5">
                <h2 class="mb-5" style="color: #525252;">Login to your Account</h2>
                <form action="{{ url('/login') }}" method="POST">
                    @csrf
                    <input type="hidden" name="redirect_after_login" value="{{ $request->redirect_after_login }}">
                    <div class="mb-4">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="Enter your email" required>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Password</label>
                        <input type="password" class="form-control" placeholder="Enter your password" name="password" required>
                    </div>
                    <div class="d-flex justify-content-between">
                        <div class="form-check ps-0">
                            <input type="checkbox" name="remember_me" id="remember-me" class="form-check-input">
                            <label for="remember-me" class="form-check-label ms-2 mb-1">Remember Me</label>
                        </div>
                        <a href="{{ route('reset-password') }}" class="text-primary">Forgot Password?</a>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 mt-4">Login</button>
                    <div class="mt-5 text-center">
                        <span>Not Registered Yet?&nbsp;&nbsp;
                            @if($request->redirect_after_login)
                                <a href="{{ route('register', ['redirect_after_login' => $request->redirect_after_login]) }}" class="text-primary">Create an account</a>    
                            @else
                                <a href="{{ route('register') }}" class="text-primary">Create an account</a>
                            @endif
                        </span>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
    </script>
@endpush
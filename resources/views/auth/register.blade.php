@extends('frontend.layouts.app')

@section('content')
<div class="row g-0">
    <div class="col-md-7">
        <img src="{{ asset('img/illustrations/login.jpg') }}" class="w-100">
    </div>
    <div class="col-md-5 mx-auto">
        <div class="p-md-5 pb-5 mx-2">
            <h2 class="mb-5" style="color: #525252;">Create an Account</h2>
            <form action="{{ route('register.perform') }}" method="POST">
                @csrf
                <input type="hidden" name="redirect_after_login" value="{{ $request->redirect_after_login }}">
                <div class="mb-3">
                    <label class="form-label">Name</label>
                    <input type="text" class="form-control @error('full_name') is-invalid @enderror" name="full_name" value="{{ old('full_name') }}" placeholder="Enter your email" required>
                    @error('full_name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="Enter your email" required>
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Phone no</label>
                    <input type="text" class="form-control phone @error('phone_no') is-invalid @enderror" name="phone_no" value="{{ old('phone_no') }}" minlength="10" placeholder="Enter your email" required>
                    @error('phone_no')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="mb-5">
                    <label class="form-label">Password</label>
                    <input type="password" class="form-control" placeholder="Enter your password" name="password" required>
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary w-100">Register</button>
                <div class="mt-5 text-center">
                    <span>Already an member?&nbsp;
                        @if($request->redirect_after_login)
                           <a href="{{ route('login', ['redirect_after_login' => $request->redirect_after_login]) }}">Log in</a>
                        @else
                            <a href="{{ route('login') }}">Log in</a>
                        @endif
                    </span>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.3.4/jquery.inputmask.bundle.min.js"></script>
<script>
    $(document).ready(function() {
        $(".phone").inputmask({
            mask: '9999999999',
            placeholder: '',
        });
    });
</script>
@endpush

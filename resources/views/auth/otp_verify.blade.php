@extends('frontend.layouts.app')
<style>
    .otp-form {
        background-color: #ffffff;
        border-radius: 8px;
        padding: 20px;
        box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
        text-align: center;
        max-width: 400px;
        width: 100%;
    }

    h2 {
        margin-bottom: 20px;
        color: #333;
    }

    /* OTP input styles */
    .otp-container,
    .email-otp-container {
        display: flex;
        justify-content: center;
        margin-top: 20px;
    }

    .otp-input,
    .email-otp-input {
        width: 40px;
        height: 40px;
        text-align: center;
        font-size: 18px;
        margin: 0 5px;
        border: 1px solid #ccc;
        border-radius: 4px;
        outline: none;
        transition: border-color 0.3s;
    }

    .otp-input:focus,
    .email-otp-input:focus {
        border-color: #007bff;
    }

    #verificationCode,
    #emailverificationCode {
        width: 100%;
        margin-top: 15px;
        padding: 10px;
        font-size: 14px;
        border: 1px solid #ccc;
        border-radius: 4px;
        outline: none;
        transition: border-color 0.3s;
    }

    #verificationCode:focus,
    #emailverificationCode:focus {
        border-color: #007bff;
    }

    .email-otp {
        margin-top: 25px;
    }
</style>
@section('content')
    <div class="row g-0">
        <div class="col-md-7">
            <img src="{{ asset('img/illustrations/login.jpg') }}" class="w-100">
        </div>
        <div class="col-md-5 mx-auto">
            <form action="{{ route('otp.verify.perform') }}" class="text-center" id="otp_form" method="POST">
                @csrf
                <input type="hidden" name="redirect_after_login" value="{{ $request->redirect_after_login }}">
                <h2>Enter your Verification code</h2>
                <img src="{{ asset('img/icons/one-time-password.png') }}" height="100px" class="my-5">
                {{-- <div class="mb-5">
                    <p>OTP has been sent your mobile number <span class="fw-bold">+91{{ Session::get('user_information.phone_no') }}</span>.</p>
                    @if(Session::get('otp.phone_otp_verified'))
                        <div class="d-flex flex-column justify-content-center align-items-center">
                            <input type="text" name="phone_otp" class="form-control text-center w-50 otp is-valid" value="{{ Session::get('otp.phone_otp') }}" disabled>
                            <div class="valid-feedback">
                                phone OTP verified
                            </div>
                        </div>
                    @else
                        <div class="d-flex justify-content-center">
                            <input type="text" name="phone_otp" class="form-control text-center w-50 otp"  placeholder="6-digit OTP code">
                            <button type="button" class="btn btn-primary px-3 ms-4" id="phone_otp_btn" onclick="otpVerify(this, 'phone')" disabled>Verify</button>
                        </div>
                        <p class="mt-2">Didn't receive the code? <a href="#" class="text-decoration-none">Resend</a></p>
                    @endif
                </div> --}}
                <div class="mb-5">
                    <p>OTP has been sent your email address <span class="fw-bold">{{ Session::get('user_information.email') }}</span>.</p>
                    @if (Session::get('otp.email_otp_verified'))
                        <div class="d-flex flex-column justify-content-center align-items-center">
                            <input type="text" name="email_otp" class="form-control text-center w-50 otp is-valid" value="{{ Session::get('otp.email_otp') }}" disabled>
                            <div class="valid-feedback">
                                email OTP verified
                            </div>
                        </div>
                    @else
                        <div class="d-flex justify-content-center">
                            <input type="text" name="email_otp" class="form-control text-center w-50 otp" placeholder="6-digit OTP code">
                            <button type="button" class="btn btn-primary px-3 ms-4" id="email_otp_btn" onclick="otpVerify(this, 'email')" disabled>Verify</button>
                        </div>
                        <p class="mt-2">Didn't receive the code? <a href="#" class="text-decoration-none">Resend</a></p>
                    @endif
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.3.4/jquery.inputmask.bundle.min.js"></script>
    <script>
        let otp = '';
        let is_email_otp_verified = false;

        @if (Session::get('otp.email_otp_verified'))
            is_email_otp_verified = true;
        @endif

        $(document).ready(function() {
            if (is_email_otp_verified) {
                $('#otp_form').submit();
            }

            $(".otp").inputmask({
                mask: '999999',
                placeholder: '',
            });
            
            $('input[name="email_otp"]').on('keyup', function() {
                if ($(this).val().length == 6) {
                    $('#email_otp_btn').prop('disabled', false);
                } else {
                    $('#email_otp_btn').prop('disabled', true);
                }
            });
        });

        function otpVerify (element, type) {
            $(element).html('Verifying...').prop('disabled', true);

            otp = $('input[name="email_otp"]').val();
            
            $.ajax({
                url: "{{ route('otp.validate') }}",
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                data: {
                    otp: otp,
                    otp_type: type,
                },
                success: function(response) {
                    if (response.success == true) {
                        showToast('success', response.message);
                        $(element).html('Verified').removeClass('btn-primary').addClass('btn-success').prop('disabled', true);
                     
                        $('input[name="email_otp"]').addClass('is-valid').prop('disabled', true);
                        is_email_otp_verified = true;
                    } else {
                        showToast('error', response.message);
                        $(element).html('Verify').prop('disabled', false);
                    }

                    if (is_email_otp_verified) {
                        $('#otp_form').submit();
                    }
                },
                error: function(error) {
                    showToast('error', error.responseJSON.message);
                    $(element).html('Verify').prop('disabled', false);
                }
            });
        };
    </script>
@endpush

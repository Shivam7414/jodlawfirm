@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid py-4">
        <div class="card">
            <div class="card-header">
                <h3>Api credentials</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.api_credential.store') }}" method="POST">
                    <div class="row">
                        @csrf
                        <div class="col-sm-12 mb-4">
                            <div>
                                <div class="d-flex justify-content-between">
                                    <h4>Razorpay Api Credential</h4>
                                    <div class="form-check form-switch ms-4">
                                        <input class="form-check-input" type="checkbox" role="switch" name="payment_mode_status" value="" id="payment_mode_status" {{ $paymentModeStatus->get('payment_mode_status') == 'live' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="payment_mode_status">{{ ucfirst($paymentModeStatus->get('payment_mode_status')) ?? 'Test'}} Mode</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Test Razorpay Key Id</label>
                            <input type="text" name="test_razorpay_key_id" class="form-control" value="{{ $apiCredentials->get('test_razorpay_key_id') }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Test Razorpay Key Secret</label>
                            <input type="text" name="test_razorpay_key_secret" class="form-control" value="{{ $apiCredentials->get('test_razorpay_key_secret') }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Live Razorpay Key Id</label>
                            <input type="text" name="live_razorpay_key_id" class="form-control" value="{{ $apiCredentials->get('live_razorpay_key_id') }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Live Razorpay Key Secret</label>
                            <input type="text" name="live_razorpay_key_secret" class="form-control" value="{{ $apiCredentials->get('live_razorpay_key_secret') }}" required>
                        </div>
                        <div class="col-md-12 my-4">
                            <h4>Brevo Email Api Credential</h4>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Mail From Name</label>
                            <input type="text" name="mail_from_name" class="form-control" value="{{ $apiCredentials->get('mail_from_name') }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Mail From Email Address</label>
                            <input type="text" name="mail_from_email_address" class="form-control" value="{{ $apiCredentials->get('mail_from_email_address') }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Login Email</label>
                            <input type="text" name="brevo_email_login" class="form-control" value="{{ $apiCredentials->get('brevo_email_login') }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>SMTP Password</label>
                            <input type="text" name="brevo_smtp_password" class="form-control" value="{{ $apiCredentials->get('brevo_smtp_password') }}">
                        </div>
                    </div>
                    <div class="text-end mt-4">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(function() {
            $('#payment_mode_status').on('change', function() {
                if ($(this).is(':checked')) {
                    $(this).val('live');
                } else {
                    $(this).val('test');
                }

                let status = $(this).val();
                $.ajax({
                    url: "{{ route('admin.api_credential.update_payment_mode_status') }}",
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    data: {
                        status: status
                    },
                    success: function(response) {
                        if (response.success == true) {
                            showToast('success', response.message);
                            $('#payment_mode_status').next('label').html(`${status} Mode`);
                        } else {
                            showToast('error', response.message);
                        }
                    }
                });
            });
        });
    </script>
@endpush
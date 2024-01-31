@extends('account.layouts.app')

@section('content')
<style>
    .top-left-badge {
        position: absolute;
        top: 0;
        left: 100%;
        transform: translate(-85%, -30%) !important;
        background-color: #1083EE;
        color: white !important;
        font-weight: 600;
        padding: 0.5rem;
        border-radius: 0.375rem;
    }
</style>
    @section('breadcrumb')
        <li class="breadcrumb-item text-sm">
            <a class="opacity-5 text-white" href="{{ route('account.application.index') }}">Applications</a>
        </li>
        <li class="breadcrumb-item text-sm text-white active">Apply</li>
    @endsection
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3>Applications</h3>
            </div>
            <div class="card-body">
                <div class="tab-content mt-3" style="min-height: 200px">
                    <div class="row">
                        <div class="col-md-7 box-shadow-1 mx-auto p-4 rounded-4">
                            <div class="d-flex payment-container">
                                <div class="w-50 me-3 p-3 border border-primary border-3 rounded-2 text-center position-relative pointer" onclick="togglePrice(this, 'price1')">
                                    <h5 class="text-primary my-3">{{ $applicationSetting->price1_name }}</h5>
                                    <h2 class="text-primary mb-3">₹{{ $applicationSetting->discounted_price1_amount }}</h2>
                                    <span class="top-left-badge">
                                        -{{ calculatePercentageDifference($applicationSetting->actual_price1_amount, $applicationSetting->discounted_price1_amount) }}%
                                    </span>
                                </div>
                                <div class="w-50 p-3 border border-secondary border-3 rounded-2 text-center position-relative pointer" onclick="togglePrice(this, 'price2')">
                                    <h5 class="my-3">{{ $applicationSetting->price2_name }}</h5>
                                    <h2 class="mb-3">₹{{ $applicationSetting->discounted_price2_amount }}</h2>
                                    <span class="top-left-badge d-none">
                                        -{{ calculatePercentageDifference($applicationSetting->actual_price2_amount, $applicationSetting->discounted_price2_amount) }}%
                                    </span>
                                </div>
                            </div>
                            <div class="my-3 mx-2">
                                <div class="d-flex justify-content-between">
                                    <h5>Market Price</h5>
                                    <h5 class="fw-600">
                                        <span class="price1">Rs{{ $applicationSetting->actual_price1_amount }}</span>
                                        <span class="price2 d-none">Rs{{ $applicationSetting->actual_price2_amount }}</span>
                                    </h5>
                                </div>
                                <div class="d-flex justify-content-between my-2">
                                    <h5>Our Price</h5>
                                    <h5 class="fw-600">
                                        <span class="price1">Rs{{ $applicationSetting->discounted_price1_amount }}</span>
                                        <span class="price2 d-none">Rs{{ $applicationSetting->discounted_price2_amount }}</span>
                                    </h5>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <h5>You Save</h5>
                                    <h5 class="fw-600 text-success">
                                        <span class="price1">Rs{{ $applicationSetting->actual_price1_amount - $applicationSetting->discounted_price1_amount }}</span>
                                        <span class="price2 d-none">Rs{{ $applicationSetting->actual_price2_amount - $applicationSetting->discounted_price2_amount }}</span>
                                    </h5>
                                </div>
                            </div>
                            <div>
                                <button class="btn btn-primary btn-lg w-100 d-flex align-items-center justify-content-center" id="pay">
                                    <div class="spinner-border text-light" role="status" style="display: none;">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                    <span class="ms-3 fs-5">Pay Now</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        let price = '';
        let orderId = '';
        let orderPrice = '';

        $(document).ready(function() {
            togglePrice($('.payment-container .w-50:first'), 'price1');
        });

        function togglePrice(element, type){
            $('.top-left-badge').addClass('d-none');
            $('h2, h5').removeClass('text-primary');
            $('.border-primary').removeClass('border-primary').addClass('border-secondary');

            $(element).find('.top-left-badge').removeClass('d-none');
            $(element).find('h2, h5').addClass('text-primary');
            $(element).removeClass('border-secondary').addClass('border-primary');

            if(type == 'price1'){
                $(element).parent().parent().parent().find('.price1').removeClass('d-none');
                $(element).parent().parent().parent().find('.price2').addClass('d-none');
                price = '1';
            }else{
                $(element).parent().parent().parent().find('.price2').removeClass('d-none');
                $(element).parent().parent().parent().find('.price1').addClass('d-none');
                price = '2';
            }
        }
    </script>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script>
        var options = {
            "key": "{{ config('services.razorpay.key') }}",
            "amount": orderPrice,
            "currency": "INR",
            "name": "{{ config('app.name', 'Laravel') }}",
            "description": "Trademark Register Transaction",
            "image": "{{ asset('img/logos/favicon.png') }}",
            "order_id": orderId,
            "callback_url": "{{ url('account/application/payment/callback') }}",
            "prefill": {
                "name": "{{ auth()->user()->full_name  }}",
                "email": "{{ auth()->user()->email }}",
                "contact": "{{ auth()->user()->phone_no }}"
            },
            "theme": {
                "color": "#1083EE"
            },
            "modal": {
                "ondismiss": function (){
                    console.log('Payment modal was closed');
                }
            }
        };
        var rzp1 = new Razorpay(options);
        document.getElementById('pay').onclick = function(e){
            e.preventDefault();
            $('#pay').attr('disabled', true);
            $('#pay').find('.spinner-border').show();
            $.ajax({
                type: "post",
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                url: "{{ url('account/application/get_order_id') }}",
                data: {
                    type : '{{ $request->type }}',
                    price: price,
                },
                success: function (response) {
                    $('#pay').attr('disabled', false);
                    $('#pay').find('.spinner-border').hide();
                    options.order_id = response;
                    options.amount = orderPrice;
                    var rzp1 = new Razorpay(options);
                    rzp1.open();
                },
                error: function (error) {
                    showToast('error', error);
                }
            });
        }
    </script>
@endpush
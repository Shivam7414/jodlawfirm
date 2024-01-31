@extends('frontend.layouts.app')

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
    <div class="row">
        <div class="col-md-5 box-shadow-1 mx-auto p-4 rounded-4">
            <h3 class="mb-4">Trademark Register</h3>
            <div class="d-flex payment-container">
                <div class="w-50 me-3 p-3 border border-primary border-3 rounded-2 text-center position-relative pointer" onclick="togglePrice(this, 'price1')">
                    <h5 class="text-primary my-3">{{ $ApplicationSetting->price1_name }}</h5>
                    <h2 class="text-primary mb-3">₹{{ $ApplicationSetting->discounted_price1_amount }}</h2>
                    <span class="top-left-badge">
                        -{{ calculatePercentageDifference($ApplicationSetting->actual_price1_amount, $ApplicationSetting->discounted_price1_amount) }}%
                    </span>
                </div>
                <div class="w-50 p-3 border border-secondary border-3 rounded-2 text-center position-relative pointer" onclick="togglePrice(this, 'price2')">
                    <h5 class="my-3">{{ $ApplicationSetting->price2_name }}</h5>
                    <h2 class="mb-3">₹{{ $ApplicationSetting->discounted_price2_amount }}</h2>
                    <span class="top-left-badge d-none">
                        -{{ calculatePercentageDifference($ApplicationSetting->actual_price2_amount, $ApplicationSetting->discounted_price2_amount) }}%
                    </span>
                </div>
            </div>
            <div class="my-3 mx-2">
                <div class="d-flex justify-content-between">
                    <h5>Market Price</h5>
                    <h5 class="fw-600" id="market_price"></h5>
                </div>
                <div class="d-flex justify-content-between my-2">
                    <h5>Our Price</h5>
                    <h5 class="fw-600" id="our_price"></h5>
                </div>
                <div class="d-flex justify-content-between">
                    <h5>You Save</h5>
                    <h5 class="fw-600" id="saved_price"></h5>
                </div>
            </div>
            <div>
                <button class="btn btn-primary btn-lg w-100" id="pay">Pay Now</button>
            </div>
        </div>
    </div>
@endsection

@php
    $userInfo = Session::get('userInfo');
@endphp

@push('scripts')
<script>
    let orderId = '';
    let orderPrice = '';
    let price = '';
    function togglePrice(element, type){
        $('.top-left-badge').addClass('d-none');
        $('h2, h5').removeClass('text-primary');
        $('.border-primary').removeClass('border-primary').addClass('border-secondary');

        $(element).find('.top-left-badge').removeClass('d-none');
        $(element).find('h2, h5').addClass('text-primary');
        $(element).removeClass('border-secondary').addClass('border-primary');

        if(type == 'price1'){
            $('#market_price').text(`₹${'{{ number_format($ApplicationSetting->actual_price1_amount) }}'}`);
            $('#our_price').text(`₹${'{{ number_format($ApplicationSetting->discounted_price1_amount) }}'}`);
            $('#saved_price').text(`₹${'{{ number_format($ApplicationSetting->actual_price1_amount - $ApplicationSetting->discounted_price1_amount) }}'}`);
            orderPrice = parseInt('{{ $ApplicationSetting->discounted_price1_amount }}') * 100;
            price = '1';
        }else{
            $('#market_price').text(`₹${'{{ number_format($ApplicationSetting->actual_price2_amount) }}'}`);
            $('#our_price').text(`₹${'{{ number_format($ApplicationSetting->discounted_price2_amount) }}'}`);
            $('#saved_price').text(`₹${'{{ number_format($ApplicationSetting->actual_price2_amount - $ApplicationSetting->discounted_price2_amount) }}'}`);
            orderPrice = parseInt('{{ $ApplicationSetting->discounted_price2_amount }}') * 100;
            price = '2';
        }
    }
    $(document).ready(function() {
        togglePrice($('.payment-container .w-50:first'), 'price1');
    });
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
        "callback_url": "{{ url('trademark/payment/callback') }}",
        "prefill": {
            "name": "{{ $userInfo['full_name'] }}",
            "email": "{{ $userInfo['email'] }}",
            "contact": "{{ $userInfo['phone_no'] }}"
        },
        "notes": {
            "address": "Razorpay Corporate Office"
        },
        "theme": {
            "color": "#1083EE"
        }
    };
    document.getElementById('pay').onclick = function(e){
        e.preventDefault();
        $.ajax({
            type: "get",
            url: "{{ url('trademark/get_order_id') }}",
            data: {
                type : '{{ $request->type }}',
                price: price,
            },
            success: function (response) {
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
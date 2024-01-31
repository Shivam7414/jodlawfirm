@extends('frontend.layouts.app')

@section('content')
    <style>
        .youtube-video-frame{
            width: 100%;
            height: 300px;
            border-radius: 8px;
            box-shadow: rgba(17, 17, 26, 0.05) 0px 4px 16px, rgba(17, 17, 26, 0.05) 0px 8px 32px;
        }
    </style>
    <div class="px-md-4 p-0">
        <div class="row">
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-10 ps-md-4">
                        <h2 class="fs-1 brand-text-color fw-700 mt-5 mb-4">Trademark {{ ucfirst($request->type) }}</h2>
                        <div class="row" id="price-toggle">
                            <div class="col-md-6 pointer">
                                <div class="border border-2 rounded-3 p-3 h-100"
                                    onclick="togglePrice(this, '{{ $ApplicationSetting->price1_name }}')">
                                    <h5>{{ $ApplicationSetting->price1_name }}</h5>
                                    <p class="m-0 text-muted fs-7">{{ $ApplicationSetting->price1_content }}</p>
                                </div>
                            </div>
                            <div class="col-md-6 mt-md-0 mt-3 pointer">
                                <div class="border border-2 rounded-3 p-3 h-100"
                                    onclick="togglePrice(this, '{{ $ApplicationSetting->price2_name }}')">
                                    <h5>{{ $ApplicationSetting->price2_name }}</h5>
                                    <p class="m-0 text-muted fs-7">{{ $ApplicationSetting->price2_content }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="mt-5">
                            <h4 class="my-4 brand-text-color fw-700">Documents Required</h4>
                            <div class="row">
                                @if ($ApplicationSetting->required_documents)
                                    @foreach ($ApplicationSetting->required_documents as $required_document)
                                        <div class="col-md-6 mb-4">
                                            <div class="row align-items-center">
                                                <div class="col-lg-2 col-sm-1 col-2">
                                                    <img src="{{ asset('img/icons/document.png') }}" alt="document" width="35px">
                                                </div>
                                                <div class="col-lg-10 col-sm-11 col-10">
                                                    <span class="text-dark fw-600">{{ ucfirst($required_document) }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="px-4 py-4 mt-md-5 mt-0 rounded-3 tailwind-shadow" style="background: #fafafe;">
                    <div class="text-center">
                        <p class="fw-600 fs-5 brand-text-color" id="trademark_text">Trademark {{ ucfirst($request->type) }} ()</p>
                        <div class="mb-3">
                            <h2 id="discounted_price" class="brand-text-color fs-1 fw-700 mb-0"></h2>
                            <span class="text-decoration-line-through fw-400 fs-5" id="actual_price"></span>
                            <span class="text-success fw-700 fs-5" id="discount_percentage"></span>
                        </div>
                        @auth
                            <button class="btn btn-primary btn-lg w-100 d-flex align-items-center justify-content-center" id="pay">
                                <div class="spinner-border text-light" role="status" style="display: none;">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                                <span class="ms-3 fs-5 text-white">Buy Now</span>
                            </button>
                        @else
                            <a href="{{ route('login', ['redirect_after_login' => 'trademark_'.$request->type]) }}" class="btn btn-primary w-100 btn-lg">Buy Now</a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
        <div class="row my-5">
            <div class="col-md-12">
                <div class="justified-text">
                    {!! $ApplicationSetting->content !!}
                </div>
            </div>
        </div>
        @if($ApplicationSetting && $ApplicationSetting->youtube_videos)
            <div class="row mb-5">
                @foreach($ApplicationSetting->youtube_videos as $videoUrl)
                    <div class="col-md-4 mb-3">
                        <iframe class="youtube-video-frame" src="{{ $videoUrl }}" frameborder="0" allowfullscreen></iframe>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
@push('scripts')
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.3.4/jquery.inputmask.bundle.min.js"></script>
    <script>
        let price = '';
        let orderPrice = '';
        let actualPrice1Amount = parseFloat('{{ $ApplicationSetting->actual_price1_amount }}');
        let actualPrice2Amount = parseFloat('{{ $ApplicationSetting->actual_price2_amount }}');
        let discountedPrice1Amount = parseFloat('{{ $ApplicationSetting->discounted_price1_amount }}');
        let discountedPrice2Amount = parseFloat('{{ $ApplicationSetting->discounted_price2_amount }}');

        String.prototype.capitalize = function() {
            return this.charAt(0).toUpperCase() + this.slice(1);
        }
        function togglePrice(element, type) {
            $("#price-toggle .border-primary").removeClass("border-primary");
            $(element).addClass('border-primary');

            if (type == '{{ $ApplicationSetting->price1_name }}') {
                price = '1';
                $('#actual_price').text(`₹${actualPrice1Amount}`);
                $('#discounted_price').text(`₹${discountedPrice1Amount}`);
                orderPrice = parseFloat('{{ $ApplicationSetting->discounted_price1_amount }}') * 100;
                $('#discount_percentage').text(`(${calculatePercentageDifference(actualPrice1Amount, discountedPrice1Amount)}%)`);
                $('#trademark_text').text(`Trademark ${'{{ $request->type }}'.capitalize()} ({{ $ApplicationSetting->price1_name }})`);
            } else {
                price = '2';
                $('#actual_price').text(`₹${actualPrice2Amount}`);
                $('#discounted_price').text(`₹${discountedPrice2Amount}`);
                orderPrice = parseFloat('{{ $ApplicationSetting->discounted_price2_amount }}') * 100;
                $('#discount_percentage').text(`(${calculatePercentageDifference(actualPrice2Amount, discountedPrice2Amount)}%)`);
                $('#trademark_text').text(`Trademark ${'{{ $request->type }}'.capitalize()} ({{ $ApplicationSetting->price2_name }})`);
            }
        }

        function calculatePercentageDifference(value1, value2) {
            if (value1 == 0) {
                return value1 == 0 ? 0 : 100;
            }

            let percentageDifference = ((value1 - value2) / value1) * 100;
            percentageDifference = percentageDifference.toFixed(2);

            return parseFloat(percentageDifference);
        }
        $(document).ready(function() {
            $('#price-toggle .col-md-6  div:first').trigger('click');
            $('[name="phone_no"]').inputmask({
                mask: '9999999999',
                placeholder: "",
            });
        });
    </script>
    @auth
        <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
        <script>
            let orderId = '';
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
    @endauth
@endpush
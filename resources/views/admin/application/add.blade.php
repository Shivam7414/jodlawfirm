@extends('admin.layouts.app')

@section('content')
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/css/selectize.default.min.css"
        integrity="sha512-pTaEn+6gF1IeWv3W1+7X7eM60TFu/agjgoHmYhAfLEU8Phuf6JKiiE8YmsNC0aCgQv4192s4Vai8YZ6VNM6vyQ=="
        crossorigin="anonymous"
        referrerpolicy="no-referrer"
    />
    <style>
       .selectize-control.single .selectize-input {
            border-radius: 8px;
            background-color: #ffffff !important;
            background-image: none;
            border: 1px solid #d2d6da;
            color: white;
        }
        .selectize-input .input-active{
            border-bottom-left-radius: 0;
            border-bottom-right-radius: 0;
        }
        .option.selected{
            background-color: #1083EE !important;
        }
        .selectize-input>*{
            color: #0e0d0d !important;
        }
    </style>
    
    @section('breadcrumb')
        <li class="breadcrumb-item text-sm">
            <a class="opacity-5 text-white" href="{{ route('admin.dashboard') }}">Dashboard</a>
        </li>
        <li class="breadcrumb-item text-sm text-white active">
            <a class="opacity-5 text-white" href="{{ route('admin.application.index') }}">Applications</a>
        </li>
        <li class="breadcrumb-item text-sm text-white active">Add</li>
    @endsection

    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <form action="">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="name" class="form-label">Select User</label>
                            <input type="hidden" name="user_id">
                            <div class="select">
                            </div>
                        </div>
                        <div class="col-md-6 text-end">
                            <input type="submit" value="Save" class="btn btn-primary">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label>Select Application Type</label>
                            <select name="application_type" class="form-control">
                                @foreach($applicationSettings as $applicationSetting)
                                    <option value="{{ $applicationSetting->type }}">{{ ucfirst($applicationSetting->type) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label>Select Price</label>
                            <select name="price" class="form-control">
                                <option value="1">Price1</option>
                                <option value="2">Price2</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label id="price_name"></label>
                            <input type="text" class="form-control" name="amount" readonly>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-8">
                            <label>Payment Option</label> 
                            <div class="d-flex">
                                <div class="me-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="payment_option" id="offline" value="offline" checked>
                                        <label class="form-check-label" for="offline">
                                            Offline
                                        </label>
                                    </div>
                                </div>
                                <div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="payment_option" id="online" value="online">
                                        <label class="form-check-label" for="online">
                                            Online
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="input-group mb-3" id="payment-link">
                                <input type="text" class="form-control" name="payment_link" placeholder="payment link">
                                <button type="button" class="btn btn-primary mb-0" id="payment_link_btn">Generate payment link</button>
                                <button type="button" class="btn btn-secondary mb-0">
                                    <i class="fa-solid fa-copy fs-4"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script
    src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/js/selectize.min.js"
    integrity="sha512-IOebNkvA/HZjMM7MxL0NYeLYEalloZ8ckak+NDtOViP7oiYzG5vn6WVXyrJDiJPhl4yRdmNAG49iuLmhkUdVsQ=="
    crossorigin="anonymous"
    referrerpolicy="no-referrer"
></script>
<script>
    let userOptions = @json($userOptions);
   
    $(document).ready(function() {
        let applicationSettings = @json($applicationSettings);
        let applicationSetting;

        $('select[name="application_type"]').on('change', function() {
            let applicationType = $(this).val();
            applicationSetting = applicationSettings.find(applicationSetting => applicationSetting.type == applicationType);
            $('select[name="price"]').trigger('change');
        });

        $('select[name="price"]').on('change', function() {
            if($('select[name="price"]').val() == 1) {
                $('#price_name').html(applicationSetting.price1_name);
                $('input[name="amount"]').val(applicationSetting.discounted_price1_amount);
            } else {
                $('#price_name').html(applicationSetting.price2_name);
                $('input[name="amount"]').val(applicationSetting.discounted_price2_amount);
            }
        });

        $('select[name="application_type"]').trigger('change');

        $('#payment_link_btn').on('click', function(){
            $.ajax({
                url: "{{ route('admin.application.generate_payment_link') }}",
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                data: {
                    user_id: $('input[name="user_id"]').val(),
                    name: $('input[name="name"]').val(),
                    email: $('input[name="email"]').val(),
                    phone: $('input[name="phone"]').val(),
                    amount: $('input[name="amount"]').val(),
                },
                success: function(response) {
                    $('input[name="payment_link"]').val(response.payment_link);
                    showToast('success', 'Payment link generated successfully');
                }
            });
        });

        $('input[name="payment_option"]').on('change', function() {
            if($(this).val() == 'online') {
                $('#payment-link').show();
            } else {
                $('#payment-link').hide();
            }
        });

        $(function () {
            $(".select").selectize({
                plugins: ["restore_on_backspace", "clear_button"],
                delimiter: " - ",
                persist: false,
                maxItems: 1,
                valueField: "id",
                labelField: "nameorEmail",
                searchField: ["id", "name", "email"],
                options: userOptions,
                placeholder: 'Select a user...',
                onChange: function(value) {
                    $('input[name="user_id"]').val(value);
                }
            });
        });
	});
</script>
@endpush
@extends('admin.layouts.app')

@section('content')
    @section('breadcrumb')
        <li class="breadcrumb-item text-sm">
            <a class="opacity-5 text-white" href="{{ route('admin.ticket.index') }}">Tickets</a>
        </li>
        <li class="breadcrumb-item text-sm text-white active">Create</li>
    @endsection
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
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <h3 class="mb-4">Create New Ticket</h3>
                <form action="{{ route('admin.ticket.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Select User</label>
                        <input type="hidden" name="user_id">
                        <div class="select">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="subject" class="form-label">Subject</label>
                        <input type="text" class="form-control" id="subject" name="subject" placeholder="Subject" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Your Message</label>
                        <textarea name="content">
                            Welcome to {{ config('app.name') }} support. Please describe your issue below and we will get back to you as soon as possible.
                        </textarea>
                    </div>
                    <div class="text-end">
                        <button type="submit" id="create_ticket" class="btn btn-primary">Create Ticket</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.tiny.cloud/1/a9t7jyv3a99vgr0na4fenfrslboxfr8e6qano85ffxwllzkl/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/js/selectize.min.js"
        integrity="sha512-IOebNkvA/HZjMM7MxL0NYeLYEalloZ8ckak+NDtOViP7oiYzG5vn6WVXyrJDiJPhl4yRdmNAG49iuLmhkUdVsQ=="
        crossorigin="anonymous"
        referrerpolicy="no-referrer"
    ></script>
    <script>
        $('#create_ticket').on('click', function(e){
            if($('input[name="user_id"]').val() == ''){
                e.preventDefault();
                $('input[name="user_id"]').focus();
                showToast('error', 'Please select a user');
            }

            if($('textarea[name="content"]').val() == ''){
                e.preventDefault();
                showToast('error', 'Please enter a message');
            }
        })
        $(document).ready(function() {
            let users = @json($users);
            $('.select').selectize({
                plugins: ["restore_on_backspace", "clear_button"],
                delimiter: " - ",
                persist: false,
                maxItems: 1,
                valueField: "id",
                labelField: "nameorEmail",
                searchField: ["id", "name", "email"],
                options: @json($users),
                placeholder: 'Select a user...',
                onChange: function(value) {
                    $('input[name="user_id"]').val(value);
                }
            });
        });
    </script>
    <script>
        tinymce.init({
            selector: 'textarea',
            plugins: 'ai tinycomments mentions anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount checklist mediaembed casechange export formatpainter pageembed permanentpen footnotes advtemplate advtable advcode editimage tableofcontents mergetags powerpaste tinymcespellchecker autocorrect a11ychecker typography inlinecss',
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | align lineheight | tinycomments | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
            tinycomments_mode: 'embedded',
            tinycomments_author: 'Support',
            mergetags_list: [{
                    value: 'First.Name',
                    title: 'First Name'
                },
                {
                    value: 'Email',
                    title: 'Email'
                },
            ],
            ai_request: (request, respondWith) => respondWith.string(() => Promise.reject("See docs to implement AI Assistant")),
        });
    </script>
@endpush

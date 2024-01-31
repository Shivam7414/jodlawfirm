@extends('admin.layouts.app')

@section('content')
    <script src="https://cdn.tiny.cloud/1/a9t7jyv3a99vgr0na4fenfrslboxfr8e6qano85ffxwllzkl/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
@section('breadcrumb')
    <li class="breadcrumb-item text-sm">
        <a class="opacity-5 text-white" href="{{ route('admin.ticket.index') }}">Tickets</a>
    </li>
    <li class="breadcrumb-item text-sm text-white active">Detail</li>
@endsection
<style>
    .left-chat{
        background: rgb(2,0,36);
        background: linear-gradient(0deg, rgba(2,0,36,1) 0%, rgba(36,143,242,1) 0%, rgba(36,143,242,1) 100%);
        box-shadow: 0 4px 8px 0 rgba(36,143,242,0.2), 0 6px 20px 0 rgba(36,143,242,0.19);
        color: white;
        border-radius: 10px;
        border-bottom-left-radius: 0px;
        display: inline-block;
    }
    .right-chat{
        background: rgb(2,0,36);
        background: linear-gradient(0deg, rgba(2,0,36,1) 0%, rgba(36,143,242,1) 0%, rgba(250,250,250,1) 0%);
        box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;
        border-radius: 10px;
        border-bottom-right-radius: 0px;
        display: inline-block;
        color: rgb(31, 30, 30);
    }
    .fixed-header {
        position: fixed;
        top: 15px;
        transition: all 0.3s ease-in-out;
        z-index: 1;
        width: 100%;
    }
</style>
<div class="container-fluid">
    <div class="card">
        <div class="card-header bg-white" id="card-header">
            <div class="d-flex justify-content-between">
                <div class="d-flex">
                    <img src="{{ asset('storage/' . $ticket->user->profile) }}" alt="{{ auth()->user()->name }}" class="rounded-circle" width="50" height="50">
                    <div class="fw-bold text-dark ms-3">
                        <span>{{ $ticket->user->full_name }}</span><br>
                        <span class="text-primary">{{ $ticket->user->email }}</span>
                    </div>
                </div>
                <div>
                    <select name="status" class="form-control">
                        <option value="">--Select Status--</option>
                        <option value="open">open</option>
                        <option value="in_progress">In progress</option>
                        <option value="on_hold">On hold</option>
                        <option value="closed">Closed</option>
                        <option value="reopened">Reopened</option>
                        <option value="resolved">Resolved</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="card-body">
            @foreach ($ticket->messages as $message)
                @if ($message->sender_type == 'user')
                    <div class="row mb-4">
                        <div class="col-md-auto col-md-6">
                            <div class="left-chat p-3">
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="opacity-9 fs-6">{{ $ticket->user->full_name }}</span>
                                    <span class="opacity-9 fs-7">{{ $message->created_at->diffForHumans() }}</span>
                                </div>
                                <span>{!! $message->content !!}</span>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="row mb-4">
                        <div class="col-md-auto col-md-6 ms-auto d-flex justify-content-end">
                            <div class="right-chat p-3">
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="opacity-9 fs-6">You</span>
                                    <span class="opacity-9 fs-7">{{ $message->created_at->diffForHumans() }}</span>
                                </div>
                                <span>{!! $message->content !!}</span>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
            <form action="{{ route('admin.ticket.send_message') }}" method="POST">
                @csrf
                <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">
                <div class="mb-3">
                    <label class="form-label">Your Message</label>
                    <div class="placeholder-div placeholder-glow">
                        <p class="placeholder-glow mb-0">
                            <span class="placeholder col-12"></span>
                        </p>
                        <p class="placeholder-glow mb-0">
                            <span class="placeholder col-12"></span>
                        </p>
                        <p class="placeholder-glow mb-0">
                            <span class="placeholder col-12"></span>
                        </p>
                    </div>
                    <textarea name="content" class="d-none">
                        Welcome to {{ config('app.name') }} support.
                    </textarea>
                </div>
                <div class="text-end">
                    <button class="btn btn-primary">Send</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('select[name="status"]').val('{{ $ticket->status }}');
        $('.nice-select').niceSelect();
        $('select[name="status"]').on('change', function() {
            $.ajax({
                url: '{{ route('admin.ticket.change_status', $ticket->id) }}',
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data: {
                    ticket_id: '{{ $ticket->id }}',
                    status: $(this).val()
                },
                success: function(response) {
                    if (response.success == true) {
                        showToast( 'success', response.message);
                    } else {
                        showToast( 'error', response.message);
                    }
                }
            });
        });
    });
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
        setup: function(editor) {
            editor.on('init', function() {
                $('.placeholder-div').hide();
            });
        },
        ai_request: (request, respondWith) => respondWith.string(() => Promise.reject("See docs to implement AI Assistant")),
    });

    // window.addEventListener('scroll', function() {
    //     var header = document.getElementById('card-header');
    //     var scrollPosition = window.scrollY;
    //     if (scrollPosition > header.offsetHeight) {
    //         header.classList.add('fixed-header');
    //         $('.card').css('margin-top', '5rem');
    //     } else {
    //         header.classList.remove('fixed-header');
    //     }
    // });
</script>
@endpush

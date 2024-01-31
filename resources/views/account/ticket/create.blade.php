@extends('account.layouts.app')

@section('content')
    @section('breadcrumb')
        <li class="breadcrumb-item text-sm">
            <a class="opacity-5 text-white" href="{{ route('account.ticket.index') }}">Tickets</a>
        </li>
        <li class="breadcrumb-item text-sm text-white active">Create</li>
    @endsection
    <script src="https://cdn.tiny.cloud/1/a9t7jyv3a99vgr0na4fenfrslboxfr8e6qano85ffxwllzkl/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <h3 class="mb-4">Create New Ticket</h3>
                <form action="{{ route('account.ticket.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="subject" class="form-label">Subject</label>
                        <input type="text" class="form-control" id="subject" name="subject" placeholder="Subject">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Your Message</label>
                        <textarea name="content">
                            Welcome to {{ config('app.name') }} support. Please describe your issue below and we will get back to you as soon as possible.
                        </textarea>
                    </div>
                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">Create Ticket</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
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

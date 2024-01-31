@extends('account.layouts.app')

@section('content')
    <link rel="stylesheet" href="https://unpkg.com/filepond/dist/filepond.css">
    <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet"/>

    <style>
        @media (max-width: 600px) {
            .responsive-max-width {
                max-width: 100px;
            }
        }
        @media (min-width: 600px) and (max-width: 900px) {
            .responsive-max-width {
                max-width: 200px;
            }
        }
        @media (min-width: 900px) {
            .responsive-max-width {
                max-width: 210px;
            }
        }
        .active-document{
            border: 1px solid;
            border-width: 2px !important;
            border-color: #1083EE !important;
        }
    </style>

    <div class="container-fluid mb-5">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h3>Application Detail</h3>
                <div>
                    <span class="badge {{ $application->status == 'pending' ? 'badge-warning' : 'badge-success' }}">{{ ucfirst($application->status) }}</span>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="mb-4">Application Info</h5>
                                <div class="row mb-2 pb-2 bottom-shadow">
                                    <div class="col-12 col-md-5">
                                        <span>Application Type</span>
                                    </div>
                                    <div class="col-12 col-md-7">
                                        <span class="fw-bold">{{ ucfirst($application->applicationSetting->type) }}</span>
                                    </div>
                                </div>
                                <div class="row mb-2 pb-2 bottom-shadow">
                                    <div class="col-12 col-md-5">
                                        <span>Selected Price Name</span>
                                    </div>
                                    <div class="col-12 col-md-7">
                                        <span class="fw-bold">{{ $application->price == '1' ? $application->applicationSetting->price1_name : $application->applicationSetting->price2_name }}</span>
                                    </div>
                                </div>
                                <div class="row mb-2 pb-2 bottom-shadow">
                                    <div class="col-12 col-md-5">
                                        <span>Amount</span>
                                    </div>
                                    <div class="col-12 col-md-7">
                                        <span class="fw-bold">Rs {{ $application->price == '1' ? $application->applicationSetting->discounted_price1_amount : $application->applicationSetting->discounted_price2_amount }}</span>
                                    </div>
                                </div>
                                <div class="row mb-2 pb-2 bottom-shadow">
                                    <div class="col-12 col-md-5">
                                        <span>Applied At</span>
                                    </div>
                                    <div class="col-12 col-md-7">
                                        <span class="fw-bold">{{ $application->created_at->format('d M, Y g:i A') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="mb-4">Payment Info</h5>
                                <div class="row mb-2 pb-2 bottom-shadow">
                                    <div class="col-12 col-md-6">
                                        <span>Bank Transaction ID</span>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <span class="fw-bold">{{ $application->transaction->bank_transaction_id }}</span>
                                    </div>
                                </div>
                                <div class="row mb-2 pb-2 bottom-shadow">
                                    <div class="col-12 col-md-6">
                                        <span>Payment Method</span>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <span class="fw-bold">{{ ucfirst($application->transaction->method) }}</span>
                                    </div>
                                </div>
                                <div class="row mb-2 pb-2 bottom-shadow">
                                    <div class="col-12 col-md-6">
                                        <span>Total Paid</span>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <span class="fw-bold">Rs {{ ($application->transaction->amount)/100 }}</span>
                                    </div>
                                </div>
                                <div class="row mb-2 pb-2 bottom-shadow">
                                    <div class="col-12 col-md-6">
                                        <span>Payment Status</span>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <span class="badge badge-success badge-sm">{{ $application->transaction->status }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="mb-4">Select and upload your documents</h5>
                                @forelse($application->applicationSetting->required_documents as $required_document)
                                    <div class="rounded-3 px-3 py-4 mb-3 pointer document-upload" onclick="changeDocumentCard(this, 'card_{{ $loop->iteration }}')" style="background-color: #f5f7ff;">
                                        <div class="row align-items-center">
                                            <div class="col-sm-9">
                                                <span class="text-dark fw-bold">{{ ucfirst($required_document) }}</span>
                                            </div>
                                            <div class="col-sm-3">
                                                <button class="btn btn-sm btn-primary mb-0 mt-2 mt-md-0" onclick="openModal('{{ route('account.application.upload_document', ['application_id' => $application->id, 'required_document_name' => $required_document ]) }}', 'modal-md')">Upload</button>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center pb-5">
                                        <span>No Documents Uploaded</span>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5 mt-3 mt-md-0 document-show"></div>
                    <div class="col-md-12 mt-3">
                        <div class="card">
                            <div class="card-header pb-0">
                                <h5>Documents Upload by <span class="fw-bolder">{{ config('app.name') }}</span></h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table align-items-center">
                                        <thead>
                                            <th>Name</th>
                                            <th>Fize Size</th>
                                            <th>Uploaded At</th>
                                            <th>Actions</th>
                                        </thead>
                                        <tbody>
                                            @forelse ($application->adminDocuments as $adminDocument)
                                                <tr>
                                                    <td class="py-4">
                                                        <div class="d-flex align-items-center">
                                                            <div style="object-fit: cover; height:35px; width:35px;">
                                                                <img src="{{ asset('img/icons/'.$adminDocument->extension.'.png') }}" alt="{{ $adminDocument->extension }}" width="100%" height="auto">
                                                            </div>
                                                            <h6 class="ms-4 fw-bold mb-0">{{ $adminDocument->original_name }}</h6>
                                                        </div>  
                                                    </td>
                                                    @php
                                                        $size_kb = $adminDocument->size / 1024;
                                                        $size_mb = $size_kb / 1024;
                                                    @endphp
                                                    <td class="text-sm fw-bold">
                                                        <span>
                                                            @if ($size_mb > 1)
                                                                {{ round($size_mb, 2) }} MB
                                                            @else
                                                                {{ round($size_kb, 2) }} KB
                                                            @endif
                                                        </span>
                                                    </td>
                                                    <td class="text-sm fw-bold">
                                                        <span>{{ $adminDocument->created_at->format('d M, Y g:i A') }}</span>
                                                    </td>
                                                    <td>
                                                        <a href="{{ asset($adminDocument->path) }}" download>
                                                            <img src="{{ asset('img/icons/download.png') }}" alt="download" width="25px" height="auto">
                                                        </a>
                                                    </td>
                                                </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="4" class="text-center py-5">No Documents Uploaded.</td>
                                                    </tr>
                                                @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://unpkg.com/filepond-plugin-file-validate-size/dist/filepond-plugin-file-validate-size.js"></script>
    <script>
        FilePond.registerPlugin(FilePondPluginImagePreview);
        FilePond.registerPlugin(FilePondPluginFileValidateType);
        FilePond.registerPlugin(FilePondPluginFileValidateSize);

        const acceptedFileTypes = ['image/png', 'image/jpeg', 'application/pdf',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'text/plain',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
	    ];

        function deleteDocument(element, id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#1083EE',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ url('account/delete_document') }}',
                        type: 'POST',
                        headers:{
                            'x-csrf-token': '{{ csrf_token() }}',
                        },
                        data: {
                            id: id
                        },
                        success: function (response) {
                            if (response.success == true) {
                                $(element).parent().parent().remove();
                                showToast('success', 'Document Deleted Successfully');
                            } else {
                                Swal.fire('Error', 'Something went wrong', 'error');
                            }
                        }
                    });
                }
            })
        }

        function changeDocumentCard(element, id) {
            $('.document-upload').removeClass('active-document');
            $(element).addClass('active-document');
            $('.document-show .card').addClass('d-none');
            $('#'+id).removeClass('d-none');
        }

        function showDocuments(default_document = null){
            $.ajax({
                url: '{{ route('account.application.show_document') }}',
                type: 'get',
                data: {
                    application_id: '{{ $application->id }}'
                },
                success: function (response) {
                    $('.document-show').html(response);
                    if(default_document == null){
                        $('.document-upload').first().click();
                    }else{
                        let cards = $('.document-upload');
                        let activeCardIndex = cards.index($('.active-document'));
                        ++activeCardIndex;
                        $('#card_'+ activeCardIndex).removeClass('d-none');
                    }
                }
            })
        }

        $(document).ready(function () {
            showDocuments();
            $('#empty_modal').on('hidden.bs.modal', function (e) {
                showDocuments(default_document = 1);
            })
        });
    </script>
@endpush
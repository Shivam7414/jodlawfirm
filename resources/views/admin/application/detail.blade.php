@extends('admin.layouts.app')

@section('content')
    @section('breadcrumb')
        <li class="breadcrumb-item text-sm">
            <a class="opacity-5 text-white" href="{{ route('admin.dashboard') }}">Dashboard</a>
        </li>
        <li class="breadcrumb-item text-sm">
            <a class="opacity-5 text-white" href="{{ route('admin.application.index') }}">Applications</a>
        </li>
        <li class="breadcrumb-item text-sm text-white active">Detail</li>
    @endsection
    <link rel="stylesheet" href="https://unpkg.com/filepond/dist/filepond.css">
    <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet"/>
    <style>
        .profile-img {
            height: 150px;
        }
        .custom-scrollbar::-webkit-scrollbar {
            height: 5px;
            border-radius: 20px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: #ffffff;
            border-radius: 20px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #b1b1b1;
            border-radius: 20px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #8d8b8b;
        }

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
                max-width: 300px;
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
                <h3 class="text-primary">Application Detail</h3>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="status" {{ $application->status == 'completed' ? 'checked' : '' }} onclick="changeStatus(this, '{{ $application->id }}')">
                    <label class="form-check-label" for="status" id="application-status">{{ $application->status == 'pending' ? 'Pending' : 'Completed' }}</label>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <h6 class="mb-4 text-primary">Application Info</h6>
                                <div class="text-sm">
                                    <div class="row mb-3 pb-2 bottom-shadow">
                                        <div class="col-12 col-md-5">
                                            <span>Application Type</span>
                                        </div>
                                        <div class="col-12 col-md-7">
                                            <span class="fw-bold">{{ ucfirst($application->applicationSetting->type) }}</span>
                                        </div>
                                    </div>
                                    <div class="row mb-3 pb-2 bottom-shadow">
                                        <div class="col-12 col-md-5">
                                            <span>Selected Price Name</span>
                                        </div>
                                        <div class="col-12 col-md-7">
                                            <span class="fw-bold">{{ $application->type == '1' ? $application->applicationSetting->price1_name : $application->applicationSetting->price2_name }}</span>
                                        </div>
                                    </div>
                                    <div class="row mb-3 pb-2 bottom-shadow">
                                        <div class="col-12 col-md-5">
                                            <span>Application Amount</span>
                                        </div>
                                        <div class="col-12 col-md-7">
                                            <span class="fw-bold">Rs {{ $application->type == '1' ? $application->applicationSetting->discounted_price1_amount : $application->applicationSetting->discounted_price2_amount }}</span>
                                        </div>
                                    </div>
                                    <div class="row mb-3 pb-2 bottom-shadow">
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
                    </div>
                    <div class="col-md-6 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <h6 class="text-primary mb-4">Payment Info</h6>
                                <div class="text-sm">
                                    <div class="row mb-3 pb-2 bottom-shadow">
                                        <div class="col-12 col-md-6">
                                            <span>Bank Transaction ID</span>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <span class="fw-bold">{{ $application->transaction->bank_transaction_id }}</span>
                                        </div>
                                    </div>
                                    <div class="row mb-3 pb-2 bottom-shadow">
                                        <div class="col-12 col-md-6">
                                            <span>Payment Method</span>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <span class="fw-bold">{{ ucfirst($application->transaction->method) }}</span>
                                        </div>
                                    </div>
                                    <div class="table-responsive custom-scrollbar">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Payment Amount</th>
                                                    <th>Payment Fee</th>
                                                    <th>Payment Tax</th>
                                                    <th>Total Recivied Amount</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Rs {{ ($application->transaction->amount)/100 }}</td>
                                                    <td class="text-danger">-Rs {{ ($application->transaction->fee)/100 }}</td>
                                                    <td class="text-danger">-Rs {{ ($application->transaction->tax)/100 }}</td>
                                                    <td class="text-success fw-bold">Rs {{ ($application->transaction->amount)/100 - (($application->transaction->fee)/100 + ($application->transaction->tax)/100) }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 my-4">
                        <div class="row">
                            <div class="col-md-7">
                                <div class="card">
                                    <div class="card-body">
                                        <h6 class="mb-3">Documents Upload by <span class="fw-bolder">{{ $application->user->full_name }}</span></h6>
                                        @foreach ($application->applicationSetting->required_documents as $required_document)
                                            <div class="rounded-3 px-3 py-4 mb-3 pointer document-upload" onclick="changeDocumentCard(this, 'card_{{ $loop->iteration }}')" style="background-color: #f5f7ff;">
                                                <div class="row align-items-center">
                                                    <div class="col-sm-9">
                                                        <span class="text-dark fw-bold">{{ ucfirst($required_document) }}</span>
                                                    </div>
                                                    @php
                                                        $is_document_uploaded = $application->documents->where('type', $required_document)->where('user_id', $application->user_id)->count();
                                                    @endphp
                                                    <div class="col-sm-3 text-end">
                                                        @if ($is_document_uploaded)
                                                            <span class="badge badge-success">Uploaded</span>
                                                        @else
                                                            <span class="badge badge-warning">Pending</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5 mt-3 mt-md-0 document-show"></div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="card">
                            <div class="d-flex justify-content-between card-header pb-0">
                                <h6 class="mb-0">Documents uploaded by <span class="fw-700">you</span></h6>
                                <button class="btn btn-primary btn-sm mb-0" onclick="openModal('{{ route('admin.application.upload_user_documents', ['application_id' => $application->id]) }}', 'modal-md')">Upload Documents</button>
                            </div>
                            <div class="card-body admin-documents"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://unpkg.com/filepond/dist/filepond.js"></script>
    <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
    <script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>
    <script src="https://unpkg.com/filepond-plugin-file-validate-size/dist/filepond-plugin-file-validate-size.js"></script>
    <script src="{{ asset('assets/js/filepond.js') }}"></script>
    <script>
        FilePond.registerPlugin(FilePondPluginImagePreview);
        FilePond.registerPlugin(FilePondPluginFileValidateType);
        FilePond.registerPlugin(FilePondPluginFileValidateSize);

        const acceptedFileTypes = ['image/png', 'image/jpeg', 'application/pdf',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'text/plain',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
	    ];

        function changeStatus(checkbox, applicationId) {
            let status = checkbox.checked ? 'completed' : 'pending';
            $.ajax({
                url: '{{ url('admin/application/change_status/') }}/' + applicationId,
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    status: status,
                },
                success: function(response) {
                    $('#application-status').text(status);
                    showToast('success', response.message);
                },
                error: function(error) {
                    showToast('error', error);
                }
            });
        }

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
                        url: '{{ url('admin/document_delete') }}',
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

        function showUserDocuments(){
            $.ajax({
                url: '{{ route('admin.application.show_user_documents') }}',
                type: 'get',
                data: {
                    application_id: '{{ $application->id }}'
                },
                success: function (response) {
                    $('.document-show').html(response);
                    $('.document-upload').first().click();
                }
            })
        }

        function showAdminDocuments(){
            $.ajax({
                url: '{{ route('admin.application.show_admin_documents') }}',
                type: 'get',
                data: {
                    application_id: '{{ $application->id }}'
                },
                success: function (response) {
                    $('.admin-documents').html(response);
                }
            })
        }

        $(document).ready(function () {
            showUserDocuments();
            showAdminDocuments();

            $('#empty_modal').on('hidden.bs.modal', function (e) {
                showAdminDocuments();
            })
        });
    </script>
@endpush
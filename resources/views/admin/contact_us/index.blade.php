@extends('admin.layouts.app')

@section('content')
    @section('breadcrumb')
        <li class="breadcrumb-item text-sm"><a class="opacity-5 text-white" href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item text-sm text-white active">Contact Us</li>
    @endsection
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <h3 class="col-md">Contact Us</h3>
                    <div class="col-md-auto ms-auto">
                        <label>Filter by status</label>
                        <select name="status" class="form-control">
                            <option value="">All</option>
                            <option value="read">Read</option>
                            <option value="unread">Unread</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <th>S.No</th>
                            <th>Client Name</th>
                            <th>Phone No</th>
                            <th>Subject</th>
                            <th>Status</th>
                            <th>Created At</th>
                            <th>Mark as Read</th>
                        </thead>
                        <tbody>
                            @forelse ($contactUs as $contact)
                                <tr class="text-sm text-bold">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $contact->name }}</td>
                                    <td>
                                        <a href="tel:{{ '+91'.$contact->phone_no }}">{{ $contact->phone_no }}</a>
                                    </td>
                                    <td>{{ $contact->subject }}</td>
                                    <td>
                                        @if ($contact->status == 'unread')
                                            <span class="badge badge-danger">Unread</span>
                                        @else
                                            <span class="badge badge-success">Read</span>
                                        @endif
                                    </td>
                                    <td>{{ $contact->created_at->format('d-m-Y') }}</td>
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input" name="mark_as_read" value="{{ $contact->id }}" type="checkbox" data-bs-toggle="tooltip" data-bs-title="Mark as read" {{ $contact->status == 'read' ? 'checked' : '' }}>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-dark">No contact us found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{ $contactUs->links('common.custom') }}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('select[name="status"]').val('{{ ($request->status) }}');
        });
        $(function() {
            $('input[name="mark_as_read"]').on('change', function() {
                let status = $(this).is(':checked') ? 'read' : 'unread';
                let id = $(this).val();
                let checkbox = $(this);
                $.ajax({
                    url: "{{ route('admin.contact_us.change_status', '') }}/" + id,
                    type: 'post',
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    data: {
                        status: status,
                    },
                    success: function(response) {
                        if (response.success == true) {
                            showToast('success', response.message);
                            let badge = checkbox.closest('tr').find('td').eq(4).find('span');
                            if (status == 'read') {
                                badge.removeClass('badge-danger').addClass('badge-success').html('Read');
                            } else {
                                badge.removeClass('badge-success').addClass('badge-danger').html('Unread');
                            }
                        } else {
                            showToast('error', response.message);
                        }
                    }
                });
            });
        });

        $('select[name="status"]').on('change', function() {
            let status = $(this).val();
            let url = "{{ route('admin.contact_us.index') }}";
            if (status != '') {
                url = "{{ route('admin.contact_us.index') }}?status=" + status;
            }
            window.location.href = url;
        });
    </script>
@endpush
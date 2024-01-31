@extends('admin.layouts.app')

@section('content')
    @section('breadcrumb')
        <li class="breadcrumb-item text-sm">
            <a class="opacity-5 text-white" href="{{ route('admin.dashboard') }}">Dashboard</a>
        </li>
        <li class="breadcrumb-item text-sm text-white active">Applications</li>
    @endsection
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <div class="row align-items-center">
                    <h3 class="col-md-auto mb-2 mb-md-0">Applications</h3>
                    <div class="col">
                        <div class="row g-2 justify-content-end">
                            <div class="col-md-2 mb-2 mb-md-0">
                                <select name="application_status" id="application_status" class="form-control nice-select mb-0">
                                    <option value="">All Status</option>
                                    <option value="pending" {{ request()->get('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="completed" {{ request()->get('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                                </select>
                            </div>
                            <div class="col-md-3 mb-2 mb-md-0">
                                <select name="application_type" id="application_type" class="form-control nice-select mb-0">
                                    <option value="">All Application Type</option>
                                    <option value="registration">Trademark Registration</option>
                                    <option value="objection">Trademark Objection</option>
                                    <option value="opposition">Trademark Opposition</option>
                                    <option value="renewal">Trademark Renewal</option>
                                </select>
                            </div>
                            <div class="d-flex col-md-5 mb-2 mb-md-0">
                                <input type="text" class="form-control rounded-end-0" placeholder="Search by user name, email or application id" name="search_query" value="{{ $request->search_query }}">
                                <button class="btn btn-primary mb-0 rounded-start-0" id="search_btn">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                </button>
                            </div>
                            <div class="col-md-auto text-md-start text-end">
                                <a href="{{ route('admin.application.add') }}" class="btn btn-primary mb-0">Add</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table align-items-center table-striped-columns mb-0">
                        <thead>
                            <th>S.No</th>
                            <th>User Info</th>
                            <th>Application Type</th>
                            <th>Selected Price</th>
                            <th>Status</th>
                            <th>Applied At</th>
                            <th></th>
                        </thead>
                        <tbody>
                            @php
                                $startingNumber = ($applications->currentPage() - 1) * $applications->perPage() + 1;
                            @endphp
                            @forelse ($applications as $application)
                                <tr>
                                    <td>{{ $startingNumber++ }}</td>
                                    <td>
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="mb-0 text-sm">{{ $application->user->full_name }}</h6>
                                            <p class="text-xs text-secondary mb-0">
                                                <a href="mailto:{{ $application->user->email }}">{{ $application->user->email }}</a>
                                            </p>
                                        </div>
                                    </td>
                                    <td class="text-sm">{{ ucfirst($application->applicationSetting->type) }}</td>
                                    <td>
                                        <span class="text-sm ms-2">
                                            @if ($application->type == '1')
                                                {{ $application->applicationSetting->price1_name }}
                                            @else
                                                {{ $application->applicationSetting->price2_name }}
                                            @endif
                                        </span>
                                    </td>
                                    <td>
                                        @if ($application->status == 'pending')
                                            <span class="badge badge-sm badge-warning">Pending</span>
                                        @else
                                            <span class="badge badge-sm badge-success">Completed</span>
                                        @endif
                                    </td>
                                    <td class="text-sm">
                                        {{ $application->created_at->format('d M, Y g:i A') }}
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.application.detail', $application->id) }}">
                                            <i class="fa-solid fa-right-to-bracket"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-3">
                                        <h5 class="mb-0">No applications found</h5>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                {{ $applications->links('common.custom') }}
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#application_status').change(function() {
                updateUrlParam('status', $(this).val());
            });

            $('#application_type').change(function() {
                updateUrlParam('type', $(this).val());
            });

            document.getElementById('search_btn').addEventListener('click', function() {
                updateUrlParam('search_query', searchInput.value);
            });

            let searchInput = document.querySelector('input[name="search_query"]');
            searchInput.addEventListener('keypress', function(e) {
                if(e.which == 13) {
                    updateUrlParam('search_query', this.value);
                }
            });

            $('input[name="search_query"]').on('focus', function() {
                $(this).select();
            });

            $('#application_type').val('{{ $request->type }}');
            $('.nice-select').niceSelect();
        });

        function updateUrlParam(param, value) {
            let url = new URL(window.location.href);
            url.searchParams.set(param, value);
            window.location.href = url.toString();
        }
    </script>
@endpush

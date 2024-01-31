@extends('account.layouts.app')

@section('content')
@section('breadcrumb')
    <li class="breadcrumb-item text-sm">
        <a class="opacity-5 text-white" href="{{ route('account.dashboard.index') }}">Dashboard</a>
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
                        <div class="col-md-auto text-md-start text-end">
                            <a href="{{ route('account.application.apply') }}" class="btn btn-primary">Apply</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table align-items-center">
                    <thead>
                        <th>Application Id</th>
                        <th>Application Type</th>
                        <th>Selected Price</th>
                        <th>Status</th>
                        <th>Applied At</th>
                        <th></th>
                    </thead>
                    <tbody>
                        @forelse ($applications as $application)
                            <tr class="font-weight-bold">
                                <td class="text-sm text-dark">{{ $application->id }}</td>
                                <td class="text-sm">{{ ucfirst($application->applicationSetting->type) }}</td>
                                <td>
                                    <span class="text-sm ms-2">
                                        @if ($application->price == '1')
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
                                    <a href="{{ route('account.application.detail', $application->id) }}">
                                        <i class="fa-solid fa-right-to-bracket"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script>
        tippy('#application_status', {
            content: "Filter by Application status",
        });
        $(document).ready(function() {
            $('#application_status').change(function() {
                updateUrlParam('status', $(this).val());
            });

            $('#application_type').change(function() {
                updateUrlParam('type', $(this).val());
            });

            $('#application_type').val('{{ request()->get('type') }}');
        });

        function updateUrlParam(param, value) {
            let url = new URL(window.location.href);
            url.searchParams.set(param, value);
            window.location.href = url.toString();
        }
    </script>
@endpush
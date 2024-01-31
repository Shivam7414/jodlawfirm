@extends('admin.layouts.app')

@section('content')
@section('breadcrumb')
    <li class="breadcrumb-item text-sm"><a class="opacity-5 text-white" href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item text-sm text-white active">Page</li>
@endsection

<div class="container-fluid py-4">
    <div class="card">
        <div class="card-header d-md-flex justify-content-between align-items-center">
            <h3>Pages</h3>
            <div>
                <button class="btn btn-primary" onclick="openModal('{{ url('admin/page/add_category') }}', 'modal-md')">Add Category</button>
                <a href="{{ route('admin.page.add') }}" class="btn btn-primary">Add Page</a>
            </div>
        </div>
        <div class="card-body table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>S.no</th>
                        <th>Page Name</th>
                        <th>Category</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pages as $page)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $page->name }}</td>
                            <td>{{ $page->category ? $page->category->name : 'Not Available' }}</td>
                            <td>
                                <span class="badge {{ $page->status == 1 ? 'badge-success' : 'badge-warning' }}">{{ $page->status == 1 ? 'Active' : 'In-Active' }}</span>
                            </td>
                            <td>
                                <a href="{{ route('admin.page.edit', $page->id) }}" class="btn btn-primary">
                                    <i class="fa-solid fa-pen-to-square fs-6"></i>
                                </a>
                                <button class="btn btn-danger mx-1" onclick="confirmationById('{{ route('admin.page.delete') }}', 'Are you sure, Yoy want to delete this page? ', '{{ $page->id }}');">
                                    <i class="fa-solid fa-trash fs-6"></i>
                                </button>
                                <a href="{{ url('page/'.$page->slug) }}" class="btn btn-info" target="_blank">
                                    <i class="fa-solid fa-circle-info fs-6"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr class="text-center">
                            <td colspan="5">No Pages Found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
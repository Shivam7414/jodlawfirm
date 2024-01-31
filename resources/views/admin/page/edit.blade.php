@extends('admin.layouts.app')

@section('content')
<link rel="stylesheet" href="https://richtexteditor.com/richtexteditor/rte_theme_default.css" />
<script src="https://richtexteditor.com/richtexteditor/rte.js"></script>

@section('breadcrumb')
    <li class="breadcrumb-item text-sm"><a class="opacity-5 text-white" href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item ">
        <a href="{{ route('admin.page.index') }}" class="text-sm opacity-5 text-white">Page</a>
    </li>
    <li class="breadcrumb-item text-sm text-white active">Add</li>
@endsection

<div class="container-fluid py-4">
    <form action="{{ route('admin.page.store') }}" method="POST">
        <input type="hidden" name="id" value="{{ $page->id }}">
        @csrf
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3>{{ $page->id ? 'Edit' : 'Add' }} Page</h3>
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
            <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name">Page Name</label>
                                <input type="text" name="name" id="name" class="form-control" value="{{ $page->name }}">
                            </div>
                            <div class="mb-3">
                                <label for="category_id">Category</label>
                                <select name="page_category_id" id="page_category_id" class="form-control">
                                    <option value="">Select Category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ $page->page_category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="status">Status</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="">Select Status</option>
                                    <option value="1" {{ $page->status == '1' ? 'selected' : '' }}>active</option>
                                    <option value="0" {{ $page->status == '0' ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="content">Content</label>
                        <textarea name="content" id="editor-one" cols="30" rows="10" class="form-control">{!! $page->content !!}</textarea>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

@endsection

@push('scripts')
    <script>
        var rte1 = new RichTextEditor("#editor-one");
    </script>
@endpush
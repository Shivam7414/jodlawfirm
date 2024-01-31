@extends('admin.layouts.app')

@section('content')
    @section('breadcrumb')
        <li class="breadcrumb-item text-sm"><a class="opacity-5 text-white" href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item text-sm text-white active">Social Link</li>
    @endsection
    <div class="container-fluid py-4">
        <div class="card">
            <div class="card-header">
                <h3>Social Links</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.social_link.store') }}" method="POST">
                    @csrf
                    @foreach (['instagram', 'linkedin', 'youtube', 'facebook', 'twitter'] as $index => $key)
                        @php
                            $socialLink = $socialLinks->where('name', $key)->first();
                            $link = $socialLink->link ?? '';
                            $status = $socialLink->status ?? '';
                        @endphp
                        <div class="col-md-8 mb-3">
                            <label for="{{ $key }}">{{ ucfirst($key) }}</label>
                            <div class="d-flex">
                                <input type="hidden" name="id[]" value="{{ $socialLink ? $socialLink->id : '' }}">
                                <input type="text" name="link[]" class="form-control" value="{{ $link }}" required>
                                <input type="hidden" name="status[{{ $index }}]" value="0">
                                <div class="form-switch ms-3">
                                    <input class="form-check-input" type="checkbox" id="{{ $key }}" name="status[{{ $index }}]" value="1" {{ $status == '1' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="{{ $key }}">Active</label>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <div class="col-md-8 d-flex justify-content-end mt-5">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
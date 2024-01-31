@extends('frontend.layouts.app')

@section('content')
    <div class="d-flex justify-content-center align-items-center bg-light rounded fw-600" style="height: 25vh">
        <span class="fs-1 text-primary">{{ strtoupper($page->name) }}</span>
    </div>
    <div class="container my-5">
        {!! $page->content !!}
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            var url = window.location.pathname;
            var isPageRoute = url.startsWith("/page/");
            if (isPageRoute) {
                $('main').removeClass('container-fluid');
            }
        });
    </script>
@endpush
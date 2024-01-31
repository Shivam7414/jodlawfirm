<!DOCTYPE html>
<html lang="en">
    <head>
        @include('frontend.layouts.partials.head')
    </head>
    <body>
        @include('frontend.layouts.partials.header')
        <main class="container-fluid mt-6">
            @yield('content')
        </main>
        @include('frontend.layouts.partials.footer')
        @include('frontend.layouts.partials.scripts')
        @include('common.modal')
    </body>
</html>
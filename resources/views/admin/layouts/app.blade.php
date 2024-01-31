<!DOCTYPE html>
<html lang="en">
    <head>
        @include('admin.layouts.partials.head')
    </head>
    <body class="g-sidenav-show bg-gray-100">
        @if(Auth::guard('admin')->check())
            <div class="min-height-300 bg-primary position-absolute w-100"></div>
            @include('admin.layouts.partials.sidebar')
        @endif
        <main class="main-content border-radius-lg">
            @if(Auth::guard('admin')->check())
                @include('admin.layouts.partials.header', ['title' => 'Dashboard'])
            @endif
            @yield('content')
        </main>
        @include('components.fixed-plugin')
        @include('admin.layouts.partials.scripts')
        @include('common.modal')
    </body>
</html>
<!DOCTYPE html>
<html lang="en">

<head>
    @include('account.layouts.partials.head')
</head>

<body class="g-sidenav-show bg-gray-100">
    <div class="min-height-300 bg-primary position-absolute w-100"></div>
    @include('account.layouts.partials.sidenav')
        <main class="main-content border-radius-lg">
            @include('account.layouts.partials.topnav')
            @yield('content')
        </main>
    @include('components.fixed-plugin')
    @include('account.layouts.partials.scripts')
    @include('common.modal')
</body>
</html>

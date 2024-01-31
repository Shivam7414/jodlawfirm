<aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4" id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand m-0" href="{{ route('home') }}"
            target="_blank">
            <img src="{{ asset(config('app.favicon')) }}" width="50px" height="100%" alt="main_logo">
            <span class="ms-1 font-weight-bold">{{ config('app.name') ?? 'Laravel' }}</span>
        </a>
    </div>
    <hr class="horizontal dark mt-0">
    <div class="collapse navbar-collapse w-auto " id="sidenav-collapse-main">
        <ul class="navbar-nav">
            <li class="nav-item mb-3">
                <a class="nav-link {{ Route::currentRouteName() == 'account.dashboard.index' ? 'active' : '' }}" href="{{ route('account.dashboard.index') }}">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <img src="{{ asset('img/icons/dashboard.png') }}" height="20px">
                    </div>
                    <span class="nav-link-text ms-1">Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() == 'account.profile' ? 'active' : '' }}" href="{{ route('account.profile') }}">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <img src="{{ asset('img/icons/user.png') }}" height="25px">
                    </div>
                    <span class="nav-link-text ms-1">Profile</span>
                </a>
            </li>
            <li class="nav-item my-2">
                <a class="nav-link {{ Route::currentRouteName() == 'account.application.index' ? 'active' : '' }}" href="{{ route('account.application.index') }}">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <img src="{{ asset('img/icons/legal-document.png') }}" height="25px">
                    </div>
                    <span class="nav-link-text ms-1">Applications</span>
                </a>
            </li>
            <li class="nav-item">
                <a data-bs-toggle="collapse" href="#TrademarkSettings" class="nav-link {{ Route::currentRouteName() == 'account.application.apply' ? 'active' : '' }}" aria-controls="TrademarkSettings" role="button" aria-expanded="true">
                    <div class="icon icon-shape icon-sm text-center d-flex align-items-center justify-content-center">
                        <img src="{{ asset('img/icons/accept.png') }}" height="25px">
                    </div>
                    <span class="nav-link-text ms-1">Apply</span>
                </a>
                <div class="collapse active show" id="TrademarkSettings" style="">
                    <ul class="nav">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->get('type') == 'registration' ? 'active' : '' }}" href="{{ url('account/application/apply?type=registration') }}">
                                <span class="text-dark ms-4">Trademark Registration</span>
                            </a>
                            <a class="nav-link {{ request()->get('type') == 'objection' ? 'active' : '' }}" href="{{ url('account/application/apply?type=objection') }}">
                                <span class="text-dark ms-4">Trademark Objection</span>
                            </a>
                            <a class="nav-link {{ request()->get('type') == 'opposition' ? 'active' : '' }}" href="{{ url('account/application/apply?type=opposition') }}">
                                <span class="text-dark ms-4">Trademark Opposition</span>
                            </a>
                            <a class="nav-link {{ request()->get('type') == 'renewal' ? 'active' : '' }}" href="{{ url('account/application/apply?type=renewal') }}">
                                <span class="text-dark ms-4">Trademark Renewal</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() == 'account.ticket.index' || Route::currentRouteName() == 'account.ticket.create' || Route::currentRouteName() == 'account.ticket.detail' ? 'active' : '' }}" href="{{ route('account.ticket.index') }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <img src="{{ asset('img/icons/customer-service.png') }}" height="25px">
                    </div>
                    <span class="nav-link-text ms-1">Support</span>
                </a>
            </li>
        </ul>
    </div>
</aside>

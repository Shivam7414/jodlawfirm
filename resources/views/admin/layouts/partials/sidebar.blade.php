<aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4 "
    id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
            aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand m-0" href="{{ url('') }}" target="_blank">
            <img src="{{ asset(config('app.favicon')) }}" class="" width="60px" alt="main_logo">
            <span class="ms-1 font-weight-bold">{{ config('app.name') ?? 'Laravel' }}</span>
        </a>
    </div>
    <hr class="horizontal dark mt-0">
    <div class="collapse navbar-collapse  w-auto" id="sidenav-collapse-main">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() == 'home' ? 'active' : '' }}"
                    href="{{ url('admin/dashboard') }}">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-tv-2 text-primary text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() == 'admin.profile.index' ? 'active' : '' }}" href="{{ route('admin.profile.index') }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-user-gear text-primary text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Profile Settings</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() == 'admin.application.index' ? 'active' : '' }}" href="{{ route('admin.application.index') }}">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-paper-plane text-primary text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Applications</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() == 'admin.user.index' ? 'active' : '' }}" href="{{ route('admin.user.index') }}">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-users text-primary text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Manage Users</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() == 'admin.contact_us.index' ? 'active' : '' }}" href="{{ route('admin.contact_us.index') }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-headset text-primary text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Contact Us</span>
                </a>
            </li>
            <li class="nav-item">
                <a data-bs-toggle="collapse" href="#TrademarkSettings" class="nav-link collapsed" aria-controls="TrademarkSettings" role="button" aria-expanded="{{ Route::currentRouteName() == 'admin.registration.index' ? 'true' : 'false' }}">
                    <div class="icon icon-shape icon-sm text-center d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-gear text-primary"></i>
                    </div>
                    <span class="nav-link-text ms-1">Trademark Settings</span>
                </a>
                <div class="collapse {{ Route::currentRouteName() == 'admin.registration.index' ? 'show' : '' }}" id="TrademarkSettings" style="">
                    <ul class="nav">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->get('type') == 'registration' ? 'active' : '' }}" href="{{ url('admin/trademark_settings/index?type=registration') }}">
                                <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                    <i class="fa-regular fa-registered text-dark opacity-10"></i>
                                </div>
                                <span class="nav-link-text ms-1">Registration</span>
                            </a>
                            <a class="nav-link {{ request()->get('type') == 'objection' ? 'active' : '' }}" href="{{ url('admin/trademark_settings/index?type=objection') }}">
                                <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                    <i class="fa-solid fa-bullseye text-dark opacity-10"></i>
                                </div>
                                <span class="nav-link-text ms-1">Objection</span>
                            </a>
                            <a class="nav-link {{ request()->get('type') == 'opposition' ? 'active' : '' }}" href="{{ url('admin/trademark_settings/index?type=opposition') }}">
                                <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                    <i class="fa-regular fa-registered text-dark opacity-10"></i>
                                </div>
                                <span class="nav-link-text ms-1">Opposition</span>
                            </a>
                            <a class="nav-link {{ request()->get('type') == 'renewal' ? 'active' : '' }}" href="{{ url('admin/trademark_settings/index?type=renewal') }}">
                                <div
                                    class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                    <i class="fa-regular fa-registered text-dark opacity-10"></i>
                                </div>
                                <span class="nav-link-text ms-1">Renewal</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() == 'admin.ticket.index' || Route::currentRouteName() == 'admin.ticket.create' || Route::currentRouteName() == 'admin.ticket.detail' ? 'active' : '' }}" href="{{ route('admin.ticket.index') }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <img src="{{ asset('img/icons/customer-service.png') }}" height="25px">
                    </div>
                    <span class="nav-link-text ms-1">Support</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() == 'admin.api_credential.index' ? 'active' : '' }}" href="{{ route('admin.api_credential.index') }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-key text-primary"></i>
                    </div>
                    <span class="nav-link-text ms-1">Api Credentials</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() == 'admin.page.index' ? 'active' : '' }}" href="{{ route('admin.page.index') }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-file text-primary"></i>
                    </div>
                    <span class="nav-link-text ms-1">Pages</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() == 'admin.social_link.index' ? 'active' : '' }}" href="{{ route('admin.social_link.index') }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-link text-primary"></i>
                    </div>
                    <span class="nav-link-text ms-1">Social Links</span>
                </a>
            </li>
            <li class="nav-item {{ Route::currentRouteName() == 'admin.site_settings.index' ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.site_settings.index') }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-wrench text-primary"></i>
                    </div>
                    <span class="nav-link-text ms-1">Site Settings</span>
                </a>
            </li>
        </ul>
    </div>
</aside>

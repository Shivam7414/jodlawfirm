<header class="position-fixed top-0 top-header w-100">
    <nav class="navbar navbar-expand-lg bg-white">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ url('') }}">
                <div class="d-flex align-items-start">
                    <h1 class="text-primary d-inline fw-bold">{{ config('app.name') }}</h1>
                </div>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-center">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="{{ url('trademark/index?type=objection') }}">Trademark Objection</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('trademark/index?type=opposition') }}">Trademark Opposition</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('trademark/index?type=renewal') }}">Trademark Renewal</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('trademark/index?type=registration') }}">Trademark Register</a>
                    </li>
                    <li class="nav-item dropdown me-3">
                        <div class="pointer border px-3 py-2 fs-4 rounded-4" href="#" id="contact_us_dropdown"  data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-brands fa-whatsapp"></i>
                            <i class="fa-solid fa-envelope mx-3"></i>
                            <i class="fa-solid fa-phone"></i>
                        </div>
                        <ul class="dropdown-menu pt-0 border-0 shadow-13" aria-labelledby="contact_us_dropdown">
                            <li class="px-3 py-2" style="background: #EFF6F1">
                                <h6 class="mb-0 fw-600">Contact Us</h6>
                            </li>
                            <li><a class="dropdown-item mt-2" href="tel:{{ config('app.phone') }}"><i class="fas fa-phone fa-fw"></i> {{ config('app.phone') }}</a></li>
                            <li><a class="dropdown-item" href="mailto:{{ config('app.email') }}"><i class="fas fa-envelope fa-fw"></i> {{ config('app.email') }}</a></li>
                            <li><a class="dropdown-item" href="https://wa.me/{{ config('app.whatsapp') }}"><i class="fas fa-whatsapp fa-fw"></i> {{ config('app.whatsapp') }}</a></li>
                        </ul>
                    </li>
                    @auth
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown"  data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="{{ asset(auth()->user()->profile) }}" alt="profile"  width="40px" class="rounded-circle">
                            </a>
                            <ul class="dropdown-menu pt-0 border-0 box-shadow-1" aria-labelledby="navbarDropdown" style="left:-70px;">
                                <li class="bg-light px-3 py-2">
                                    <h6 class="mb-0 fw-600">{{ auth()->user()->full_name }}</h6>
                                    <i>{{ auth()->user()->email }}</i>
                                </li>
                                <li><a class="dropdown-item mt-2" href="{{ route('account.dashboard.index') }}"><i class="fas fa-sliders-h fa-fw"></i> Dashboard</a></li>
                                <li><a class="dropdown-item" href="{{ route('account.profile') }}"><i class="fas fa-cog fa-fw"></i> Profile Setting</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form role="form" method="post" action="{{ route('logout') }}" id="logout-form">
                                        @csrf
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                            class="dropdown-item">
                                            <i class="fas fa-sign-out-alt fa-fw"></i>
                                            Log out
                                        </a>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="btn btn-primary" href="{{ url('login') }}">Login/Register</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>
</header>
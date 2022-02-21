<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top shadow" id="navbar">
    <!-- NAVBAR CUSTOM RESPONSIVE-->
    <div class="container d-lg-none d-xl-none d-xxl-none">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapseCustom"
            aria-controls="navbarCollapseCustom" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        @guest
        <a class="navbar-brand text-harga" href="{{ route('landing')}}">PANAK.ID</a>
        <img src="{{asset('assets/img/logo.svg')}}" style="width:50px;"></img>
        @else
        <a class="navbar-brand text-harga" href="{{ route('landing')}}">
            <img src="{{asset('assets/img/logo.svg')}}" style="width:50px;" class="d-inline-block align-text-top">
            PANAK.ID
        </a>
        <ul class="nav navbar-nav list-group list-group-horizontal" id="navbar-cart-notif-position">
            <li class="nav-item dropdown me-3" style="position: initial;">
                <a class="nav-link dropdown-toggle hidden-arrow" href="#" id="navbarDarkDropdownMenuLink" role="button"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="far fa-bell text-harga"></i>
                    <span
                        class="badge rounded-pill badge-notification bg-danger">{{Auth::user()->unreadNotifications->count()}}</span>
                </a>
                <ul class="dropdown-menu position-absolute shadow p-0 border-0"
                    aria-labelledby="navbarDarkDropdownMenuLink" id="dropdown-notification">
                    @include('layouts.notification')
                </ul>
            </li>
            <li class="nav-item me-1">
                <a class="nav-link " aria-current="page" href="{{ route('cart') }}">
                    <i class="fas fa-shopping-cart text-harga"></i>
                    <span class="badge badge-pill bg-danger badge-notification ">{{Auth::user()->carts->count()}}</span>
                </a>
            </li>
        </ul>
        @endguest
        <div class="collapse navbar-collapse" id="navbarCollapseCustom">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            </ul>
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link " aria-current="page" href="{{ route('investnak')}}">Bisnak</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " aria-current="page" href="{{ route('pasarnak') }}">Pasarnak</a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link " aria-current="page" href="{{route('edunak')}}">Edunak</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " aria-current="page" href="{{route('migo-product')}}">MIGO Product</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " aria-current="page" href="{{route('jadi-pec')}}">Jadi PEC</a>
                </li>
                <li class="nav-item me-2">
                    <a class="nav-link " aria-current="page" href="{{route('about-us')}}">About us</a>
                </li>

                @guest
                <a class="btn btn-warning" href="{{ route('login') }}">Mulai Bisnis</a>

                @else
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-harga" href="#" id="navbarDropdown" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="{{Auth::user()->getPhotoProfile()}}" height="25" width="25" alt="" loading="lazy"
                            class="rounded-circle me-1" /> {{Auth::user()->name}}
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item text-harga fw-bold" href="{{route('profile.wallet')}}">Rp.
                                {{number_format(Auth::user()->balance,0,",",".")}}
                            </a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="{{ route('profile') }}">Profil</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">Logout</a></li>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </ul>
                </li>
                @endguest
            </ul>
        </div>
    </div>
    <!-- NAVBAR NORMAL SCREEN-->
        <div class="container d-none d-lg-inline-flex "><img src="{{asset('assets/img/logo.svg')}}" style="width:50px;" />
        <a class="navbar-brand text-harga" href="{{ route('landing')}}">PANAK.ID</a>
        <!-- <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"
            id="navbar-button-position">
            <span class="navbar-toggler-icon"></span>
        </button> -->
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        </ul>
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link " aria-current="page" href="{{ route('investnak')}}">Bisnak</a>
            </li>
            <li class="nav-item">
                <a class="nav-link " aria-current="page" href="{{ route('pasarnak') }}">Pasarnak</a>
            </li>
            <li class="nav-item ">
                <a class="nav-link " aria-current="page" href="{{route('edunak')}}">Edunak</a>
            </li>
            <li class="nav-item">
                <a class="nav-link " aria-current="page" href="{{route('migo-product')}}">MIGO Product</a>
            </li>
            <!--<li class="nav-item">
                <a class="nav-link " aria-current="page" href="{{route('jadi-pec')}}">Jadi PEC</a>
            </li>-->
            <li class="nav-item me-2">
                <a class="nav-link " aria-current="page" href="{{route('about-us')}}">About us</a>
            </li>

            @guest
            <a class="btn btn-warning" href="{{ route('login') }}">Mulai Bisnak</a>

            @else

            <div class="d-flex align-items-start">
                <li class="nav-item me-2 dropstart">
                    <a class="nav-link dropdown-toggle hidden-arrow" href="#" id="dropdownNotification" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="far fa-bell text-harga"></i>
                        <span
                            class="badge rounded-pill badge-notification bg-danger">{{Auth::user()->unreadNotifications->count()}}</span>
                    </a>
                    <ul class="dropdown-menu p-0 border-0 mt-5" aria-labelledby="dropdownNotification"
                        id="dropdown-notification-lg">
                        @include('layouts.notification')
                    </ul>
                </li>

                <li class="nav-item me-1">
                    <a class="nav-link " aria-current="page" href="{{ route('cart') }}">
                        <i class="fas fa-shopping-cart text-harga"></i>
                        <span
                            class="badge badge-pill bg-danger badge-notification ">{{Auth::user()->carts->count()}}</span>
                    </a>
                </li>

            </div>
            <div class="navbar-divider"></div>

            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle text-harga" href="#" id="navbarDropdown" role="button"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="{{Auth::user()->getPhotoProfile()}}" height="25" width="25" alt="" loading="lazy"
                        class="rounded-circle me-1" /> {{Auth::user()->name}}
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item text-harga fw-bold" href="{{route('profile.wallet')}}">Rp.
                            {{number_format(Auth::user()->balance,0,",",".")}}
                        </a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item" href="{{ route('profile') }}">Profil</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">Logout</a></li>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </ul>
            </li>
            @endguest
        </ul>
    </div>
</nav>
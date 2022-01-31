@extends('layouts.app')
@section('title','Profil')
@section('content')
<div class="container py-3">
    <div class="row">
        <div class="col-lg-3">
            <div class="card shadow-sm h-100 sticky-top" style="border-radius: 15px; background-color:#F6F2F2 !important;" id="card-nav-menu">
                <div class="card-body">
                    <nav class="nav nav-pills navbar-expand-lg flex-column">
                        <div class="container-fluid">
                            <div class="d-flex justify-content-between align-items-center d-lg-none d-lg-block">
                                <a class="navbar-toggler" href="#">Menu</a>
                                <span class="navbar-toggler fas fa-angle-right" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#menu" aria-controls="menu" aria-expanded="false"
                                    aria-label="Toggle navigation"></span>
                            </div>
                            <div class="collapse navbar-collapse" id="menu">
                                <ul class="nav nav-pills flex-column ">
                                    <li class="nav-item py-1 pt-3">
                                        <a href="{{route('profile')}}" class="nav-link text-dark {{last(request()->segments()) == 'profile' ? 'active':''}}" aria-current="page">
                                            <i class="fa fa-user" aria-hidden="true"></i>
                                            Akun Saya
                                        </a>
                                    </li>
                                    <li class="nav-item py-1">
                                        <a href="{{route('profile.portofolio')}}" class="nav-link text-dark {{last(request()->segments()) == 'portofolio' ? 'active':''}}">
                                        <i class="fas fa-file-invoice"></i>
                                            Portofolio
                                        </a>
                                    </li>
                                    <li class="nav-item py-1">
                                        <a href="{{route('profile.transaction')}}" class="nav-link text-dark {{last(request()->segments()) == 'transaction' ? 'active':''}}">
                                            <i class="fas fa-exchange-alt"></i>
                                            Transaksi
                                        </a>
                                    </li>
                                    <li class="nav-item py-1">
                                        <a href="{{route('profile.wallet')}}" class="nav-link text-dark {{last(request()->segments()) == 'wallet' ? 'active':''}}">
                                        <i class="fas fa-wallet"></i>
                                            Wallet
                                        </a>
                                    </li>
                                    <li class="nav-item py-1">
                                        <a href="{{route('profile.notification')}}" class="nav-link text-dark {{last(request()->segments()) == 'notification' ? 'active':''}}">
                                        <i class="fas fa-bell"></i>
                                            Notifikasi
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </nav>
                </div>
            </div>
        </div>

        <div class="col-lg-9">
            @yield('contentprofile')
        </div>
    </div>
</div>
@endsection
@push('js')
<script>
function myFunction(x) {
    if (x.matches) { // If media query matches
        var a = document.getElementById('profile');
        var b = document.getElementById('menu-title');
        a.setAttribute("class", "nav d-flex justify-content-center")
        b.setAttribute("class", "text-center")
    } else {
        var a = document.getElementById('profile');
        a.setAttribute("class", "nav")
        b.setAttribute("class", "")

    }
}
var x = window.matchMedia("(max-width: 1000px)")
myFunction(x) // Call listener function at run time
x.addListener(myFunction)
</script>
@endpush
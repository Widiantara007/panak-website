@extends('auth.app')
@section('title','Login')
@push('css')
<style>
@media only screen and (min-width: 768px ) and (min-height: 720px){
.perfect-center{
    position: absolute;
    top: 50%;
    left: 50%;
    -moz-transform: translateX(-50%) translateY(-50%);
    -webkit-transform: translateX(-50%) translateY(-50%);
    transform: translateX(-50%) translateY(-50%);
 }
}
 </style>
@endpush
@section('content')
<div class="container perfect-center">
    <div class="card justify-content-center shadow-lg " style="border-radius: 15px;">
        <div class="row">
            <div class="col-md-5 text-center py-md-5 py-3" style="background-color: #560043;border-radius: 15px;">
                <div class="row d-flex justify-content-center">
                    <div class="col-4 col-md-12">

                    <a href="{{ route('landing')}}"><img class="img-fluid mt-md-5 mb-md-5 " src="{{ asset('img/logo-panak-ori.png') }}" alt=""></a>
                    </div>
                    <!-- <div class="col-7 col-md-12"> -->
                    <!-- <a href="{{ route('landing')}}" class="text-decoration-none"><h1 class="text-white font-weight-bold">PASAR TERNAK INDONESIA</h1></a> -->
                        
                    <!-- </div> -->
                </div>
            </div>
            <div class="col-md-7 col-12 text-center py-5 px-3">
                <h1 class="display-4 font-weight-bold color-default" >LOGIN</h1>
                <div class="row justify-content-center mt-5 mx-4">
                    <div class="col-md-7 col-12 ">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <label for="email" class="col-form-label float-left color-default">{{ __('Email') }}</label>

                            <input id="email" type="email"
                                class="form-control underline-border @error('email') is-invalid @enderror" name="email"
                                value="{{ old('email') }}" required autocomplete="email" autofocus >

                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror


                            <label for="password" class="col-form-label float-left color-default mt-3">{{ __('Password') }}</label>

                            <input id="password" type="password"
                                class="form-control underline-border @error('password') is-invalid @enderror"
                                name="password" required autocomplete="current-password">

                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                    





            
                    
                        <button type="submit" class="btn btn-block bg-default btn-rounded mt-5">
                            {{ __('Login') }}
                        </button>
                        <h6 class="my-3">atau</h6>
                        {{-- @if (Route::has('password.request'))
                        <a class="btn btn-link" href="{{ route('password.request') }}">
                            {{ __('Forgot Your Password?') }}
                        </a>
                        @endif --}}
                    
                        <a class="btn btn-block btn-light btn-rounded shadow" href="{{ route('auth.google') }}"><img  src="{{ asset('img/google-icon.svg') }}" alt="" class="mr-3" style="height: 1em"> Login dengan Google</a>
                        
                        <h6 class="mt-5">Belum punya akun? <a href="{{ route('register') }}">Daftar</a></h6>
                    </div>
                    
                </form>
            </div>
        </div>

    </div>
</div>

</div>
</div>
@endsection
@push('css')
<style>
    .btn-rounded{
        border-radius: 15px;
    }
.bg-default{
    color: white;
    background-color: #560043;
}
.color-default{
    color: #560043!important;
}
.underline-border{
    border: solid #560043;
    border-width: 0px 0px medium 0px;
}
.underline-border:focus{
    
}

</style>
@endpush

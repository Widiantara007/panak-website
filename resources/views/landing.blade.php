@extends('layouts.app')
@section('title','Pasar Ternak Indonesia')
@section('content')
<!-- Carousel -->

<div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">
        @foreach ($sliders as $index=>$slider)
        <div class="carousel-item {{$index == 0 ? 'active':'' }}">
            <img class="d-block w-100" src="{{asset('storage/images/sliders/'.$slider->image)}}" alt="First slide">
            <div class="carousel-caption">
                <h1 class="heading">{{$slider->title}}</h1>
                <p class="text-justify mb-0">{{$slider->description}}</p>
                <a class="btn btn-outline-light btn-normal mt-2" target="" href="{{$slider->link}}">Mulai Sekarang <i
                        class="fa fa-angle-right text-white ml-3 font-weight-bold"></i></a>
            </div>
        </div>
        @endforeach
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
    </button>
</div>

<!-- End OF Carousel -->

<!-- Container Dasar -->
<div class="container mt-2">
    <!-- Content Produk Bisnak -->
    <div class="card border-0 shadow" id="land1">
        <div class="row mt-4 mx-3">
            <div class="col">
                <h4>Produk Bisnak</h4>
            </div>
            <div class="col d-flex justify-content-end">
                <button class="btn btn-outline-default" id="button-resize-landing">Lihat Semua Produk</button>
            </div>
        </div>

        <div class="row mb-4 mx-3">
            @foreach ($types as $type)

            <div class="col-lg col-sm-6 col-6 mt-3">
                <div class="card border-0 rounded " id="card-hover-special">
                    <div class="overlay-div d-flex align-items-center justify-content-center">
                        <h2 style="color:white; font-size:1.1em;">{{$type->name}}</h2>
                    </div> <!-- the new div -->
                    <img class="card-img-top rounded stretched-link" id="produk-invest"
                        src="{{asset('storage/images/project-types/'.$type->image)}}" alt="Card image cap" href="">
                        <a href="{{route('investnak', ['category[]' => $type->name])}}" class="stretched-link"></a>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- End of Produk Bisnak -->

    <!-- Content Proyek Terbaru -->
    @php
        use Carbon\Carbon;
        Carbon::setLocale('id');
    @endphp
    <section>
        <div class="row my-4">
            <div class="col">
                <h4>Proyek Terbaru</h4>
            </div>
            <div class="col d-flex justify-content-end">
                <a href="{{ route('investnak') }}" class="btn btn-outline-default" id="button-resize-landing">Lihat
                    Semua Proyek </a>
            </div>
        </div>
        <div class="row d-flex justify-content-center">

            @foreach ($project_batches as $project_batch)

            <div class="col-lg col-md-6 mb-4">
                <div class="card rounded border-0 h-100" id="card-hover-special">
                    <a class="card-block text-decoration-none">
                        <div class="card border-0">
                            <div class="{{ $project_batch->isFullyFunded() ? 'bg-image' : '' }}">
                                <img class="card-img-top"
                                    src="{{ asset('storage/images/projects/'.$project_batch->project->image) }}"
                                    alt="Card image cap">
                            </div>
                            @if ($project_batch->isFullyFunded())
                            <div
                                class="card-img-overlay bg-text card-img-top d-flex align-items-center justify-content-center">
                                <h4 class="fw-bold bg-default-secondary text-white p-2">FULLY FUNDED</h4>
                            </div>
                            @endif
                        </div>
                        <div class="card-body d-flex flex-column shadow-sm">
                            <span class="badge rounded-pill bg-primary mb-2 pe-2"
                                style="background-color:#FF8200 !important"><i class="fas fa-star pe-1"
                                    style="color:white;"></i>{{$project_batch->project->risk_grade}}</span>
                            <h6 class="card-title landing text-wrap">{{ $project_batch->project->name }}</h6>
                            <div class="mt-auto">
                                <div class="d-flex justify-content-between align-items-center"
                                    id="landing-projek-paragraph">
                                    <p class="float-left mb-0">Ditutup Pada</p>
                                    <p class="float-right mb-0">Tersisa</p>
                                </div>
                                <div class="d-flex justify-content-between align-items-center"
                                    id="landing-projek-paragraph">
                                    <p class="text-muted mb-1">
                                        {{$project_batch->start_date->locale('id')->isoFormat('DD MMMM YYYY')}}</p>
                                    <p class="text-muted mb-1">
                                        {{$project_batch->daysLeft() }}
                                        hari lagi</p>
                                </div>
                                <p class="text-muted text-pendanaan mb-1"><i class="fas fa-user"></i>
                                    {{$project_batch->project->project_owner->name}}</p>
                                <div class="d-flex justify-content-between align-items-center "
                                    id="landing-projek-paragraph">
                                    <p class="float-left mb-2">Modal</p>
                                    <p class="float-right mb-2 text-roi">ROI
                                        {{ $project_batch->roi_low .'-'.$project_batch->roi_high }} %</p>
                                </div>
                                <p class="text-pendanaan mt-2"><span class="text-harga">Rp
                                        {{number_format($project_batch->totalInvestments(),0,",",".")}}</span> /
                                    <span class="fw-bold"> Rp
                                        {{number_format($project_batch->target_nominal,0,",",".")}}</span>
                                </p>
                                <div class="d-grid">
                                    @if ($project_batch->isFullyFunded())
                                    <a class="btn btn-sm btn-outline-secondary align-self-end " disabled>Fully
                                        Funded</a>

                                    @else

                                    <a id="btn-pasarnak1" class="btn btn-sm btn-primary align-self-end"
                                        href="{{route('investnak.show', $project_batch->id)}}">Mulai Bisnis</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            @endforeach

        </div>
    </section>
    <!-- End of Proyek Terbaru -->

    <!-- Start of Pasarnak Banner -->
    <div class="row">
        <div class="col">
            <div class="card border-0 h-100">
                <div class="overlay-div"></div> <!-- the new div -->
                <img class="card-img-top custom-rounded" src="{{asset('assets/img/bg-banner.svg')}}"
                    alt="Card image cap">
                <div class="pasarnak">
                    <div class="row">
                        <div class="col-md-8 offset-md-1 offset-sm-1 offset-1">
                            <h1 class="heading" style="color:white;">Produk dari Pasarnak </h1>
                            <a class="btn btn-outline-light btn-normal" target="_blank"
                                href="https://www.tokopedia.com/pasarternakpanak">Kunjungi Pasarnak
                                <i class="fa fa-angle-right text-white ml-3 font-weight-bold"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End of Pasarnak Banner -->

    <!-- Pasarnak -->
    <section>
        <div class="row mb-4">
            @foreach ($products as $product)
            <div class="col-lg-2 col-md-4 col-6 my-4">
                <div class="card rounded border-0 h-100" id="card-hover-special">
                    <div class="card border-0">
                        <div class="{{ $product->isOutOfStock() ? 'bg-image' : '' }}">
                            <img class="card-img-top" src="{{asset('storage/images/products/'.$product->image)}}"
                                alt="Card image cap">
                        </div>
                        @if ($product->isOutOfStock())
                        <div
                            class="card-img-overlay bg-text card-img-top d-flex align-items-center justify-content-center">
                            <h4 class="fw-bold bg-default-secondary text-white p-2">OUT OF STOCK</h4>
                        </div>
                        @endif

                    </div>
                    <div class="card-body d-flex flex-column shadow-sm">
                        <h6 class="card-title mb-2">{{ $product->name }}</h6>
                        {{-- <p class="card-text text-pendanaan mb-0">Minimal Beli 1 Kg</p> --}}
                        @if (!empty($product->discount))
                        <p class="text-muted text-pendanaan mb-1"><del> Rp
                                {{number_format($product->price,0,",",".")}}</del><span class="badge bg-success">
                                {{$product->discount}}% Off</span></p>
                        <p class="card-title text-harga">Rp
                            {{number_format($product->price_after_discount(),0,",",".")}} / {{$product->unit}}</p>
                        @else
                        <p class="card-title text-harga">Rp {{number_format($product->price,0,",",".")}} /
                            {{$product->unit}}</p>

                        @endif
                        <div class="row mt-auto">
                            @if ($product->isOutOfStock())
                            <div class="col-12 d-grid gap-2 pe-1">
                                <button class="btn btn-sm btn-outline-default" disabled>Stok Habis</button>
                            </div>
                            @else
                            <div class="col-9 d-grid gap-2 pe-1">
                                <a  class="btn btn-sm btn-default" href="{{ route('pasarnak.show', $product->id) }}">Lihat Produk</a>
                            </div>
                            <div class="col-3 d-grid gap-2 px-0">
                                <form action="{{ route('cart.store') }}" method="POST">
                                    @csrf
                                    <input type="text" name="product_id" value="{{ $product->id }}" hidden>
                                    <button id="btn-pasarnak2" class="btn btn-sm btn-outline-warning" type="submit"><i
                                        class="fas fa-shopping-cart"></i></button>
                                </form>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach

        </div>

    </section>
    <!-- End Of pasarnak -->

</div>
<!-- End Of Container Dasar -->

@endsection
@push('js')

<script>

function navbarposition(y) {
    if (y.matches) { // If media query matches
        var a = document.getElementById('navbar');
        var b = document.getElementById('navbar-cart-notif-position');
        var c = document.getElementById('dropdown-notification');
        a.setAttribute("class", "navbar navbar-expand-lg navbar-light bg-light fixed-top shadow me-4")
        b.setAttribute("class", "nav navbar-nav list-group list-group-horizontal me-3")
        c.setAttribute("class", "dropdown-menu position-absolute shadow p-0 border-0 right-position-landing-dropdown");
    } else {
        var a = document.getElementById('navbar');
        var b = document.getElementById('navbar-cart-notif-position');
        var c = document.getElementById('dropdown-notification');

        a.setAttribute("class", "navbar navbar-expand-lg navbar-light bg-light fixed-top shadow")
        b.setAttribute("class", "nav navbar-nav list-group list-group-horizontal")
        c.setAttribute("class", "dropdown-menu position-absolute shadow p-0 border-0");

    }
}
var y = window.matchMedia("(max-width: 767px)")
navbarposition(y) // Call listener function at run time
y.addListener(navbarposition)



//     function navbarposition() {
//         var a = document.getElementById('navbar');
//         a.setAttribute("class", "navbar navbar-expand-lg navbar-light bg-light fixed-top shadow me-4");
// }
// function navbarposition2() {
//        var b = document.getElementById('navbar-image-position-responsive');
//         b.setAttribute("class", "navbar-brand text-harga me-5");
// }
// window.onload = navbarposition;

</script>
@endpush

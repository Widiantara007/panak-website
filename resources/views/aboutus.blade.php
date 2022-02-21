@extends('layouts.app')
@section('title','Pasar Ternak Indonesia')
@push('css')
<style>
body {
    padding-top: 60px;
}
</style>
@endpush

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


<div class="container-fluid">
    <div class="row my-2">
        <div class="col-10 offset-1 p-2 py-5">
        <h2 class="featurette-heading text-muted text-center">SEJARAH <span class="text-harga">PANAK.ID</span></h2><br>
            <p align="justify">Panak. Id merupakan platform digital berbasis website untuk meningkatkan produktivitas 
            peternak lokal Indonesia yang menghubungkan peternak, pasar, dan pemilik modal. Panak.Id bertujuan untuk membantu 
            mewujudkan swasembada daging dan ketahanan pangan di Indonesia tahun 2045. Panak.Id berdiri pada tahun 2019 namun 
            idenya telah terbentuk dari 2015. Tetsuya selaku founder dan CEO Panak.Id termotivasi membangun Startup ini dilandasi 
            adanya permasalahan di lapangan, yaitu peternak kesulitan dalam mengakses pasar, modal, serta pengetahuan, sehingga 
            sulit untuk berkembang, maka terbentuklah Panak.Id sebagai salah satu solusi peternakan di Indonesia. Panak.Id ini 
            dibangun oleh Tetsuya sendiri selaku founder dan CEO, diawali dengan terjun langsung ke lapangan untuk melakukan survey 
            dan mengetahui permasalahan peternak sehingga dapat memberikan solusi bagi permasalahan Peternak maupun masyarakat.</p>
        </div>
    </div>
</div>

<div class="container-fluid marketing bg-light border-top">
    <div class="col-10 offset-1 p-2 py-5">
        <div class="row featurette">
            <div class="col-md-6">
                <h2 class="featurette-heading text-muted text-center">VISI <span class="text-harga">PANAK.ID</span></h2><br>
                <p class="lead" align="justify">Menjadi platform digital bidang peternakan terkemuka yang memiliki
                                solusi terkini, terintegrasi, dan profesional sehingga Indonesia menjadi negara 
                                ekspor produk peternakan terbesar di Asia dengan pilar utama yang menciptakan
                                dampak sosial bagi Masyarakat.
                </p><br>
                <p class="lead" align="justify">Menjadi platform yang dapat mewujudkan swasembada daging di Indonesia</p><br>
               
            </div>
            <div class="col-md-6 ">
            <h2 class="featurette-heading text-muted text-center">MISI <span class="text-harga">PANAK.ID</span></h2><br>
                <p class="lead" align="justify">Menyedihkan akses permodalan, pemasaran, dan pengetahuan untuk Peternak tradisional.</p><br>
                <p class="lead" align="justify">Mempermudah Masyarakat menyalurkan dana untuk proyek investasi bidang peternakan.</p><br>
                <p class="lead" align="justify">Mempermudah konsumen untuk membeli produk peternakan.</p><br>
                <p class="lead" align="justify">Mengedepankan profesionalisme, inovasi, dan kerjasama tim.</p><br>
            </div>

        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="container">
        <div class="row pt-5">
            <div class="col-12">
            <h2 class="featurette-heading text-muted text-center">ACHIVEMENT OF <span class="text-harga">PANAK.ID</span></h2><br>
            </div>
        </div>
        <div class="row pb-4">
        <div class="col-10 offset-1 p-2">
            <div class="row mb-4 justify-content-center align-item-center">
            <div class="col-md-4 col-sm-6 col-6 mt-2">
                    <div class="card bg-light h-100">
                    <img src="{{asset('./assets/img/sertif002.jpg')}}" class="card-img-top" alt="...">
                        <div class="card-body">
                        <h5 class="featurette-heading text-muted text-center">BALI STARTUP CAMP</h5>
                            <figure class="text-start">
                                    <p align="justify"><small>
                                    Sebagai juara II pada Bali StartUp Camp 2019 yang diadakan di STIMIK PRIMAKARA Denpasar 
                                    pada 13 - 15 desember 2019, yang bertujuan untuk mengembangkan ekosistem StartUp di Bali.
                                    </small>
                                    </p>
                            </figure>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 col-6 mt-2">
                    <div class="card bg-light h-100">
                    <img src="{{asset('./assets/img/sertif001.jpg')}}" class="card-img-top" alt="...">
                        <div class="card-body">
                        <h5 class="featurette-heading text-muted text-center">TIM BERPRESTASI</h5>
                            <figure class="text-start">
                                    <p align="justify"><small>
                                    Meraih juara III pada StarUp Weekend Indonesia NextGen, &
                                        Lolos Pendanaan Pada StartUp Inovasi Indonesia (CPPBT) 2020.
                                    </small>
                                    </p>
                            </figure>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4 col-sm-6 col-6 mt-2">
                    <div class="card bg-light h-100">
                    <img src="{{asset('./assets/img/sertif003.jpg')}}" class="card-img-top" alt="...">
                        <div class="card-body">
                        <h5 class="featurette-heading text-muted text-center">MITRA MAGANG</h5>
                            <figure class="text-start">
                                    <p align="justify"><small>
                                     Sebagai mitra magang dalam program magang kurikulum merdeka belajar kampus merdeka di Universitas Ngurah Rai Denpasar
                                     pada 2 Desember 2021. 
                                    </small>
                                    </p>
                            </figure>
                        </div>
                    </div>
                </div>  
                

            </div>
        </div>
    </div>
</div>
    </div>
</div>

<div class="container-fluid marketing bg-light border-top">
    <div class="col-10 offset-1 p-2 py-5">
        <div class="row featurette">
            <div class="col-md-6 col-12">
                <h2 class="featurette-heading text-muted">LOKASI <span
                        class="text-harga">PANAK.ID</span></h2>
                <p class="lead" align="justify">Pasar ternak indonesia berlokasi di Jl. Nangka No.168, Dangin Puri Kaja, Kec. Denpasar Utara, Kota Denpasar, Bali.</p>
            </div>
            <div class="col-md-6 col-sm-6 col-12">
               <div class="embed-responsive embed-responsive-4by3">
               <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d15778.246885659042!2d115.222701!3d-8.638004!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x3a55402b1cd513fa!2sPasar%20Ternak%20Indonesia!5e0!3m2!1sid!2sid!4v1644461870108!5m2!1sid!2sid" 
                width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
               </div>
            </div>
        </div>
    </div>

    <!-- /END THE FEATURETTES -->

</div><!-- /.container -->
<div class="container-fluid border-top">
    <div class="row py-4">
        <div class="col-10 offset-1 p-2">
            <div class="div-team text-center">
            <img src="{{asset('./assets/img/logo-panak-ori.png')}}" style="width: 55px; height: 55px;" class="card-img-top" alt="...">
                <h2 class="featurette-heading text-muted text-center">FOUNDER & CEO OF <span class="text-harga">PANAK.ID</span></h2>
                <!--<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the
                    industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type
                    and
                    scrambled it to make a type specimen book. It has survived not only five centuries, </p>-->
            </div>
        </div>
    </div>
    <div class="row pb-4">
        <div class="col-10 offset-1 p-2">
            <div class="row mb-4 justify-content-center align-item-center">
                <div class="col-md-3 col-sm-6 col-6">
                    <div class="card mb-3">
                        <img src="{{asset('./assets/img/founder.jpg')}}" class="card-img-top" alt="...">
                        <div class="card-body">
                            <p class="card-text text-harga fw-bold mb-0">Tetsuya Aisyah Rayanti</p>
                            <h6 class="card-subtitle mb-2 text-muted mt-1"><small>Founder & CEO Panak.id</small></h6>
                            <figure class="text-start">
                                <blockquote class="blockquote">
                                <p align="justify"><small><i>
                                    "The purpose of panak.id is to connect farmers with markets, capital, and knowledge so that they can 
                                        boost the local farmer's economy and social impact for the wider community." 
                                    </small>
                                    </i>
                                    </p>
                                </blockquote>
                                <figcaption class="blockquote-footer mt-2">
                                     Tetsuya Aisyah Rayanti
                                </figcaption>
                            </figure>
                        </div>
                    </div>
                </div>
                

            
        </div>
    </div>
</div>
@endsection
                                    
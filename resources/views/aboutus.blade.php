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
<div class="container-fluid px-0">
    <div class="img-fluid p-5 mb-4 bg-light"
        style="
      background-image: url('./assets/img/bg-banner-card.svg'); height: 40vh; width:100%;background-repeat: repeat-y; background-size:cover;">
        <div class="container-fluid py-5">
            <h3 class="display-5 fw-bold text-center" style="color:white;">About Us</h3>
            <!-- <p class="col-md-8 fs-4">Using a series of utilities, you can create this jumbotron, just like the one in
                previous versions of Bootstrap. Check out the examples below for how you can remix and restyle it to
                your liking.</p> -->
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="row my-2">
        <div class="col-10 offset-1 p-2 py-5">
            <p>Panak.id is an agritech startup
                founded by the CEO of Panak.id
                in 2019, Tetsuya Aisyah Rayanti,
                a graduate of Udayana University
                Animal Husbandry which aims to
                be a platform / liaison between
                investors, breeders and users to
                help develop local livestock to
                achieve meat self-sufficiency in
                Indonesia.</p>
        </div>
    </div>
</div>

<div class="container-fluid marketing bg-light border-top">
    <div class="col-10 offset-1 p-2 py-5">
        <div class="row featurette">
            <div class="col-md-7">
                <h2 class="featurette-heading text-harga">First featurette heading. <span class="text-muted">It’ll blow
                        your
                        mind.</span></h2>
                <p class="lead">Some great placeholder content for the first featurette here. Imagine some exciting
                    prose
                    here.</p>
            </div>
            <div class="col-md-5">
                <svg class="bd-placeholder-img bd-placeholder-img-lg featurette-image img-fluid mx-auto" width="500"
                    height="500" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: 500x500"
                    preserveAspectRatio="xMidYMid slice" focusable="false">
                    <title>Placeholder</title>
                    <rect width="100%" height="100%" fill="#eee" /><text x="50%" y="50%" fill="#aaa"
                        dy=".3em">500x500</text>
                </svg>
            </div>

        </div>
    </div>
</div>
<div class="container-fluid marketing border-top">
    <div class="col-10 offset-1 p-2 py-5">
        <div class="row featurette">
            <div class="col-md-7 order-md-2">
                <h2 class="featurette-heading text-harga">Oh yeah, it’s that good. <span class="text-muted">See for
                        yourself.</span>
                </h2>
                <p class="lead">Another featurette? Of course. More placeholder content here to give you an idea of how
                    this
                    layout would work with some actual real-world content in place.</p>
            </div>
            <div class="col-md-5 order-md-1">
                <svg class="bd-placeholder-img bd-placeholder-img-lg featurette-image img-fluid mx-auto" width="500"
                    height="500" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: 500x500"
                    preserveAspectRatio="xMidYMid slice" focusable="false">
                    <title>Placeholder</title>
                    <rect width="100%" height="100%" fill="#eee" /><text x="50%" y="50%" fill="#aaa"
                        dy=".3em">500x500</text>
                </svg>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid marketing bg-light border-top">
    <div class="col-10 offset-1 p-2 py-5">
        <div class="row featurette">
            <div class="col-md-7">
                <h2 class="featurette-heading text-harga">And lastly, this one. <span
                        class="text-muted">Checkmate.</span></h2>
                <p class="lead">And yes, this is the last block of representative placeholder content. Again, not really
                    intended to be actually read, simply here to give you a better view of what this would look like
                    with
                    some actual content. Your content.</p>
            </div>
            <div class="col-md-5">
                <svg class="bd-placeholder-img bd-placeholder-img-lg featurette-image img-fluid mx-auto" width="500"
                    height="500" xmlns="" role="img" aria-label="Placeholder: 500x500"
                    preserveAspectRatio="xMidYMid slice" focusable="false">
                    <title>Placeholder</title>
                    <rect width="100%" height="100%" fill="#eee" /><text x="50%" y="50%" fill="#aaa"
                        dy=".3em">500x500</text>
                </svg>
            </div>
        </div>
    </div>

    <!-- /END THE FEATURETTES -->

</div><!-- /.container -->
<div class="container-fluid border-top">
    <div class="row py-4">
        <div class="col-10 offset-1 p-2">
            <div class="div-team text-center">
                <span class="badge rounded-pill bg-primary mb-2" style="background-color:#7e0051 !important">Team</span>
                <h4 class="mb-4">Our Team</h4>
                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the
                    industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type
                    and
                    scrambled it to make a type specimen book. It has survived not only five centuries, </p>
            </div>
        </div>
    </div>
    <div class="row pb-4">
        <div class="col-10 offset-1 p-2">
            <div class="row">
                <div class="col-md-3 col-sm-6 col-12">
                    <div class="card mb-3">
                        <img src="{{asset('./assets/img/sayangku.png')}}" class="card-img-top" alt="...">
                        <div class="card-body">
                            <p class="card-text text-harga fw-bold mb-0">Tetsuya Aisyah Rayanti</p>
                            <h6 class="card-subtitle mb-2 text-muted mt-1"><small>Founder & CEO Panak.id</small></h6>
                            <figure class="text-start">
                                <blockquote class="blockquote">
                                    <p>A well-known quote, contained in a blockquote element.</p>
                                </blockquote>
                                <figcaption class="blockquote-footer">
                                    Someone famous in <cite title="Source Title">Source Title</cite>
                                </figcaption>
                            </figure>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 col-12">
                    <div class="card mb-3">
                        <img src="{{asset('./assets/img/sayangku.png')}}" class="card-img-top" alt="...">
                        <div class="card-body">
                            <p class="card-text text-harga fw-bold mb-0">Tetsuya Aisyah Rayanti</p>
                            <h6 class="card-subtitle mb-2 text-muted mt-1"><small>Founder & CEO Panak.id</small></h6>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 col-12">
                    <div class="card mb-3">
                        <img src="{{asset('./assets/img/sayangku.png')}}" class="card-img-top" alt="...">
                        <div class="card-body">
                            <p class="card-text text-harga fw-bold mb-0">Tetsuya Aisyah Rayanti</p>
                            <h6 class="card-subtitle mb-2 text-muted mt-1"><small>Founder & CEO Panak.id</small></h6>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 col-12">
                    <div class="card mb-3">
                        <img src="{{asset('./assets/img/sayangku.png')}}" class="card-img-top" alt="...">
                        <div class="card-body">
                            <p class="card-text text-harga fw-bold mb-0">Tetsuya Aisyah Rayanti</p>
                            <h6 class="card-subtitle mb-2 text-muted mt-1"><small>Founder & CEO Panak.id</small></h6>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
@extends('layouts.app')
@section('title','Jadi PEC')
@push('css')
<style>
    body{
        padding-top:60px;
    }
    </style>
@endpush

@section('content')
<div class="container-fluid px-0">
    <div class="img-fluid p-5 mb-4 bg-light"
        style="
      background-image: url('./assets/img/bg-banner-card.svg'); height: 40vh; width:100%;background-repeat: repeat-y; background-size:cover;">
        <div class="container-fluid py-5">
            <h3 class="display-5 fw-bold text-center" style="color:white;">Jadi PEC</h3>
            <!-- <p class="col-md-8 fs-4">Using a series of utilities, you can create this jumbotron, just like the one in
                previous versions of Bootstrap. Check out the examples below for how you can remix and restyle it to
                your liking.</p> -->
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="row my-2">
        <div class="col-10 offset-1 p-2 py-5">
            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the
                industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and
                scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap
                into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the
                release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing
                software like Aldus PageMaker including versions of Lorem Ipsum.</p>
        </div>
    </div>
</div>
@endsection
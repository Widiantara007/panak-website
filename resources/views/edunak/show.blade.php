@extends('layouts.app')
@section('title','Pasar Ternak Indonesia')
@section('content')
@php
use Carbon\Carbon;
Carbon::setLocale('id');
@endphp
<div class="container py-5">
    <div class="row">
        <div class="col-sm-8 offset-sm-2 col-12">
            <h3 class="display-5 my-3">{{$article->title}}</h3>
            <p class="card-text mb-3"><small class="text-muted"><a href="{{route('edunak', ['category'=>$article->category->category])}}">{{$article->category->category}} </a> | {{ Carbon::parse($article->created_at)->isoFormat('D MMMM Y')}}</small></p>
            <img src="{{asset('storage/images/edunak/articles/'.$article->cover_image)}}" class="img-fluid" alt="..."
                style="max-height:300px; object-fit:cover; width:100%;">

                <div class="text-artikel mt-3">{!!$article->content!!}</div>
                <div class="mt-5 d-flex justify-content-start">
                    <h6 class="me-2">Tags</h6>
                    @foreach ($article->tags as $tag)
                    <a href="{{route('edunak', ['tag'=>$tag])}}" class="me-1"><span class="badge bg-secondary ">{{$tag}}</span></a>
                    @endforeach
                </div>
        </div>
    </div>
</div>
@endsection
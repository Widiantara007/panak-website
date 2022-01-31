@extends('layouts.app')
@section('title','Pasar Ternak Indonesia')
@push('css')
<style>
    .tab-slider {
        padding: 0px 15px 0px 0px;
    }

    @media only screen and (min-width: 540px) and (max-width: 768px) {
        .card-img-top {
            width: 100%;
            height: 30vw !important;
            object-fit: cover;
        }
    }

    @media only screen and (min-width: 500px) and (max-width: 768px) {
        .tab-slider .btn-icon {
            top: 73px !important;
        }
    }

    @media only screen and (max-width: 499px) {
        .tab-slider .btn-icon {
            top: 70px !important;
        }
    }

    .tab-slider .btn-icon {
        position: absolute;
        top: 80px;
    }

    #goPrev {
        left: 0;
    }

    #goNext {
        right: 0;
    }

    .wrap {
        overflow: hidden;
        position: relative;
        white-space: nowrap;
        width: 100%;
        /* background: #dad9d9; */
        font-size: 0;
    }



    .wrap>.nav-kategori {
        display: inline-block;
        padding: 0;
        margin: 0;
        position: relative;
        top: 0;
        left: 0;
    }

    .wrap>.nav-kategori>li {
        background: #fff;
        display: inline-block;
        position: relative;
        white-space: normal;
        float: none;
        font-size: 14px;
    }

    .nav-kategori>li>a {
        margin-right: 0;
        border-radius: 0;
    }

    .page-item.active .page-link {
        background-color: #7e0051 !important;
        border-color: #7e0051 !important;
        color: white !important;
    }

    .page-link {
        color: #7e0051 !important;
    }

    .btn:focus {
        outline: none !important;
        box-shadow: none !important;
        ;
    }

</style>
@endpush
@section('content')
@php
use Carbon\Carbon;
Carbon::setLocale('id');
@endphp
<div class="container py-5">
    <div class="card">
        <div class="row">
            <div class="col">
                <h2 class="ps-3 pt-3 text-muted">Edunak
                    @if (!empty(Request::get('tag')))
                    - {{Request::get('tag')}}
                        
                    @endif
                    
                </h6>
            </div>
        </div>

        <div class="card-body">
            <div class="card-header bg-white border-0 p-0 pb-3 ps-2">
                <div class="tab-slider">
                    <div class="wrap border-0">
                        <ul class="nav nav-kategori border-0" id="menus" role="tablist">
                            <li><a href="{{route('edunak')}}" class="nav-link @empty(Request::get('category')) active @endempty text-dark text-menu-portofolio" >All</a></li>
                            @foreach ($categories as $category)

                            <li> <a href="{{route('edunak', ['category'=>$category->category])}}" class="nav-link @if(Request::get('category')==$category->category) active @endif text-dark text-menu-portofolio">{{$category->category}}</a></li>
                            @endforeach

                        </ul>
                    </div>
                    <button id="goPrev" class="btn btn-icon"><i class="fas fa-chevron-left"></i></button>
                    <button id="goNext" class="btn btn-icon"><i class="fas fa-chevron-right"></i></i></button>
                </div>

            </div>
            <div class="tab-content" id="nav-tabContent">
                <!-- Tab All pertama -->
                <div class="tab-pane fade show active" id="nav-All" role="tabpanel" aria-labelledby="nav-All-tab">
                    @foreach ($articles as $article)
                    <div class="row g-0 ps-2">
                        <div class="col-md-3">
                            <a href="{{route('edunak.show', $article->slug)}}"><img
                                    src="{{asset('storage/images/edunak/articles/'.$article->cover_image)}}"
                                    class="img-fluid rounded-start card-img-top" alt="..."></a>
                        </div>
                        <div class="col-md-6 my-auto">
                            <div class="card-body">
                                <h3 class="card-text"><a
                                        href="{{route('edunak.show', $article->slug)}}">{{$article->title}}</a></h3>
                                <p class="card-text"><small class="text-muted"><a
                                            href="{{route('edunak', ['category'=>$article->category->category])}}">{{$article->category->category}}
                                        </a> | {{ Carbon::parse($article->created_at)->isoFormat('D MMMM Y')}}</small>
                                </p>
                            </div>
                        </div>
                        <div class="col-md-3 my-auto text-md-center">
                            @foreach ($article->tags as $tag)
                            <a href="{{route('edunak', ['tag'=>$tag])}}"><span
                                    class="badge bg-secondary ">{{$tag}}</span></a>
                            @endforeach
                        </div>
                        <hr class="my-3">
                    </div>
                    @endforeach

                </div>
                

            </div>
            <nav aria-label="...">
                {{ $articles->appends(['category'=>Request::get('category'), 'tag'=>Request::get('tag')])->links('edunak.pagination') }}
            </nav>
        </div>

    </div>
</div>
@endsection
@push('js')
<script>
    var menus = $("#menus"),
        menuWidth = menus.parent().outerWidth();
    var menupage = Math.ceil(menus[0].scrollWidth / menuWidth),
        currPage = 1;
    if (menupage > 1) {
        $("#goNext").click(function () {
            currPage < menupage && menus.stop(true).animate({
                "left": -menuWidth * currPage
            }, "slow") && currPage++
        });
        $("#goPrev").click(function () {
            currPage > 1 && menus.stop(true).animate({
                "left": -menuWidth * (currPage - 2)
            }, "slow") && currPage--;
        });
        $(window).on("resize", function () {
            menuWidth = menus.parent().outerWidth();
            menupage = Math.ceil(menus[0].scrollWidth / menuWidth);
            currPage = Math.ceil(-parseInt(menus.css("left")) / menuWidth) + 1;
        });
    }

</script>
@endpush

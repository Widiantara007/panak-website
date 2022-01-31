@extends('layouts.app')
@section('title','Pasarnak')
@section('content')
@php
use Carbon\Carbon;
@endphp
<div class="container">
    <div class="row py-2">
        <div class="col">
            <form action="{{ route('pasarnak') }}">
                <div class="input-group rounded shadow">
                    <input type="search" class="form-control rounded" name="search" value="{{ Request::get('search') ?? '' }}" placeholder="Search" aria-label="Search"
                        list="datalistOptions" id="exampleDataList" aria-describedby="search-addon" />
                    <datalist id="datalistOptions">
                        @foreach ($products_all as $p)
                        <option value="{{$p}}">
                            @endforeach
                    </datalist>
                    <span class="input-group-text border-0" id="search-addon">
                        <button type="submit" class="btn">
                            <i class="fas fa-search" type="submit"></i>
                        </button>
                    </span>
                </div>
            </form>
        </div>
    </div>
    <div class="row d-flex justify-content-center pt-2">
        {{-- <div class="col-lg-3 pt-2">
            <div class="sticky-top" id="sticky-sidebar">
                <div class="card shadow">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="pt-2">Filter</h5>
                            <i class="fas fa-angle-down" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseExample" aria-expanded="true"
                                aria-controls="collapseExample"></i>
                        </div>
                        <form action="{{ route('investnak') }}">
                            @php
                            $category = Request::get('category');
                            @endphp
                            <div class="collapse show" id="collapseExample">
                                <ul class="list-group list-group-flush border-bottom ">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <li class="list-group-item border-0 fw-bold">Kategori</li>
                                        <i class="fas fa-angle-right" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseExample2" aria-expanded="true"
                                            aria-controls="collapseExample2"></i>
                                    </div>
                                    <div class="collapse show" id="collapseExample2">
                                        @foreach ($project_types as $project_type)
                                        <li class="list-group-item border-0">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    value="{{ $project_type->name }}"
                                                    id="category{{ $project_type->id }}" name="category[]"
                                                    {{ !empty($category) ? (in_array($project_type->name, $category) ? 'checked':''):'checked' }}>
                                                <label class="form-check-label" for="category{{ $project_type->id }}">
                                                    {{ $project_type->name }}
                                                </label>
                                            </div>
                                        </li>
                                        @endforeach

                                    </div>
                                </ul>

                                <ul class="list-group list-group-flush border-bottom">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <li class="list-group-item border-0 fw-bold">ROI Minimal</li>
                                        <i class="fas fa-angle-right" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseExample4" aria-expanded="true"
                                            aria-controls="collapseExample4"></i>
                                    </div>
                                    <div class="collapse show" id="collapseExample4">
                                        <li class="list-group-item border-0">
                                            <div class="input-group mb-3">
                                                <span class="input-group-text" id="hargaMinimum">Rp</span>
                                                <input type="text" class="form-control" placeholder="Harga Minimum"
                                                    aria-label="Username" value="" aria-describedby="hargaMinimum">
                                            </div>
                                            <div class="input-group mb-3">
                                                <span class="input-group-text" id="hargaMaksimum">Rp</span>
                                                <input type="text" class="form-control" placeholder="Harga Maksimum"
                                                    aria-label="Username" value="" aria-describedby="hargaMaksimum">
                                            </div>
                                        </li>

                                    </div>
                                </ul>
                                <ul class="list-group list-group-flush mt-3">
                                    <div class="d-flex justify-content-end align-items-center">
                                        <button type="submit" class="btn btn-default">Terapkan</button>
                                    </div>
                                </ul>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div> --}}
        <div class="col-lg-10 pt-2">
            <div class="row d-flex justify-content-start">
            @foreach ($products as $product)
               
            <div class="col-lg-3 col-md-6 col-6 mb-4">
                <div class="card rounded border-0 h-100" id="card-hover-special">
                    <div class="card border-0">
                        <div class="{{ $product->isOutOfStock() ? 'bg-image' : '' }}">
                            <img class="card-img-top" src="{{asset('storage/images/products/'.$product->image)}}" alt="Card image cap" loading="lazy">
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
                        <p class="text-muted text-pendanaan mb-1"><del> Rp {{number_format($product->price,0,",",".")}}</del><span class="badge bg-success">
                                {{$product->discount}}% Off</span></p>
                        <p class="card-title text-harga">Rp {{number_format($product->price_after_discount(),0,",",".")}} / {{$product->unit}}</p>
                        @else
                        <p class="card-title text-harga">Rp {{number_format($product->price,0,",",".")}} / {{$product->unit}}</p>
                            
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
        </div>
    </div>
</div>

@endsection

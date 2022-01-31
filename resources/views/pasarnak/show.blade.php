@extends('layouts.app')
@section('title','Pasarnak')
@section('content')
@php
use Carbon\Carbon;
use App\Models\Address;
@endphp
<div class="container" id="container">
    <div class="row py-3">
        <div class="col-lg-4 order-last">
            <div class="sticky-top" id="sticky-sidebar">
                <div class="card shadow" style="border-radius: 30px">
                    <div class="card-body">
                        <form action="{{ route('cart.store') }}" method="POST">
                            @csrf
                        <h5 class="text-center mt-4 mb-5">Atur Jumlah Pesanan</h5>
                        <div class="my-3 row">
                            <label for="count" class="col-sm-6 col-form-label">Jumlah Produk</label>
                            <div class="col-sm">
                                <input type="text" name="product_id" value="{{ $product->id }}" hidden>
                                <div class="input-group" id="input_div">
                                    <button class="btn btn-outline-secondary" type="button" id="button-addon1"
                                        onclick="minus()">-</button>
                                    <input type="number" class="form-control" id="count"
                                        aria-label="Example text with button addon" aria-describedby="button-addon1"
                                        value="1" onchange="simulation()" max="{{ $product->stock }}" name="quantity">
                                    <button class="btn btn-outline-secondary" type="button" id="button-addon1"
                                        onclick="plus()">+</button>
                                </div>
                            </div>
                        </div>
                        <div class="my-3 row d-flex align-items-center">
                            <label for="start_invest" class="col-3  col-form-label">Stok</label>
                            <div class="col-9 ">
                                <h5 class="text-end mb-0"><span id="start_invest"> {{$product->stock}}</span></h5>
                            </div>
                        </div>
                        <div class="my-3 row">
                            <label for="perkiraan_return" class="col-4 col-form-label text-nowrap">Subtotal</label>
                            <div class="col-8">
                                <h5 class="text-roi text-end"><span id="subtotal"></span></h5>
                            </div>
                        </div>
                        <div class="my-3 row">
                            <div class="col">
                                <div class="d-grid">
                                    <button class="btn btn-default mb-3" type="submit" name="action" value="cart">+ Keranjang</button>
                                    <button id="btn-pasarnak2" class="btn btn-outline-warning" type="submit" name="action" value="checkout">Beli
                                        Langsung</button>
                                </div>
                            </div>
                        </div>
                    </form>

                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-8 col-md-12" id="main">
            <div class="card mb-3 border-0">
                <div class="row g-0">
                    <div class="col-md-5">
                        <img src="{{asset('storage/images/products/'.$product->image)}}" alt="..."
                            class="img-fluid rounded card-img-top">
                    </div>
                    <div class="col-md-7">
                        <div class="card-body">
                            <h5 class=" mb-1">{{ $product->name }}</h5>
                            {{-- <p class="card-text mb-0">Minimal Beli 1 Kg</p> --}}
                            @if (!empty($product->discount))
                            <p class="text-muted mb-1"><del> Rp {{number_format($product->price,0,",",".")}} </del><span
                                    class="badge bg-success">
                                    {{$product->discount}}% Off</span></p>
                            <h5 class="text-harga">Rp {{number_format($product->price_after_discount(),0,",",".")}} /
                                {{$product->unit}}</h5>

                            @else
                            <h5 class="text-harga">Rp {{number_format($product->price,0,",",".")}} / {{$product->unit}}
                            </h5>
                            @endif
                            <p class="text-muted">Berat: {{$product->weight/1000}} kg</p>

                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <h3 class="mt-4 mb-2">Produk Detail</h3>
                        {!! $product->description !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@push('css')
<style>
    /* Chrome, Safari, Edge, Opera */
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    /* Firefox */
    input[type=number] {
        -moz-appearance: textfield;
        text-align: center;
    }

</style>
@endpush
@push('js')
<script>
    var countEl = document.getElementById("count");
    let subtotalEl = document.getElementById("subtotal");
    let harga_produk = {{$product->price_after_discount()}};

    //number format
    let nf = new Intl.NumberFormat('id-ID', {
        style: 'currency',
        'currency': 'IDR',
        maximumSignificantDigits: 3
    });

    function plus() {
        let count = countEl.value;

        if(count < {{$product->stock}}){
        countEl.value = ++count;
        simulation();
        }
    }

    function minus() {
        let count = countEl.value;

        if (count > 1) {
            countEl.value = --count;
            simulation();
        }
    }

    function simulation() {
        let jumlah_produk = countEl.value;
        let subtotal = jumlah_produk * harga_produk;
        console.log(subtotal);

        subtotalEl.innerHTML = nf.format(subtotal);
    }

    simulation();

</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"
    integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
@endpush

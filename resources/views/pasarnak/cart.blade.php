@extends('layouts.app')
@section('title','Keranjang')
@section('content')
<div class="container" id="container">
    <div class="row py-3">
        <div class="col-md-4 order-last">
            <div class="sticky-top" id="sticky-sidebar">
                <div class="card shadow" style="border-radius: 30px">
                    <div class="card-body">
                        <h5 class="my-2">Ringkasan Belanja</h5>
                        <div class="my-2 row d-flex align-items-center">
                            <label for="count" class="col-6 col-form-label text-muted">Total Harga
                                <br>({{$carts->count()}} barang)</label>
                            <div class="col-6">
                                <span id="total_harga" class="text-muted float-end cart-text-ringkasan"></span>
                            </div>
                        </div>
                        <hr>
                        <div class="my-1 row d-flex align-items-center">
                            <h6 class="col-6 mb-0 fw-bold">Subtotal</h6>
                            <div class="col-6">
                                <h6 class="mb-0 fw-bold float-end cart-text-ringkasan"><span id="subtotal"></span></h6>
                            </div>
                        </div>
                        <hr>
                        <div class="my-2 row">
                            <div class="col">
                                <div class="d-grid">
                                    
                                    <button class="btn btn-default mb-2" type="button" onclick="event.preventDefault();
                                    document.getElementById('checkout-form').submit();">Checkout</button>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <h4 class="py-3">Keranjang</h4>
        </div>
        <div class="col-md-8 ">
            <div class="col-md-12 col-md-6" id="main">
                <div class="card mb-3 border-0">
                    @if ($carts == '[]')
                        {{-- Tampilan jika kosong --}}
                        
                    @else
                        
                    <form action="{{route('checkout.process')}}" method="POST" id="checkout-form">
                        @csrf
                        <input type="text" name="from" value="cart" hidden>
                    @foreach ($carts as $cart)
                    <div class="row my-2">
                        <div class="col-md-3 pt-3">
                            <img src="{{asset('storage/images/products/'.$cart->product->image)}}" alt="..."
                                class="rounded cover-img-keranjang">
                        </div>
                        <div class="col-md-9 pt-3">
                            <div class="d-flex ">
                                <h5 class=" mb-3">{{$cart->product->name}}</h5>
                            </div>
                            <h5 class="text-harga">Rp. <span class="harga_produk"
                                    id="harga_produk">{{$cart->product->price_after_discount()}}</span> <span
                                    id="satuan_produk">/ {{ $cart->product->unit }}</span></h5>
                            <p>Stok: {{ $cart->product->stock }}</p>
                            <div class="row d-flex justify-content-between align-items-center">
                                <div class="col-6 col-md-7 col-lg-8" style="color:gray !important;">
                                        <a href="{{ route('cart.destroy', $cart->id) }}" style="text-decoration: none;color:gray !important;"
                                            class="btn btn-link card-link-secondary small text-uppercase mr-3 mt-3"><i
                                                class="fas fa-trash-alt mr-1 "></i> Remove item </a>
                                </div>
                                <div class="col-md-5 col-6">
                                    <input type="text" name="cart_id[]" value="{{$cart->id}}" hidden>
                                    @if ($cart->product->isOutOfStock())
                                    <h5 class="text-muted mb-0">Stock Habis</h5>
                                    <input type="number" class="quantity" value="0" name="quantity[]" hidden>
                                    <span class="d-none stock">0</span>
                                    @else
                                    <div class="input-group" id="input_div">
                                        <button class="btn btn-outline-secondary minus" type="button"
                                        id="button-addon1">-</button>
                                        <input type="number" class="form-control quantity" id="count"
                                        aria-label="Example text with button addon" aria-describedby="button-addon1"
                                        value="{{$cart->quantity}}" min="1" max="{{$cart->product->stock}}" name="quantity[]" onchange="simulation()">
                                        <button class="btn btn-outline-secondary plus" type="button"
                                        id="button-addon1">+</button>
                                    </div>
                                    <span class="d-none stock">{{$cart->product->stock}}</span>
                                    @endif

                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    @endforeach
                </form>
                @endif


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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"
    integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

<script>
    let harga_produkEl = document.getElementsByClassName("harga_produk");
    let quantityEl = document.getElementsByClassName("quantity");
    let total_hargaEl = document.getElementById("total_harga");
    let subtotalEl = document.getElementById("subtotal");
    let stockEl = document.getElementsByClassName("stock");


    //number format
    let nf = new Intl.NumberFormat('id-ID', {
        style: 'currency',
        'currency': 'IDR',
        maximumSignificantDigits: 3
    });

    function simulation() {
        let jumlah_produk = harga_produkEl.length;
        let subtotal = 0;
        
        //cek max min
        for (let j = 0; j < jumlah_produk; j++) {
            if(quantityEl[j].value < 1){
                quantityEl[j].value = 1;
            }

            if(quantityEl[j].value > parseInt(stockEl[j].innerHTML)){
                quantityEl[j].value = parseInt(stockEl[j].innerHTML);
            }
            
        }

        for (let i = 0; i < jumlah_produk; i++) {
            let harga_produk = parseInt(harga_produkEl[i].innerHTML);
            let quantity = parseInt(quantityEl[i].value);

            let total_harga = harga_produk * quantity;
            subtotal += total_harga;
        }

        total_hargaEl.innerHTML = nf.format(subtotal);
        subtotalEl.innerHTML = nf.format(subtotal);

    }
    simulation();

    $('.plus').click(function () {
        let stock = parseInt($(this).prev().attr("max"));
        console.log(stock)
        if($(this).prev().val() < stock) $(this).prev().val(+$(this).prev().val() + 1);
        simulation();
    });
    $('.minus').click(function () {
        if ($(this).next().val() > 1) $(this).next().val(+$(this).next().val() - 1);
        simulation();
    });

</script>



@endpush

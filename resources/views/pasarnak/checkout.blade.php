@extends('layouts.app')
@section('title','Checkout')
@section('content')
@php
use Carbon\Carbon;
use App\Models\Address;
@endphp
<div class="container" id="container">
    <div class="row py-3">
        <div class="col-lg-3 order-last">
            <div class="sticky-top" id="sticky-sidebar">
                <div class="card shadow" style="border-radius: 30px">
                    <div class="card-body">
                        <h5 class="mt-4">Ringkasan Belanja</h5>
                        <div class="my-2 row d-flex align-items-center">
                            <label for="count" class="col-5 col-form-label text-muted">Total Harga</label>
                            <div class="col-7">
                                <p class="mb-0 text-muted text-end float-md-end float-lg-none"><span id="total_harga"
                                        class=""></span></p>
                            </div>
                        </div>
                        <div class="row d-flex align-items-center">
                            <label for="start_invest" class="col-7 text-muted col-form-label">Total Ongkos
                                Kirim</label>
                            <div class="col-5 text-end">
                                <div class="text-muted text-end float-md-end float-lg-none">Rp<span
                                        id="ongkir">{{$ongkir}}</span></div>
                            </div>
                        </div>
                        <hr>
                        <div class="my-1 row d-flex align-items-center">
                            <h6 class="col-5 mb-0">Subtotal</h6>
                            <div class="col-7 text-end">
                                <h6 class="text-roi mb-0"><span id="subtotal"
                                        class="text-end float-md-end float-lg-none"></span></h6>
                            </div>
                        </div>
                        <hr>
                        <div class="my-2 row">
                            <div class="col">
                                <div class="d-grid">
                                    @if (empty($chosenAddress))
                                    <button class="btn btn-default mb-2" id="bayar" type="button"
                                        onclick="alert('Pilih Alamat terlebih dahulu')">Bayar</button>
                                    @else
                                    <button class="btn btn-default mb-2" id="bayar" type="submit" data-bs-toggle="modal"
                                        data-bs-target="#ModalBayar">Bayar</button>
                                    @endif

                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12">
            <h4>Beli Sekarang</h4>
        </div>
        <div class="col-lg-9">
            <div class="card mb-3 p-2">
                <div class="row d-flex justify-content-between align-items-center px-2">
                    @if (empty($chosenAddress))
                    <div class="col-sm-6">
                        <p class="mb-2">Pilih Alamat Pengiriman</p>
                    </div>
                    <div class="col-sm-6 d-grid d-sm-block"><button class="btn btn-default float-sm-end" data-bs-toggle="modal"
                            data-bs-target="#modalPilihAlamat">Pilih Alamat</button></div>
                    @else

                    <div class="col-sm-6">
                        <h6>
                            {{$chosenAddress->label}}
                        </h6>
                        <p>{{$chosenAddress->address_detail}}
                            <br>{{ Address::getFullAddress($chosenAddress->location_code) }} <br>
                            {{$chosenAddress->postal_code}}</p>
                        <p class="text-muted">{{$chosenAddress->no_hp}}</p>
                    </div>

                    <div class="col-sm-6 d-grid d-sm-block"><button class="btn btn-default float-sm-end" data-bs-toggle="modal"
                            data-bs-target="#modalPilihAlamat">Ubah Alamat</button></div>
                    @endif


                </div>

            </div>
            <div class="col-lg-12">
                <h6 class="mb-2">Barang yang dibeli</h6>
            </div>
            @foreach($products as $product)

            <div class="col-lg-9 col-md-12" id="main">
                <div class="card mb-3 border-0">
                    <div class="row g-0">
                        <div class="col-md-3">
                            <img src="{{asset('storage/images/products/'.$product['image'])}}" alt="..."
                                class="rounded cover-img-keranjang">
                        </div>
                        <div class="col-md-7">
                            <div class="card-body">
                                <h6 class=" mb-1">{{$product['name']}}</h6>
                                <h5 class="text-harga">Rp. <span class="harga_produk">{{$product['price']}}</span></h5>
                                <div class="col-sm-6">
                                    <p>Quantity: <span class="quantity">{{$product['quantity']}}</span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @endforeach

        </div>
    </div>
    <!-- Modal pilih alamat -->
    <div class="modal fade" id="modalPilihAlamat" tabindex="-1" aria-labelledby="modalPilihAlamatLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content bg-light">
                <div class="modal-body">
                    <form>
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Pilih Alamat</h5>
                            <button class=" btn btn-outline-default" data-bs-toggle="modal"
                                data-bs-target="#modalTambahAlamatInside" data-bs-dismiss="modal">Tambah Alamat</button>
                        </div>
                        @if ($addresses == '[]')
                        <div class="container-fluid" style="height:200px;">
                            <div class="row card mt-3 h-100">
                                <div class="col-sm-12 my-auto text-center">
                                    <i class="far fa-map text-muted"></i>
                                    <p class="text-muted">Belum Ada Alamat yang terdaftar</p>
                                    <button class="btn btn-default" data-bs-toggle="modal"
                                        data-bs-target="#modalTambahAlamatInside" data-bs-dismiss="modal">+ Tambah
                                        Alamat</button>
                                </div>
                            </div>
                        </div>
                        @else
                        @foreach ($addresses as $address)
                        <div class="card my-3">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-1 pe-0">
                                        <i class="fas fa-map-marker-alt"></i>
                                    </div>
                                    <div class="col-8 pe-0">
                                        <h6>
                                            {{$address->label}}
                                        </h6>
                                        <p>{{$address->address_detail}}
                                            <br>{{ Address::getFullAddress($address->location_code) }} <br>
                                            {{$address->postal_code}} <br><br>{{$address->no_hp}}</p>
                                        <p class="text-muted">
                                            <button class="btn btn-sm btn-outline-default mb-2"><i
                                                    class="fas fa-edit"></i></button>
                                            <button class="btn btn-sm btn-default mb-2"><i
                                                    class="fas fa-trash-alt mr-1 "></i></button>
                                    </div>
                                    <div class="col-3 px-0 ">
                                        <a href="{{request()->fullUrlWithQuery(['address' => $address->id])}}"
                                            class="btn btn-sm btn-default float-end float-lg-none float-md-none float-sm-none ">Pilih
                                            Alamat</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Form Alamat-->
    <div class="modal fade" id="modalTambahAlamatInside">
        <div class="modal-dialog  modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <a type="button" data-bs-toggle="modal" data-bs-target="#modalPilihAlamat" data-bs-dismiss="modal">
                        <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-chevron-left me-2"></i>Tambah
                            Alamat</h5>
                    </a>
                </div>
                <form action="{{route('user.storeAddress')}}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group col-md-12 mb-3">
                                <label for="recipient_name" class="fw-bold">Label</label>
                                <input type="text" class="form-control" name="label" id="label" placeholder="ex: Rumah"
                                    value="{{old('label') }}" required>
                            </div>
                            <label class="mb-2 fw-bold">Informasi Penerima</label>
                            <div class="form-group col-md-8">
                                <label for="recipient_name">Nama Penerima</label>
                                <input type="text" class="form-control" name="recipient_name" id="recipient_name"
                                    placeholder="ex: Bambang Sujanarko" value="{{old('recipient_name') }}" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="no_hp">No HP</label>
                                <input type="number" class="form-control" name="no_hp" id="no_hp"
                                    placeholder="ex: 081234567890" value="{{old('no_hp') }}" required>
                            </div>
                        </div>
                        <label class="my-3 fw-bold">Alamat</label>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="province">Provinsi</label>
                                <select class="form-control" id="province" name="province">
                                    <option value="0" selected disabled>Pilih Provinsi</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="district">Kabupaten/Kota</label>
                                <select class="form-control" id="district" name="district">
                                    <option value="0" selected disabled>Pilih Kabupaten/Kota</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="form-group col-md-6">
                                <label for="sub-district">Kecamatan</label>
                                <select class="form-control" id="sub-district" name="sub-district">
                                    <option value="0" selected disabled>Pilih Kecamatan</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="village">Kelurahan/Desa</label>
                                <select class="form-control" id="village" name="village" required>
                                    <option value="0" selected disabled>Pilih Kelurahan/Desa</option>
                                </select>
                            </div>
                        </div>


                        <div class="form-group col-md-12 mt-2">
                            <label for="address_detail">Detail Alamat</label>
                            <textarea class="form-control" id="address_detail" name="address_detail" rows="3"
                                maxlength="190" required>{{old('address_detail')}}</textarea>
                        </div>
                        <div class="form-group col-md-4 mt-2">
                            <label for="postal_code">Kode Pos</label>
                            <input type="number" class="form-control" name="postal_code" id="postal_code"
                                placeholder="ex: 40257" value="{{old('postal_code') }}" required>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-default">Save changes</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
    <!-- End Of Form Alamat -->
    <!-- Modal Wallet -->
    <div class="modal fade" id="ModalBayar" tabindex="-1" aria-labelledby="modalTopUpSaldoLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header pb-0 border-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <h5 class="modal-title mx-auto text-harga" id="ModalDetailTransaksiInvestnakLabel">
                    Pembayaran</h5>
                <div class="modal-body">
                    <nav class="">
                        <ul class="nav mb-3 d-flex align-items-start" id="nav-tab" role="tablist">
                            <li class="topup-li"><button
                                    class="nav-link active border-0 bg-white text-dark text-menu-portofolio m-0  "
                                    id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button"
                                    role="tab" aria-controls="nav-home" aria-selected="true">
                                    <span class="bs-stepper-circle ">1</span><br>
                                    <span class="bs-stepper-label">Nominal</span>
                                </button></li>
                            <div class="modal-line-header"></div>
                            <li class="topup-li"><button
                                    class="nav-link border-0 bg-white text-dark text-menu-portofolio m-0 "
                                    id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile"
                                    type="button" role="tab" aria-controls="nav-profile" aria-selected="false">
                                    <span class="bs-stepper-circle ">2</span><br>
                                    <span class="bs-stepper-label ">
                                        <div class="text-wrap" style="width: 7rem;">
                                            Metode Pembayaran
                                        </div>
                                        </pan>
                                </button></li>
                            <div class="modal-line-header"></div>
                            <li class="topup-li"><button
                                    class="nav-link border-0 bg-white text-dark text-menu-portofolio m-0 "
                                    id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact"
                                    type="button" role="tab" aria-controls="nav-contact" aria-selected="false">
                                    <span class="bs-stepper-circle">3</span><br>
                                    <span class="bs-stepper-label">Konfirmasi</span>
                                </button>
                            </li>
                        </ul>
                    </nav>
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-home" role="tabpanel"
                            aria-labelledby="nav-home-tab">
                            <div class="container-fluid my-3">
                                <label for="nominal-topup" class="form-label">Nominal</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text">Rp.</span>
                                    <input type="text" class="form-control" placeholder="100.000" id="nominal-topup"
                                        aria-label="Username" aria-describedby="nominal-topup" readonly>
                                </div>
                                <a class="btn btn-default btnNext float-end">Next ></a>
                                <!-- <a class="btn btn-primary btnPrevious">Previous</a> -->
                            </div>
                        </div>
                        <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                            <div class="container-fluid">
                                @include('payment.payment-method')
                                <a class="btn btn-default btnNext float-end">Next ></a>
                                <a class="btn btn-outline-default btnPrevious">
                                    < Previous</a>
                            </div>

                        </div>
                        <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
                            <div class="container my-4">
                                <div class="card p-3">
                                    <h6>Nominal: </h6>
                                    <span class="fw-bold fs-5" id="checkout-nominal"></span>
                                    <hr>
                                    <h6>Metode Pembayaran </h6>
                                    <span class="fw-bold fs-5" id="checkout-method"></span>
                                </div>
                            </div>

                            <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> -->
                            <!-- <button type="submit" class="btn btn-default d-grid">Top Up</button> -->
                            <form action="{{ route('pay.pasarnak') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @if (!empty($chosenAddress))
                                <input type="text" name="address_id" value="{{$chosenAddress->id}}" hidden>
                                @endif
                                @foreach ($products as $product)
                                <input type="text" name="product_id[]" value="{{$product['id']}}" hidden>
                                <input type="text" name="quantity[]" value="{{$product['quantity']}}" hidden>
                                @endforeach
                                <input type="text" name="from" value="{{Request::get('from')}}" hidden>
                                <input type="text" value="" name="payment_method" hidden>
                                <button class="btn btn-default btnNext float-end" type="submit" id="text-laststep-paymentmethod">Bayar </button>
                            </form>
                            <a class="btn btn-outline-default btnPrevious">
                                < Previous</a>

                        </div>
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
let harga_produkEl = document.getElementsByClassName("harga_produk");
let quantityEl = document.getElementsByClassName("quantity");
let total_hargaEl = document.getElementById("total_harga");
let subtotalEl = document.getElementById("subtotal");
let ongkir = parseInt(document.getElementById("ongkir").innerHTML);
let value_nominal = document.getElementById('nominal-topup');
let checkout_nominal = document.getElementById('checkout-nominal')
//number format
let nf = new Intl.NumberFormat('id-ID', {
    style: 'currency',
    'currency': 'IDR',
});

function simulation() {
    let jumlah_produk = harga_produkEl.length;
    let subtotal = 0;

    for (let i = 0; i < jumlah_produk; i++) {
        let harga_produk = parseInt(harga_produkEl[i].innerHTML);
        let quantity = parseInt(quantityEl[i].innerHTML);

        let total_harga = harga_produk * quantity;
        subtotal += total_harga;
    }

    total_hargaEl.innerHTML = nf.format(subtotal);
    subtotalEl.innerHTML = nf.format(subtotal + ongkir);
    setNominal(subtotal + ongkir);
}

function setNominal(nominal) {
    let value_nominal = $("#nominal-topup").val(nominal);

    // input nominal uang ke span checkout
    $("#checkout-nominal").text(nf.format($(
        value_nominal).val()));

}
simulation();
</script>
<script>
$('#bayar').click(function() {
    let baten = $('#nav-profile-tab').click();

});
$('.btnNext').click(function() {
    let baten = $('#nav-tab > .topup-li > .active').parent().next().next('li').find('button').click();

});
$('.btnPrevious').click(function() {
    let baten = $('#nav-tab > .topup-li > .active').parent().prev().prev('li').find('button').click();

});
</script>
<script>
// input method paymend ke span checkout
// $(document).ready(function() {
//     $('.accordion-button').click(function() {
//         let id_selet_method= $(this).closest('h2').next().children().find('select').attr('id');
//         let id_selet_method_value= $(this).closest('h2').next().children().find('select').val();
//         // console.log(id_selet_method);
        // console.log(id_selet_method_value);
        
    // $("#checkout-method").text(id_selet_method_value);
      
    // $('#' +id_selet_method).change(function(event) {
    //     let eaea= $(this).attr('id');
    //     // console.log(eaea);
    //     $("#checkout-method").text($(this).val());
    // });
    $(document).ready(function() {
    $('.card-input-element').click(function() {
        let radioValue = $("input[name='payment-method']:checked").val();
        $('input[name="payment_method"]').val(radioValue); 
    $("#checkout-method").text(radioValue);
         console.log(radioValue);

        if ($("input[name='payment-method']:checked").val() == "E-Money, Tranfer Bank, Dan Lain Lain"){
            let test123 = $("#text-laststep-paymentmethod").html("Pilih Pembayaran");
            console.log(test123);
        }else{
            let test123 = $("#text-laststep-paymentmethod").html("Bayar");
            console.log(test123);
        }
});
});
// restrict next dan disable button, jika belum isi nominal
$(document).ready(function() {
    $('#nav-profile-tab').attr('disabled', true);
    $('#nav-profile-tab').click(function() {
        if ($('#nominal-topup').val().length === 0) {
            alert('Masukan Nominal Uang');
            $('#nav-profile-tab').attr('disabled', true);
        } else {
            $('#nav-profile-tab').attr('disabled', false);
        }
    })
});

// restrict next dan disable button, jika belum isi method payment
$(document).ready(function() {
    $('#nav-contact-tab').attr('disabled', true);
    $('#nav-contact-tab').click(function() {
        if ($("#checkout-method").text().length == 0) {
            alert('Masukan Metode Pembayaran');
            $('#nav-contact-tab').attr('disabled', true);
            // console.log('ada value');
        }else{
            $('#nav-contact-tab').attr('disabled', false);
        }
    });
    $(".select-method").click(function() {
        if ($(".select-method ").children("option:selected").val()) {
            $('input[name="payment_method"]').val($("#checkout-method").text());
            // alert('Masukan Method Pembayaran');
            $('#nav-contact-tab').attr('disabled', false);
            // console.log('ada value');
        } else {
            $('#nav-contact-tab').attr('disabled', true);
            alert('Masukan Method Pembayaran');
            // console.log('tida ada value');
        }
    });
});
</script>

{{-- Script region existing --}}
@include('admin.plugins.set-existing-region')
@if ( !empty(old('village')) )
<script>
set_region("{{ old('village')  }}");
</script>
@else
<script>
get_province();
</script>
@endif


{{-- Script Get Region --}}
@include('admin.plugins.get-region')


@endpush
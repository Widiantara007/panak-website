@extends('layouts.app')
@section('title','Bisnak')
@section('content')
@php
use Carbon\Carbon;
Carbon::setLocale('id');
use App\Models\Address;
@endphp
<div class="container" id="container">
    @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
    <div class="row py-3">
        <div class="col-lg-8 col-md-12" id="main">
            <div class="card mb-3 border-0">
                <div class="row g-0">
                    <div class="col-md-5">
                        <img src="{{asset('storage/images/projects/'.$project_batch->project->image)}}" alt="..."
                            class="img-fluid rounded">
                    </div>
                    <div class="col-md-7">
                        <div class="card-body">
                            <span class="badge rounded-pill bg-primary mb-2 pe-2"
                                style="background-color:#FF8200 !important"><i class="fas fa-star pe-1"
                                    style="color:white;"></i>{{$project_batch->project->risk_grade}}</span>
                            <h3 class="">{{$project_batch->project->name}} - Batch {{$project_batch->batch_no}}</h3>
                            <div class="row mt-3 mb-4">
                                <div class="col-sm-6 col-12">
                                    <p class="text-muted mb-1"><i class="fas fa-user"></i>
                                        {{$project_batch->project->project_owner->name }}
                                    </p>
                                </div>
                                <div class="col-sm-6 col-12 pe-0">
                                <p class="text-muted mb-1 text-sm-end">
                                    {{Str::title(Address::getDistrict($project_batch->project->location_code).', '.Address::getProvince($project_batch->project->location_code))}}
                                </p>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between align-items-center ">
                                <p class="float-left mb-2">Modal</p>
                                <h6 class="float-right mb-2 text-roi">ROI
                                    <span id="roi_low">{{$project_batch->roi_low}}</span> - <span id="roi_high">{{$project_batch->roi_high}}</span> %</h6>
                            </div>
                            <div class="progress my-1">
                                <div class="progress-bar"
                                    style="width:{{ $project_batch->totalPercentage() }}%;background-color:#560043;"
                                    role="progressbar" aria-valuenow="{{ $project_batch->totalPercentage() }}"
                                    aria-valuemin="0" aria-valuemax="100">{{ $project_batch->totalPercentage() }}%
                                </div>
                            </div>
                            <div class="row align-items-center ">
                                <div class="col-sm-7 col-12">
                                    <p class="text-pendanaan mt-2"><span class="text-harga">Rp
                                            {{number_format($project_batch->totalInvestments(),0,",",".")}}</span>
                                        /<span class="fw-bold"> Rp
                                            {{number_format($project_batch->target_nominal,0,",",".")}}</span></p>
                                </div>
                                <div class="col-sm-5 col-12 pe-0">
                                    <p class="text-pendanaan text-harga mt-2">Project mulai dalam
                                        {{$project_batch->daysLeft()}}
                                        hari lagi</p>
                                </div>
                            </div>

                            <h6 class="mt-2">Jangka Waktu : <span id="period">{{$project_batch->period()}}</span> bulan</h6>
                            <p>( {{Carbon::parse($project_batch->start_date)->isoFormat('D MMMM Y').' - '. Carbon::parse($project_batch->end_date)->isoFormat('D MMMM Y')}}
                                )</p>
                        </div>
                    </div>
                    <div class="col mb-2">
                        <a target="_blank" class="btn btn-outline-default mt-3"
                            href="{{asset('storage/prospektus/'.$project_batch->project->prospektus_file)}}"><i
                                class="fas fa-download"></i>
                            Download Prospektus</a>
                    </div>
                </div>

            </div>

        </div>

        @if (!$project_batch->isFullyFunded())   
        <div class="col-lg-4">
            <div class="sticky-custom" id="sticky-sidebar">
                <div class="card shadow" style="border-radius: 30px">
                    <div class="card-body">
                        <h5 class="text-center mt-4 mb-5">Simulasi Bisnis</h5>
                        @if ($project_batch->is_yearly)
                        <div class="row my-3 d-flex justify-content-between ms-1">
                            <div class="col-md-4 form-check form-check-inline">
                                <input class="form-check-input periodSelect" type="radio" name="periodSelect" id="inlineRadio1" value="once" checked >
                                <label class="form-check-label" for="inlineRadio1">Per Batch</label>
                              </div>
                              <div class="col-md-7 form-check form-check-inline">
                                <input class="form-check-input periodSelect" type="radio" name="periodSelect" id="inlineRadio2" value="yearly">
                                <label class="form-check-label" for="inlineRadio2">Per Tahun(<span id="quota"></span> Batch)</label>
                              </div>
                        </div>
                        @endif

                        <div class="my-3 row">
                            <label for="count" class="col-sm-5 col-form-label">Jumlah Lot</label>
                            <div class="col-sm">
                                <div class="input-group" id="input_div">
                                    <button class="btn btn-outline-secondary" type="button" id="button-addon1"
                                        onclick="minus()">-</button>
                                    <input type="number" class="form-control" id="count"
                                        aria-label="Example text with button addon" aria-describedby="button-addon1"
                                        value="1" onchange="simulation()">
                                    <button class="btn btn-outline-secondary" type="button" id="button-addon1"
                                        onclick="plus()">+</button>
                                </div>
                            </div>
                        </div>
                        <div class="my-3 row d-flex align-items-center">
                            <label for="start_invest" class="col-4 col-sm-6  col-form-label">Modal Awal</label>
                            <div class="col-8 col-sm-6">
                                <h6 class="text-end"><span id="start_invest">Rp 0</span></h6>
                            </div>
                        </div>
                        <div class="my-3 row d-flex align-items-center">
                            <label for="perkiraan_return" class="col-4 col-sm-5 col-form-label ">Perkiraan Return</label>
                            <div class="col-8 col-sm-7">
                                <h6 class="text-roi float-md-end text-end "><span id="return_from">Rp 0</span> - <span
                                        id="return_until">Rp
                                        0</span></h6>
                            </div>
                        </div>
                        <div class="my-3 row">
                            <div class="col">
                                <div class="d-grid">
                                    @if (Auth::check())
                                        <button type="submit" class="btn btn-default" id="bayar"
                                    data-bs-toggle="modal" data-bs-target="#ModalBayar">Mulai Bisnis</button>
                                    @else
                                        <a href="{{route('login')}}" class="btn btn-default" id="bayar">Login untuk Mulai Bisnis</a>
                                    @endif
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <div class="col-lg-8 col-md-12" style="word-wrap: break-word;">
            <h3 class="mt-4 ">Profile Pak Tani</h3>
            {!! $project_batch->project->description !!}
        </div>
        
        @if (Auth::check())
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
                                        </span>
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
                                    <a class="btn btn-default btnNext float-end">Next</a>
                                    <!-- <a class="btn btn-primary btnPrevious">Previous</a> -->
                                </div>
                            </div>
                            <div class="tab-pane fade" id="nav-profile" role="tabpanel"
                                aria-labelledby="nav-profile-tab">
                                <div class="container-fluid">
                                    @include('payment.payment-method')
                                    <a class="btn btn-default btnNext float-end">Next</a>
                                    <a class="btn btn-outline-default btnPrevious">
                                        Previous</a>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="nav-contact" role="tabpanel"
                                aria-labelledby="nav-contact-tab">
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
                                <form
                                    action="{{ route('pay.investnak', [$project_batch->project->id, $project_batch->id]) }}"
                                    method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <input type="number" value="" name="lot" hidden>
                                    <input type="number" name="quota" value="0" hidden>
                                    <input type="text" value="" name="payment_method" hidden>
                                    <button class="btn btn-default btnNext float-end" type="submit" id="text-laststep-paymentmethod">Bayar </button>
                                </form>
                                <a class="btn btn-outline-default btnPrevious">
                                    Previous</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

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

@if (!$project_batch->isFullyFunded()) 
<script>
    var countEl = document.getElementById("count");
    let investasiAwalEl = document.getElementById("start_invest");
    let returnFromEl = document.getElementById("return_from");
    let returnUntilEl = document.getElementById("return_until");
    let roi_from = parseFloat(document.getElementById("roi_low").innerText);
    let roi_until = parseFloat(document.getElementById("roi_high").innerText);
    let periodSelectEl = $("input[type=radio][name=periodSelect]");
    let periodSelectChecked = $("input[type=radio][name=periodSelect]:checked").val();
    let period = parseFloat(document.getElementById("period").innerText);
    //number format
    let nf = new Intl.NumberFormat('id-ID', {
        style: 'currency',
        'currency': 'IDR',
    });

    let countQuota = Math.floor(12/period);
    $("#quota").text(countQuota);
    periodSelectEl.click(function(){
        periodSelectChecked = $("input[type=radio][name=periodSelect]:checked").val();
        console.log(periodSelectChecked)
        simulation()
    });

    function plus() {
        let count = countEl.value;

        countEl.value = ++count;
        simulation();
    }

    function minus() {
        let count = countEl.value;

        if (count > 1) {
            countEl.value = --count;
            simulation();
        }
    }

    function simulation() {
        let lot = countEl.value;
        let start_invest = lot * 50000;
        let roi_low = roi_from;
        let roi_high = roi_until;
        if(periodSelectChecked == "yearly"){
             roi_low = roi_from*countQuota;
             roi_high = roi_until*countQuota;
        }
        console.log(roi_low);
        let return_from = (start_invest * ((100 + roi_low) / 100))
            .toFixed(0);
        let return_until = (start_invest * ((100 + roi_high) /
            100)).toFixed(0);

        investasiAwalEl.innerHTML = nf.format(start_invest);
        returnFromEl.innerHTML = nf.format(return_from);
        returnUntilEl.innerHTML = nf.format(return_until);
        setNominal(start_invest);
        if(periodSelectChecked == "yearly"){
            setPaymentForm(lot, start_invest, countQuota-1);
        }else{
            setPaymentForm(lot, start_invest);
        }
    }

    function setNominal(nominal) {
        let value_nominal = $("#nominal-topup").val(nominal);

        // input nominal uang ke span checkout
        $("#checkout-nominal").text(nf.format($(
            value_nominal).val()));
    }

    function setPaymentForm(lot, nominal, quota=0)
    {
        $('input[name="lot"]').val(lot); 
        $('input[name="quota"]').val(quota); 
    }

    simulation();
</script>
<script>
    function sticky_relocate() {
        var window_top = $(window).scrollTop();
        var footer_top = $("#footer").offset().top;
        var div_top = $('#container').offset().top + $('#container')
            .height();
        var div_height = $("#sticky-sidebar").height();

        var padding = 60;

        if (window_top + div_height > footer_top - padding) {
            $('#sticky-sidebar').css({
                top: (window_top + div_height - footer_top +
                    padding) * -1
            });
        } else if (window_top > div_top) {
            $('#sticky-sidebar').addClass('stick');
            $('#sticky-sidebar').css({
                top: 70
            });
        } else {
            $('#sticky-sidebar').removeClass('stick');
            $('#sticky-sidebar').css({
                top: 70
            });

        }
    }
    $(function() {
        $(window).scroll(sticky_relocate);
        sticky_relocate();
    });
</script>

<script>
    $('#bayar').click(function() {
        let baten = $('#nav-profile-tab').click();

    });
    $('.btnNext').click(function() {
        let baten = $('#nav-tab > .topup-li > .active')
            .parent().next().next('li').find('button')
            .click();

    });
    $('.btnPrevious').click(function() {
        let baten = $('#nav-tab > .topup-li > .active')
            .parent().prev().prev('li').find('button')
            .click();

    });
</script>
<script>
    let currency = new Intl.NumberFormat('id-ID', {
        style: 'currency',
        'currency': 'IDR',
        maximumSignificantDigits: 3
    });

    // input method paymend ke span checkout

    // $(document).ready(function() {
    // $('.accordion-button').click(function() {
    //     let id_selet_method= $(this).closest('h2').next().children().find('select').attr('id');
    //     let id_selet_method_value= $(this).closest('h2').next().children().find('select').val();
    //     // console.log(id_selet_method);
    // $("#checkout-method").text(id_selet_method_value);

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
    // $('#' +id_selet_method).change(function(event) {
    //     let eaea= $(this).attr('id');
    //     // console.log(eaea);
    //     $("#checkout-method").text($(this).val());
    // });
    
});
});


    // restrict next dan disable button, jika belum isi nominal
    $(document).ready(function() {
        $('#nav-profile-tab').attr('disabled', true);
        $('#nav-profile-tab').click(function() {
            if ($('#nominal-topup').val().length ===
                0) {
                alert('Masukan Nominal Uang');
                $('#nav-profile-tab').attr(
                    'disabled', true);
            } else {
                $('#nav-profile-tab').attr(
                    'disabled', false);
            }
        })
    });

        // restrict next dan disable button, jika belum isi method payment
        $(document).ready(function() {
            $('#nav-contact-tab').attr('disabled', true);
            $('#nav-contact-tab').click(function() {
                if ($("#checkout-method").text()
                    .length == 0) {
                    alert('Masukan Metode Pembayaran');
                    $('#nav-contact-tab').attr('disabled', true);
                     // console.log('ada value');
                    }else{
                     $('#nav-contact-tab').attr('disabled', false);
                    }

            });

            $(".select-method").click(function () {
                if ($(".select-method ").children(
                        "option:selected").val()) {
                $('input[name="payment_method"]').val($("#checkout-method").text()); 
                    // alert('Masukan Method Pembayaran');
                    $('#nav-contact-tab').attr(
                        'disabled', false);
                    // console.log('ada value');
                } else {
                    $('#nav-contact-tab').attr(
                        'disabled', true);
                    alert('Masukan Method Pembayaran');
                    // console.log('tida ada value');
                }
            });
    
    });
</script>
@endif

@endpush
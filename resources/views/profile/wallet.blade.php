@extends('profile.mastermenu')
@section('title','Wallet')
@section('contentprofile')
@php
use Carbon\Carbon;
Carbon::setLocale('id');
@endphp
<div class="col pt-3">
    <h3 class="" id="menu-title">Wallet</h3>
</div>
<div class="card col my-3">
    <div class="card-body">
        <h5 class="text-harga">Saldo</h5>
        <div class="row d-flex justify-content-between align-items-center">
            <div class="col-lg-7 my-2 offset-lg-1">
                <h1 class="text-harga" id="menu-title">Rp {{ number_format($user->balance,0,",",".") }}</h1>
            </div>
            <div class="col-lg-4 d-grid">
                <button type="button" class="btn btn-default mb-2" data-bs-toggle="modal"
                    data-bs-target="#modalTopUpSaldo">
                    + Top Up Saldo
                </button>
                <div class="col d-grid">
                    <button type="button" class="btn btn-outline-default" data-bs-toggle="modal"
                        data-bs-target="#modalTarikSaldo">
                        Tarik Saldo
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="col">
    <div class="card">
        <div class="card-header bg-white border-0">
            <nav class="border-bottom">
                <div class="nav" role="tablist" id="profile">
                    <a class="nav-link active text-dark" id="nav-History-tab" data-bs-toggle="tab"
                        data-bs-target="#nav-History" type="button" role="tab" aria-controls="nav-History"
                        aria-selected="true">History</a>
                    <a class="nav-link text-dark" id="nav-Withdrawal-tab" data-bs-toggle="tab"
                        data-bs-target="#nav-Withdrawal" type="button" role="tab" aria-controls="nav-Withdrawal"
                        aria-selected="true">Pengajuan Penarikan Dana</a>
                </div>
            </nav>
        </div>
        <div class="card-body">
            <div class="tab-content" id="nav-tabContent">
                <!-- Tab History-->
                <div class="tab-pane fade show active" id="nav-History" role="tabpanel"
                    aria-labelledby="nav-History-tab">

                    @forelse ($histories as $history)
                    <div
                        class="card border-left-{{in_array($history->transaction_type, ['income','return']) ? 'success':'danger'}} shadow h-100 mb-2 rounded">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 text-muted mt-2 text-size-Portofolio-Transaksi-title">Nama
                                    Transaksi
                                    <div class="col pt-2">
                                        <h6 class="fw-bolder">
                                            @if ($history->type == 'wallet')
                                            @if ($history->transaction_type == 'income')
                                            {{ 'Top-Up Saldo' }}
                                            @else
                                            {{ 'Penarikan Dana' }}
                                            @endif
                                            @elseif($history->transaction_type == 'return')
                                            {{ 'Pembagian Hasil Bisnis' }} <br>
                                            {{ $history->project_batch->fullName() }}

                                            @endif
                                        </h6>
                                    </div>
                                </div>
                                <div class="col-md-2 text-muted mt-2 text-wrap text-size-Portofolio-Transaksi-title">
                                    Jenis
                                    <div class="col pt-2">
                                        <h6 class="fw-bolder">{{Str::title($history->transaction_type)}}</h6>
                                    </div>
                                </div>
                                <div class="col-md text-muted mt-2 text-size-Portofolio-Transaksi-title">Tanggal
                                    <div class="col pt-2 text-nowrap">
                                        <h6 class="fw-bolder">
                                            {{ Carbon::parse($history->created_at)->isoFormat('D MMMM Y')}}<br>{{Carbon::parse($history->created_at)->isoFormat('HH:mm:ss') }}
                                        </h6>
                                    </div>
                                </div>
                                <div class="col-md text-muted mt-2 text-nowrap text-size-Portofolio-Transaksi-title">
                                    Besar Dana
                                    <div class="col pt-2 ">
                                        <h6 class="fw-bolder"><span>Rp</span>
                                            {{ number_format($history->nominal,0,",",".") }}</h6>
                                    </div>
                                </div>
                                <div class="col-md text-muted mt-2 text-size-Portofolio-Transaksi-title">Status
                                    <div class="col pt-2 ">
                                        <h6 class="fw-bolder">
                                            @php
                                            switch ($history->status) {
                                            case 'pending':
                                            echo 'Menunggu Pembayaran';
                                            break;
                                            case 'success':
                                            echo 'Berhasil';
                                            break;
                                            case 'failed':
                                            echo 'Gagal';
                                            break;
                                            }
                                            @endphp
                                        </h6>
                                    </div>
                                </div>
                                @if ($history->status == 'pending')
                                <div class="col-md-12 ">
                                    <div class="col mt-2 float-end">

                                        <a type="button" class="text-harga" target="_blank"
                                            href="{{ \App\Models\Transaction::PAYMENT_URL() . $history->payment_token}}">
                                            Bayar Sekarang
                                        </a>

                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    @empty
                    <!-- JIKA Transaksi Investnak TIDAK ADA DATANYA -->
                    <div class="card container-fluid" style="height:300px;">
                        <div class="row h-100">
                            <div class="col-sm-12 my-auto text-center">
                                <i class="fas fa-wallet text-muted"></i>
                                <p class="text-muted">Belum Ada Transaksi</p>
                            </div>
                        </div>
                    </div>
                    @endforelse

                </div>
                <!-- Tab Pengajuan Penarikan Dana-->
                <div class="tab-pane fade" id="nav-Withdrawal" role="tabpanel" aria-labelledby="nav-Withdrawal-tab">
                    @forelse($user->withdrawals->sortByDesc('updated_at') as $withdrawal)
                    <div class="card border-left-primary shadow h-100 mb-2 rounded">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 text-muted mt-2 text-size-Portofolio-Transaksi-title">Nama
                                    Transaksi
                                    <div class="col pt-2">
                                        <h6 class="fw-bolder">Penarikan Dana</h6>
                                    </div>
                                </div>
                                <div class="col-md text-muted mt-2 text-size-Portofolio-Transaksi-title">Tanggal
                                    <div class="col pt-2 text-nowrap">
                                        <h6 class="fw-bolder">
                                            {{ Carbon::parse($withdrawal->created_at)->isoFormat('D MMMM Y')}}<br>{{Carbon::parse($withdrawal->created_at)->isoFormat('HH:mm:ss') }}
                                        </h6>
                                    </div>
                                </div>
                                <div class="col-md text-muted mt-2 text-nowrap text-size-Portofolio-Transaksi-title">
                                    Besar Dana
                                    <div class="col pt-2 ">
                                        <h6 class="fw-bolder"><span>Rp</span>
                                            {{ number_format($withdrawal->nominal,0,",",".") }}</h6>
                                    </div>
                                </div>
                                <div class="col-md text-muted mt-2 text-size-Portofolio-Transaksi-title">Status
                                    <div class="col pt-2 ">
                                        <h6 class="fw-bolder">
                                            @php
                                            switch ($withdrawal->status) {
                                            case 'request':
                                            echo 'Menunggu Konfirmasi';
                                            break;
                                            case 'process':
                                            echo 'Diproses';
                                            break;
                                            case 'paid':
                                            echo 'Berhasil';
                                            break;
                                            case 'rejected':
                                            echo 'Ditolak';
                                            break;
                                            }
                                            @endphp
                                        </h6>
                                    </div>
                                </div>
                                @if ($withdrawal->status =='rejected')

                                <div class="col-md-12 ">
                                    <div class="col mt-2 float-end">
                                        <a type="button" class="text-harga" data-bs-toggle="modal"
                                            data-bs-target="#ModalFeedback{{$withdrawal->id}}">
                                            Lihat Feedback
                                        </a>
                                    </div>
                                </div>
                                <!-- Modal Feedback -->
                                <div class="modal fade" id="ModalFeedback{{$withdrawal->id}}" tabindex="-1"
                                    aria-labelledby="ModalFeedback{{$withdrawal->id}}Label" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-scrollable">
                                        <div class="modal-content">
                                            <div class="modal-header pb-0 border-0">
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <h5 class="modal-title mx-auto" id="ModalFeedback{{$withdrawal->id}}Label">
                                                Feedback Pengajuan Dana</h5>
                                            <div class="modal-body">
                                                <div class="container-fluid border-bottom border-3">
                                                    <div class="row d-flex justify-content-center mb-2">

                                                        <div class="col-12">{{$withdrawal->feedback}}</div>
                                                    </div>

                                                </div>


                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <!-- End of Modal -->
                                @endif


                            </div>
                        </div>
                    </div>
                    @empty
                    <!-- JIKA Transaksi Investnak TIDAK ADA DATANYA -->
                    <div class="card container-fluid" style="height:300px;">
                        <div class="row h-100">
                            <div class="col-sm-12 my-auto text-center">
                                <i class="fas fa-wallet text-muted"></i>
                                <p class="text-muted">Belum Ada Pengajuan</p>
                            </div>
                        </div>
                    </div>
                    @endforelse


                </div>
            </div>
            <!-- Modal Tarik Saldo -->
            <div class="modal fade" id="modalTarikSaldo" tabindex="-1" aria-labelledby="modalTarikSaldoLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header pb-0 border-0">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <h5 class="modal-title mx-auto text-harga" id="ModalDetailTransaksiInvestnakLabel">
                            Penarikan Saldo</h5>
                        <form action="{{route('profile.withdraw.store')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body">
                                @if (!empty($user->banks->first()))
                                @php
                                $user_bank = $user->banks->first();
                                @endphp
                                <label for="nominalPenarikan" class="form-label">Jumlah Penarikan</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text border-0 bg-white" id="nominalPenarikan">Rp</span>
                                    <input type="number" class="form-control" id="nominalPenarikan" name="nominal"
                                        value="" placeholder="Masukan Nominal">
                                </div>
                                <div class="mb-3">
                                    <label for="nomorRekening" class="form-label">Nama Bank</label>
                                    <input type="text" class="form-control" id="namaBank" name="bank"
                                        value="{{$user_bank->name}}" readonly>
                                </div>
                                <div class="mb-3">
                                    <label for="nomorRekening" class="form-label">Nomor Rekening</label>
                                    <input type="number" class="form-control" id="nomorRekening" name="account_number"
                                        value="{{$user_bank->pivot->account_number}}" readonly>
                                </div>
                                <div class="mb-3">
                                    <label for="namaRekening" class="form-label">Nama Pemilik Rekening</label>
                                    <input type="text" class="form-control" id="namaRekening" name="holder_name"
                                        value="{{$user_bank->pivot->holder_name}}" readonly>
                                </div>

                                @else
                                <div class="d-flex justify-content-center">

                                    <a class="btn btn-outline-default mx-auto my-3"
                                        href="{{ route('profile', ['tab'=>'bank']) }}">+ Tambah Data
                                        Bank</a>
                                </div>
                                @endif
                                <div class="d-grid border-0 ">
                                    <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> -->
                                    <button type="submit" class="btn btn-default d-grid"
                                        {{empty($user->banks->first()) ? 'disabled':''}}>Tarik</button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
            <!-- Modal TopUp Saldo -->
            <div class="modal fade" id="modalTopUpSaldo" tabindex="-1" aria-labelledby="modalTopUpSaldoLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                        <div class="modal-header pb-0 border-0">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <h5 class="modal-title mx-auto text-harga" id="ModalDetailTransaksiInvestnakLabel">
                            Top Up Saldo</h5>
                        <div class="modal-body">
                            <nav class="">
                                <ul class="nav mb-3 d-flex align-items-start" id="nav-tab" role="tablist">
                                    <li class="topup-li"><button
                                            class="nav-link active border-0 bg-white text-dark text-menu-portofolio m-0  "
                                            id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home"
                                            type="button" role="tab" aria-controls="nav-home" aria-selected="true">
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
                                            <input type="tnumber" class="form-control" placeholder="100.000"
                                                id="nominal-topup" aria-label="Username"
                                                aria-describedby="nominal-topup">
                                        </div>
                                        <a class="btn btn-default btnNext float-end">Next ></a>
                                        <!-- <a class="btn btn-primary btnPrevious">Previous</a> -->
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="nav-profile" role="tabpanel"
                                    aria-labelledby="nav-profile-tab">
                                    <div class="container-fluid">
                                        @include('payment.payment-method')
                                        <a class="btn btn-default btnNext float-end">Next ></a>
                                        <a class="btn btn-outline-default btnPrevious">
                                            < Previous</a> </div> </div> <div class="tab-pane fade" id="nav-contact"
                                                role="tabpanel" aria-labelledby="nav-contact-tab">
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
                                                <form action="{{ route('pay.topup') }}" method="POST"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    <input type="number" name="nominal" value="0" hidden>
                                                    <input type="text" value="" name="payment_method" hidden>
                                                    <button class="btn btn-default btnNext float-end" type="submit"
                                                        id="text-laststep-paymentmethod">Bayar </button>
                                                </form>

                                                <a class="btn btn-outline-default btnPrevious">
                                                    < Previous</a> </div> </div> </div> </div> </div> </div> </div>
                                                        </div> </div> <!-- </div> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endsection
                @push('js')
                <script>
                    $('.btnNext').click(function () {
                        let baten = $('#nav-tab > .topup-li > .active').parent().next().next('li').find(
                            'button').click();
                        console.log(baten);

                    });
                    $('.btnPrevious').click(function () {
                        let baten = $('#nav-tab > .topup-li > .active').parent().prev().prev('li').find(
                            'button').click();
                        console.log(baten);

                    });

                </script>
                <script>
                    // input method paymend ke span checkout
                    $(document).ready(function () {
                        $('.card-input-element').click(function () {
                            let radioValue = $("input[name='payment-method']:checked").val();
                            $('input[name="payment_method"]').val(radioValue); 
                            $("#checkout-method").text(radioValue);
                            console.log(radioValue);

                            if ($("input[name='payment-method']:checked").val() ==
                                "E-Money, Tranfer Bank, Dan Lain Lain") {
                                let test123 = $("#text-laststep-paymentmethod").html(
                                "Pilih Pembayaran");
                                console.log(test123);
                            } else {
                                let test123 = $("#text-laststep-paymentmethod").html("Bayar");
                                console.log(test123);
                            }

                        });
                        $('#radio-wallet').attr('disabled', true);
                        $("#wallet-card-methodpayment").css("background-color", "#c9c9c9");
                    });


                    let currency = new Intl.NumberFormat('id-ID', {
                        style: 'currency',
                        'currency': 'IDR',
                    });

                    // input nominal uang ke span checkout
                    $(document).ready(function () {
                        $('#nominal-topup').change(function (event) {
                            $("#checkout-nominal").text(currency.format($(this).val()));
                            $('input[name="nominal"]').val($(this).val());
                        });
                    });

                    // restrict next dan disable button, jika belum isi nominal
                    $(document).ready(function () {
                        $('#nav-profile-tab').attr('disabled', true);
                        $('#nav-profile-tab').click(function () {
                            if ($('#nominal-topup').val().length === 0) {
                                alert('Masukan Nominal Uang');
                                $('#nav-profile-tab').attr('disabled', true);
                            } else {
                                $('#nav-profile-tab').attr('disabled', false);
                            }
                        })
                    });

                    // restrict next dan disable button, jika belum isi method payment
                    $(document).ready(function () {
                        $('#nav-contact-tab').attr('disabled', true);
                        $('#nav-contact-tab').click(function () {
                            if ($("#checkout-method").text().length == 0) {
                                alert('Masukan Metode Pembayaran');
                                $('#nav-contact-tab').attr('disabled', true);
                                // console.log('ada value');
                            } else {
                                $('#nav-contact-tab').attr('disabled', false);
                            }

                        });
                        $(".select-method").change(function () {
                            if ($(".select-method ").children("option:selected").val()) {
                                // alert('Masukan Method Pembayaran');
                                $('input[name="payment_method"]').val($("#checkout-method").text());
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
                @endpush

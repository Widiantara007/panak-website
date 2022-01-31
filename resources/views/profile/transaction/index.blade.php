@extends('profile.mastermenu')
@section('title','Transaksi')
@section('contentprofile')
@php
use Carbon\Carbon;
Carbon::setLocale('id');
@endphp
<div class="col pt-3">
    <h3 class="" id="menu-title">Transaksi</h3>

</div>
<div class="col">
    <div class="card">
        <div class="card-header bg-white border-0">
            <nav>
                <div class="nav" role="tablist" id="profile">
                    <a class="nav-link text-dark text-menu-portofolio {{empty(Request::get('tab'))||Request::get('tab') == 'investnak' ? 'active':''}}"
                        id="nav-Investnak-tab" data-bs-toggle="tab" data-bs-target="#nav-Investnak" type="button"
                        role="tab" aria-controls="nav-Investnak" aria-selected="true">Bisnak</a>
                    <a class="nav-link text-dark text-menu-portofolio {{Request::get('tab') == 'pasarnak' ? 'active':''}}"
                        id="nav-Pasarnak-tab" data-bs-toggle="tab" data-bs-target="#nav-Pasarnak" type="button"
                        role="tab" aria-controls="nav-Pasarnak" aria-selected="false">Pasarnak</a>
                </div>
            </nav>
        </div>
        <div class="card-body">
            <div class="tab-content" id="nav-tabContent">
                <!-- Tab Transaksi Investnak -->
                <div class="tab-pane fade  {{empty(Request::get('tab'))||Request::get('tab') == 'investnak' ? 'show active':''}}"
                    id="nav-Investnak" role="tabpanel" aria-labelledby="nav-Investnak-tab">
                    @if ($transactions->where('type', 'investnak') == '[]')
                    <!-- JIKA Transaksi Investnak TIDAK ADA DATANYA -->
                    <div class="card container-fluid" style="height:300px;">
                        <div class="row h-100">
                            <div class="col-sm-12 my-auto text-center">
                                <i class="fas fa-exchange-alt text-muted"></i>
                                <p class="text-muted">Belum Ada Transaksi</p>
                                <a class="btn btn-sm btn-default" href="{{route('investnak')}}">+ Mulai Bisnis</a>
                            </div>
                        </div>
                    </div>
                    @else
                    @foreach ($transactions->where('type', 'investnak')->sortByDesc('updated_at') as $transaction)
                    <div class="card border-left-primary shadow h-100 mb-2 rounded">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 text-muted mt-2 text-size-Portofolio-Transaksi-title"
                                    id="transaksi-proyek-width">Nama Proyek
                                    <div class="col pt-2 mt-md-4">
                                        <h6 class="fw-bolder">{{$transaction->project_batch->fullName()}}</h6>
                                    </div>
                                </div>
                                <div class="col-md-1 text-muted mt-2 text-wrap text-size-Portofolio-Transaksi-title"
                                    id="transaksi-jumlahlot-width">
                                    <span class="">Tipe</span>
                                    <div class="col pt-2 mt-md-4">
                                        <h6 class="fw-bolder text-nowrap">
                                            @php
                                            switch ($transaction->transaction_type) {
                                            case 'income':
                                            echo 'Bisnis';
                                            break;
                                            case 'return':
                                            echo 'Return';
                                            break;
                                            case 'reinvest':
                                            echo 'Rejoin';
                                            break;

                                            }
                                            @endphp
                                        </h6>
                                    </div>
                                </div>
                                <div class="col-md-2 text-muted mt-2 text-wrap text-size-Portofolio-Transaksi-title ms-xl-3"
                                    id="transaksi-metodebayar-width">Metode
                                    Pembayaran
                                    <div class="col pt-2 margin-top-xs ">
                                        <h6 class="fw-bolder">{{$transaction->payment_method}} </h6>
                                    </div>
                                </div>
                                <div class="col-md-2 text-muted mt-2 text-size-Portofolio-Transaksi-title">
                                    Jumlah
                                    <div class="col pt-2 mt-md-4 d-flex justify-content-start">

                                        <h6 class="fw-bolder"><span>Rp
                                                {{ number_format($transaction->nominal,0,",",".") }}</span></h6>
                                    </div>
                                </div>
                                <div class="col-md-2 text-muted mt-2 text-size-Portofolio-Transaksi-title text-wrap pe-0 ms-md-3"
                                    id="transaksi-status-width">Status
                                    <div class="col pt-2 mt-md-4">
                                        <h6 class="fw-bolder">
                                            @php
                                            switch ($transaction->status) {
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
                                <div class="col-12 ">
                                    <div class="mt-2 float-end">
                                        @if ($transaction->status == 'pending')
                                        <a type="button" class="text-harga" target="_blank" href="{{ \App\Models\Transaction::PAYMENT_URL() . $transaction->payment_token}}">
                                            Bayar Sekarang
                                        </a>
                                        <span class="text-secondary">|</span>
                                        @endif
                                        <a type="button" class="text-harga" data-bs-toggle="modal"
                                            data-target-id="{{$transaction->id}}"
                                            data-bs-target="#ModalDetailTransaksiInvestnak">
                                            Lihat Detail Transaksi
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    <!-- Modal Detail Transaksi Investnak -->
                    <div class="modal fade" id="ModalDetailTransaksiInvestnak" tabindex="-1"
                        aria-labelledby="ModalDetailTransaksiInvestnakLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-scrollable" role="document">
                            <div class="modal-content">
                                <div class="modal-header pb-0 border-0">
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <h5 class="modal-title mx-auto pb-3" id="ModalDetailTransaksiInvestnakLabel">
                                    Detail Transaksi Bisnak</h5>
                                <div class="modal-body" id="investnakModalBody">
                                <div class="d-flex justify-content-center">
                                        <div class="spinner-border" role="status">
                                            <span class="sr-only">Loading...</span>
                                        </div>
                                    </div>
                                </div>
                               
                            </div>
                        </div>
                    </div>
                    <!-- End of Modal -->
                </div>

                @endif

                <!-- Tab Transaksi Pasarnak Selesai -->
                <div class="tab-pane fade {{Request::get('tab') == 'pasarnak' ? 'show active':''}}" id="nav-Pasarnak"
                    role="tabpanel" aria-labelledby="nav-Pasarnak-tab">
                    @if ($transactions->where('type', 'pasarnak') == '[]')
                    <!-- JIKA Transaksi PASARNAK TIDAK ADA DATANYA -->
                    <div class="card container-fluid" style="height:300px;">
                        <div class="row h-100">
                            <div class="col-sm-12 my-auto text-center">
                                <i class="fas fa-exchange-alt text-muted"></i>
                                <p class="text-muted">Belum Ada Transaksi</p>
                                <a class="btn btn-sm btn-default" href="{{route('pasarnak')}}">+ Beli Produk
                                    Pasarnak</a>
                            </div>
                        </div>
                    </div>
                    @else
                    @foreach ($transactions->where('type', 'pasarnak')->sortByDesc('updated_at') as $transaction)
                    <div class="card border-left-default shadow h-100 mb-2 rounded">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 text-muted mt-2 text-size-Portofolio-Transaksi-title ">Nama
                                    Produk
                                    <div class="col pt-2">
                                        <h6 class="fw-bolder">
                                            @foreach ($transaction->order->order_details as $detail)
                                            {{$detail->product->name}} <br>
                                            @endforeach
                                        </h6>
                                    </div>
                                </div>
                                <div class="col-md-3 text-muted mt-2 text-size-Portofolio-Transaksi-title">Total
                                    <div class="col pt-2">
                                        <h6 class="fw-bolder">Rp {{number_format($transaction->nominal,0,",",".")}}
                                        </h6>
                                    </div>
                                </div>
                                <div class="col-md-2 text-muted mt-2 text-size-Portofolio-Transaksi-title ">Tanggal
                                    <div class="col pt-2">
                                        <h6 class="fw-bolder">
                                            {{ Carbon::parse($transaction->created_at)->isoFormat('D MMMM Y')}}</h6>
                                    </div>
                                </div>
                                <div class="col-md-3 text-muted mt-2 text-size-Portofolio-Transaksi-title ">Status
                                    <div class="col pt-2">
                                        <h6 class="fw-bolder">
                                            @php
                                            switch ($transaction->order->status) {
                                            case 'payment':
                                            echo 'Menunggu Pembayaran';
                                            break;
                                            case 'process':
                                            echo 'Diproses';
                                            break;
                                            case 'sending':
                                            echo 'Dalam Pengiriman';
                                            break;
                                            case 'received':
                                            echo 'Tiba di Tujuan';
                                            break;
                                            case 'done':
                                            echo 'Selesai';
                                            break;

                                            }
                                            @endphp
                                        </h6>

                                    </div>
                                </div>
                                @if ($transaction->order->status == 'sending')
                                <div class="col-md-12 mt-2 mb-0">
                                    <div class="col float-end">
                                        <form action="{{route('order.update.done', $transaction->order->id)}}"
                                            method="POST">
                                            @csrf
                                            @method('PATCH')

                                            <button class="btn btn-sm btn-success"><i class="fas fa-check"></i> Barang
                                                Diterima</button>
                                        </form>

                                    </div>
                                </div>
                                @endif
                                <div class="col-md-12 mt-2 mb-0">

                                    <div class="col float-end">

                                        @if ($transaction->status == 'pending')
                                        <a type="button" class="text-harga" target="_blank" href="{{ \App\Models\Transaction::PAYMENT_URL() . $transaction->payment_token}}">
                                            Bayar Sekarang
                                        </a>
                                        <span class="text-secondary">|</span>
                                        @endif
                                        <a type="button" class="text-harga" data-bs-toggle="modal"
                                            data-target-id="{{$transaction->id}}"
                                            data-bs-target="#ModalDetailTransaksiPasarnak">
                                            Lihat Detail Transaksi
                                        </a>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    <!-- Modal Detail Transaksi Pasarnak -->
                    <div class="modal fade" id="ModalDetailTransaksiPasarnak" tabindex="-1"
                        aria-labelledby="ModalDetailTransaksiPasarnakLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-scrollable" role="document">
                            <div class="modal-content">
                                <div class="modal-header pb-0 border-0">
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <h5 class="modal-title mx-auto" id="ModalDetailTransaksiPasarnakLabel">
                                    Detail Transaksi Pasarnak</h5>
                                <div class="modal-body" id="pasarnakModalBody">
                                    <div class="d-flex justify-content-center">
                                        <div class="spinner-border" role="status">
                                            <span class="sr-only">Loading...</span>
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>
                    <!-- End of Modal -->
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
</div>



@endsection
@push('js')
<script>
$(document).ready(function() {
    $("#ModalDetailTransaksiInvestnak").on("show.bs.modal", function(e) {
        $("#investnakModalBody").html(
            '<div class="d-flex justify-content-center"><div class="spinner-border" role="status"><span class="sr-only">Loading...</span></div></div>'
        );
        var id = $(e.relatedTarget).data('target-id');
        $.get('/profile/transaction/modal/' + id, function(data) {
            $("#investnakModalBody").html(data.modalBody);
        });

    });
    $("#ModalDetailTransaksiPasarnak").on("show.bs.modal", function(e) {
        $("#pasarnakModalBody").html(
            '<div class="d-flex justify-content-center"><div class="spinner-border" role="status"><span class="sr-only">Loading...</span></div></div>'
        );
        var id = $(e.relatedTarget).data('target-id');
        $.get('/profile/transaction/modal/' + id, function(data) {
            $("#pasarnakModalBody").html(data.modalBody);
        });

    });
});
</script>
@endpush
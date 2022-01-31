@extends('profile.mastermenu')
@section('title','Notifikasi')
@section('contentprofile')
@php
use Carbon\Carbon;
Carbon::setLocale('id');
@endphp
<div class="col pt-3">
    <h3 class="" id="menu-title">Notifikasi</h3>
</div>
<div class="col">
    <div class="card">
        <div class="card-body">
            @forelse ($notifications as $notification)
            <a class="card border-left-primary shadow h-100 mb-2 rounded" href="{{$notification->data['url']}}" data-id="{{$notification->id}}" onclick="return markRead($(this))">
                <div class="card-body">
                    <div class="row">
                        <div class="col-2 col-md-1">
                            @switch($notification->data['type'])
                            @case('verification_accept')
                            <!-- NAVBAR CENTANG DITERIMA SUKSES-->
                            <div class="icon-circle bg-success">
                                <i class="fas fas fa-check text-white"></i>
                            </div>
                            @break
                            @case('verification_reject')
                            <!-- NAVBAR DITOLAK GAGAL SILANG TETOT-->
                            <div class="icon-circle bg-danger">
                                <i class="fas fa-times text-white"></i>
                            </div>
                            @break
                            @case('transaction_income')
                            <!-- NAVBAR GAMBAR UANG-->
                            <div class="icon-circle bg-success">
                                <i class="fas fa-money-bill-wave text-white"></i>
                            </div>
                            @break
                            @case('transaction_outcome')
                            <!-- NAVBAR GAMBAR UANG-->
                            <div class="icon-circle bg-default-primary">
                                <i class="fas fa-money-bill-wave text-white"></i>
                            </div>
                            @break
                            @case('investnak_start')
                            <!-- NAVBAR GAMBAR INVESTNAK UDAH MULAI-->
                            <div class="icon-circle bg-success">
                                <i class="fas fa-play text-white"></i>
                            </div>
                            @break
                            @case('investnak_stop')
                            <!-- NAVBAR GAMBAR INVESTNAK STOP SELESAI-->
                            <div class="icon-circle bg-default-secondary">
                                <i class="fas fa-stop text-white"></i>
                            </div>
                            @break
                            @case('pasarnak_sending')
                            <!-- NAVBAR GAMBAR KIRIM BARANG PAKE TRUCK-->
                            <div class="icon-circle bg-default-primary">
                                <i class="fas fa-truck text-white"></i>
                            </div>
                            @break
                            @default
                            <!-- NAVBAR GAMBAR LONCENG-->
                            <div class="icon-circle bg-warning">
                                <i class="fas fa-bell text-white"></i>
                            </div>
                            @endswitch
                        </div>
                        <div class="col-md-11 col-10 text-left">
                            <div class="small text-gray-500">{{ Carbon::parse($notification->created_at)->diffForHumans()}}</div>
                            <span class="@empty($notification->read_at) fw-bold @endempty text-wrap">{{$notification->data['message']}}</span>
                        </div>

                    </div>
                </div>
            </a>
            @empty
            <!-- JIKA Transaksi Investnak TIDAK ADA DATANYA -->
            <div class="card container-fluid" style="height:300px;">
                <div class="row h-100">
                    <div class="col-sm-12 my-auto text-center">
                        <i class="fas fa-bell-slash text-muted"></i>
                        <p class="text-muted">Tidak ada Notifikasi</p>
                    </div>
                </div>
            </div> 
            @endforelse


        </div>
    </div>
</div>

@endsection


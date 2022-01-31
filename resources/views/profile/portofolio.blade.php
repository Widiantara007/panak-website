@extends('profile.mastermenu')
@section('title','Portofolio')
@section('contentprofile')
<div class="col pt-3">
    <h3 class="" id="menu-title">Portofolio</h3>
</div>
<div class="row pb-3">
    <div class="col-lg-4 col-md-6 pt-3">
        <div class="card p-3">
            <div class="card-body text-center">
                <h5>Bisnis Saya</h5>
                <p class="card-text text-harga">Rp {{ number_format($user->totalInvestments(),0,",",".") }}</p>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-6 pt-3">
        <div class="card p-3">
            <div class="card-body text-center">
                <h5>Proyek Aktif</h5>
                <p class="card-text text-harga">{{$user->portofolios->whereNotIn('status', ['paid','closed'])->count()}}</p>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-6 pt-3">
        <div class="card p-3">
            <div class="card-body text-center">
                <h5>Estimasi Keuntungan</h5>
                <p class="card-text text-harga">Rp {{ number_format($user->profitEstimation(),0,",",".") }}</p>
            </div>
        </div>
    </div>
</div>
<div class="col">
    <div class="card">
        <div class="card-header bg-white border-0">
            <nav>
                <div class="nav" role="tablist" id="profile">
                    <a class="nav-link active text-dark text-menu-portofolio" id="nav-PortofolioAktif-tab"
                        data-bs-toggle="tab" data-bs-target="#nav-PortofolioAktif" type="button" role="tab"
                        aria-controls="nav-PortofolioAktif" aria-selected="true">Portfolio Aktif</a>
                    <a class="nav-link text-dark text-menu-portofolio" id="nav-PortofolioSelesai-tab"
                        data-bs-toggle="tab" data-bs-target="#nav-PortofolioSelesai" type="button" role="tab"
                        aria-controls="nav-PortofolioSelesai" aria-selected="false">Portfolio Selesai</a>
                </div>
            </nav>
        </div>
        <div class="card-body">
            <div class="tab-content" id="nav-tabContent">
                <!-- Tab Portofolio Aktif -->
                <div class="tab-pane fade show active" id="nav-PortofolioAktif" role="tabpanel"
                    aria-labelledby="nav-PortofolioAktif-tab">
                    @forelse ($portofolio_progress->sortByDesc('created_at') as $portofolio)
                    <div class="card border-left-primary shadow h-100 mb-2 rounded">
                        <div class="card-body">
                            <div class="row pb-3 ">
                                <div class="col-md-4 mt-2 text-size-Portofolio-Transaksi-title text-muted">Nama Proyek
                                    <div class="col pt-2">
                                        <h6 class="fw-bolder">{{$portofolio->project_batch->fullName()}}</h6>
                                    </div>
                                </div>
                                <div class="col-md mt-2 text-size-Portofolio-Transaksi-title text-muted">Progress
                                    <div class="col pt-2">
                                        <h6 class="fw-bold mb-0">{{$portofolio->project_batch->status}}</h6>
                                        <p class="text-muted text-size-Portofolio-Transaksi-title">{{$portofolio->project_batch->daysLeft()}} Hari lagi </p>
                                    </div>
                                </div>
                                <div class="col-md mt-2 text-size-Portofolio-Transaksi-title text-muted">ROI
                                    <div class="col pt-2 text-nowrap">
                                        <h6 class="fw-bolder">{{$portofolio->project_batch->roi_low}} - {{$portofolio->project_batch->roi_high}}%</h6>
                                    </div>
                                </div>
                                <div class="col-md mt-2 text-size-Portofolio-Transaksi-title text-muted">Dana Anda
                                    <div class="col pt-2 text-nowrap">
                                        <h6 class="fw-bolder"><span>Rp</span> {{ number_format($portofolio->nominal,0,",",".") }}</h6>
                                    </div>
                                </div>
                                <div class="col-md mt-2 ">
                                    
                                        <div class="d-grid">
                                            <a href="{{ route('investnak.show', $portofolio->project_batch->id) }}"
                                                class="btn btn-sm btn-outline-default button-margin-portofolio">
                                                Lihat Detail
                                            </a>
                                            <a href="{{ route('profile.portofolio.showCBC', $portofolio->id) }}" target="_blank"
                                                class="btn btn-sm btn-outline-default button-margin-portofolio mt-2">
                                                Lihat Sertifikat CBC
                                            </a>
                                           
                                        </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>

                    @empty
                        <!-- JIKA Portofolio AKtif TIDAK ADA DATANYA -->
                        <div class="card container-fluid" style="height:200px;">
                            <div class="row h-100">
                                <div class="col-sm-12 my-auto text-center">
                                    <i class="fas fa-exchange-alt text-muted"></i>
                                    <p class="text-muted">Belum Ada Transaksi</p>
                                    <a class="btn btn-sm btn-default" href="{{route('investnak')}}">+ Mulai Bisnis</a>
                                </div>
                            </div>
                        </div>
                    @endforelse

                </div>
                <!-- Tab Portofolio Selesai -->
                <div class="tab-pane fade" id="nav-PortofolioSelesai" role="tabpanel"
                    aria-labelledby="nav-PortofolioSelesai-tab">
                    @forelse ($portofolio_completed->sortByDesc('created_at') as $portofolio)
                        
                    <div class="card border-left-primary shadow h-100 mb-2 rounded">
                        <div class="card-body">
                            <div class="row pb-3 ">
                                <div class="col-md-5 mt-2 text-size-Portofolio-Transaksi-title text-muted">Nama Proyek
                                    <div class="col pt-2">
                                        <h6 class="fw-bolder">{{$portofolio->project_batch->fullName()}}</h6>
                                    </div>
                                </div>
                                <div class="col-md mt-2 text-size-Portofolio-Transaksi-title text-muted">Progress
                                    <div class="col pt-2">
                                        <h6 class="fw-bold mb-0">{{$portofolio->project_batch->status}}</h6>
                                        <p class="text-muted text-size-Portofolio-Transaksi-title">{{$portofolio->project_batch->daysLeft()}} Hari lagi </p>
                                    </div>
                                </div>
                                <div class="col-md mt-2 text-size-Portofolio-Transaksi-title text-muted">ROI
                                    <div class="col pt-2 text-nowrap">
                                        <h6 class="fw-bolder">{{$portofolio->project_batch->roi}}%</h6>
                                    </div>
                                </div>
                                <div class="col-md mt-3 text-size-Portofolio-Transaksi-title text-muted">Dana Anda
                                    <div class="col pt-2 text-nowrap">
                                        <h6 class="fw-bolder"><span>Rp</span> {{ number_format($portofolio->nominal,0,",",".") }}</h6>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 d-grid"> <a
                                        href="{{ route('investnak.show', $portofolio->project_batch->id) }}"
                                        class=" btn btn-sm btn-outline-default ">
                                        Lihat Detail
                                    </a></div>
                                <div class="col-md-4 d-grid"> <a
                                        href="{{ route('profile.portofolio.showCBC', $portofolio->id) }}"
                                        target="_blank"
                                        class=" btn btn-sm btn-outline-default ">
                                        Lihat Sertifikat CBC
                                    </a></div>
                                <div class="col-md-4 d-grid "> <a
                                        href="{{ route('profile.portofolio.showCertificate', $portofolio->id) }}"
                                        target="_blank"
                                        class=" btn btn-sm btn-outline-default ">
                                        Lihat Sertifikat
                                    </a></div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <!-- JIKA Portofolio Selesai TIDAK ADA DATANYA -->
                    <div class="card container-fluid" style="height:200px;">
                        <div class="row h-100">
                            <div class="col-sm-12 my-auto text-center">
                                <i class="fas fa-exchange-alt text-muted"></i>
                                <p class="text-muted">Belum Ada Transaksi</p>
                                <a class="btn btn-sm btn-default" href="{{route('investnak')}}">+ Mulai Bisnis</a>
                            </div>
                        </div>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
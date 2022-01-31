@php
use App\Models\Address;
use Carbon\Carbon;
Carbon::setLocale('id');
@endphp
<div class="container-fluid border-bottom border-3">
    <div class="row d-flex justify-content-between mb-2">

        <div class="col-6 text-muted">Jenis Transaksi</div>
        <div class="col-6">
            @php
                switch ($transaction->transaction_type) {
                    case 'income':
                    if($transaction->type == 'investnak'){
                        echo 'Bisnis';
                    }else {
                        echo 'Pembelian';
                    }
                        break;
                    case 'return':
                    echo 'Return';
                    break;
                    case 'reinvest':
                    echo 'Rejoin';
                    break;
                    
                }
            @endphp 
        </div>
    </div>
    <div class="row d-flex justify-content-between mb-2">

        <div class="col-6 text-muted">Status Pembayaran</div>
        <div class="col-6">
            @php
                switch ($transaction->status) {
                    case 'pending':
                        echo 'Menunggu Pembayaran';
                        break;
                    case 'success':
                        echo 'Sukses';
                        break;
                    case 'failed':
                        echo 'Gagal';
                        break;
                }
            @endphp
        </div>
    </div>
    <div class="row d-flex justify-content-between mb-2">
        <div class="col-6  text-muted">Tanggal Transaksi</div>
        <div class="col-6">{{Carbon::parse($transaction->created_at)->isoFormat('D MMMM Y HH:mm:ss')}}</div>
    </div>
</div>
@if ($transaction->type == 'investnak')
    {{-- Investnak --}}
    @php
        $project_batch = $transaction->project_batch;
    @endphp
<div class="container-fluid mt-3">
    <h6 class="fw-bold">Detail Bisnak</h6>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <img src="{{asset('/storage/images/projects/'.$project_batch->project->image)}}"
                        alt="Image Project"
                        class="card-img-top rounded mb-2">
                    <span
                        class="badge rounded-pill bg-primary mb-2 pe-2"
                        style="background-color:#FF8200 !important"><i
                            class="fas fa-star pe-1"
                            style="color:white;"></i>{{$project_batch->project->risk_grade}}</span>
                    <h5 class="">{{$project_batch->fullName()}}</h5>
                    <div class="row mt-3 mb-2">
                        <div class="col-12">
                            <p class="text-muted mb-1"><i
                                    class="fas fa-user"></i>
                                    {{$project_batch->project->project_owner->name }}
                            </p>
                        </div>
                        <div class="col-12 pe-0">
                            <p class="text-muted mb-3">
                                {{Str::title(Address::getDistrict($project_batch->project->location_code).', '.Address::getProvince($project_batch->project->location_code))}}
                            </p>
                        </div>
                        <div
                            class="d-flex justify-content-between align-items-center ">
                            <p
                                class="float-left mb-2 text-muted">
                                ROI
                            </p>
                            <h6
                                class="float-right mb-2 text-roi">
                                {{$project_batch->getRangeROI()}} %
                            </h6>
                        </div>
                        <hr>
                        <div class="col-12 pe-0">
                            <p
                                class="text-muted mb-1 text-nowrap">
                                Nominal {{$transaction->transaction_type == 'income' ? 'Pembelian' : 'Return'}}
                            </p>
                        </div>
                        <div class="col-12 pe-0">
                            <p class=" mb-1">
                                Rp {{number_format($transaction->nominal,0,",",".")}}
                            </p>
                        </div>
                        @if ($transaction->transaction_type == 'income')
                        <div class="col-12 pe-0">
                            <p
                                class="text-muted mb-1 text-nowrap">
                                Jumlah Lot
                            </p>
                        </div> 
                        <div class="col-12 pe-0">
                            <p class=" mb-1">
                                {{$project_batch->countLot($transaction->nominal)}}
                            </p>
                        </div>
                        @else
                        <div class="col-12 pe-0">
                            <p
                                class="text-muted mb-1 text-nowrap">
                                Jumlah Lot
                            </p>
                        </div> 
                        <div class="col-12 pe-0">
                            <p class=" mb-1">
                                {{$transaction->user_portofolio->lot}}
                            </p>
                        </div>
                        <div class="col-12 pe-0">
                            <p class="text-muted mb-1 text-nowrap">
                                Keuntungan Bisnis
                            </p>
                        </div>
                        <div class="col-12 pe-0">
                            <p class=" mb-1">
                                Rp {{number_format($transaction->user_portofolio->countProfit(),0,",",".")}}
                            </p>
                        </div>
                        @endif



                        <div class="col-12 pe-0">
                            <p
                                class="text-muted mb-1 text-nowrap">
                                Metode Pembayaran
                            </p>
                        </div>
                        <div class="col-12 pe-0">
                            <p class=" mb-1">
                                {{$transaction->payment_method}}
                            </p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

</div>
@else
<div class="container-fluid mt-3">
    <h6 class="fw-bold">Detail Pasarnak</h6>
    <div class="card">
        <div class="card-body">
            <div class="row">

                <div class="col-12">
                    @foreach ($transaction->order->order_details as $order_detail)
                        
                    <div class="row mb-2">
                        <div class="col-4">
                            <img src="{{asset('storage/images/products/'.$order_detail->product->image)}}" alt="..."
                            class="img-fluid rounded mb-2" >
                        </div>
                        <div class="col-8">
                            <h6 class="mb-2">{{ $order_detail->product->name }}</h6>
                            <p class="text-harga">Rp {{number_format($order_detail->price,0,",",".")}} / {{$order_detail->product->unit}}</p>
                            <p class="text-muted">Qty: {{$order_detail->quantity}} </p>
                        </div>
                    </div>
                    @endforeach
                    
            
                </div>



                <hr>
                <div class="col-12 pe-0">
                    <p class="text-muted mb-1 text-nowrap">
                        Total Harga Pembelian
                    </p>
                </div>
                <div class="col-12 pe-0 mb-2">
                    <p class=" mb-1">
                        Rp {{number_format($transaction->order->total,0,",",".")}}
                    </p>
                </div>
                <div class="col-12 pe-0">
                    <p class="text-muted mb-1 text-nowrap">
                        Jumlah Produk Yang dibeli
                    </p>
                </div>
                <div class="col-12 pe-0 mb-2">
                    <p class=" mb-1">
                        {{$transaction->order->order_details->count()}}
                    </p>
                </div>
                <div class="col-12 pe-0">
                    <p class="text-muted mb-1 text-nowrap">
                        Alamat Pengiriman
                    </p>
                </div>
                <div class="col-12 pe-0 mb-2">
                    <p class=" mb-1">
                        {{$transaction->order->address_detail}}
                            <br>{{ Address::getFullAddress($transaction->order->location_code) }} <br>
                            {{$transaction->order->postal_code}} <br>
                            <span class="text-muted mt-1">{{$transaction->order->no_hp}}</span>
                    </p>
                </div>
                <div class="col-12 pe-0">
                    <p class="text-muted mb-1 text-nowrap">
                        Ongkos Pengiriman
                    </p>
                </div>
                <div class="col-12 pe-0 mb-2">
                    <p class=" mb-1">
                        Rp {{number_format($transaction->order->shipping_cost,0,",",".")}}
                    </p>
                </div>
                <div class="col-12 pe-0">
                    <p class="text-muted mb-1 text-nowrap">
                        Subtotal
                    </p>
                </div>
                <div class="col-12 pe-0 mb-2">
                    <p class=" mb-1">
                        Rp {{number_format($transaction->order->total,0,",",".")}}
                    </p>
                </div>
                <div class="col-12 pe-0">
                    <p class="text-muted mb-1 text-nowrap">
                        Metode Pembayaran
                    </p>
                </div>
                <div class="col-12 pe-0">
                    <p class=" mb-1">
                        {{$transaction->payment_method}}
                    </p>
                </div>

            </div>
        </div>
    </div>
</div>
@endif

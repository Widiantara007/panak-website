@extends('admin.layouts.app')
@section('header')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin') }}">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Order</li>
    </ol>
</nav>
<h1 class="h3 mb-0 text-gray-800">Order</h1>
{{-- <p class="mb-4">Description</p> --}}

@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <a class="btn btn-sm btn-primary float-right" href="{{ route('order.create') }}"><i
                        class="fas fa-plus"></i> Tambah Order</a>
                <h6 class="m-0 font-weight-bold text-primary">List Order</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Nama Pemesan</th>
                                <th>Alamat</th>
                                <th>No HP</th>
                                <th>Status</th>
                                <th>Total</th>
                                <th>Tipe Pembayaran</th>
                                <th>Pesanan</th>
                                <th>Created At</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            use App\Models\Address;
                            @endphp
                            @foreach ($orders as $order)
                            <tr>
                                <td>{{ $order->recipient_name }}</td>
                                <td>{{ $order->address_detail }} <br>
                                    {{ Address::getFullAddress($order->location_code) }} {{ $order->postal_code }}</td>
                                <td>{{ $order->no_hp }}</td>
                                <td>{{ $order->status }}</td>
                                <td>{{ $order->total }}</td>
                                <td>{{ $order->payment_type }}</td>
                                <td>
                                    <ul>
                                        @foreach ($order->order_details as $detail)
                                        <li>{{$detail->product->name}} ({{ $detail->quantity }})</li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td>{{ $order->created_at }}</td>
                                <td class="text-center">
                                    <form action="{{ route('order.update.status', $order->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        @if ($order->status == 'process')
                                        <button type="submit" name="submit" value="sending"
                                        class="btn btn-sm btn-success mb-2"><i class="far fa-paper-plane"></i> Kirim
                                        Barang</button>
                                        
                                        @endif
                                        
                                        
                                    </form>
                                    <form action="{{ route('order.destroy', $order->id) }}" method="POST"
                                        onsubmit="return confirm('Apakah anda yakin menghapus data ini?')">
                                        @csrf
                                        @method('delete')
                                        <a class="btn btn-sm btn-info mb-2"
                                            href="{{ route('order.edit', $order->id) }}"><i class="far fa-edit"></i>
                                            Edit</a>
                                        <button type="submit" class="btn btn-sm btn-outline-danger mb-2"><i
                                                class="far fa-trash-alt"></i> Hapus</button>
                                    </form>


                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('css')
@include('admin.plugins.dataTables-css')
@endpush
@push('js')
@include('admin.plugins.dataTables-js')
@include('admin.plugins.dataTables-set-js')
@endpush

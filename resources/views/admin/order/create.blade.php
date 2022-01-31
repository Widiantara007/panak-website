@extends('admin.layouts.app')
@section('header')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('order.index') }}">Order</a></li>
        <li class="breadcrumb-item active" aria-current="page">Tambah Order</li>
    </ol>
</nav>
<h1 class="h3 mb-0 text-gray-800">Order</h1>
{{-- <p class="mb-4">Description</p> --}}

@endsection
@section('content')
<div class="row">
    <div class="col-12">
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
    </div>
    <form action="{{ route('order.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
    <div class="col-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Tambah Order</h6>
            </div>
            <div class="card-body">
                
                    <div class="row">
                        <div class="form-group col-md-8">
                            <label for="recipient_name">Nama Penerima</label>
                            <input type="text" class="form-control" name="recipient_name" id="recipient_name"
                                placeholder="ex: Bambang Sujanarko" value="{{old('recipient_name') }}">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="no_hp">No HP</label>
                            <input type="number" class="form-control" name="no_hp" id="no_hp"
                                placeholder="ex: 081234567890" value="{{old('no_hp') }}">
                        </div>
                    </div>
                    <label class="mt-3 mb-0">Alamat</label>
                    <div class="row">
                        <div class="form-group col-md-3">
                            <label for="province">Provinsi</label>
                            <select class="form-control" id="province" name="province">
                                <option value="0" selected disabled>Pilih Provinsi</option>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="district">Kabupaten/Kota</label>
                            <select class="form-control" id="district" name="district">
                                <option value="0" selected disabled>Pilih Kabupaten/Kota</option>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="sub-district">Kecamatan</label>
                            <select class="form-control" id="sub-district" name="sub-district">
                                <option value="0" selected disabled>Pilih Kecamatan</option>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="village">Kelurahan/Desa</label>
                            <select class="form-control" id="village" name="village">
                                <option value="0" selected disabled>Pilih Kelurahan/Desa</option>
                            </select>
                        </div>
                        <div class="form-group col-md-8">
                            <label for="address_detail">Detail Alamat</label>
                            <textarea class="form-control" id="address_detail" name="address_detail" rows="3" maxlength="190"></textarea>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="postal_code">Kode Pos</label>
                            <input type="number" class="form-control" name="postal_code" id="postal_code"
                                placeholder="ex: 40257" value="{{old('postal_code') }}">
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="form-group col-md-5">
                            <label for="payment_type">Tipe Pembayaran</label>
                            <select class="form-control" id="payment_type" name="payment_type">
                                <option value="0" selected disabled>Pilih Tipe Pembayaran</option>
                                <option value="cash">Cash</option>
                                <option value="bank tranfer">Bank Transfer</option>
                            </select>
                        </div>
                    </div>
                
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Tambah Barang</h6>
            </div>
            
            <div class="card-body">
                <div class="row">
                    <div class="form-group col-md-8">
                        <div class="table-responsive">
                            <table class="table table-hover text-center">
                                <thead>
                                    <tr>
                                        <th>Nama Barang</th>
                                        <th>Quantity</th>
                                        <th>
                                            <button type="button" id="addProduct"
                                                class="btn btn-outline-primary btn-sm">Tambah Barang</button>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="listProduct">
                                     {{-- Add with js below --}}
                                        
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-end">
                    <a class="btn btn-secondary mr-3" href="{{ route('order.index') }}">Cancel</a>
                    <button class="btn btn-primary">Submit</button>
                </div>
            </div>
        </div>
    </div>
</form>
</div>
@endsection
@push('js')
<script>
    function add_select_product(){
        var line =
                '<tr>' +
                '<td>' +
                '{!! Form::select("product_id[]", $products->where("stock", ">",0)->pluck("name", "id")->toArray(), null, ["class" => "form-control"]) !!}'+
                '</td>' +
                '<td>' +
                '<input type="number" class="form-control" name="quantity[]" min=1 value="1">' +
                '</td>' +
                '<td> <button type="button" id="deleteProduct" class="btn btn-outline-danger btn-sm"><i class="far fa-trash-alt"></i></button></td>' +
                '</tr>'
            $('#listProduct').append(line);
    }

    $(document).ready(function () {
        // initial select
        add_select_product();

        //add select when click
        $('#addProduct').on('click', function () {
            
            add_select_product();
            
        })
        $('#listProduct').on('click', 'button[id="deleteProduct"]', function (e) {
            $(this).closest('tr').remove();
        })
    })

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

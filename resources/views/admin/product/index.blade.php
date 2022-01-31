@extends('admin.layouts.app')
@section('header')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin') }}">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Product</li>
    </ol>
</nav>
<h1 class="h3 mb-0 text-gray-800">Product</h1>
{{-- <p class="mb-4">Description</p> --}}

@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <a class="btn btn-sm btn-primary float-right" href="{{ route('product.create') }}"><i
                        class="fas fa-plus"></i> Tambah Product</a>
                <h6 class="m-0 font-weight-bold text-primary">List Product</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Price</th>
                                <th>Unit</th>
                                <th>Weight</th>
                                <th>Gambar</th>
                                <th>Stock</th>
                                <th>Discount</th>
                                <th>Aksi</>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                            <tr>
                                <td>{{$product->name}}</td>
                                <td> {!! $product->description !!} </td>
                                <td>Rp {{number_format($product->price,0,",",".")}}</td>
                                <td>{{$product->unit}}</td>
                                <td>{{$product->weight}}</td>
                                <td><a href="{{asset('storage/images/products/'.$product->image)}}">{{$product->image}}</a></td>
                                <td>{{$product->stock}}</td>
                                <td>{{$product->discount}}</td>
                                <td class="text-center">
                                    <form action="{{ route('product.destroy', $product->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('Apakah anda yakin menghapus data ini?')">
                                        @csrf
                                        @method('delete')
                                        <a class="btn btn-sm btn-info"
                                            href="{{ route('product.edit', $product->id) }}"><i
                                                class="far fa-edit"></i> Edit</a>
                                        <button type="submit" class="btn btn-sm btn-outline-danger"><i
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
<script>
    $('#dataTable').DataTable({
            columnDefs: [{
                targets: 1,
                render: function (data, type, row) {
                    data = data.replace(/<(?:.|\\n)*?>/gm, '');
                    if(type === 'display' && data.length > 90){
                        return data.substr(0, 90) + '…';
                    }else{
                        return data;
                    }
                }
            }]
        });
</script>
@endpush
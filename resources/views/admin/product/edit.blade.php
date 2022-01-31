@extends('admin.layouts.app')
@section('header')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('product.index') }}">Product</a></li>
        <li class="breadcrumb-item active" aria-current="page">Edit Product</li>
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
                <h6 class="m-0 font-weight-bold text-primary">Edit Product</h6>
            </div>
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
            <div class="card-body">
                <form action="{{ route('product.update', $product->id )}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="name">Nama</label>
                            <input type="text" class="form-control" name="name" id="name"
                                placeholder="ex: Lele Bumbu Kuning" value="{{old('name') ?? $product->name  }}" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="name">Price</label>
                            <div class="input-group">
                                <span class="input-group-text" id="price">Rp</span>
                                <input type="double" class="form-control" name="price" id="price"
                                    placeholder="Masukan Harga" value="{{old('price') ?? $product->price }}" required>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="name">Unit</label>
                            <input type="text" class="form-control" name="unit" id="unit" placeholder="ex: 100 gr"
                                value="{{old('unit')?? $product->unit }}" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="name">Stock</label>
                            <input type="number" class="form-control" name="stock" id="stock"
                                placeholder="Masukan stock barang" value="{{old('stock')?? $product->stock }}" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="name">Discount</label>
                            <div class="input-group">
                                <input type="number" class="form-control" name="discount" id="discount"
                                    placeholder="Max 100" max="100" value="{{old('discount')?? $product->discount }}">
                                <span class="input-group-text" id="discount">%</span>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="name">Gambar Product</label>
                            <div class="input-group">
                                <input type="file" class="form-control" name="image" id="image"
                                    accept="image/png,image/jpeg,image/jpg" value="{{old('image')?? $product->image }}">
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="form-group col-md-6">
                            <label for="name">Berat</label>
                            <div class="input-group">
                                <input type="number" class="form-control" name="weight" id="weight"
                                    placeholder="ex: 100"  value="{{old('weight') ?? $product->weight }}" required>
                                <span class="input-group-text" id="weight">gram</span>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="form-group col-md-12">
                            <label for="description">Deskripsi Product</label>
                            <textarea class="form-control" id="description" name="description"
                                rows="3">{{ old('description') ?? $product->description }}</textarea>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end">
                        <a class="btn btn-secondary mr-3" href="{{ route('product.index') }}">Cancel</a>
                        <button class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@push('css')
<link href="{{asset('vendor/summernote/summernote-bs4.min.css')}}" rel="stylesheet">
@endpush
@push('js')
<script src="{{asset('vendor/summernote/summernote-bs4.min.js')}}"></script>
<script>
$(document).ready(function() {
    $('#description').summernote({
        placeholder: 'Ketik disini..',
        height: 200
    });
});
</script>
@endpush
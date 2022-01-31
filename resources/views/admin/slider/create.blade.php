@extends('admin.layouts.app')
@section('header')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin') }}">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Slider</li>
    </ol>
</nav>
<h1 class="h3 mb-0 text-gray-800">Slider Landing</h1>
{{-- <p class="mb-4">Description</p> --}}

@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Tambah slider</h6>
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
                <form action="{{ route('slider.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="name">Title</label>
                            <input type="text" class="form-control" name="title" id="title"
                                placeholder="ex: Investasi Mulai RP 50.000" value="{{old('title') }}">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="name">Description</label>
                            <input type="text" class="form-control" name="description" id="description"
                                placeholder="ex: Investasi membantu peternak ..." value="{{old('description') }}">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="name">link</label>
                            <input type="text" class="form-control" name="link" id="link" placeholder="ex: https://www.panak.id/"
                                value="{{old('link') }}">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="name">Gambar slider</label>
                            <div class="input-group">
                                <input type="file" class="form-control" name="image" id="image"
                                    accept="image/png,image/jpeg,image/jpg" value="{{old('image') }}">
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end">
                        <a class="btn btn-secondary mr-3" href="{{ route('slider.index') }}">Cancel</a>
                        <button class="btn btn-primary">Submit</button>
                    </div>
                </form>
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
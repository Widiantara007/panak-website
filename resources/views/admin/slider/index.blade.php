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
                <a class="btn btn-sm btn-primary float-right" href="{{ route('slider.create') }}"><i
                        class="fas fa-plus"></i> Tambah Slider</a>
                <h6 class="m-0 font-weight-bold text-primary">List Sliders</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Link</th>
                                <th>Aksi</>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sliders as $slider)
                            <tr>
                                <td>{{$slider->title}}</td>
                                <td>{{$slider->description}}</td>
                                <td>{{$slider->link}}</td>
                                <td class="text-center">
                                    <form action="{{ route('slider.destroy', $slider->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('Apakah anda yakin menghapus data ini?')">
                                        @csrf
                                        @method('delete')
                                        <a class="btn btn-sm btn-info"
                                            href="{{ route('slider.edit', $slider->id) }}"><i
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
@include('admin.plugins.dataTables-set-js')
@endpush
@extends('admin.layouts.app')
@section('header')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin') }}">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Porject Type</li>
    </ol>
</nav>
<h1 class="h3 mb-0 text-gray-800">Project Type</h1>
{{-- <p class="mb-4">Description</p> --}}

@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <a class="btn btn-sm btn-primary float-right" href="{{route('project-type.create')}}" data-toggle="modal" data-target="#modal"> <i
                        class="fas fa-plus"></i> Tambah Tipe</a>
            <h6 class="m-0 font-weight-bold text-primary">List type</h6>

                <!-- Modal -->
                <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Tambah Tipe Project</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
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
                                    <form method="post" action="{{ route('project-type.store') }}" autocomplete="off"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-group col-md-12">
                                            <label for="name">Nama </label>
                                            <input type="text" class="form-control" name="name" id="name"
                                                placeholder="ex: ayam" value="{{old('name') }}">
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="name">Image </label>
                                            <input type="file" class="form-control" name="image" id="image"
                                                accept="image/png,image/jpeg,image/jpg" placeholder=""
                                                value="{{old('name') }}">
                                        </div>
                                        <div class="text-center">
                                            <button type="button" class="btn btn-Warning mt-4"
                                                data-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-success mt-4">Save</button>
                                        </div>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Gambar</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($types as $index=>$type)
                            <tr>
                                <td>{{$type->name}}</td>
                                <td><a href="{{asset('storage/images/project-types/'.$type->image)}}">{{$type->image}}</a></td>
                                <td class="text-center">
                                    <form action="{{ route('project-type.destroy', $type->id) }}" method="POST"
                                        onsubmit="return confirm('Apakah anda yakin menghapus data ini?')">
                                        @csrf
                                        @method('delete')
                                        <a class="btn btn-sm btn-info"
                                            href="{{ route('project-type.edit', $type->id) }}" data-toggle="modal"
                                            data-target="#modal{{$index}}">
                                            <i class="far fa-edit"></i> Edit</a>
                                        <!-- modal -->
                                        <button type="submit" class="btn btn-sm btn-outline-danger"><i
                                                class="far fa-trash-alt"></i> Hapus</button>
                                    </form>
                                    <div class="modal fade" id="modal{{$index}}" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Tambah type</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form method="post" action="{{ route('project-type.update',$type->id) }}"
                                                        autocomplete="off" enctype="multipart/form-data">
                                                        @csrf
                                                        @method('patch')
                                                        <div class="row">
                                                            <div class="form-group col-md-12">
                                                                <label for="name">Nama type</label>
                                                                <input type="text" class="form-control" name="name"
                                                                    id="name" placeholder="ex: Mandiri"
                                                                    value="{{old('name') ?? $type->name  }}">
                                                            </div>
                                                            <div class="form-group col-md-12">
                                                                <label for="name">Image </label>
                                                                <input type="file" class="form-control" name="image"
                                                                    id="image" accept="image/png,image/jpeg,image/jpg"
                                                                    placeholder="" value="{{old('iamge') ?? $type->image }}">
                                                            </div>
                                                            <div class="text-center">
                                                                <button type="button" class="btn btn-Warning mt-4"
                                                                    data-dismiss="modal">Cancel</button>
                                                                <button type="submit"
                                                                    class="btn btn-success mt-4">Save</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
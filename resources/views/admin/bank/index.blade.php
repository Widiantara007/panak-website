@extends('admin.layouts.app')
@section('header')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin') }}">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Bank</li>
    </ol>
</nav>
<h1 class="h3 mb-0 text-gray-800">Bank</h1>
{{-- <p class="mb-4">Description</p> --}}

@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <a class="btn btn-sm btn-primary float-right" href="{{ route('bank.create') }}" data-toggle="modal"
                    data-target="#modal"> <i class="fas fa-plus"></i> Tambah Bank</a>
                <!-- Modal -->
                <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Tambah Bank</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form method="post" action="{{ route('bank.store') }}" autocomplete="off"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <label for="name">Nama Bank</label>
                                            <input type="text" class="form-control" name="name" id="name"
                                                placeholder="ex: Mandiri" value="{{old('name') }}">
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="name">Code Bank</label>
                                            <input type="text" class="form-control" name="code" id="code"
                                                placeholder="ex: 008" value="{{old('code') }}">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                            <button type="button" class="btn btn-Warning mt-4"
                                                data-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-primary mt-4">Save</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <h6 class="m-0 font-weight-bold text-primary">List Bank</h6>
            </div>


            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Code</th>
                                <th>Aksi</>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($banks as $index=>$bank)
                            <tr>
                                <td>{{$bank->name}}</td>
                                <td>{{$bank->code}}</td>
                                <td class="text-center">
                                    <form action="{{ route('bank.destroy', $bank->id) }}" method="POST"
                                        onsubmit="return confirm('Apakah anda yakin menghapus data ini?')">
                                        @csrf
                                        @method('delete')
                                        <a class="btn btn-sm btn-info" href="{{ route('bank.edit', $bank->id) }}"
                                            data-toggle="modal" data-target="#modal{{$index}}">
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
                                                    <h5 class="modal-title" id="exampleModalLabel">Tambah Bank</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form method="post" action="{{ route('bank.update',$bank->id) }}"
                                                        autocomplete="off" enctype="multipart/form-data">
                                                        @csrf
                                                        @method('patch')
                                                        <div class="row">
                                                            <div class="form-group col-md-12">
                                                                <label for="name">Nama Bank</label>
                                                                <input type="text" class="form-control" name="name"
                                                                    id="name" placeholder="ex: Mandiri"
                                                                    value="{{old('name') ?? $bank->name  }}">
                                                            </div>
                                                            <div class="form-group col-md-12">
                                                                <label for="name">Code</label>
                                                                <input type="text" class="form-control" name="code"
                                                                    id="name" placeholder="ex: 008"
                                                                    value="{{old('code') ?? $bank->code  }}">
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                                                <button type="button" class="btn btn-Warning mt-4"
                                                                    data-dismiss="modal">Cancel</button>
                                                                <button type="submit"
                                                                    class="btn btn-primary mt-4">Save</button>
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
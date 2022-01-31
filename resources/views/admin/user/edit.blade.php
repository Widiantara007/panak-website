@extends('admin.layouts.app')
@section('header')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin') }}">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">User</li>
    </ol>
</nav>
<h1 class="h3 mb-0 text-gray-800">User</h1>
{{-- <p class="mb-4">Description</p> --}}

@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Edit User</h6>
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
                <form action="{{ route('user.update', $user->id )}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="name">Nama</label>
                            <input type="text" class="form-control" name="name" id="name" placeholder=""
                                value="{{old('name') ?? $user->name  }}">
                        </div>
                        <!-- <div class="form-group col-md-6">
                            <label for="name">Google Id</label>
                            <input type="text" class="form-control" name="google_id" id="name" placeholder=""
                                value="{{old('google_id') ?? $user->google_id  }}">
                        </div> -->
                        <div class="form-group col-md-6">
                            <label for="name">Email</label>
                            <input type="text" class="form-control" name="email" id="unit" placeholder=""
                                value="{{old('email')?? $user->email }}">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="name">Photo Profile</label>

                            <input type="file" class="form-control" name="photo_profile" id="photo_profile"
                                accept="image/png,image/jpeg,image/jpg"
                                value="{{old('photo_profile')?? $user->photo_profile }}">
                            <small class="form-text text-muted">Kosongkan jika tidak diubah</small>

                        </div>
                        <div class="form-group col-md-12">
                            <br>
                            <a class="btn btn-secondary mr-3" href="{{ route('user.index') }}">Cancel</a>
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
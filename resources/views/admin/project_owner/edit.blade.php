@extends('admin.layouts.app')
@section('header')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('project-owner.index') }}">Project Owner</a></li>
        <li class="breadcrumb-item active" aria-current="page">Edit Data</li>
    </ol>
</nav>
<h1 class="h3 mb-0 text-gray-800">Project Owner</h1>
{{-- <p class="mb-4">Description</p> --}}

@endsection
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Edit Data</h6>
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
                <form action="{{ route('project-owner.update', $project_owner->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="name">Nama</label>
                            <input type="text" class="form-control" name="name" id="name" placeholder="ex: Burhan Alinurdin" value="{{ old('name') ?? $project_owner->name }}">
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="form-group col-md-12">
                            <label for="description">Deskripsi (Profil Peternak)</label>
                            <textarea class="form-control" id="description" name="description" rows="3">{{ old('description') ?? $project_owner->description }}</textarea>
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-end">
                        <a class="btn btn-secondary mr-3" href="{{ route('project-owner.index') }}">Cancel</a>
                        <button class="btn btn-primary">Save</button>
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
    $(document).ready(function () {
        $('#description').summernote({
            placeholder: 'Ketik disini..',
            height: 200
        });
    });

</script>
@endpush

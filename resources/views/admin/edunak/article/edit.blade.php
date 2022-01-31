@extends('admin.layouts.app')
@section('header')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin') }}">Home</a></li>
        <li class="breadcrumb-item" aria-current="page"><a href="{{ route('edunak-article.index') }}">Edunak Article</a></li>
        <li class="breadcrumb-item active" aria-current="page">Edit Data</li>
    </ol>
</nav>
<h1 class="h3 mb-0 text-gray-800">Edunak Article</h1>
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
                <form action="{{ route('edunak-article.update', $article->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="category">Kategori</label>
                            <select class="form-control" id="category" name="category_id">
                                @php
                                    $selected_category = old('category') ?? $article->category_id ?? null;
                                @endphp
                                <option value="0" selected disabled>Pilih Kategori</option>
                                @foreach ($categories as $category)
                                <option value="{{ $category->id}}" {{$selected_category == $category->id ? 'selected':''}}>{{ $category->category }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="form-group col-md-6">
                            <label for="title">Judul</label>
                            <input type="text" class="form-control" name="title" id="title"
                            placeholder="ex: Cara Budidaya Ikan Air Laut" value="{{old('title') ?? $article->title }}">
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="form-group col-md-3">
                            <label for="cover_image">Gambar Cover</label>
                            <input type="file" class="form-control" name="cover_image" id="cover_image" accept="image/*">
                            <small class="form-text text-muted">Kosongkan jika tidak diubah</small>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="form-group col-md-12">
                            <label for="content">Konten</label>
                            <textarea class="form-control" id="content_article" name="content"
                                rows="3">{{ old('content') ?? $article->content }}</textarea>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="form-group col-md-6">
                            <label for="tags">Tags</label>
                            <select class="form-control" name="tags[]" id="tags" multiple="multiple">
                                @forelse ((array)old('tags') as $tag)
                                <option selected="selected">{{$tag}}</option>
                                @empty
                                    @forelse ($article->tags as $tag)
                                    <option selected="selected">{{$tag}}</option>
                                        
                                    @empty
                                
                                    @endforelse
                                @endforelse
                                
                            </select>
                            <small class="form-text text-muted">Use <strong> comma (,) or enter</strong> to insert tags</small>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="form-group col-md-8">
                        <label for="is_published">Status</label> <br>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="is_published" id="is_published1" value="0" checked>
                            <label class="form-check-label" for="is_published1">Draft</label>
                          </div>
                          <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="is_published" id="is_published2" value="1" {{old('is_published') || $article->is_published ? 'checked':''}}>
                            <label class="form-check-label" for="is_published2">Published</label>
                          </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end">
                        <a class="btn btn-secondary mr-3" href="{{ route('edunak-article.index') }}">Cancel</a>
                        <button class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@include('admin.plugins.select2')
@push('css')
<link href="{{asset('vendor/summernote/summernote-bs4.min.css')}}" rel="stylesheet">
@endpush
@push('js')
<script src="{{asset('vendor/summernote/summernote-bs4.min.js')}}"></script>
<script>
$(document).ready(function() {
    $('#content_article').summernote({
        placeholder: 'Ketik disini..',
        height: 400
    });
});
</script>
<script>
    $("#tags").select2({
  tags: true,
  tokenSeparators: [',']
});
</script>


@endpush
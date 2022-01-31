@extends('admin.layouts.app')
@section('header')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin') }}">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Edunak Article</li>
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
                <a class="btn btn-sm btn-primary float-right" href="{{ route('edunak-article.create') }}"><i
                        class="fas fa-plus"></i> Tambah Data</a>
                <h6 class="m-0 font-weight-bold text-primary">List Data</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Kategori</th>
                                <th>Judul</th>
                                <th>Slug</th>
                                <th>Gambar Cover</th>
                                <th>Konten</th>
                                <th>Tags</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($articles as $article)
                            <tr>
                                <td>{{ $article->category->category }}</td>
                                <td>{{ $article->title }}</td>
                                <td>{{ $article->slug }}</td>
                                <td><a href="{{asset('storage/images/edunak/articles/'.$article->cover_image)}}">{{$article->cover_image}}</a></td>
                                <td>{!! $article->content !!}</td>
                                <td>
                                    
                                    @foreach ($article->tags as $tag)
                                    <span class="badge badge-secondary p-1">{{$tag}}</span>
                                    @endforeach
                                    
                                </td>
                                <td>{!! $article->is_published ? '<span class="badge badge-success p-1">Published</span>':'<span class="badge badge-warning p-1">Draft</span>' !!}</td>
                                <td class="text-center">
                                    <form action="{{ route('edunak-article.destroy', $article->id) }}"
                                        method="POST" onsubmit="return confirm('Apakah anda yakin menghapus artikel ini?')">
                                        @csrf
                                        @method('delete')
                                        <a class="btn btn-sm btn-info"
                                            href="{{ route('edunak-article.edit', $article->id) }}"><i class="far fa-edit"></i> Edit</a>
                                        <button type="submit" class="btn btn-sm btn-outline-danger"><i class="far fa-trash-alt"></i> Hapus</button>
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
                targets: 4,
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

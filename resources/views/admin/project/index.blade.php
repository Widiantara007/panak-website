@extends('admin.layouts.app')
@section('header')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin') }}">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Project</li>
    </ol>
</nav>
<h1 class="h3 mb-0 text-gray-800">Project</h1>
{{-- <p class="mb-4">Description</p> --}}

@endsection
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <a class="btn btn-sm btn-primary float-right" href="{{ route('project.create') }}"><i class="fas fa-plus"></i> Tambah Data</a>
                <h6 class="m-0 font-weight-bold text-primary">List Data</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Pemilik</th>
                                <th>Kategori</th>
                                <th>Lokasi</th>
                                <th>Gambar</th>
                                <th>Risk Grade</th>
                                <th>Prospektus</th>
                                <th>Deskripsi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                use App\Models\Address;       
                            @endphp
                            @foreach ($projects as $project)
                                <tr>
                                    <td>{{ $project->name }}</td>
                                    <td>{{ $project->project_owner->name }}</td>
                                    <td>{{ $project->type }}</td>
                                    <td>{{Address::getFullAddress($project->location_code)}}</td>
                                    <td><a href="{{asset('storage/images/projects/'.$project->image)}}">{{$project->image}}</a></td>
                                    <td>{{ $project->risk_grade }}</td>
                                    <td><a href="{{asset('storage/prospektus/'.$project->prospektus_file)}}">{{$project->prospektus_file}}</a></td>
                                    <td>{!! $project->description !!}</td>
                                    <td class="text-center">
                                        <form action="{{ route('project.destroy', $project->id) }}"
                                            method="POST" onsubmit="return confirm('Apakah anda yakin menghapus data ini?')">
                                            @csrf
                                            @method('delete')
                                            <a class="btn btn-sm btn-primary mb-2"
                                                href="{{ route('project.show', $project->id) }}"><i class="far fa-eye"></i> Detail</a>
                                            <a class="btn btn-sm btn-info mb-2"
                                                href="{{ route('project.edit', $project->id) }}"><i class="far fa-edit"></i> Edit</a>
                                            <button type="submit" class="btn btn-sm btn-outline-danger mb-2"><i class="far fa-trash-alt"></i> Hapus</button>
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
                    targets: 7,
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

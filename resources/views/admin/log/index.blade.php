@extends('admin.layouts.app')
@section('header')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin') }}">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Log</li>
    </ol>
</nav>
<h1 class="h3 mb-0 text-gray-800">Logs</h1>
{{-- <p class="mb-4">Description</p> --}}

@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Logs Aktifitas User</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Workflow type</th>
                                <th>Activity</th>
                                <th>Description</th>
                                <th>Created at</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($logs as $log)
                            <tr>
                                <td>{{$log->user->name}}</td>
                                <td> {{ $log->workflow_type}} </td>
                                <td>{{$log->activity}}</td>
                                <td>{{$log->description}}</td>
                                <td>{{$log->created_at}}</td>
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
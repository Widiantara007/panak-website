@extends('admin.layouts.app')
@section('header')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('project.index') }}">Project</a></li>
        <li class="breadcrumb-item"><a href="{{ route('project.show', $project->id) }}">{{$project->name}}</a></li>
        <li class="breadcrumb-item active" aria-current="page">Tambah Batch</li>
    </ol>
</nav>
<h1 class="h3 mb-0 text-gray-800">Project {{$project->name}}</h1>
{{-- <p class="mb-4">Description</p> --}}

@endsection
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Tambah Batch</h6>
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
                <form action="{{ route('project.batch.store', $project->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="batch_no">Batch ke-</label>
                            <input type="number" class="form-control" name="batch_no" id="batch_no" min=1
                                value="{{old('batch_no') }}">
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="form-group col-md-6">
                            <label for="minimum_fund">Minimal Investasi</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" class="form-control" name="minimum_fund" id="minimum_fund" min=1
                                    value="{{ old('minimum_fund') ?? 50000}}" readonly>
                            </div>

                        </div>
                        <div class="form-group col-md-6">
                            <label for="maximum_fund">Maksimal Investasi</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" class="form-control" name="maximum_fund" id="maximum_fund" min=1
                                    value="{{ old('maximum_fund') }}">
                            </div>
                            <small class="form-text text-muted">Kosongkan jika tidak ada batas maksimum investasi per
                                orang</small>

                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="form-group col-md-12">
                            <label for="target_nominal">Target Total</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" class="form-control" name="target_nominal" id="target_nominal"
                                    min=1 value="{{ old('target_nominal') }}">
                            </div>

                            <small class="form-text text-muted">Jumlah Lot : <span id="lot_count">0</span> lot</small>
                        </div>
                    </div>
                    
                    <div class="row mt-3">
                        <div class="form-group col-md-4">
                            <label for="roi">Rentang ROI</label>
                            <div class="input-group">
                                <input type="number" class="form-control" name="roi_low" id="roi_low" min=1
                                    value="{{ old('roi_low') }}" placeholder="3">
                                <span class="mx-3 align-center font-weight-bold">-</span>
                                <input type="number" class="form-control" name="roi_high" id="roi_high" min=1
                                    value="{{ old('roi_high') }}" placeholder="7">
                                <span class="input-group-text">%</span>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="form-group col-md-8">
                            <label for="date">Tanggal Pelaksanaan Project</label>
                            <div class="input-group">
                                <input type="date" class="form-control" name="start_date" id="start_date"
                                    value="{{ old('start_date') }}" placeholder="3">
                                <span class="mx-3 align-center font-weight-bold">-</span>
                                <input type="date" class="form-control" name="end_date" id="end_date"
                                    value="{{ old('end_date') }}" placeholder="7">
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="form-group col-md-8">
                            <label for="date">Ada investasi tahunan?</label><br>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="is_yearly" id="inlineRadio1" value="1" >
                                <label class="form-check-label" for="inlineRadio1">Ada</label>
                              </div>
                              <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="is_yearly" id="inlineRadio2" value="0" checked>
                                <label class="form-check-label" for="inlineRadio2">Tidak Ada</label>
                              </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end">
                        <a class="btn btn-secondary mr-3" href="{{ route('project.show', $project->id) }}">Cancel</a>
                        <button class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
    <script>
        function count_lot(){
            var minimum_fund = $('#minimum_fund').val();
            var target_nominal = $('#target_nominal').val();
            var lot = target_nominal/minimum_fund;
            $('#lot_count').text(lot);
        }
        $(document).ready(function(){
            count_lot();
        });
        $('#minimum_fund, #target_nominal').on("keyup change load", function(){
            count_lot();
        });

        $('#start_date').change(function(){
            $('#end_date').attr("min", $('#start_date').val())
        });
    </script>
@endpush
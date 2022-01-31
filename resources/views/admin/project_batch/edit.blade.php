@extends('admin.layouts.app')
@section('header')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('project.index') }}">Project</a></li>
        <li class="breadcrumb-item"><a href="{{ route('project.show', $project->id) }}">{{$project->name}}</a></li>
        <li class="breadcrumb-item active" aria-current="page">Edit Batch</li>
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
                <h6 class="m-0 font-weight-bold text-primary">Edit Batch</h6>
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
                <form action="{{ route('project.batch.update', [$project->id, $project_batch->id]) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="batch_no">Batch ke-</label>
                            <input type="number" class="form-control" name="batch_no" id="batch_no" min=1
                                value="{{old('batch_no') ?? $project_batch->batch_no }}">
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="form-group col-md-6">
                            <label for="minimum_fund">Minimal Investasi</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" class="form-control" name="minimum_fund" id="minimum_fund" min=1
                                    value="{{ (old('minimum_fund') ?? $project_batch->minimum_fund) ?? 50000}}"
                                    readonly>
                            </div>

                        </div>
                        <div class="form-group col-md-6">
                            <label for="maximum_fund">Maksimal Investasi</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" class="form-control" name="maximum_fund" id="maximum_fund" min=1
                                    value="{{ old('maximum_fund') ?? $project_batch->maximum_fund }}">
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
                                    min=1 value="{{ old('target_nominal') ?? $project_batch->target_nominal }}">
                            </div>

                            <small class="form-text text-muted">Jumlah Lot : <span id="lot_count">0</span> lot</small>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="form-group col-md-4">
                            <label for="roi">Rentang ROI</label>
                            <div class="input-group">
                                <input type="number" class="form-control" name="roi_low" id="roi_low" min=1
                                    value="{{ old('roi_low') ?? $project_batch->roi_low }}" placeholder="3">
                                <span class="mx-3 align-center font-weight-bold">-</span>
                                <input type="number" class="form-control" name="roi_high" id="roi_high" min=1
                                    value="{{ old('roi_high') ?? $project_batch->roi_high }}" placeholder="7">
                                <span class="input-group-text">%</span>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="form-group col-md-8">
                            <label for="date">Tanggal Pelaksanaan Project</label>
                            <div class="input-group">
                                <input type="date" class="form-control" name="start_date" id="start_date"
                                    value="{{ old('start_date') ?? (date('Y-m-d', strtotime($project_batch->start_date))) }}"
                                    placeholder="3">
                                <span class="mx-3 align-center font-weight-bold">-</span>
                                <input type="date" class="form-control" name="end_date" id="end_date"
                                    value="{{ old('end_date') ?? (date('Y-m-d', strtotime($project_batch->end_date)))}}"
                                    placeholder="7">
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="form-group col-md-8">
                            <label for="date">Ada investasi tahunan?</label><br>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="is_yearly" id="inlineRadio1"
                                    value="1" {{$project_batch->is_yearly ? 'checked':''}}>
                                <label class="form-check-label" for="inlineRadio1">Ada</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="is_yearly" id="inlineRadio2"
                                    value="0" {{$project_batch->is_yearly ? '':'checked'}}>
                                <label class="form-check-label" for="inlineRadio2">Tidak Ada</label>
                            </div>
                        </div>
                    </div>
                    @if((isset($project_batch->gross_income) || isset($project_batch->roi)) && $project_batch->status != 'paid')
                    <div class="row mt-3">
                        <div class="form-group col-md-12">
                            <label for="target_nominal">Pendapatan Kotor</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" class="form-control" name="gross_income" id="gross_income" min=1
                                    value="{{ old('gross_income') ?? $project_batch->gross_income }}">
                            </div>
                         
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="form-group col-md-12">
                            <label for="gross_income">ROI</label>
                            <div class="input-group">
                                <input type="number" class="form-control" name="roi" id="roi" step="0.1"
                                    value="{{ old('roi') ?? $project_batch->roi }}" required>
                                <span class="input-group-text">%</span>

                            </div>

                            <small class="form-text text-muted">Jumlah Lot : <span id="lot_count">{{$project_batch->totalLot()}}</span> lot</small>

                            <small class="form-text text-muted">Return per Lot : <span>Rp.</span> <span id="return_count">0</span></small>
                        </div>
                    </div>
                    @push('js')
                    <script>
                        function count_return(){
                            var total_lot = parseInt($('#lot_count').text());
                            var minimum_fund = {{$project_batch->minimum_fund}};
                            var gross_income = $('#gross_income').val();
                            var roi = $('#roi').val();
                            var return_lot = minimum_fund + (minimum_fund*roi/100);
                            $('#return_count').text(Math.floor(return_lot));
                        }
                        
                        $('#roi').on("keyup change load", function(){
                            count_return();
                        });
                        count_return();

                    </script>
                    @endpush
                    @endif

                    <div class="d-flex justify-content-end">
                        <a class="btn btn-secondary mr-3" href="{{ route('project.show', $project->id) }}">Cancel</a>
                        <button class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
<script>
    function count_lot() {
        var minimum_fund = $('#minimum_fund').val();
        var target_nominal = $('#target_nominal').val();
        var lot = target_nominal / minimum_fund;
        $('#lot_count').text(lot);
    }
    $(document).ready(function () {
        count_lot();
    });
    $('#minimum_fund, #target_nominal').on("keyup change load", function () {
        count_lot();
    });

    $('#start_date').change(function () {
        $('#end_date').attr("min", $('#start_date').val())
    });

</script>
@endpush

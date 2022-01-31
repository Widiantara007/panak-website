@extends('admin.layouts.app')
@section('header')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('project.index') }}">Project</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{$project->name}}</li>
    </ol>
</nav>
<h1 class="h3 mb-0 text-gray-800">{{$project->name}}</h1>
@endsection
@php
use Carbon\Carbon;
Carbon::setLocale('id');
@endphp
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <a class="btn btn-sm btn-primary float-right"
                    href="{{ route('project.batch.create', $project->id) }}"><i class="fas fa-plus"></i> Tambah Data</a>
                <h6 class="m-0 font-weight-bold text-primary">Project Batches</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Batch ke-</th>
                                <th>Minimal Investasi</th>
                                <th>Maksimal Investasi</th>
                                <th>Target Total</th>
                                <th>Jumlah Lot</th>
                                <th>Rentang ROI</th>
                                <th>Ada investasi tahunan?</th>
                                <th>Tanggal Mulai</th>
                                <th>Tanggal Selesai</th>
                                <th>Status</th>
                                <th>ROI</th>
                                <th>Pendapatan Kotor</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($project->project_batches as $project_batch)
                            <tr>
                                <td>{{ $project_batch->batch_no }}</td>
                                <td>Rp. {{ number_format($project_batch->minimum_fund,0,",",".") }}</td>
                                <td>{{ empty($project_batch->maximum_fund) ? '-':'Rp. '. number_format($project_batch->maximum_fund,0,",",".")}}
                                </td>
                                <td>Rp. {{ number_format($project_batch->target_nominal,0,",",".") }}</td>
                                <td>{{ $project_batch->lot }}</td>
                                <td>{{ $project_batch->roi_low }} - {{ $project_batch->roi_high }}%</td>
                                <td>{{$project_batch->is_yearly ? 'Ada':'Tidak'}}</td>
                                <td>{{ Carbon::parse($project_batch->start_date)->isoFormat('dddd, D MMMM Y') }}</td>
                                <td>{{ Carbon::parse($project_batch->end_date)->isoFormat('dddd, D MMMM Y') }}</td>
                                <td>{{ $project_batch->status }}</td>
                                <td>{{ empty($project_batch->roi) ? '-': $project_batch->roi.' %'}}</td>
                                <td>{{ empty($project_batch->gross_income) ? '-':'Rp. '. number_format($project_batch->gross_income,0,",",".")}}
                                </td>
                                <td class="text-center">
                                    @if ($project_batch->status == 'draft')
                                    <form
                                        action="{{ route('project.batch.status.update', [$project->id, $project_batch->id]) }}"
                                        method="POST" onsubmit="return confirm('Apakah anda yakin membuka batch ini?')">
                                        @csrf
                                        @method('PATCH')
                                        <input type="text" name="status" value="funding" hidden>
                                        <button type="submit" class="btn btn-sm btn-success mb-2"><i
                                                class="fas fa-lock-open"></i> Open</button>
                                    </form>
                                    @elseif($project_batch->status == 'funding')
                                    <form
                                        action="{{ route('project.batch.status.update', [$project->id, $project_batch->id]) }}"
                                        method="POST" onsubmit="return confirm('Apakah anda yakin memulai batch ini?')">
                                        @csrf
                                        @method('PATCH')
                                        <input type="text" name="status" value="ongoing" hidden>
                                        <button class="btn btn-sm btn-warning mb-2"><i class="fas fa-play"></i>
                                            Start</button>
                                    </form>
                                    @elseif($project_batch->status == 'ongoing')
                                    <button type="button" class="btn btn-sm btn-danger mb-2" data-toggle="modal"
                                        data-target="#closedModal{{$project_batch->id}}">
                                        <i class="fas fa-stop"></i> Close
                                    </button>

                                    <!-- Modal -->
                                    <div class="modal fade" id="closedModal{{$project_batch->id}}" tabindex="-1"
                                        aria-labelledby="closedModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Tutup Project Batch
                                                    </h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form
                                                    action="{{ route('project.batch.status.update', [$project->id, $project_batch->id]) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Apakah anda yakin menutup batch ini?')">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="text" name="status" value="closed" hidden>

                                                    <div class="modal-body">
                                                        <div class="row mt-3">
                                                            <div class="form-group col-md-12">
                                                                <label for="gross_income">Pendapatan Kotor</label>
                                                                <div class="input-group">
                                                                    <span class="input-group-text">Rp</span>
                                                                    <input type="number" class="form-control" name="gross_income" id="gross_income"
                                                                        min=1 value="{{ old('gross_income') }}">
                                                                </div>
                                    
                                                            </div>
                                                        </div>
                                                        <div class="row mt-3">
                                                            <div class="form-group col-md-12">
                                                                <label for="gross_income">ROI</label>
                                                                <div class="input-group">
                                                                    <input type="number" class="form-control" name="roi" id="roi" step="0.1"
                                                                        value="{{ old('roi') }}" required>
                                                                    <span class="input-group-text">%</span>

                                                                </div>
                                    
                                                                <small class="form-text text-muted">Jumlah Lot : <span id="lot_count">{{$project_batch->totalLot()}}</span> lot</small>

                                                                <small class="form-text text-muted">Return per Lot : <span>Rp.</span> <span id="return_count">0</span></small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Cancel</button>
                                                        <button class="btn btn-sm btn-danger mb-2"><i
                                                                class="fas fa-stop"></i> Close Project Batch</button>

                                                    </div>
                                                </form>

                                            </div>
                                        </div>
                                    </div>


                                    @elseif($project_batch->status == 'closed')
                                    <form action="{{ route('project.batch.payReturn', [$project->id, $project_batch->id]) }}"
                                        method="POST"
                                        onsubmit="return confirm('Apakah anda yakin akan meneruskan dana ke investor? AKSI INI BERSIFAT PERMANEN (TIDAK BISA DIBATALKAN/DIEDIT)')">
                                        @csrf
                                        @method('PATCH')
                                    <button type="submit" class="btn btn-sm btn-primary mb-2"><i class="fas fa-dollar-sign"></i>
                                        Pay</button>
                                    </form>
                                    @endif
                                    <form
                                        action="{{ route('project.batch.destroy', [$project->id, $project_batch->id]) }}"
                                        method="POST"
                                        onsubmit="return confirm('Apakah anda yakin menghapus data ini?')">
                                        @csrf
                                        @method('delete')
                                        <a class="btn btn-sm btn-info mb-2"
                                            href="{{ route('project.batch.edit', [$project->id, $project_batch->id]) }}"><i
                                                class="far fa-edit"></i> Edit</a>
                                        <button type="submit" class="btn btn-sm btn-outline-danger mb-2"><i
                                                class="far fa-trash-alt"></i> Hapus</button>
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

<script>
        function count_return(){
            var total_lot = parseInt($('#lot_count').text());
            var minimum_fund = {{$project_batch->minimum_fund ?? 50000}};
            var gross_income = $('#gross_income').val();
            var roi = $('#roi').val();
            var return_lot = minimum_fund + (minimum_fund*roi/100);
            $('#return_count').text(Math.floor(return_lot));
        }
        
        $('#roi').on("keyup change load", function(){
            count_return();
        });

        
</script>

@include('admin.plugins.dataTables-js')
@include('admin.plugins.dataTables-set-js')
@endpush

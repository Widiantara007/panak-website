@extends('layouts.app')
@section('title','Bisnak')
@section('content')
@php
use Carbon\Carbon;
Carbon::setLocale('id');
@endphp
<div class="container">
    <div class="row py-2">
        <div class="col">
            <form action="{{ route('investnak') }}">
                <div class="input-group rounded shadow">
                    <input type="search" class="form-control rounded" name="search"
                        value="{{ Request::get('search') ?? '' }}" placeholder="Search" aria-label="Search"
                        list="datalistOptions" id="exampleDataList" aria-describedby="search-addon" />
                    <datalist id="datalistOptions">
                        @foreach ($project_all as $p)
                        <option value="{{$p}}">
                            @endforeach
                    </datalist>
                    <span class="input-group-text border-0" id="search-addon">
                        <button type="submit" class="btn">
                            <i class="fas fa-search" type="submit"></i>
                        </button>
                    </span>
                </div>
            </form>
        </div>
    </div>
    <div class="row pt-2">
        <div class="col-lg-3 pt-2">
            <div class="sticky-top" id="sticky-sidebar">
                <div class="card shadow">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="pt-2">Filter</h5>
                            <i class="fas fa-angle-down" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseExample" aria-expanded="true"
                                aria-controls="collapseExample"></i>
                        </div>
                        <form action="{{ route('investnak') }}">
                            @php
                            $category = Request::get('category');
                            @endphp
                            <input type="hidden" name="search" value="{{ Request::get('search') ?? '' }}">
                            <div class="collapse show" id="collapseExample">

                                <ul class="list-group list-group-flush border-bottom ">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <li class="list-group-item border-0 fw-bold">Kategori</li>
                                        <i class="fas fa-angle-right" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseExample2" aria-expanded="true"
                                            aria-controls="collapseExample2"></i>
                                    </div>
                                    <div class="collapse show" id="collapseExample2">
                                        @foreach ($project_types as $project_type)
                                        <li class="list-group-item border-0">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    value="{{ $project_type->name }}"
                                                    id="category{{ $project_type->id }}" name="category[]"
                                                    {{ !empty($category) ? (in_array($project_type->name, $category) ? 'checked':''):'checked' }}>
                                                <label class="form-check-label" for="category{{ $project_type->id }}">
                                                    {{ $project_type->name }}
                                                </label>
                                            </div>
                                        </li>
                                        @endforeach

                                    </div>
                                </ul>

                                <ul class="list-group list-group-flush border-bottom">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <li class="list-group-item border-0 fw-bold">ROI Minimal</li>
                                        <i class="fas fa-angle-right" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseExample4" aria-expanded="true"
                                            aria-controls="collapseExample4"></i>
                                    </div>
                                    <div class="collapse show" id="collapseExample4">
                                        <li class="list-group-item border-0">
                                            <div class="input-group">
                                                <input type="number" class="form-control" name="roi_low" id="roi_low"
                                                    min=1 value="{{ Request::get('roi_low') ?? null }}" placeholder="-">
                                                <span class="input-group-text">%</span>
                                            </div>
                                        </li>

                                    </div>
                                </ul>
                                <ul class="list-group list-group-flush mt-3">
                                    <div class="d-flex justify-content-end align-items-center">
                                        <button type="submit" class="btn btn-default">Terapkan</button>
                                    </div>
                                </ul>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-9 pt-2">
            <div class="row d-flex justify-content-start">
                @foreach ($project_batches as $project_batch)
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="card rounded border-0 h-100 shadow-sm" id="card-hover-special">
                        <a class="card-block stretched-link text-decoration-none {{ $project_batch->isFullyFunded() ? 'pe-none':'' }}"
                            href="{{ route('investnak.show', $project_batch->id) }}">

                            <div class="card border-0">
                                <div class="{{ $project_batch->isFullyFunded() ? 'bg-image' : '' }}">
                                    <img class="card-img-top"
                                        src="{{ asset('storage/images/projects/'.$project_batch->project->image) }}"
                                        alt="Card image cap" loading="lazy">
                                </div>
                                @if ($project_batch->isFullyFunded())
                                <div
                                    class="card-img-overlay bg-text card-img-top d-flex align-items-center justify-content-center">
                                    <h4 class="fw-bold bg-default-secondary text-white p-2">FULLY FUNDED</h4>
                                </div>
                                @endif
                            </div>
                            <div class="card-body d-flex flex-column">
                                <span class="badge rounded-pill bg-primary mb-2 pe-2"
                                    style="background-color:#FF8200 !important"><i class="fas fa-star pe-1"
                                        style="color:white;"></i>{{$project_batch->project->risk_grade}}</span>

                                <h6 class="card-title">{{ $project_batch->project->name }} - Batch
                                    {{ $project_batch->batch_no }}</h6>
                                    <div class=" mt-auto">
                                <div class="d-flex justify-content-between align-items-center"
                                    id="landing-projek-paragraph">
                                    <p class="float-left mb-0">Ditutup Pada</p>
                                    <p class="float-right mb-0">Tersisa</p>
                                </div>
                                <div class="d-flex justify-content-between align-items-center"
                                    id="landing-projek-paragraph">
                                    <p class="text-muted mb-1">
                                        {{Carbon::parse($project_batch->start_date)->isoFormat('D MMMM Y')}}</p>
                                    <p class="text-muted mb-1">{{$project_batch->daysLeft()}} hari lagi</p>
                                </div>
                                <p class="text-muted text-pendanaan mb-1"><i class="fas fa-user"></i>
                                    {{$project_batch->project->project_owner->name}}</p>
                                <div class="d-flex justify-content-between align-items-center"
                                    id="landing-projek-paragraph">
                                    <p class="float-left mb-2">Modal</p>
                                    <p class="float-right mb-2 text-roi">ROI
                                        {{$project_batch->roi_low.' - '.$project_batch->roi_high}} %</p>
                                </div>
                                <div class="progress">
                                    <div class="progress-bar" style="width: {{ $project_batch->totalPercentage() }}% ;background-color:#560043;" role="progressbar"
                                     aria-valuenow="{{ $project_batch->totalPercentage() }}" aria-valuemin="0" aria-valuemax="100">{{ $project_batch->totalPercentage() }}%
                                    </div>
                                </div>
                                <p class="text-pendanaan mt-2 nowrap-my-text-investnak"><span class="text-harga">Rp {{number_format($project_batch->totalInvestments(),0,",",".")}}</span>
                                    /<span class="fw-bold"> Rp
                                        {{number_format($project_batch->target_nominal,0,",",".")}}</span></p>
                                    <a  class="d-none"
                                        href="#"></a>
                                </div>
                            </div>


                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

@endsection
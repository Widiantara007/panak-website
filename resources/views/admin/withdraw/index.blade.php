@extends('admin.layouts.app')
@section('header')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin') }}">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">withdrawals</li>
    </ol>
</nav>
<h1 class="h3 mb-0 text-gray-800">Withdrawals</h1>
{{-- <p class="mb-4">Description</p> --}}

@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Daftar Withdrawals</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Name</th>
                                <th>Bank</th>
                                <th>Nomer Rekening</th>
                                <th>Saldo User</th>
                                <th>Nominal</th>
                                <th>Status</th>
                                <th>Feedback</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($withdrawals as $index =>$withdrawal)
                            <tr>
                                <td>{{$withdrawal->created_at}}</td>
                                <td>{{$withdrawal->user->name}}</td>
                                <td> {{$withdrawal->user_bank->bank->name}} </td>
                                <td> {{$withdrawal->user_bank->account_number}} </td>
                                <td>Rp {{number_format($withdrawal->user->balance,0,",",".")}}</td>
                                <td>Rp {{number_format($withdrawal->nominal,0,",",".")}}</td>
                                <td> {{$withdrawal->status}} </td>
                                <td> {{$withdrawal->feedback}} </td>
                                <td class="text-center">
                                    @if ( in_array($withdrawal->status, ['process', 'request']))
                                        
                                    <form action="{{ route('withdraw.acc', $withdrawal->id) }}" method="POST">
                                        @csrf
                                        @method('patch')
                                        <a class="btn btn-sm btn-outline-danger"
                                            href="{{ route('withdrawals.edit', $withdrawal->id) }}" data-toggle="modal"
                                            data-target="#modal{{$index}}">
                                            <i class="far fa-edit"></i> Tolak</a>
                                        <a class="btn btn-sm btn-primary" data-toggle="modal"
                                            data-target="#modalWithdrawal{{$index}}">
                                            <i class="far fa-edit"></i> Bayar</a>
                                        <!-- modal -->
                                        @if ($withdrawal->status != 'process')
                                        <button type="submit" class="btn btn-sm btn-success"><i
                                            class="fas fa-check"></i> Terima </button>
                                        @endif
                                        
                                    </form>
                                    <div class="modal fade" id="modal{{$index}}" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Tolak Request
                                                        Withdrawal</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form method="post"
                                                        action="{{ route('withdraw.reject',$withdrawal->id) }}"
                                                        autocomplete="off" enctype="multipart/form-data">
                                                        @csrf
                                                        @method('patch')
                                                        <div class="row">
                                                            <div class="form-group col-md-12">
                                                                <label for="name">Feedback</label>
                                                                <input type="text" class="form-control" name="feedback"
                                                                    id="name" placeholder=""
                                                                    value="{{old('feedback') ?? $withdrawal->feedback  }}">
                                                            </div>
                                                            <div class="text-center">
                                                                <button type="button" class="btn btn-Warning mt-4"
                                                                    data-dismiss="modal">Cancel</button>
                                                                <button type="submit"
                                                                    class="btn btn-success mt-4" onsubmit="return confirm('Apakah anda yakin menolak permintaan ini?')">Save</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal fade" id="modalWithdrawal{{$index}}" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Bayar</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form method="post"
                                                        action="{{ route('pay.withdrawal',$withdrawal->id) }}"
                                                        autocomplete="off" enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="row">
                                                            <div class="col-12 mb-3">
                                                                Nama User: {{$withdrawal->user->name}}
                                                            </div>
                                                            <div class="col-12 mb-3">
                                                                Saldo User: Rp. {{ number_format($withdrawal->user->balance,0,",",".") }}
                                                            </div>
                                                            <div class="col-12 mb-3">
                                                                Nominal Penarikan: Rp. {{ number_format($withdrawal->nominal,0,",",".") }}
                                                            </div>
                                                            <div class="col-12 mb-3">
                                                                <label for="nomorRekening" class="form-label">Nama Bank</label>
                                                                <input type="text" class="form-control" id="namaBank" name="bank"
                                                                    value="{{$withdrawal->user_bank->bank->name}}" readonly>
                                                            </div>
                                                            <div class="col-12 mb-3">
                                                                <label for="nomorRekening" class="form-label">Nomor Rekening</label>
                                                                <input type="number" class="form-control" id="nomorRekening" name="account_number"
                                                                    value="{{$withdrawal->user_bank->account_number}}" readonly>
                                                            </div>
                                                            <div class="col-12 mb-3">
                                                                <label for="namaRekening" class="form-label">Nama Pemilik Rekening</label>
                                                                <input type="text" class="form-control" id="namaRekening" name="holder_name"
                                                                    value="{{$withdrawal->user_bank->holder_name}}" readonly>
                                                            </div>
                                                            <div class="text-center">
                                                                <button type="button" class="btn btn-Warning mt-4"
                                                                    data-dismiss="modal">Cancel</button>
                                                                <button type="submit"
                                                                    class="btn btn-success mt-4" onsubmit="return confirm('Apakah anda yakin membayar penarikan dana ini?')">Bayar</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endif

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
    $(document).ready(function () {
        $('#dataTable').DataTable({
        "order": [[ 0, "desc" ]]
    });
    });
</script>

@endpush
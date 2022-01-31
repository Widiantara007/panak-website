@extends('admin.layouts.app')
@section('header')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin') }}">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">User Verification</li>
    </ol>
</nav>
<h1 class="h3 mb-0 text-gray-800">User Verification</h1>
{{-- <p class="mb-4">Description</p> --}}

@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">List Users</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Aksi</>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($user_profiles as $user_profile)

                            <tr>
                                <td>{{$user_profile->user->name}}</td>
                                <td>{{$user_profile->user->email}}</td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-success btn-sm" data-toggle="modal"
                                        data-target-id="{{$user_profile->id}}" data-target="#documentModal">View All
                                        Details</button>

                                </td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>


                    <!-- Modal -->
                    <div class="modal fade" id="documentModal" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Detail Dokumen</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body" id="documentBody">

                                    <div class="spinner-border d-flex justify-content-center" role="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>

                                </div>
                                <div class="modal-footer d-flex justify-content-between" id="documentFooter">

                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Modal Reject --}}
                    <div class="modal fade" id="rejectModal" aria-labelledby="rejectModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Reject Dokumen</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div id="rejectBody">



                                </div>

                            </div>
                        </div>
                    </div>
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
    $(document).ready(function () {
        $("#documentModal").on("show.bs.modal", function (e) {
            $("#documentBody").html('<div class="spinner-border d-flex justify-content-center" role="status"><span class="sr-only">Loading...</span></div>');
            var id = $(e.relatedTarget).data('target-id');
            $.get('/admin/user_verification/' + id, function (data) {
                $("#rejectBody").html(data.rejectBody);
                $("#documentBody").html(data.documentBody);
                $("#documentFooter").html(data.documentFooter);
            });

        });
    });

</script>

@include('admin.plugins.dataTables-js')
@include('admin.plugins.dataTables-set-js')
@endpush

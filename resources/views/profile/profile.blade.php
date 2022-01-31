@extends('profile.mastermenu')
@section('title','Profile')
@section('contentprofile')

<div class="col py-3">
    <h3 class="" id="menu-title">Akun saya</h3>
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
<div class="col">
    <div class="card">
        <div class="card-header bg-white border-0">
            <nav>
                <div class="nav" role="tablist" id="profile">
                    <a class="nav-link text-dark {{empty(Request::get('tab'))||Request::get('tab') == 'profile' ? 'active':''}}"
                        id="nav-DataDiri-tab" data-bs-toggle="tab" data-bs-target="#nav-DataDiri" type="button"
                        role="tab" aria-controls="nav-DataDiri" aria-selected="true"><i class="far fa-user"></i> Data
                        Diri</a>
                    <a class="nav-link text-dark {{Request::get('tab') == 'document' ? 'active':''}}"
                        id="nav-Dokumen-tab" data-bs-toggle="tab" data-bs-target="#nav-Dokumen" type="button" role="tab"
                        aria-controls="nav-Dokumen" aria-selected="false"><i class="far fa-file-alt"></i> Dokumen</a>
                    <a class="nav-link text-dark {{Request::get('tab') == 'bank' ? 'active':''}}" id="nav-AkunBank-tab"
                        data-bs-toggle="tab" data-bs-target="#nav-AkunBank" type="button" role="tab"
                        aria-controls="nav-AkunBank" aria-selected="false"><i class="far fa-credit-card"></i> Akun
                        Bank</a>
                </div>
            </nav>
        </div>
        <div class="card-body">
            <div class="tab-content" id="nav-tabContent">
                <!-- Tab Akun Profile -->
                <div class="tab-pane fade  {{empty(Request::get('tab'))||Request::get('tab') == 'profile' ? 'show active':''}}"
                    id="nav-DataDiri" role="tabpanel" aria-labelledby="nav-DataDiri-tab">
                    <div class="row">
                        <p class="text-muted my-0">Foto Profil</p>
                        <div class="col-lg-5 pt-3">
                            <div class="card">
                                <img src="{{ $user->getPhotoProfile()}}" alt="..." class="card-img-top rounded p-2">
                                <button type="button" class="btn btn-sm btn-outline-default mt-1 m-2"
                                    data-bs-toggle="modal" data-bs-target="#modalUbahFoto">
                                    Ubah Foto Profile
                                </button>
                                <!-- Modal Ubah Foto-->
                                <div class="modal fade" id="modalUbahFoto" tabindex="-1"
                                    aria-labelledby="modalUbahFotoLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="modalUbahFotoLabel">Ubah
                                                    Foto</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <form action="{{ route('profile.changePhotoProfile') }}" method="POST"
                                                enctype="multipart/form-data">
                                                @csrf
                                                @method('PATCH')
                                                <div class="modal-body">
                                                    <label for="exampleInputEmail1" class="form-label">Pilih
                                                        Gambar</label>
                                                    <input type="file" name="profile_image" class="form-control"
                                                        id="profile_image " accept="image/png, image/jpg, image/jpeg" />
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-default">Save
                                                        changes</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <p class="text-center pt-2 mb-0">Ukuran gambar: maks. 1 MB</p>
                                <p class="text-center pb-1">Format gambar: .JPEG, .PNG</p>
                            </div>
                        </div>
                        <div class="col-lg-7 pt-3">
                            <div class="mb-3 row">
                                <label for="namaProfile" class="col-sm-4 col-form-label fw-bold">Nama</label>
                                <div class="col-sm-8">
                                    <input type="text" readonly class="form-control-plaintext" id="namaProfile"
                                        value="{{$user->name}}">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="EmailProfile" class="col-sm-4 col-form-label fw-bold">Email</label>
                                <div class="col-sm-8">
                                    <input type="text" readonly class="form-control-plaintext" id="EmailProfile"
                                        value="{{$user->email}}">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="phoneProfile" class="col-sm-4 col-form-label fw-bold">Pekerjaan
                                    </label>
                                <div class="col-sm-8">
                                    <input type="text" readonly class="form-control-plaintext" id="jobProfile"
                                        value="{{!empty($user->profile) ? $user->profile->job : ''}}" placeholder="-">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="phoneProfile" class="col-sm-4 col-form-label fw-bold">No
                                    Telepon</label>
                                <div class="col-sm-8">
                                    <input type="text" readonly class="form-control-plaintext" id="phoneProfile"
                                        value="{{$user->no_hp}}" placeholder="-">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="genderProfile" class="col-sm-4 col-form-label fw-bold">Jenis
                                    Kelamin</label>
                                <div class="col-sm-8">
                                    <input type="text" readonly class="form-control-plaintext" id="genderProfile"
                                        value="{{!empty($user->profile->sex) ? ($user->profile->sex == 'male' ? 'Laki-laki':'Perempuan'):''}}"
                                        placeholder="-">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="tanggallahirProfile" class="col-sm-4 col-form-label fw-bold">Tanggal
                                    Lahir</label>
                                <div class="col-sm-8">
                                    <input type="text" readonly class="form-control-plaintext" id="tanggallahirProfile"
                                        value="{{!empty($user->profile->birthday) ? (date('d/m/Y', strtotime($user->profile->birthday))) :''}}"
                                        placeholder="-">
                                </div>
                            </div>
                            <div class="d-grid">
                                <button type="button" class="btn btn-sm btn-default mb-2" data-bs-toggle="modal"
                                    data-bs-target="#ubahProfileModal">
                                    Ubah Profile
                                </button>

                                <button type="button" class="btn btn-sm btn-outline-default" data-bs-toggle="modal"
                                    data-bs-target="#ubahPasswordModal">
                                    Ubah Password
                                </button>
                                <!-- Modal Ubah Profile -->
                                <div class="modal fade" id="ubahProfileModal" tabindex="-1"
                                    aria-labelledby="ubahProfileModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="ubahProfileModalLabel">Ubah Profile
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <form action="{{ route('profile.update') }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <div class="modal-body">
                                                    <label for="name" class="col-sm-4 col-form-label">Nama</label>
                                                    <div class="mb-3">
                                                        <input type="text" class="form-control" id="name" name="name"
                                                            value="{{ $user->name }}" required>
                                                    </div>
                                                    <label for="email" class="col-sm-4 col-form-label">Email</label>
                                                    <div class="mb-3">
                                                        <input type="email" class="form-control" id="email" name="email"
                                                            readonly value="{{ $user->email }}" required>
                                                    </div>
                                                    <label for="no_hp" class="col-sm-4 col-form-label">Pekerjaan</label>
                                                    <div class="mb-3">
                                                        <input type="text" class="form-control" id="job"
                                                            name="job" value="{{ !empty($user->profile) ? $user->profile->job : '' }}">
                                                    </div>
                                                    <label for="no_hp" class="col-sm-4 col-form-label">No
                                                        Telepon</label>
                                                    <div class="mb-3">
                                                        <input type="number" class="form-control" id="no_hp"
                                                            name="no_hp" value="{{ $user->no_hp }}">
                                                    </div>
                                                    <label for="UbahProfileGenderModal"
                                                        class="col-sm-4 col-form-label">Jenis kelamin</label>
                                                    <div class="mb-3">
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" name="sex"
                                                                id="inlineRadio1" value="male"
                                                                {{ !empty($user->profile->sex) ? ($user->profile->sex == 'male' ? 'checked':''):'' }}>
                                                            <label class="form-check-label" for="inlineRadio1">Laki
                                                                Laki</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" name="sex"
                                                                id="inlineRadio2" value="female"
                                                                {{ !empty($user->profile->sex) ? ($user->profile->sex == 'female' ? 'checked':''):'' }}>
                                                            <label class="form-check-label"
                                                                for="inlineRadio2">Perempuan</label>
                                                        </div>
                                                    </div>
                                                    <label for="birthday" class="col-sm-4 col-form-label">Tanggal
                                                        Lahir</label>
                                                    <div class="mb-3">
                                                        <input type="date" class="form-control" id="birthday"
                                                            name="birthday"
                                                            value="{{ !empty($user->profile->birthday) ? (date('Y-m-d', strtotime($user->profile->birthday))) :''}}">
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-default">Save
                                                        changes</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!-- Modal Ubah Password -->
                                <div class="modal fade" id="ubahPasswordModal" tabindex="-1"
                                    aria-labelledby="ubahPasswordModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Ubah Password
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <form action="{{ route('profile.changePassword') }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <div class="modal-body">
                                                    <label for="old_password" class="col-sm-4 col-form-label">Password
                                                        Lama</label>
                                                    <div class="mb-3">
                                                        <input type="password" class="form-control" id="old_password"
                                                            name="old_password" placeholder="Masukan Password Lama">
                                                    </div>
                                                    <label for="new_password" class="col-sm-4 col-form-label">Password
                                                        Baru</label>
                                                    <div class="mb-3">
                                                        <input type="password" class="form-control" id="new_password"
                                                            name="new_password" placeholder="Masukan Password Baru" />
                                                        <small class="form-text text-muted">Minimal 8 karakter</small>

                                                    </div>
                                                    <label for="confirm_new_password"
                                                        class="col-sm-6 col-form-label">Konfirmasi Password
                                                        baru</label>
                                                    <div class="mb-3">
                                                        <input type="password" class="form-control"
                                                            id="confirm_new_password" name="confirm_new_password"
                                                            placeholder="Konfirmasi Password Baru" />
                                                    </div>

                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-default">Save
                                                        changes</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <!-- Tab Dokumen -->
                <div class="tab-pane fade  {{Request::get('tab') == 'document' ? 'show active':''}}" id="nav-Dokumen"
                    role="tabpanel" aria-labelledby="nav-Dokumen-tab">
                    @if (!empty($profile))
                    @if ($profile->verification_status == 'accepted')
                    <div class="alert alert-success" role="alert">
                        Dokumen Terverifikasi
                    </div>
                    @elseif($profile->verification_status == 'rejected')
                    <div class="alert alert-danger" role="alert">
                        Verifikasi dokumen ditolak, karena
                        <strong>{{$profile->verification_feedback}}</strong>. Anda dapat mengupload ulang dokumen.
                    </div>
                    @elseif($profile->verification_status == 'process')
                    <div class="alert alert-warning" role="alert">
                        Dokumen dalam proses pengecekan oleh Admin
                    </div>
                    @endif

                    @endif
                    <div class="row">
                        <h5>Informasi Dokumen</h5>
                        @if (empty($profile) || !in_array($profile->verification_status, ['accepted']))
                        <button type="button" class="btn btn-outline-default mb-1" data-bs-toggle="modal"
                            data-bs-target="#modalKTPNIK">
                            Upload Dokumen
                        </button>
                        @endif

                        <div class="col-lg-6 mt-2">
                            <p class="card-text text-muted">Foto KTP</p>
                            @if (!empty($profile->ktp_image))
                            <div class="col-lg-10 card my-3">
                                <img src="{{asset('storage/images/profiles/ktp/'.$profile->ktp_image)}}" alt="..."
                                    class="card-img-top rounded p-1">
                            </div>
                            @else
                            <p class="card-text fw-bold mb-1">TIDAK ADA DATA</p>
                            @endif
                        </div>
                        <div class="col-lg-6 mt-2 ">
                            <p class="card-text text-muted">Nomor NIK</p>
                            <p class="card-text fw-bold mb-1">{{ $profile->ktp_number ?? 'TIDAK ADA DATA'}}
                            </p>
                        </div>
                        <div class="col-lg-6 mt-2">
                            <p class="card-text text-muted">Foto Selfie Dengan KTP</p>
                            @if (!empty($profile->selfie_image))
                            <div class="col-lg-10 card my-3">
                                <img src="{{asset('storage/images/profiles/selfie/'.$profile->selfie_image)}}" alt="..."
                                    class="card-img-top rounded p-1">
                            </div>
                            @else
                            <p class="card-text fw-bold mb-1">TIDAK ADA DATA</p>
                            @endif


                        </div>
                        <div class="col-lg-6 mt-2">
                            <p class="card-text text-muted">Foto Tanda Tangan Digital</p>
                            @if (!empty($profile->signature))
                            <div class="col-lg-10 card my-3">
                                <img src="{{asset('storage/images/profiles/signature/'.$profile->signature)}}" alt="..."
                                    class="card-img-top rounded p-1">
                            </div>
                            @else
                            <p class="card-text fw-bold mb-1">TIDAK ADA DATA</p>
                            @endif
                        </div>
                        <div class="col-lg-6 mt-2">
                            <p class="card-text text-muted">Informasi NPWP</p>
                            @if (!empty($profile->npwp_image))
                            <div class="col-lg-10 card my-3">
                                <img src="{{asset('storage/images/profiles/npwp/'.$profile->npwp_image)}}" alt="..."
                                    class="card-img-top rounded p-1">
                            </div>
                            @else
                            <p class="card-text fw-bold mb-1">TIDAK ADA DATA</p>
                            @endif
                            <!-- JIKA DATA 4 DOKUMEN UDH DI UPLOAD SISAIN BUTTON INPUT NPWP-->
                            @if (!empty($profile) && !empty($profile->ktp_image) && empty($profile->npwp_number))
                            <button type="button" class="btn btn-outline-default mb-1" data-bs-toggle="modal"
                                data-bs-target="#modalNPWP">
                                Upload Data NPWP
                            </button>
                            @endif


                        </div>
                        <div class="col-lg-6 mt-2">
                            <p class="card-text text-muted">Nomor NPWP</p>
                            <p class="card-text fw-bold mb-2">
                                {{ $profile->npwp_number ?? 'TIDAK ADA DATA'}}</p>
                        </div>

                    </div>
                    <!-- Modal KTP & NIK -->
                    <div class="modal fade" id="modalKTPNIK" tabindex="-1" aria-labelledby="modalKTPNIKLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-scrollable">
                            <div class="modal-content">
                                <div class="modal-header pb-0 border-0">
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <h5 class="modal-title mx-auto pb-2" id="ModalDetailTransaksiInvestnakLabel">
                                    Data Dokumen</h5>
                                <div class="modal-body">
                                    <form action="{{ route('profile.changeDocument') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        @method('PATCH')
                                        <label for="uploadKTP" class="col-sm-4 col-form-label">
                                            Upload Foto KTP<sup style="color:red;">*</sup></label>
                                        <div class="mb-2">
                                            <input type="file" name="ktp_image" class="form-control" id="uploadKTP"
                                                accept="image/png, image/jpg, image/jpeg" {{empty($profile->ktp_image) ? 'required':''}} />
                                            <div id="NIKwajib" class="form-text">*Wajib, Maks. File 1MB</div>
                                        </div>
                                        <div class="col-sm-4 col-form-label"><img id="blah" class="cover"
                                                src="{{ empty($profile->ktp_image) ? asset('/assets/img/ktp.jpg') : asset('/storage/images/profiles/ktp/'.$profile->ktp_image)}}"
                                                alt="your image" /></div>

                                        <label for="DataNIK" class="col-sm-4 col-form-label">Informasi
                                            NIK<sup style="color:red;">*</sup></label>
                                        <div class="mb-2">
                                            <input type="number" class="form-control" name="ktp_number" id="DataNIK"
                                                placeholder="Masukan Data NIK" value="{{old('ktp_number') ?? $profile->ktp_number ?? ''}}" required>
                                            <div id="NIKwajib" class="form-text">*Wajib, Maks. File 1MB </div>
                                        </div>

                                        <label for="selfieDiri" class="col-sm-8 col-form-label">
                                            Upload Foto Selfie Dengan KTP<sup style="color:red;">*</sup></label>
                                        <div class="mb-2">
                                            <input type="file" name="selfie_image" class="form-control"
                                                id="selfieDiri" accept="image/png, image/jpg, image/jpeg" {{empty($profile->selfie_image) ? 'required':''}} />
                                            <div id="NIKwajib" class="form-text">*Wajib, Maks. File 1MB</div>
                                        </div>
                                        <div class="col-sm-4 col-form-label"><img id="fotoselfie" class="cover"
                                                src="{{ empty($profile->selfie_image) ? asset('/assets/img/selfie.jpg') : asset('/storage/images/profiles/selfie/'.$profile->selfie_image) }}"
                                                alt="your image" /></div>

                                        <label for="tandaTanganDigital" class="col-sm-8 col-form-label">Upload Foto
                                            Tanda Tangan Digital<sup style="color:red;">*</sup></label>
                                        <div class="mb-2">
                                            <input type="file" name="signature" class="form-control"
                                                id="tandaTanganDigital" accept="image/png, image/jpg, image/jpeg" {{empty($profile->signature) ? 'required':''}} />
                                            <div id="NIKwajib" class="form-text">*Wajib, Maks. File 1MB</div>
                                        </div>
                                        <div class="col-sm-4 col-form-label"><img id="ttdDigital" class="cover"
                                                src="{{ empty($profile->signature) ? asset('/assets/img/ttd.svg') : asset('/storage/images/profiles/signature/'.$profile->signature)}}"
                                                alt="your image" /></div>
                                        <!-- <label for="uploadKTP" class="mb-3">
                                                <span class="btn btn-sm btn-outline-default ">Upload Foto KTP</span>
                                                <input type="file" class="d-none" id="uploadKTP"
                                                    accept="image/png, image/jpg, image/jpeg" />
                                            </label> -->

                                        <label for="gambarNPWP" class="col-sm-4 col-form-label">Upload
                                            Foto NPWP</label>
                                        <div class="mb-2">
                                            <input type="file" class="form-control" id="gambarNPWP" name="npwp_image"
                                                accept="image/png, image/jpg, image/jpeg" />
                                            <div id="NPWPOpsional" class="form-text">Opsional</div>
                                        </div>
                                        <label for="DataNIK" class="col-sm-4 col-form-label">Nomor
                                            NPWP</label>
                                        <div class="mb-2">
                                            <input type="number" class="form-control" id="nomorNPWP" name="npwp_number"
                                                placeholder="Masukan Nomor NPWP" value="{{old('npwp_number') ?? $profile->npwp_number ?? ''}}">
                                            <div id="NPWPOpsional" class="form-text">Opsional</div>
                                        </div>
                                </div>
                                <div class="modal-footer d-inline">
                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-default">Save
                                            changes</button>
                                    </div>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Modal NPWP -->
                    <div class="modal fade" id="modalNPWP" tabindex="-1" aria-labelledby="modalNPWPLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header pb-0 border-0">
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <h5 class="modal-title mx-auto" id="ModalDetailTransaksiInvestnakLabel">
                                    NPWP</h5>
                                <div class="modal-body">
                                    <form action="{{ route('profile.changeNPWP') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        @method('PATCH')
                                        <label for="gambarNPWP" class="col-sm-4 col-form-label">Upload
                                            Foto NPWP</label>
                                        <div class="mb-2">
                                            <input type="file" class="form-control" id="gambarNPWP" name="npwp_image"
                                                accept="image/png, image/jpg, image/jpeg" />
                                            <div id="NPWPOpsional" class="form-text">Opsional</div>
                                        </div>
                                        <label for="DataNIK" class="col-sm-4 col-form-label">Nomor
                                            NPWP</label>
                                        <div class="mb-2">
                                            <input type="number" class="form-control" id="nomorNPWP" name="npwp_number"
                                                placeholder="Masukan Nomor NPWP">
                                            <div id="NPWPOpsional" class="form-text">Opsional</div>
                                        </div>
                                        <hr>
                                        <div class="d-grid my-2">
                                            <button type="submit" class="btn btn-default">Save
                                                changes</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Tab Akun Bank -->
                <div class="tab-pane fade {{Request::get('tab') == 'bank' ? 'show active':''}}" id="nav-AkunBank"
                    role="tabpanel" aria-labelledby="nav-AkunBank-tab">
                    <div class="card p-4">
                        <div class="row">
                            @if (!empty(Auth::user()->banks->first()))
                            @php
                            $user_bank = Auth::user()->banks->first();
                            @endphp
                            <div class="col-sm-6">
                                <p class="card-text text-muted">Nama Bank</p>
                                <p class="card-text fw-bold">{{$user_bank->name}}</p>
                                <p class="card-text text-muted">Nama Pemilik Bank</p>
                                <p class="card-text fw-bold">{{$user_bank->pivot->holder_name}}</p>
                                <p class="card-text text-muted">Nomor Rekening Bank</p>
                                <p class="card-text fw-bold">{{$user_bank->pivot->account_number}}</p>
                                <button class="btn btn-default" data-bs-toggle="modal"
                                    data-bs-target="#modalEditRekening">Ubah rekening bank</button>
                            </div>

                            <!-- Modal Edit Rekening -->
                            <div class="modal fade" id="modalEditRekening" tabindex="-1"
                                aria-labelledby="modalEditRekeningLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header pb-0 border-0">
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <h5 class="modal-title mx-auto" id="ModalDetailTransaksiInvestnakLabel">
                                            Edit Rekening Bank</h5>

                                        <form action="{{ route('profile.storeBank') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="modal-body">
                                                <p class="text-muted text-center"> Rekening bank yang telah ditambahkan
                                                    bisa
                                                    kamu
                                                    gunakan untuk penarikan Saldo Panak</p>
                                                <div class="mb-3">
                                                    <label for="namaBank" class="form-label">Nama Bank</label>
                                                    <select class="form-select" id="namaBankChange"
                                                        aria-label="Default select example" name="bank_id" style="width: 100%" required>
                                                        <option selected disabled>Pilih nama bank</option>
                                                        @foreach ($banks as $bank)
                                                        <option value="{{ $bank->id }}"
                                                            {{$bank->id == $user_bank->id ? 'selected':''}}>
                                                            {{ $bank->name }}</option>
                                                        @endforeach

                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="namaRekening" class="form-label">Nama Pemilik
                                                        Rekening</label>
                                                    <input type="text" class="form-control" id="namaRekening"
                                                        name="holder_name" value="{{$user_bank->pivot->holder_name}}"
                                                        placeholder="Masukan Nama Pemilik Rekening"
                                                        aria-describedby="emailHelp" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="nomorRekening" class="form-label">Nomor Rekening</label>
                                                    <input type="number" class="form-control" id="nomorRekening"
                                                        name="account_number"
                                                        value="{{$user_bank->pivot->account_number}}"
                                                        placeholder="Masukan Nomor Rekening"
                                                        aria-describedby="emailHelp" required>
                                                </div>

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-default">Save changes</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @else

                            <!-- JIKA DATA BANK MASIH KOSONG TAMPILIN COL YANG INI YA SAY -->

                            <div class="container-fluid" style="height:300px;">
                                <div class="row h-100">
                                    <div class="col-sm-12 my-auto text-center">
                                        <i class="far fa-credit-card text-muted"></i>
                                        <p class="text-muted">Belum Ada Rekening Yang Terdaftar</p>
                                        <button class="btn btn-default" data-bs-toggle="modal"
                                            data-bs-target="#modalTambahRekening">+ Tambah Data
                                            Bank</button>
                                    </div>
                                </div>
                            </div>
                            @endif


                            <!-- Modal Tambah Rekening -->
                            <div class="modal fade" id="modalTambahRekening" tabindex="-1"
                                aria-labelledby="modalTambahRekeningLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header pb-0 border-0">
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <h5 class="modal-title mx-auto" id="ModalDetailTransaksiInvestnakLabel">
                                            Tambah Rekening Bank</h5>

                                        <form action="{{ route('profile.storeBank') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="modal-body">
                                                <p class="text-muted text-center"> Rekening bank yang telah ditambahkan
                                                    bisa
                                                    kamu
                                                    gunakan untuk penarikan Saldo Panak</p>
                                                <div class="mb-3">
                                                    <label for="namaBank">Nama Bank</label><br>
                                                    <select class="form-select" id="namaBank" name="bank_id" style="width: 100%" required>
                                                        <option selected disabled>Pilih nama bank</option>
                                                        @foreach ($banks as $bank)
                                                        <option value="{{ $bank->id }}">{{ $bank->name }}</option>
                                                        @endforeach

                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="namaRekening" class="form-label">Nama Pemilik
                                                        Rekening</label>
                                                    <input type="text" class="form-control" id="namaRekening"
                                                        name="holder_name" placeholder="Masukan Nama Pemilik Rekening"
                                                        aria-describedby="emailHelp" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="nomorRekening" class="form-label">Nomor Rekening</label>
                                                    <input type="number" class="form-control" id="nomorRekening"
                                                        name="account_number" placeholder="Masukan Nomor Rekening"
                                                        aria-describedby="emailHelp" required>
                                                </div>

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-default">Save changes</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
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
@include('admin.plugins.select2')
@push('js')
<script>
    uploadKTP.onchange = evt => {
        const [file] = uploadKTP.files
        if (file) {
            blah.src = URL.createObjectURL(file)
        }
    }
    selfieDiri.onchange = evt => {
        const [file] = selfieDiri.files
        if (file) {
            fotoselfie.src = URL.createObjectURL(file)
        }
    }
    tandaTanganDigital.onchange = evt => {
        const [file] = tandaTanganDigital.files
        if (file) {
            ttdDigital.src = URL.createObjectURL(file)
        }
    }

</script>

{{-- SELECT2 --}}
<script>
    $(document).ready(function() {
        $("#namaBank").select2({
            width: 'resolve',
    dropdownParent: $("#modalTambahRekening")
  });
        $("#namaBankChange").select2({
            width: 'resolve',
    dropdownParent: $("#modalEditRekening")
  });
});
</script>
@endpush

<label class="col-sm-12 col-form-label">Nama: <span class="card-text font-weight-bold">{{$profile->user->name}}</span></label>

<label for="uploadKTP" class="col-sm-12 col-form-label">
    Foto KTP</label>
<div class="col-sm-12 col-form-label"><img class="img-fluid"
        src="{{ asset('/storage/images/profiles/ktp/'.$profile->ktp_image)}}" alt="your image" /></div>
<label for="DataNIK" class="col-sm-12 col-form-label">NIK: <span class="card-text font-weight-bold">{{$profile->ktp_number}}</span></label>


<label for="uploadKTP" class="col-sm-12 col-form-label">
    Foto Selfie KTP</label>
<div class="col-sm-12 col-form-label"><img class="img-fluid"
        src="{{ asset('/storage/images/profiles/selfie/'.$profile->selfie_image)}}" alt="your image" /></div>

<label for="uploadKTP" class="col-sm-12 col-form-label">
    Foto NPWP</label>
@if (!empty($profile->npwp_image))
<div class="col-sm-12 col-form-label">
    <img class="img-fluid" src="{{ asset('/storage/images/profiles/npwp/'.$profile->npwp_image)}}" alt="your image" />
</div>
<label for="DataNIK" class="col-sm-12 col-form-label">Nomor NPWP: <span class="card-text font-weight-bold">{{$profile->npwp_number}}</span></label>

@else
<p class="card-text font-weight-bold mb-1">Tidak Ada NPWP</p>

@endif


<label for="uploadKTP" class="col-sm-12 col-form-label">
    Foto Tanda Tangan</label>
<div class="col-sm-12 col-form-label"><img class="img-fluid" src="{{ asset('/storage/images/profiles/signature/'. $profile->signature)}}"
        alt="your image" /></div>

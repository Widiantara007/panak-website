<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\User;
use App\Models\UserBank;
use App\Models\UserPortofolio;
use App\Models\UserProfile;
use App\Models\Withdrawal;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class ProfileController extends Controller
{

    public function index()
    {
        $user = Auth::user();
        $profile = $user->profile;
        $banks = Bank::orderBy('name')->get();
        return view('profile.profile', compact('user', 'banks', 'profile'));
    }

    public function updateProfile(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'email' => 'required',
            'job' => 'required|string',
            'no_hp' => 'nullable|numeric',
            'sex' => 'nullable|in:male,female',
            'birthday' => 'nullable|date'
        ]);

        $update = User::find(Auth::user()->id)->update([
            'name' => $request->name,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
           
        ]);

        $update = UserProfile::updateOrCreate(
            [
                'user_id' => Auth::user()->id
            ],
            [
                'sex' => $request->sex,
                'birthday' => $request->birthday,
                'job' => $request->job
            ]
        );

        if ($update) {
            Toastr::success('Profil berhasil diubah', 'Berhasil!');
            return redirect()->route('profile');
        } else {
            Toastr::error('Profil gagal diubah, coba lagi', 'Gagal!');
            return redirect()->back();
        }
    }

    public function changePassword(Request $request)
    {
        $validatedData = $request->validate([
            'old_password' => 'required|string',
            'new_password' => 'required|string|min:8',
        ]);
        if ($request->new_password != $request->confirm_new_password) {
            Toastr::error('', 'Konfirmasi password baru tidak sama!');
            return redirect()->route('profile');
        }

        $user = Auth::user();

        if (Hash::check($request->old_password, $user->password)) {
            User::find($user->id)->update([
                'password' => Hash::make($request->new_password)
            ]);
        } else {
            Toastr::error('', 'Password Lama salah!');
            return redirect()->route('profile');
        }

        Toastr::success('Password berhasil diubah', 'Berhasil!');
        return redirect()->route('profile');
    }

    public function changePhotoProfile(Request $request)
    {
        $validatedData = $request->validate([
            'profile_image' => 'required|image|max:1024',
        ]);

        $user = User::find(Auth::user()->id);

        //delete existing image
        if (!empty($user->photo_profile)) {
            if (!(Str::startsWith($user->photo_profile, 'http'))) {
                $existingImage = $user->photo_profile;
                Storage::disk('public')->delete('images/profiles/' . $existingImage);
            }
        }

        //store image
        $fileNameImage = date("Y-m-d-His") . '_' . $request->file('profile_image')->getClientOriginalName();
        $image = $request->file('profile_image')
            ->storeAs('public/images/profiles/', $fileNameImage);

        //update db
        $update = $user->update([
            'photo_profile' => $fileNameImage,
        ]);

        if ($update) {
            Toastr::success('Foto profil berhasil diubah', 'Berhasil!');
            return redirect()->route('profile');
        } else {
            Toastr::error('Foto profil gagal diubah, coba lagi', 'Gagal!');
            return redirect()->back();
        }
    }

    public function changeDocument(Request $request)
    {
        $validatedData = $request->validate([
            'ktp_image' => 'nullable|image|max:1024',
            'ktp_number' => 'required|digits:16',
            'selfie_image' => 'nullable|image|max:1024',
            'signature' => 'nullable|image|max:1024',
            'npwp_image' => 'nullable|image|max:1024',
            'npwp_number' => 'nullable|digits:15',
        ]);

        $user = Auth::user();

        //delete existing image KTP
        if (!empty($request->ktp_image) && !empty($user->profile->ktp_image)) {
            $existingImage = $user->profile->ktp_image;
            Storage::disk('public')->delete('images/profiles/ktp/' . $existingImage);
        }
        //delete existing image Selfie KTP
        if (!empty($request->selfie_image) && !empty($user->profile->selfie_image)) {
            $existingImage = $user->profile->selfie_image;
            Storage::disk('public')->delete('images/profiles/selfie/' . $existingImage);
        }
        //delete existing image Signature
        if (!empty($request->signature) && !empty($user->profile->signature)) {
            $existingImage = $user->profile->signature;
            Storage::disk('public')->delete('images/profiles/signature/' . $existingImage);
        }
        //delete existing image NPWP
        if (!empty($request->npwp_image) && !empty($user->profile->npwp_image)) {
            $existingImage = $user->profile->npwp_image;
            Storage::disk('public')->delete('images/profiles/npwp/' . $existingImage);
        }

        //store image KTP
        if (!empty($request->ktp_image)) {
        $fileNameImageKTP = date("Y-m-d-His") . '_' . $request->ktp_number . '.' . $request->file('ktp_image')->getClientOriginalExtension();
        $image = $request->file('ktp_image')
            ->storeAs('public/images/profiles/ktp/', $fileNameImageKTP);
        }

        //store image Selfie KTP
        if (!empty($request->selfie_image)) {
        $fileNameImageSelfie = date("Y-m-d-His") . '_' . $request->ktp_number . '.' . $request->file('selfie_image')->getClientOriginalExtension();
        $image = $request->file('selfie_image')
            ->storeAs('public/images/profiles/selfie/', $fileNameImageSelfie);
        }

        //store image Signature
        if (!empty($request->signature)) {
        $fileNameImageSignature = date("Y-m-d-His") . '_' . $request->ktp_number . '.' . $request->file('signature')->getClientOriginalExtension();
        $image = $request->file('signature')
            ->storeAs('public/images/profiles/signature/', $fileNameImageSignature);
        }

        //store image NPWP
        if (!empty($request->npwp_image)) {
            $fileNameImageNPWP = date("Y-m-d-His") . '_' . $request->npwp_number . '.' . $request->file('npwp_image')->getClientOriginalExtension();
            $image = $request->file('npwp_image')
                ->storeAs('public/images/profiles/npwp/', $fileNameImageNPWP);
        }


        //update db
        $update = UserProfile::updateOrCreate(
            [
                'user_id' => Auth::user()->id
            ],
            [
                'ktp_image' => $fileNameImageKTP ?? $user->profile->ktp_image,
                'ktp_number' => $request->ktp_number,
                'selfie_image' => $fileNameImageSelfie ?? $user->profile->selfie_image,
                'npwp_number' => $request->npwp_number,
                'npwp_image' => $fileNameImageNPWP ?? $user->profile->npwp_image ?? null,
                'signature' => $fileNameImageSignature ?? $user->profile->signature,
                'verification_status' => 'process',
            ]
        );

        if ($update) {
            Toastr::success('Dokumen berhasil diunggah', 'Berhasil!');
            return redirect()->route('profile',['tab' => 'document']);
        } else {
            Toastr::error('Dokumen gagal diunggah, coba lagi', 'Gagal!');
            return redirect()->route('profile',['tab' => 'document']);
        }
    }

    public function changeNPWP(Request $request)
    {

        $validatedData = $request->validate([
            'npwp_image' => 'required|image|max:1024',
            'npwp_number' => 'required|digits:15',
        ]);

        $user = User::find(Auth::user()->id);

        //delete existing image
        if (!empty($user->profile->npwp_image)) {

            $existingImage = $user->profile->npwp_image;
            Storage::disk('public')->delete('images/profiles/npwp/' . $existingImage);
        }

        //store image
        $fileNameImage = date("Y-m-d-His") . '_' . $request->npwp_number . '.' . $request->file('npwp_image')->getClientOriginalExtension();
        $image = $request->file('npwp_image')
            ->storeAs('public/images/profiles/npwp/', $fileNameImage);

        //update db
        $update = UserProfile::updateOrCreate(
            [
                'user_id' => Auth::user()->id
            ],
            [
                'npwp_image' => $fileNameImage,
                'npwp_number' => $request->npwp_number,
            ]
        );

        if ($update) {
            Toastr::success('NPWP berhasil diunggah', 'Berhasil!');
            return redirect()->route('profile',['tab' => 'document']);
        } else {
            Toastr::error('NPWP gagal diunggah, coba lagi', 'Gagal!');
            return redirect()->route('profile',['tab' => 'document']);
        }
    }

    public function storeBank(Request $request)
    {
        $validatedData = $request->validate([
            'bank_id' => 'required',
            'holder_name' => 'required|string',
            'account_number' => 'required|numeric'
        ]);

        $store = UserBank::updateOrCreate(
            [
                'user_id' => Auth::user()->id
            ],
            [
                'bank_id' => $request->bank_id,
                'holder_name' => $request->holder_name,
                'account_number' => $request->account_number
            ]
        );

        if ($store) {
            Toastr::success('Akun Bank berhasil ditambahkan', 'Berhasil!');
            return redirect()->route('profile', ['tab' => 'bank']);
        } else {
            Toastr::error('Akun Bank gagal ditambahkan, coba lagi', 'Gagal!');
            return redirect()->route('profile', ['tab' => 'bank']);
        }
    }

    public function portofolio()
    {
        $user = Auth::user();
        $portofolio_completed = UserPortofolio::where('user_id', $user->id)->whereHas('project_batch', function($query){
            $query->whereIn('status', ['paid', 'closed']);
        })->get();
        $portofolio_progress = UserPortofolio::where('user_id', $user->id)->whereHas('project_batch', function($query){
            $query->whereNotIn('status', ['paid', 'closed']);
        })->get();
        // dd($portofolio_completed);
        return view('profile.portofolio', compact('user', 'portofolio_completed', 'portofolio_progress'));
    }

    public function transaction()
    {
        $transactions = Auth::user()->transactions;
        return view('profile.transaction.index', compact('transactions'));
    }

    public function transactionModalBody($id)
    {
        $transaction = Auth::user()->transactions->where('id', $id)->first();
        $modalBody = view('profile.transaction.modal-body',compact('transaction'))->render();

        return response()->json([
            'modalBody' => $modalBody,
        ]);
    }

    public function wallet()
    {
        $user = Auth::user();
        $histories = $user->transactions->filter(function ($item) {
            return $item->type == 'wallet' || $item->transaction_type == 'return';
         })->sortByDesc('created_at');
        return view('profile.wallet', compact('user', 'histories'));
    }

    public function withdrawStore(Request $request)
    {
        $validatedData = $request->validate([
            'bank' => 'required',
            'holder_name' => 'required|string',
            'account_number' => 'required|numeric',
            'nominal' => 'required|numeric'
        ]);
        $user = Auth::user();

        if($request->nominal > $user->balance){
            Toastr::error('Jumlah penarikan dana melebihi saldo', 'Gagal!');
            return redirect()->back();
        }

        $store = Withdrawal::create([
            'user_id' => $user->id,
            'user_bank_id' => $user->banks->first()->pivot->id,
            'nominal' => $request->nominal,
            'status' => 'request',
        ]);

        if ($store) {
            Toastr::success('Penarikan dana berhasil diajukan, silahkan menunggu konfirmasi Admin', 'Berhasil!');
            return redirect()->route('profile.wallet');
        } else {
            Toastr::error('Penarikan dana gagal diajukan, coba lagi', 'Gagal!');
            return redirect()->route('profile.wallet');
        }
    }

    public function notification()
    {
        $notifications = Auth::user()->notifications;
        return view('profile.notification', compact('notifications'));
    }

    public function markNotification(Request $request)
    {
        $id = $request->id;
        $mark_read =  Auth::user()->unreadNotifications->where('id', $id)->markAsRead();
        return response()->noContent();
    }
}

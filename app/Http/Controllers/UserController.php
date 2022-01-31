<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\User;
use App\Models\UserAddress;
use App\Models\UserProfile;
use App\Notifications\UserNotification;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Laravel\Ui\Presets\React;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return view('admin.user.index',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        return view('admin.user.edit',compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string',
            'photo_profile' => 'nullable|file|image',
        ]);
        if ($request->hasFile('photo_profile')) {
            $existingImage = User::find($id)->photo_profile;
            Storage::delete('public/images/photo_profiles/' . $existingImage);

            $fileName = date("Y-m-d-His") . '_' . $request->file('photo_profile')->getClientOriginalName();
            $image = $request->file('photo_profile')
                ->storeAs('public/images/photo_profiles/', $fileName);

            $image = User::find($id)->update([
                'photo_profile' => $fileName,
            ]);
        }

        $user = User::find($id);
        $update = $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'updated_at' => Carbon::now(),
        ]);
        if($update){
            Toastr::success('User berhasil diubah','Berhasil!');
            return redirect()->route('user.index');
        }else{
            Toastr::error('User gagal diubah, coba lagi','Gagal!');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {   
        $existingImage = User::find($id)->photo_profile;
            Storage::delete('public/images/photo_profiles/' . $existingImage);

        $user = User::find($id);
        $delete = $user->delete();
        if($delete){
            Toastr::success('User berhasil dihapus','Berhasil!');
            return redirect()->route('user.index');
        }else{
            Toastr::error('User gagal dihapus, coba lagi','Gagal!');
            return redirect()->back();
        }
    }

    public function storeAddress(Request $request){
        $validatedData = $request->validate([
            'label' => 'required|string',
            'recipient_name' => 'required|string',
            'no_hp'=> 'required|numeric',
            'village'=> 'required|string',
            'address_detail' => 'required|string',
            'postal_code' => 'required|string',
        ]);

        $store = UserAddress::create([
            'user_id' => Auth::user()->id,
            'label' => $request->label,
            'recipient_name' => $request->recipient_name,
            'location_code' => $request->village,
            'address_detail' => $request->address_detail,
            'postal_code' => $request->postal_code,
            'no_hp' => $request->no_hp,
        ]);

        if($store){
            Toastr::success('Alamat berhasil ditambahkan','Berhasil!');
            return redirect()->back();
        }else{
            Toastr::error('Alamat gagal ditambahkan, coba lagi','Gagal!');
            return redirect()->back();
        }
        
    }

    public function userVerificationIndex()
    {
        $user_profiles  = UserProfile::where('verification_status', 'process')->get();
        return view('admin.user_verification.index', compact('user_profiles'));
    }

    public function userVerificationModalBody($id){
        $profile = UserProfile::find($id);
        $documentBody = view('admin.user_verification.modal-body',compact('profile'))->render();
        $documentFooter = view('admin.user_verification.modal-footer',compact('profile'))->render();
        $rejectBody = view('admin.user_verification.modal-reject',compact('profile'))->render();

        return response()->json([
            'documentBody' => $documentBody,
            'documentFooter' => $documentFooter,
            'rejectBody' => $rejectBody,
            
        ]);
    }

    public function userVerificationAccept(Request $request){
        $validatedData = $request->validate([
            'profile_id' => 'required',
        ]);

        $profile = UserProfile::find($request->profile_id);

        $update = $profile->update([
            'verification_status' => 'accepted',
            'verified_at' => Carbon::now(),
            'verification_feedback' => null,
            
        ]);
        if($update){
            $log = [
                'user_id' => Auth::user()->id,
                'workflow_type' => 'user',
                'activity' => 'edit',
                'description' => 'Acc User Email: '.$profile->user->email,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
            $document = Log::create($log);
            $profile->user->notify(new UserNotification('verification_accept','Selamat data anda telah diverifikasi, Anda sudah dapat melakukan investasi di Investnak', route('investnak')));
            Toastr::success('Verifikasi User berhasil disetujui','Berhasil!');
            return redirect()->back();
        }else{
            Toastr::error('Verifikasi User gagal disetujui, coba lagi','Gagal!');
            return redirect()->back();
        }
    }

    public function userVerificationReject(Request $request){
        $validatedData = $request->validate([
            'profile_id' => 'required',
            'verification_feedback' => 'required|string'
        ]);

        $profile = UserProfile::find($request->profile_id);

        $update = $profile->update([
            'verification_status' => 'rejected',
            'verification_feedback' => $request->verification_feedback,
        ]);
        if($update){
            $log = [
                'user_id' => Auth::user()->id,
                'workflow_type' => 'user',
                'activity' => 'edit',
                'description' => 'Reject User Email: '.$profile->user->email,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
            $document = Log::create($log);
            $profile->user->notify(new UserNotification('verification_reject','Mohon maaf data anda belum bisa diverifikasi, silahkan periksa kembali data anda', route('profile',['tab'=>'document'])));
            Toastr::success('Verifikasi User berhasil ditolak','Berhasil!');
            return redirect()->back();
        }else{
            Toastr::error('Verifikasi User gagal ditolak, coba lagi','Gagal!');
            return redirect()->back();
        }
    }
}
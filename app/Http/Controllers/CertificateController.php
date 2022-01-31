<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Browsershot\Browsershot;
use Anam\PhantomMagick\Converter;
use App\Models\UserPortofolio;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;

class CertificateController extends Controller
{
    public function generate(){
        $view_certif = view('emisertifikat')->render();
        $code = '932848c90r';
        $path = storage_path()."/app/public/images/certificate/{$code}.jpeg";
        // $coba = Browsershot::html($view_certif)->save($path);
        //emisertif 745x1052
        //sertif 750x1058
        $coba = Browsershot::html($view_certif)->setNodeModulePath(base_path().'/node_modules/')->windowSize(745, 1052)->setScreenshotType('jpeg', 90)->save($path);
        return response($coba);
    }
    public function emisertif(){
        $portofolio = UserPortofolio::whereNotNull('contract_number')->first();
        return view('emisertifikat', compact('portofolio'));
    }

    public function generateCBC($id){
        $portofolio = Auth::user()->portofolios->where('id', $id)->first();
        $view_cbc = view('emisertifikat', compact('portofolio'))->render();
        $code = $portofolio->contract_number;

        $path = storage_path()."/app/public/images/cbc/{$code}.jpeg";
        $generate = Browsershot::html($view_cbc)->setNodeModulePath(base_path().'/node_modules/')->windowSize(745, 1052)->setScreenshotType('jpeg', 90)->save($path);
        $filename = "{$code}.jpeg";
        return $filename;
    }

    public function showCBC($id){
        $portofolio = Auth::user()->portofolios->where('id', $id)->first();
        if(empty($portofolio)){
            Toastr::error('Portofolio tidak ditemukan', 'Gagal!');
            return redirect()->back();
        }

        if(empty($portofolio->cbc_file)){
            $filename = $this->generateCBC($portofolio->id);
            $update = $portofolio->update([
                'cbc_file' => $filename,
            ]);
        }
        $filename = $portofolio->cbc_file;

        return redirect('/storage/images/cbc/'.$filename);
    }

    public function generateCertificate($id){
        $portofolio = Auth::user()->portofolios->where('id', $id)->first();
        $view_certificate = view('sertifikat', compact('portofolio'))->render();
        $code = $portofolio->contract_number;

        if(empty($code)){
            Toastr::error('Nomor Kontrak tidak ditemukan', 'Gagal!');
            return redirect()->back();
        }

        $path = storage_path()."/app/public/images/certificate/{$code}.jpeg";
        $generate = Browsershot::html($view_certificate)->setNodeModulePath(base_path().'/node_modules/')->windowSize(745, 1052)->setScreenshotType('jpeg', 90)->save($path);
        $filename = "{$code}.jpeg";
        return $filename;
    }

    public function showCertificate($id){
        $portofolio = Auth::user()->portofolios->where('id', $id)->first();
        if(empty($portofolio)){
            Toastr::error('Portofolio tidak ditemukan', 'Gagal!');
            return redirect()->back();
        }

        if(empty($portofolio->certificate_file)){
            $filename = $this->generateCertificate($portofolio->id);
            $update = $portofolio->update([
                'certificate_file' => $filename,
            ]);
        }
        $filename = $portofolio->certificate_file;
        return redirect('/storage/images/certificate/'.$filename);
    }

   
}

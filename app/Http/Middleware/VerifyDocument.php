<?php

namespace App\Http\Middleware;

use Brian2694\Toastr\Facades\Toastr;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerifyDocument
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(empty(Auth::user()->profile->verified_at)){
            Toastr::error('Dokumen anda belum terverifikasi', 'Mohon maaf', [
                "positionClass"=> "toast-top-center",
                "showDuration" => "0",
                "hideDuration" => "0",
                "timeOut" => "0",
                "extendedTimeOut" => "0",
            ]);
            return redirect()->route('profile', ['tab' => 'document']);
        }
        return $next($request);
    }
}

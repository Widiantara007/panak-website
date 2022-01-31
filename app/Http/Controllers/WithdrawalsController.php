<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\Withdrawal;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WithdrawalsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $withdrawals = Withdrawal::all();
        return view('admin.withdraw.index',compact('withdrawals'));
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
    
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tolak = Withdrawal::find($id);
        return view('admin.withdraw.index',compact('tolak'));
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function accept($id)
    {
        $withdraw = Withdrawal::find($id);
        $terima = $withdraw->update([
            'status'=>'process'
        ]);
        if($terima){
            $log = [
                'user_id' => Auth::user()->id,
                'workflow_type' => 'withdraw',
                'activity' => 'edit',
                'description' => 'Acc permintaan penarikan user email: '.$withdraw->user->email,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
            $document = Log::create($log);
            Toastr::success('Permintaan diterima !','Berhasil!');
            return redirect()->route('withdrawals.index');
        }
    }
    public function reject(Request $request, $id)
    {
        $withdraw = Withdrawal::find($id);
        $tolak = $withdraw->update([
            'status'=>'rejected',
            'feedback'=>$request->feedback,
            'updated_at' => Carbon::now(),
        ]);
        if($tolak){
            $log = [
                'user_id' => Auth::user()->id,
                'workflow_type' => 'withdraw',
                'activity' => 'edit',
                'description' => 'Reject permintaan penarikan user email: '.$withdraw->user->email,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
            $document = Log::create($log);
            Toastr::success('Permintaan ditolak !','Berhasil!');
            return redirect()->route('withdrawals.index');
        }
    }
}

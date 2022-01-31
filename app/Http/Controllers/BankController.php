<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BankController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $banks = Bank::all();
        return view('admin.bank.index',compact('banks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.bank.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
        ]);
        $store = Bank::insert([
            'name'=>$request->name,
            'code'=>$request->code,
        ]);
        if($store){
            Toastr::success('Bank berhasil ditambahkan','Berhasil!');
            return redirect()->route('bank.index');
        }else{
            Toastr::error('Bank gagal ditambahkan, coba lagi','Gagal!');
            return redirect()->back();
        }
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
        //
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
        ]);
        $bank = Bank::find($id);
        $update = $bank->update([
            'name'=>$request->name,
            'code'=>$request->code,
        ]);
        if($update){
            Toastr::success('Bank berhasil diedit','Berhasil!');
            return redirect()->route('bank.index');
        }else{
            Toastr::error('Bank gagal ditambahkan, coba lagi','Gagal!');
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
        $delete = Bank::find($id)->delete();
        if($delete){
            Toastr::success('Bank berhasil dihapus','Berhasil!');
            return redirect()->route('bank.index');
        }else{
            Toastr::error('Bank gagal dihapus, coba lagi','Gagal!');
            return redirect()->back();
        }
    }
}

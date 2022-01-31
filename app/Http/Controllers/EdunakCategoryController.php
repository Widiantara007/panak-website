<?php

namespace App\Http\Controllers;

use App\Models\EdunakCategory;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;

class EdunakCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = EdunakCategory::all();
        return view('admin.edunak.category.index',compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.edunak.category.create');
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
            'category' => 'required|string',
        ]);

        $store=EdunakCategory::insert([
            'category' => $request->category,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        if($store){
            Toastr::success('Data berhasil ditambahkan','Berhasil!');
            return redirect()->route('edunak-category.index');
        }else{
            Toastr::error('Data gagal ditambahkan, coba lagi','Gagal!');
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
            'category' => 'required|string',
        ]);
        
        $update=EdunakCategory::find($id)->update([
            'category' => $request->category,
            'updated_at' => Carbon::now(),
        ]);

        if($update){
            Toastr::success('Data berhasil diupdate','Berhasil!');
            return redirect()->route('edunak-category.index');
        }else{
            Toastr::error('Data gagal diupdate, coba lagi','Gagal!');
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
        $delete = EdunakCategory::find($id)->delete();
        if($delete){
            Toastr::success('Data berhasil dihapus','Berhasil!');
            return redirect()->route('edunak-category.index');
        }else{
            Toastr::error('Data gagal dihapus, coba lagi','Gagal!');
            return redirect()->back();
        }
    }
}

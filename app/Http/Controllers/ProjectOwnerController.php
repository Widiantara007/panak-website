<?php

namespace App\Http\Controllers;

use App\Models\ProjectOwner;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;

class ProjectOwnerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $project_owners = ProjectOwner::all();
        return view('admin.project_owner.index', compact('project_owners'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.project_owner.create');
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
            'description' => 'nullable|string',
        ]);

        $store = ProjectOwner::insert([
            'name' => $request->name,
            'description' => $request->description,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        if($store){
            Toastr::success('Data berhasil ditambahkan','Berhasil!');
            return redirect()->route('project-owner.index');
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
        $project_owner = ProjectOwner::find($id);
        return view('admin.project_owner.edit', compact('project_owner'));
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
        $project_owner = ProjectOwner::find($id);
        $update = $project_owner->update([
            'name' => $request->name,
            'description' => $request->description,
            'updated_at' => Carbon::now()
        ]);

        if($update){
            Toastr::success('Data berhasil diubah','Berhasil!');
            return redirect()->route('project-owner.index');
        }else{
            Toastr::error('Data gagal diubah, coba lagi','Gagal!');
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
        $delete = ProjectOwner::find($id)->delete();
        if($delete){
            Toastr::success('Data berhasil dihapus','Berhasil!');
            return redirect()->route('project-owner.index');
        }else{
            Toastr::error('Data gagal dihapus, coba lagi','Gagal!');
            return redirect()->back();
        }
    }
}

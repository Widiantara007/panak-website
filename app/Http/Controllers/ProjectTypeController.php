<?php

namespace App\Http\Controllers;

use App\Models\ProjectType;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProjectTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $types = ProjectType::all();
        return view('admin.project_type.index',compact('types'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
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
            'image'=> 'required|file|image'
        ]);

        $fileName = date("Y-m-d-His") . '_' . $request->file('image')->getClientOriginalName();

        $image = $request->file('image')
            ->storeAs('public/images/project-types/', $fileName);

        $store = ProjectType::insert([
            'name'=>$request->name,
            'image'=>$fileName,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        if($store){
            Toastr::success('Tipe berhasil ditambahkan','Berhasil!');
            return redirect()->route('project-type.index');
        }else{
            Toastr::error('Tipe gagal ditambahkan, coba lagi','Gagal!');
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProjectType  $projectType
     * @return \Illuminate\Http\Response
     */
    public function show(ProjectType $projectType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProjectType  $projectType
     * @return \Illuminate\Http\Response
     */
    public function edit(ProjectType $projectType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProjectType  $projectType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id )
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'image'=> 'nullable|file|image'
        ]);

        if ($request->hasFile('image')) {
            $existingImage = ProjectType::find($id)->image;
            Storage::delete('public/images/project-types/' . $existingImage);

            $fileName = date("Y-m-d-His") . '_' . $request->file('image')->getClientOriginalName();
            $image = $request->file('image')
                ->storeAs('public/images/project-types/', $fileName);

            $image = ProjectType::find($id)->update([
                'image' => $fileName,
            ]);
        }
        $type = ProjectType::find($id);
        $update = $type->update([
            'name'=>$request->name,
            'updated_at' => Carbon::now(),
        ]);
        if($update){
            Toastr::success('Tipe berhasil diedit','Berhasil!');
            return redirect()->route('project-type.index');
        }else{
            Toastr::error('Tipe gagal diedit, coba lagi','Gagal!');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProjectType  $projectType
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $type = ProjectType::find($id);
        $existingImage = ProjectType::find($id)->image;
        Storage::delete('public/images/project-types/' . $existingImage);
        $delete = $type->delete();
        if($delete){
            Toastr::success('ProjectType berhasil dihapus','Berhasil!');
            return redirect()->route('project-type.index');
        }else{
            Toastr::error('ProjectType gagal dihapus, coba lagi','Gagal!');
            return redirect()->back();
        }
    }
}

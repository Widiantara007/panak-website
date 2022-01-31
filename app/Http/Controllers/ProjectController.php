<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Log;
use App\Models\Project;
use App\Models\ProjectOwner;
use App\Models\ProjectType;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Project::all();
        return view('admin.project.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $project_owners = ProjectOwner::all();
        $project_types = ProjectType::orderBy('name')->get();
        return view('admin.project.create', compact('project_owners', 'project_types'));
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
            'project_name' => 'required|string',
            'project_owner' => 'required',
            'village' => 'required',
            'type' => 'required',
            'risk_grade' => 'required',
            'image' => 'required|file',
            'prospektus' => 'required|file',
            'description' => 'nullable|string',
        ]);

        // save image
        $fileNameImage = date("Y-m-d-His") . '_' . $request->file('image')->getClientOriginalName();
        $image = $request->file('image')
            ->storeAs('public/images/projects/', $fileNameImage);

        // save prospektus
        $fileNameProspektus = date("Y-m-d-His") . '_' . $request->file('prospektus')->getClientOriginalName();
        $prospektus = $request->file('prospektus')
            ->storeAs('public/prospektus/', $fileNameProspektus);

        $store = Project::insert([
            'name' => $request->project_name,
            'owner_id' => $request->project_owner,
            'type' => $request->type,
            'location_code' => $request->village,
            'image'=> $fileNameImage,
            'risk_grade'=>$request-> risk_grade,
            'prospektus_file' => $fileNameProspektus,
            'description' => $request->description,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        if($store){
            $log = [
                'user_id' => Auth::user()->id,
                'workflow_type' => 'project',
                'activity' => 'add',
                'description' => 'Add Project '.$request->project_name,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
            $document = Log::create($log);
            Toastr::success('Data berhasil ditambahkan','Berhasil!');
            return redirect()->route('project.index');
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
        $project = Project::find($id);
        return view('admin.project.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $project = Project::find($id);
        $project_owners = ProjectOwner::all();
        $project_types = ProjectType::orderBy('name')->get();
        return view('admin.project.edit', compact('project','project_owners', 'project_types'));
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
            'project_name' => 'required|string',
            'project_owner' => 'required',
            'village' => 'required',
            'type' => 'required',
            'risk_grade' => 'required',
            'image' => 'nullable|file',
            'prospektus' => 'nullable|file',
            'description' => 'nullable|string',
        ]);

        // Overwrite image
        if ($request->hasFile('image')) {
            $existingImage = Project::find($id)->image;
            Storage::disk('public')->delete('images/projects/' . $existingImage);


            $fileNameImage = date("Y-m-d-His") . '_' . $request->file('image')->getClientOriginalName();
            $image = $request->file('image')
            ->storeAs('public/images/projects/', $fileNameImage);


            $image = Project::find($id)->update([
                'image' => $fileNameImage,
            ]);
        }

        // Overwrite Peospektus
        if ($request->hasFile('prospektus')) {
            $existingProspektus = Project::find($id)->prospektus_file;
            Storage::disk('public')->delete('prospektus/' . $existingProspektus);


            $fileNameProspektus = date("Y-m-d-His") . '_' . $request->file('prospektus')->getClientOriginalName();
            $prospektus = $request->file('prospektus')
            ->storeAs('public/prospektus/', $fileNameProspektus);


            $prospektus = Project::find($id)->update([
                'prospektus_file' => $fileNameProspektus,
            ]);
        }

        $update = Project::find($id)->update([
            'name' => $request->project_name,
            'owner_id' => $request->project_owner,
            'type' => $request->type,
            'risk_grade' => $request->risk_grade,
            'location_code' => $request->village,
            'description' => $request->description,
            'updated_at' => Carbon::now(),
        ]);

        if($update){
            Toastr::success('Data berhasil diubah','Berhasil!');
            return redirect()->route('project.index');
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
        $project = Project::find($id);
        foreach($project->project_batches as $project_batch){
            $project_batch->delete();
        }
        $delete = $project->delete();
        if($delete){
            Toastr::success('Data berhasil dihapus','Berhasil!');
            return redirect()->route('project.index');
        }else{
            Toastr::error('Data gagal dihapus, coba lagi','Gagal!');
            return redirect()->back();
        }
    }
}

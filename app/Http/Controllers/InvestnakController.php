<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectBatch;
use App\Models\ProjectType;
use Illuminate\Http\Request;

class InvestnakController extends Controller
{
    public function index(Request $request){
        $project_types = ProjectType::all();
        $project_all = Project::pluck('name');

        //filter search
        if(empty($request->search)){
            $project_batches = ProjectBatch::with('project')->where('status','!=','draft')->get();
        }else{
            $project_batches = ProjectBatch::where('status','!=','draft')->whereHas('project', function ($query) use($request){
                $query->where('name', 'like', "%{$request->search}%")->orWhereHas('project_owner', function($q) use($request){
                    $q->where('name', 'like', "%{$request->search}%");
                });
            })->get();
        }
        
        if(!empty($request)){
           
            
            //filter category
            if(!empty($request->category)){
                $project_batches = $project_batches->whereIn('project.type',$request->category);
            }

            //filter roi
            if(!empty($request->roi_low)){
                $project_batches = $project_batches->where('roi_low', '>=', $request->roi_low);
            }

        }
        return view('investnak.index', compact('project_batches', 'project_types', 'project_all'));
    }

    public function show($id){
        $project_batch = ProjectBatch::find($id);
        return view('investnak.show', compact('project_batch'));
    }
}

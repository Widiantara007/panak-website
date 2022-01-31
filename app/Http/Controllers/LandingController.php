<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Project;
use App\Models\ProjectBatch;
use App\Models\ProjectType;
use App\Models\Slider;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index()
    {
        $sliders = Slider::all();
        $types = ProjectType::all();
        $project_batches = ProjectBatch::where('status','!=','draft')->limit(5)->get();
        $products = Product::all();
        return view('landing',compact('sliders','types', 'project_batches', 'products'));
        
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Project;
use App\Models\ProjectBatch;
use App\Models\UserProfile;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(){
        $total_pending_verification = UserProfile::where('verification_status', 'process')->count();
        $total_order_process = Order::where('status', 'process')->count();

        $total_product_buy = 0;
        $order_done = Order::where('status', 'done')->get();
        foreach ($order_done as $item) {
            $total_product_buy += $item->order_details->sum('quantity');
        }

        $total_investment_active = 0;
        $project_batches_active = ProjectBatch::whereNotIn('status', ['draft','closed','paid'])->get();
        foreach($project_batches_active as $project_batch){
            $total_investment_active += $project_batch->totalInvestments();
        }
        return view('admin.admin', compact('total_pending_verification', 'total_order_process', 'total_product_buy', 'total_investment_active'));
    }

    
}

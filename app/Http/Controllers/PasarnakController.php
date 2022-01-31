<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class PasarnakController extends Controller
{
    public function index(Request $request){
        $products = Product::all();
        $products_all = Product::pluck('name');

        //filter search
        if(!empty($request->search)){
            $products = Product::where('name', 'like', "%{$request->search}%")->get();
        }

        return view('pasarnak.index', compact('products', 'products_all'));
    }

    public function show($id){
        $product = Product::find($id);

        return view('pasarnak.show', compact('product'));
    }
}

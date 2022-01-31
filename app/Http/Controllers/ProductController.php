<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all();
        return view('admin.product.index',compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.product.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
            //Logs
            
            // 

        $validatedData = $request->validate([
            'name' => 'required|string',
            'price'=> 'required|numeric',
            'unit'=> 'required|string',
            'weight'=> 'required|numeric',
            'discount' => 'nullable|numeric',
            'stock' => 'required|numeric',
            'image' => 'required|file|image',
            'description' => 'nullable|string',
        ]);

        $fileName = date("Y-m-d-His") . '_' . $request->file('image')->getClientOriginalName();

        $image = $request->file('image')
            ->storeAs('public/images/products/', $fileName);

        $store = Product::insert([
            'name' => $request->name,
            'price' => $request->price,
            'unit' => $request->unit,
            'weight' => $request->weight,
            'discount' => $request->discount,
            'stock' => $request->stock,
            'description' => $request->description,
            'image' => $fileName,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        if($store){
            Toastr::success('Data berhasil ditambahkan','Berhasil!');
            $log = [
                'user_id' => Auth::user()->id,
                'workflow_type' => 'product',
                'activity' => 'add',
                'description' => 'Menambah product '.$request ->name,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
            $document = Log::create($log);
            return redirect()->route('product.index');
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
        $product = Product::find($id);
        return view ('admin.product.edit',compact('product'));
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
        $validatedData = $request->validate([
            'name' => 'required|string',
            'price'=> 'required|numeric',
            'unit'=> 'required|string',
            'weight'=> 'required|numeric',
            'discount' => 'nullable|numeric',
            'stock' => 'required|numeric',
            'image' => 'nullable|file|image',
            'description' => 'nullable|string',
        ]);
        if ($request->hasFile('image')) {
            $existingImage = Product::find($id)->image;
            Storage::delete('public/images/products/' . $existingImage);


            $fileName = date("Y-m-d-His") . '_' . $request->file('image')->getClientOriginalName();
            $image = $request->file('image')
                ->storeAs('public/images/products/', $fileName);

            $image = Product::find($id)->update([
                'image' => $fileName,
            ]);
        }

        $product = Product::find($id);
        $update = $product->update([
            'name' => $request->name,
            'price' => $request->price,
            'unit' => $request->unit,
            'weight' => $request->weight,
            'discount' => $request->discount,
            'stock' => $request->stock,
            'description' => $request->description,
            'updated_at' => Carbon::now(),
        ]);
        if($update){
            Toastr::success('Data berhasil ditambahkan','Berhasil!');
            $log = [
                'user_id' => Auth::user()->id,
                'workflow_type' => 'product',
                'activity' => 'edit',
                'description' => 'Edit product '.$request ->name,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
            $document = Log::create($log);
            return redirect()->route('product.index');
            Toastr::success('Product berhasil diubah','Berhasil!');
            return redirect()->route('product.index');
        }else{
            Toastr::error('Product gagal diubah, coba lagi','Gagal!');
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
        //
        $product = Product::find($id);

        $existingImage = Product::find($id)->image;

        Storage::delete('public/images/products/' . $existingImage);
        $log = [
            'user_id' => Auth::user()->id,
            'workflow_type' => 'product',
            'activity' => 'del',
            'description' => 'Menghapus product '.Product::find($id)->name,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
        $document = Log::create($log);
        $delete = $product->delete();
        if($delete){
            Toastr::success('Product berhasil dihapus','Berhasil!');
            return redirect()->route('product.index');
        }else{
            Toastr::error('Product gagal dihapus, coba lagi','Gagal!');
            return redirect()->back();
        }
    }
}
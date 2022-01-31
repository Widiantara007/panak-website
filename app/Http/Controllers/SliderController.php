<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sliders = Slider::all();
        return view('admin.slider.index',compact('sliders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.slider.create');
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
            'title' => 'required|string',
            'link'=> 'required|string',
            'image' => 'required|file|image',
            'description' => 'nullable|string',
        ]);

        $fileName = date("Y-m-d-His") . '_' . $request->file('image')->getClientOriginalName();

        $image = $request->file('image')
            ->storeAs('public/images/sliders/', $fileName);

        $store = Slider::insert([
            'title' => $request->title,
            'link' => $request->link,
            'description' => $request->description,
            'image' => $fileName,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        if($store){
            Toastr::success('Data berhasil ditambahkan','Berhasil!');
            return redirect()->route('slider.index');
        }else{
            Toastr::error('Data gagal ditambahkan, coba lagi','Gagal!');
            return redirect()->back();
        }

    }
    

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function show(slider $slider)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $slider = Slider::find($id);
        return view('admin.slider.edit',compact('slider'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'title' => 'required|string',
            'link'=> 'required|string',
            'image' => 'nullable|file|image',
            'description' => 'nullable|string',
        ]);
        if ($request->hasFile('image')) {
            $existingImage = Slider::find($id)->image;
            Storage::delete('public/images/sliders/' . $existingImage);


            $fileName = date("Y-m-d-His") . '_' . $request->file('image')->getClientOriginalName();
            $image = $request->file('image')
                ->storeAs('public/images/sliders/', $fileName);

            $image = Slider::find($id)->update([
                'image' => $fileName,
            ]);
        }
        $slider = Slider::find($id);
        $update = $slider->update([
            'title' => $request->title,
            'link' => $request->link,
            'description' => $request->description,
            'updated_at' => Carbon::now(),
        ]);
        if($update){
            Toastr::success('Data berhasil diedit','Berhasil!');
            return redirect()->route('slider.index');
        }else{
            Toastr::error('Data gagal diedit, coba lagi','Gagal!');
            return redirect()->back();
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $slider = Slider::find($id);
        $existingImage = Slider::find($id)->image;
        Storage::delete('public/images/sliders/' . $existingImage);
        $delete = $slider->delete();
        if($delete){
            Toastr::success('Slider berhasil dihapus','Berhasil!');
            return redirect()->route('slider.index');
        }else{
            Toastr::error('Slider gagal dihapus, coba lagi','Gagal!');
            return redirect()->back();
        }
    }
}

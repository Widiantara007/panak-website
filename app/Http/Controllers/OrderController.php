<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Notifications\UserNotification;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::all();
        return view('admin.order.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $products = Product::where('stock', '>', 0)->orderBy('name')->get();
        return view('admin.order.create', compact('products'));
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
            'recipient_name' => 'required|string',
            'no_hp'=> 'required|numeric',
            'village'=> 'required|string',
            'address_detail' => 'required|string',
            'postal_code' => 'required|string',
            'payment_type' => 'required',
            'product_id' => 'required',
            'quantity' => 'required'
        ]);

        $order_id = Order::insertGetId([
            'user_id' => Auth::user()->id,
            'recipient_name' => $request->recipient_name,
            'location_code' => $request->village,
            'address_detail' => $request->address_detail,
            'postal_code' => $request->postal_code,
            'no_hp' => $request->no_hp,
            'payment_type' => $request->payment_type,
            'status' => 'process'
        ]);

        $product_id = $request->product_id;
        $quantity = $request->quantity;
        $total = 0;
        for ($i=0; $i < count($product_id); $i++) { 
            $totalPerProduct = OrderDetail::insertOrderProduct($order_id, $product_id[$i], $quantity[$i]);
            $total += $totalPerProduct;
        }

        // update total
        $update = Order::find($order_id)->update([
            'total' => $total,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
        if($update){
            Toastr::success('Data berhasil ditambahkan','Berhasil!');
            return redirect()->route('order.index');
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
        $order = Order::find($id);
        $products = Product::orderBy('name')->get();
        return view('admin.order.edit', compact('order', 'products'));
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
            'recipient_name' => 'required|string',
            'no_hp'=> 'required|numeric',
            'village'=> 'required|string',
            'address_detail' => 'required|string',
            'postal_code' => 'required|string',
            'payment_type' => 'required',
            'status' => 'required'
        ]);

        $order = Order::find($id);
        $order->update([
            'recipient_name' => $request->recipient_name,
            'location_code' => $request->village,
            'address_detail' => $request->address_detail,
            'postal_code' => $request->postal_code,
            'no_hp' => $request->no_hp,
            'payment_type' => $request->payment_type,
            'status' => $request->status
        ]);


        //update order product
        if(!empty($request->detail_id)){
            foreach($order->order_details as $order_product){
                //cek apakah ada di data form baru
                if(in_array($order_product->id, $request->detail_id)){
                    //jika ada maka update quantity
                    $index = array_search($order_product->id, $request->detail_id);
                    $quantity = $request->existing_quantity[$index];
                    OrderDetail::find($order_product->id)->update([
                        'quantity' => $quantity,
                        'updated_at' => Carbon::now(),
                    ]);

                }else{
                    //jika tidak ada maka hapus
                    OrderDetail::find($order_product->id)->forceDelete();
                }
            }
        }

        //insert new order product if exist
        if(!empty($request->product_id)){
            $product_id = $request->product_id;
            $quantity = $request->quantity;
            for ($i=0; $i < count($product_id); $i++) { 
                $totalPerProduct = OrderDetail::insertOrderProduct($order->id, $product_id[$i], $quantity[$i]);
            }
        }

        // update total
        $order = Order::find($id);
        $total = $order->total();
        $update = $order->update([
            'total' => $total,
            'updated_at' => Carbon::now()
        ]);


        if($update){
            Toastr::success('Data berhasil diubah','Berhasil!');
            return redirect()->route('order.index');
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
        $order = Order::find($id);
        // delete detail
        foreach($order->order_details as $detail){
            $detail->delete();
        }
        // delete order
        $delete = $order->delete();
        if($delete){
            Toastr::success('Data berhasil dihapus','Berhasil!');
            return redirect()->route('order.index');
        }else{
            Toastr::error('Data gagal dihapus, coba lagi','Gagal!');
            return redirect()->back();
        }
    }

    public function destroy_order_detail($order_id, $order_detail_id)
    {
        $delete = OrderDetail::find($order_detail_id)->forceDelete();

        if($delete){
            Toastr::success('Order Produk berhasil dihapus','Berhasil!');
            return redirect()->back();

        }else{
            Toastr::error('Order Produk gagal dihapus, coba lagi','Gagal!');
            return redirect()->back();
        }
    }

    public function updateStatus($order_id, Request $request){
        $validatedData = $request->validate([
            'submit' => 'required',
        ]);

        $order = Order::find($order_id);
        $update = $order->update([
            'status' => $request->submit,
        ]);
        if($request->submit == 'sending'){
            //notifikasi user
            $order->user->notify(new UserNotification('pasarnak_sending','Pesanan anda sedang dalam pengiriman', route('profile.transaction', ['tab'=>'pasarnak'])));
        }

        if($update){
            Toastr::success('Status berhasil diubah','Berhasil!');
            return redirect()->route('order.index');
        }else{
            Toastr::error('Status gagal diubah, coba lagi','Gagal!');
            return redirect()->back();
        }
    }

    public function updateDone($order_id){

        $order = Auth::user()->orders->where('status', 'sending')->where('id', $order_id)->first();
        if(empty($order)){
            Toastr::error('Pesanan tidak ditemukan','Gagal!');
            return redirect()->back();
        }

        $update = $order->update([
            'status' => 'done'
        ]);

        if($update){
            Toastr::success('Pesanan Selesai','Berhasil!');
            return redirect()->route('profile.transaction',['tab'=>'pasarnak']);
        }else{
            Toastr::error('Status gagal diubah, coba lagi','Gagal!');
            return redirect()->back();
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $carts = Cart::where('user_id', Auth::user()->id)->get();
        return view('pasarnak.cart', compact('carts'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'product_id' => 'required',
            'quantity' => 'nullable|numeric'
        ]);

        if($request->action == 'checkout'){
            return redirect()->route('checkout', ['from' => 'product', 'product_id'=> $request->product_id, 'quantity' => $request->quantity ?? 1]);
        }

        $store = Cart::updateOrCreate(
            [
                'user_id' => Auth::user()->id,
                'product_id' => $request->product_id,
            ],
            [
                'quantity' => $request->quantity ?? 1,
            ]
            );

        if ($store) {
            Toastr::success('Produk berhasil ditambahkan ke keranjang', 'Berhasil!');
            return redirect()->back();
        } else {
            Toastr::error('Produk gagal ditambahkan ke keranjang, coba lagi', 'Gagal!');
            return redirect()->back();
        }
        
    }

    public function destroy($id)
    {
        $delete = Cart::find($id)->delete();

        if ($delete) {
            Toastr::success('Produk berhasil dihapus dari keranjang', 'Berhasil!');
            return redirect()->back();
        } else {
            Toastr::error('Produk gagal dihapus dari keranjang, coba lagi', 'Gagal!');
            return redirect()->back();
        }
    }

    public function checkoutProcess(Request $request)
    {
        if($request->from == 'cart'){
            $cart_id = $request->cart_id;
            //update quantity
            for ($i=0; $i < count($cart_id) ; $i++) { 
                $update = Cart::find($cart_id[$i])->update([
                    'quantity' => $request->quantity[$i],
                ]);
            }
            return redirect()->route('checkout', ['from'=>'cart']);
        }else{
            return redirect()->route('checkout', ['product_id' => $request->product_id, ['quantity'=> $request->quantity]]);
        }


    }

    public function checkout(Request $request)
    {
        $user = Auth::user();

        $products = collect();
        $weight = 0;
        if($request->from == 'cart'){
            $carts = $user->carts;
            foreach ($carts as $index => $cart) {
                if($cart->quantity > 0){
                    $product = collect();
                    
                    //masukin quantity ke product
                    $product->put('id', $cart->product->id);
                    $product->put('name', $cart->product->name);
                    $product->put('price', $cart->product->price_after_discount());
                    $product->put('image', $cart->product->image);
                    $product->put('quantity', $cart->quantity);
                    $products->push($product);

                    //tambah berat
                    $weight += ($cart->product->weight * $cart->quantity);
                }
            }
        }else if($request->from == 'product'){
            $chosenProduct = Product::find($request->product_id);

            //cek stock
            if($request->quantity <= $chosenProduct->stock){
                $product = collect();
                $product->put('id', $chosenProduct->id);
                $product->put('name', $chosenProduct->name);
                $product->put('price', $chosenProduct->price_after_discount());
                $product->put('image', $chosenProduct->image);
                $product->put('quantity', $request->quantity);
                $products->push($product);

                //tambah berat
                $weight += ($chosenProduct->weight * $request->quantity);
            }

        }

        $addresses = Auth::user()->addresses;

        $ongkir =0;
        //kode lokasi yang terjangkau
        $location = ['51', '31'];

        $chosenAddress = null;
        //jika user sudah memilih alamat
        if(!empty($request->address)){
            $chosenAddress = $user->addresses->find($request->address);

            if(!empty($chosenAddress)){
                //cek lokasi
                for ($i=0; $i < count($location); $i++) { 
                    //jika berhasil (didalam jangkauan)
                    if( $location[$i] == substr($chosenAddress->location_code, 0, strlen($location[$i])) ){
                        $ongkir = PaymentController::getOngkir($chosenAddress->location_code, $weight);
                        return view('pasarnak.checkout', compact('products', 'addresses', 'chosenAddress', 'ongkir'));
                    }
                }

                //jika diluar bali
                $chosenAddress = null;
                Toastr::error('Mohon maaf, Untuk saat ini pengiriman produk Pasarnak hanya bisa untuk wilayah BALI dan JAKARTA. Terimakasih', '', [
                    "positionClass"=> "toast-top-center",
                    "showDuration" => "0",
                    "hideDuration" => "0",
                    "timeOut" => "0",
                    "extendedTimeOut" => "0",
                ]);
            }
           
        }

        
        return view('pasarnak.checkout', compact('products', 'addresses', 'chosenAddress', 'ongkir'));
    }
}

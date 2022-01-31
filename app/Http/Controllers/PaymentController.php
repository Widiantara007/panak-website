<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Log;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\ProjectBatch;
use App\Models\Transaction;
use App\Models\UserAddress;
use App\Models\UserPortofolio;
use App\Models\Withdrawal;
use App\Notifications\UserNotification;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function payInvestnak($project_id, $project_batch_id, Request $request)
    {
        $validatedData = $request->validate([
            'lot' => 'required|numeric',
            'quota' => 'nullable|numeric',
            'payment_method' => 'required|string'
        ]);
        $project_batch = ProjectBatch::find($project_batch_id);

        //cek apakah sudah fullyfunded
        if ($project_batch->isFullyFunded()) {
            Toastr::error('Investasi sudah ditutup', 'Gagal!');
            return redirect()->back();
        }


        //hitung nominal
        $nominal = $project_batch->minimum_fund * $request->lot;

        //cek saldo jika pake wallet
        if ($request->payment_method == 'wallet') {
            //cek saldo
            if (Auth::user()->balance < $nominal) {
                Toastr::error('Saldo tidak mencukupi', 'Gagal!');
                return redirect()->back();
            }
        }

        $description = [
            'quota' => $request->quota ?? 0,
            'lot' => $request->lot,
        ];
        //transaction
        $storeTransaction = Transaction::create([
            'user_id' => Auth::user()->id,
            'type' => 'investnak',
            'transaction_type' => 'income',
            'project_batch_id' => $project_batch_id,
            'nominal' => $nominal,
            'payment_method' => $request->payment_method,
            'status' => 'pending',
            'description' => json_encode($description),
        ]);
        if ($request->payment_method == 'wallet') {
            $storeTransaction->user->minusBalance($nominal);
            $this->handlingInvestnak($storeTransaction);
            Toastr::success('Pembayaran berhasil dilakukan', 'Berhasil!');
            return redirect()->route('profile.transaction');
        } else {
            $payment_token = $this->_generatePaymentToken($storeTransaction->id, $nominal);
            $storeTransaction->payment_token = $payment_token;
            $storeTransaction->save();

            return redirect(Transaction::PAYMENT_URL() .$storeTransaction->payment_token);
        }
    }

    public function payPasarnak(Request $request)
    {
        $validatedData = $request->validate([
            'address_id' => 'required',
            'product_id' => 'required',
            'quantity' => 'required',
            'payment_method' => 'required|string'
        ]);

        $user = Auth::user();
        $address = $user->addresses->where('id', $request->address_id)->first();

        //jika alamat tidak ada
        if (empty($address)) {
            Toastr::error('Alamat tidak ditemukan', 'Gagal!');
            return redirect()->back();
        }

        //hitung subtotal
        $product_id = $request->product_id;
        $quantity = $request->quantity;
        $total = 0;
        $weight = 0;
        for ($i = 0; $i < count($product_id); $i++) {
            $product = Product::find($product_id[$i]);
            $totalPerProduct = ($product->price_after_discount() * $quantity[$i]);
            $total += $totalPerProduct;

            //hitung berat
            $weight += ($product->weight *  $quantity[$i]);
        }

        $ongkir = $this->getOngkir($address->location_code, $weight);
        $subtotal = $total + $ongkir;

        //cek saldo jika pake wallet
        if ($request->payment_method == 'wallet') {
            //cek saldo
            if (Auth::user()->balance < $subtotal) {
                Toastr::error('Saldo tidak mencukupi', 'Gagal!');
                return redirect()->back();
            }
        }

        //masukin ke tabel order
        $order = Order::create([
            'user_id' => $user->id,
            'recipient_name' => $address->recipient_name,
            'location_code' => $address->location_code,
            'address_detail' => $address->address_detail,
            'postal_code' => $address->postal_code,
            'no_hp' => $address->no_hp,
            'status' => 'payment',
            'payment_type' => $request->payment_method,
        ]);

        $shipping_address = [
            'first_name' => $address->recipient_name,
            'phone' => $address->no_hp,
            'address' => $address->address_detail,
            'city' => Address::getDistrict($address->location_code),
            'postal_code' => $address->postal_code,
        ];

        $item_details = array();
        //masukin ke tabel order detail
        $product_id = $request->product_id;
        $quantity = $request->quantity;
        $total = 0;
        $weight = 0;
        for ($i = 0; $i < count($product_id); $i++) {
            $totalPerProduct = OrderDetail::insertOrderProduct($order->id, $product_id[$i], $quantity[$i]);
            $total += $totalPerProduct;

            //hitung berat
            $product = Product::find($product_id[$i]);
            $item_details_add = [
                'id' => $product->id,
                'price' => round($product->price),
                'quantity' => $quantity[$i],
                'name' => $product->name,
            ];
            array_push($item_details, $item_details_add);
            $weight += ($product->weight *  $quantity[$i]);
        }

        $ongkir = $this->getOngkir($address->location_code, $weight);
        $item_details_add = [
            'id' => 'ongkir',
            'price' => (int) $ongkir,
            'quantity' => 1,
            'name' => 'Ongkir',
        ];
        array_push($item_details, $item_details_add);


        $subtotal = $total + $ongkir;
        //update total
        $order->update([
            'shipping_cost' => $ongkir,
            'total' => $subtotal,
        ]);

        //insert ke transaction
        $storeTransaction = Transaction::create([
            'user_id' => $user->id,
            'type' => 'pasarnak',
            'order_id' => $order->id,
            'transaction_type' => 'income',
            'nominal' => $subtotal,
            'payment_method' => $request->payment_method,
            'status' => 'pending',
        ]);
        //hapus keranjang jika dari cart
        if ($request->from == 'cart') {
            foreach ($user->carts as $cart) {
                $deleteCart = $cart->delete();
            }
        }

        if ($request->payment_method == 'wallet') {
            //cek saldo
            if (Auth::user()->balance < $subtotal) {
                Toastr::error('Saldo tidak mencukupi', 'Gagal!');
                return redirect()->back();
            }
            $storeTransaction->user->minusBalance($subtotal);
            $this->handlingPasarnak($storeTransaction);
            Toastr::success('Pembayaran berhasil dilakukan', 'Berhasil!');
            return redirect()->route('profile.transaction');
        } else {
            $payment_token = $this->_generatePaymentToken($storeTransaction->id, $subtotal, $shipping_address, $item_details);
            $storeTransaction->payment_token = $payment_token;
            $storeTransaction->save();

            return redirect(Transaction::PAYMENT_URL() .$storeTransaction->payment_token);
        }
    }

    public static function getOngkir($location_code, $weight = 1000)
    {
        $ongkir = 18000;

        //pembulatan berat
        $weight = ceil($weight /= 1000);

        $free_ongkir_location_code = [];
        // Denpasar, tabanan, kelungkung, kuta, seminyak, jimbaran, cangu, kerobokan, batubulan, nusa dua / benoa

        //cek apakah lokasi gratis ongkir
        for ($i = 0; $i < count($free_ongkir_location_code); $i++) {
            //jika gratis (didalam jangkauan)
            if ($free_ongkir_location_code[$i] == substr($location_code, 0, strlen($free_ongkir_location_code[$i]))) {
                $ongkir = 0;
            }
        }

        return $ongkir * $weight;
    }

    public function payWithdrawal($withdrawal_id)
    {
        $withdrawal = Withdrawal::find($withdrawal_id);

        //log transaction
        $storeTransaction = Transaction::create([
            'user_id' => $withdrawal->user_id,
            'type' => 'wallet',
            'transaction_type' => 'outcome',
            'nominal' => $withdrawal->nominal,
            'payment_method' => $withdrawal->user_bank->bank->name,
            'status' => 'success',
            'description' => 'penarikan dana',
            'created_by' => Auth::user()->id,
            'updated_by' => Auth::user()->id,
        ]);

        //update withdrawal
        $update = $withdrawal->update([
            'status' => 'paid',
            'transaction_id' => $storeTransaction->id,
        ]);

        $update = $withdrawal->user->minusBalance($withdrawal->nominal);

        if ($update) {
            $log = [
                'user_id' => Auth::user()->id,
                'workflow_type' => 'withdraw',
                'activity' => 'edit',
                'description' => 'Bayar permintaan penarikan user email: ' . $withdrawal->user->email,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
            $document = Log::create($log);
            $storeTransaction->user->notify(new UserNotification('transaction_outcome', 'Penarikan dana sebesar Rp ' . number_format($withdrawal->nominal, 0, ",", ".") . ' telah berhasil', route('profile.wallet')));
            Toastr::success('Pembayaran penarikan dana berhasil', 'Berhasil!');
            return redirect()->back();
        } else {
            Toastr::error('Pembayaran penarikan dana gagal, coba lagi', 'Gagal!');
            return redirect()->back();
        }
    }

    public function payTopup(Request $request)
    {
        $validatedData = $request->validate([
            'nominal' => 'required|numeric',
            'payment_method' => 'required|string'
        ]);
        $user = Auth::user();


        //transaction
        $storeTransaction = Transaction::create([
            'user_id' => $user->id,
            'type' => 'wallet',
            'transaction_type' => 'income',
            'nominal' => $request->nominal,
            'payment_method' => $request->payment_method,
            'status' => 'pending',
            'description' => 'top up wallet'
        ]);
        $callback_url = env('APP_URL').'/profile/wallet';
        $payment_token = $this->_generatePaymentToken($storeTransaction->id, $request->nominal, null, null, $callback_url);
        $storeTransaction->payment_token = $payment_token;
        $storeTransaction->save();

        return redirect(Transaction::PAYMENT_URL() . $storeTransaction->payment_token);
    }

    public function handlingTransaction(Request $request)
    {
        //check credibility
        $this->initMidtrans();
        $check = \Midtrans\Transaction::status($request->order_id);
        if ($check->transaction_status != $request->transaction_status) {
            return response('Data did not match', 400);
        }

        $transaction = Transaction::find($request->order_id);

        if ((!empty($check->fraud_status) ? in_array($check->fraud_status, ['deny', 'challenge']) : false)) {
            $log = [
                'user_id' => $transaction->user_id,
                'workflow_type' => 'payment',
                'activity' => 'check',
                'description' => "Terdeteksi fraud:{$request->fraud_status} di transaction_id : {$transaction->id}",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
            $document = Log::create($log);
            return response('success sent to log, fraud detected');
        } else {
            if (in_array($request->transaction_status, ['settlement', 'capture'])) {
                //jika investnak
                if ($transaction->type == 'investnak' && $transaction->transaction_type == 'income') {
                    $this->handlingInvestnak($transaction);
                } else if ($transaction->type == 'pasarnak' && $transaction->transaction_type == 'income') {
                    $this->handlingPasarnak($transaction);
                } else if ($transaction->type == 'wallet' && $transaction->transaction_type == 'income') {
                    $update = $transaction->update([
                        'status' => 'success',
                    ]);
                    $update = $transaction->user->plusBalance($transaction->nominal);

                    if ($update) {
                        $transaction->user->notify(new UserNotification('transaction_income', 'TopUp Wallet sebesar Rp ' . number_format($transaction->nominal, 0, ",", ".") . ' telah berhasil dilakukan', route('profile.wallet')));
                    }
                }
            }
            $update = $transaction->update([
                'payment_method' => $check->payment_type
            ]);
        }

        return response('success');
    }

    public function handlingInvestnak($transaction)
    {
        //jika request sudah settlement / capture
        $transaction->update([
            'status' => 'success'
        ]);
        if (empty($transaction->user_portofolio_id)) {

            //portfolios
            $description = json_decode($transaction->description, true);
            $storePortfolio = UserPortofolio::create([
                'user_id' => $transaction->user_id,
                'project_id' => $transaction->project_batch->project->id,
                'project_batch_id' => $transaction->project_batch_id,
                'lot' => $description['lot'],
                'nominal' => $transaction->nominal,
                'quota' => $description['quota'],
            ]);

            $update = $transaction->update([
                'user_portofolio_id' => $storePortfolio->id,
            ]);

            //update contract number
            $update = $storePortfolio->update([
                'contract_number' => $storePortfolio->generateContractNumber(),
            ]);
            if ($update) {
                $transaction->user->notify(new UserNotification('transaction_outcome', 'Pembayaran anda sebesar Rp ' . number_format($transaction->nominal, 0, ",", ".") . ' telah berhasil dilakukan', route('profile.transaction')));
            }
        }
    }

    public function handlingPasarnak($transaction)
    {
        //update jika sudah dibayar
        $transaction->update([
            'status' => 'success',
        ]);
        $update = $transaction->order->update([
            'status' => 'process',
        ]);
        if ($update) {
            $transaction->user->notify(new UserNotification('transaction_outcome', 'Pembayaran anda sebesar Rp ' . number_format($transaction->nominal, 0, ",", ".") . ' telah berhasil dilakukan', route('profile.transaction', ['tab' => 'pasarnak'])));
        }
    }

    public function _generatePaymentToken($order_id, $gross_amount, $shipping_address = null, $item_details = null, $callback_url = null)
    {
        $this->initMidtrans();
        $customer_details = [
            'first_name' => Auth::user()->name,
            'email' => Auth::user()->email,
            'phone' => Auth::user()->phone,
            'shipping_address' => $shipping_address
        ];

        $transaction_details = [
            'order_id' => $order_id,
            'gross_amount' => (int)$gross_amount,
        ];

        $callbacks = [
            'finish' => $callback_url,
        ];

        $params = [
            'transaction_details' => $transaction_details,
            'customer_details' => $customer_details,
            'item_details' => $item_details,
            'callbacks' => $callbacks
        ];

        $snap = \Midtrans\Snap::createTransaction($params);
        return $snap->token;
    }
}

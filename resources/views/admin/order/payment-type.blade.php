{!! Form::select('payment_type', 
[
"BCA Virtual account" => "BCA Virtual account",
"BNI" => "BNI",
"BRIVA" => "BRIVA",
"Mandiri" => "Mandiri",
"Permata" => "Permata", 
"Indomaret" => "Indomaret",
"Alfamart" => "Alfamart",
"Alfamidi" => "Alfamidi",
"Dan+Dan" => "Dan+Dan", 
"GoPay" => "GoPay",
"ShopeePay" => "ShopeePay",
"Qris" => "Qris"
],
old('payment_type') ?? $order->payment_type ?? null, ['placeholder' => 'Pilih Tipe Pembayaran', 'class' => 'form-control']); !!}
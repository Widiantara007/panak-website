<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class OrderDetail
 * 
 * @property int $id
 * @property int $order_id
 * @property int $product_id
 * @property float $price
 * @property int $quantity
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Order $order
 * @property Product $product
 *
 * @package App\Models
 */
class OrderDetail extends Model
{
	use SoftDeletes;
	protected $table = 'order_details';

	protected $casts = [
		'order_id' => 'int',
		'product_id' => 'int',
		'price' => 'float',
		'quantity' => 'int'
	];

	protected $fillable = [
		'order_id',
		'product_id',
		'price',
		'quantity'
	];

	public function order()
	{
		return $this->belongsTo(Order::class);
	}

	public function product()
	{
		return $this->belongsTo(Product::class);
	}
	public function total_price(){
		return $this->price * $this->quantity;
	}

	public static function insertOrderProduct($order_id, $product_id, $quantity){
		$product = Product::find($product_id);

		// cek stok
		if($product->stock < $quantity){
			return 0;
		}

		// ngurangin stock
		$product->update([
			'stock' => ($product->stock - $quantity),
			'updated_at' => Carbon::now()
		]);

		$price = (empty($product->discount) ? $product->price : ($product->price - ($product->price * $product->discount /100)));

		$insert = OrderDetail::insert([
			'order_id' => $order_id,
			'product_id' => $product->id,
			'price' => $price,
			'quantity' => $quantity,
			'created_at' => Carbon::now(),
			'updated_at' => Carbon::now(),
		]);
		$total = ($price * $quantity);

		return $total;
	}
}

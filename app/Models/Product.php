<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Product
 * 
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property float $price
 * @property string $unit
 * @property int $stock
 * @property float|null $discount
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * 
 * @property Collection|Cart[] $carts
 * @property Collection|OrderDetail[] $order_details
 *
 * @package App\Models
 */
class Product extends Model
{
	use SoftDeletes;
	protected $table = 'products';

	protected $casts = [
		'price' => 'float',
		'stock' => 'int',
		'discount' => 'float'
	];

	protected $fillable = [
		'name',
		'description',
		'price',
		'unit',
		'weight',
		'stock',
		'discount',
		'image'
	];

	public function price_after_discount()
	{
		$price = $this->price - ($this->price*$this->discount/100);
		return $price;
	}
	public function carts()
	{
		return $this->hasMany(Cart::class);
	}

	public function order_details()
	{
		return $this->hasMany(OrderDetail::class);
	}

	public function isOutOfStock(){
		return $this->stock > 0 ? false: true;
	}
}

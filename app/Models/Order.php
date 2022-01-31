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
 * Class Order
 * 
 * @property int $id
 * @property int $user_id
 * @property string|null $recipient_name
 * @property string $location_code
 * @property string $address_detail
 * @property string $postal_code
 * @property string $no_hp
 * @property string $status
 * @property float $total
 * @property string|null $payment_type
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * 
 * @property User $user
 * @property Collection|OrderDetail[] $order_details
 * @property Collection|Transaction[] $transactions
 *
 * @package App\Models
 */
class Order extends Model
{
	use SoftDeletes;
	protected $table = 'orders';

	protected $casts = [
		'user_id' => 'int',
		'total' => 'float'
	];

	protected $fillable = [
		'user_id',
		'recipient_name',
		'location_code',
		'address_detail',
		'postal_code',
		'no_hp',
		'status',
		'shipping_cost',
		'total',
		'payment_type'
	];

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function order_details()
	{
		return $this->hasMany(OrderDetail::class);
	}

	public function transactions()
	{
		return $this->hasMany(Transaction::class);
	}

	public function total(){
		$total = 0;
		foreach($this->order_details as $order_detail){
			$total += $order_detail->total_price();
		}
		return $total;
	}
}

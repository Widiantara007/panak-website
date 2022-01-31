<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\App;

/**
 * Class Transaction
 * 
 * @property int $id
 * @property int $user_id
 * @property string|null $type
 * @property string $transaction_type
 * @property int|null $order_id
 * @property int|null $user_portofolio_id
 * @property float $nominal
 * @property string|null $description
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * 
 * @property Order|null $order
 * @property User $user
 * @property UserPortofolio|null $user_portofolio
 *
 * @package App\Models
 */
class Transaction extends Model
{
	use SoftDeletes;
	protected $table = 'transactions';

	protected $casts = [
		'user_id' => 'int',
		'order_id' => 'int',
		'user_portofolio_id' => 'int',
		'nominal' => 'float'
	];

	protected $fillable = [
		'user_id',
		'type',
		'transaction_type',
		'order_id',
		'project_batch_id',
		'user_portofolio_id',
		'nominal',
		'payment_method',
		'status',
		'description',
		'payment_token',
		'created_by',
		'updated_by'
	];
	
	public static function PAYMENT_URL(){
		if (App::environment('production')) {
			return "https://app.midtrans.com/snap/v2/vtweb/";
		}else{
			return "https://app.sandbox.midtrans.com/snap/v2/vtweb/";
		}
	}

	public function order()
	{
		return $this->belongsTo(Order::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function user_portofolio()
	{
		return $this->belongsTo(UserPortofolio::class);
	}

	public function project_batch()
	{
		return $this->belongsTo(ProjectBatch::class);
	}
}

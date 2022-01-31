<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Withdrawal
 * 
 * @property int $id
 * @property int $user_id
 * @property int|null $user_bank_id
 * @property float $nominal
 * @property string $status
 * @property string|null $feedback
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * 
 * @property UserBank|null $user_bank
 * @property User $user
 *
 * @package App\Models
 */
class Withdrawal extends Model
{
	use SoftDeletes;
	protected $table = 'withdrawals';

	protected $casts = [
		'user_id' => 'int',
		'user_bank_id' => 'int',
		'nominal' => 'float'
	];

	protected $fillable = [
		'user_id',
		'user_bank_id',
		'transaction_id',
		'nominal',
		'status',
		'feedback'
	];

	public function user_bank()
	{
		return $this->belongsTo(UserBank::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}
}

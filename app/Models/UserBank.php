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
 * Class UserBank
 * 
 * @property int $id
 * @property int $user_id
 * @property int $bank_id
 * @property string $holder_name
 * @property string $account_number
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * 
 * @property Bank $bank
 * @property User $user
 * @property Collection|Withdrawal[] $withdrawals
 *
 * @package App\Models
 */
class UserBank extends Model
{
	use SoftDeletes;
	protected $table = 'user_banks';

	protected $casts = [
		'user_id' => 'int',
		'bank_id' => 'int'
	];

	protected $fillable = [
		'user_id',
		'bank_id',
		'holder_name',
		'account_number'
	];

	public function bank()
	{
		return $this->belongsTo(Bank::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function withdrawals()
	{
		return $this->hasMany(Withdrawal::class);
	}
}

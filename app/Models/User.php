<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

/**
 * Class User
 * 
 * @property int $id
 * @property string $name
 * @property string|null $google_id
 * @property string $email
 * @property Carbon|null $email_verified_at
 * @property string $password
 * @property int|null $main_address_id
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * 
 * @property UserAddress|null $user_address
 * @property Collection|Cart[] $carts
 * @property Collection|Log[] $logs
 * @property Collection|Order[] $orders
 * @property Collection|Transaction[] $transactions
 * @property Collection|UserAddress[] $user_addresses
 * @property Collection|Bank[] $banks
 * @property Collection|UserPortofolio[] $user_portofolios
 * @property Collection|UserProfile[] $user_profiles
 * @property Collection|Withdrawal[] $withdrawals
 *
 * @package App\Models
 */
class User extends Authenticatable
{
	use SoftDeletes, HasRoles, Notifiable;
	protected $table = 'users';

	protected $casts = [
		'main_address_id' => 'int'
	];

	protected $dates = [
		'email_verified_at'
	];

	protected $hidden = [
		'password',
		'remember_token'
	];

	protected $fillable = [
		'name',
		'google_id',
		'email',
		'email_verified_at',
		'no_hp',
		'password',
		'balance',
		'main_address_id',
		'photo_profile',
		'remember_token'
	];

	public function user_address()
	{
		return $this->belongsTo(UserAddress::class, 'main_address_id');
	}

	public function carts()
	{
		return $this->hasMany(Cart::class);
	}

	public function logs()
	{
		return $this->hasMany(Log::class);
	}

	public function orders()
	{
		return $this->hasMany(Order::class);
	}

	public function transactions()
	{
		return $this->hasMany(Transaction::class);
	}

	public function addresses()
	{
		return $this->hasMany(UserAddress::class);
	}

	public function banks()
	{
		return $this->belongsToMany(Bank::class, 'user_banks')
					->withPivot('id', 'holder_name', 'account_number', 'deleted_at')
					->withTimestamps();
	}

	public function portofolios()
	{
		return $this->hasMany(UserPortofolio::class);
	}

	public function profile()
	{
		return $this->hasOne(UserProfile::class);
	}

	public function withdrawals()
	{
		return $this->hasMany(Withdrawal::class);
	}

	public function getPhotoProfile()
	{
		return Str::startsWith($this->photo_profile, 'http') ? $this->photo_profile: (empty($this->photo_profile) ? asset('img/default-profile.png'):asset('storage/images/profiles/'.$this->photo_profile));
	}

	public function totalInvestments()
	{
		return $this->portofolios()->sum('nominal');
	}

	public function profitEstimation()
	{
		$totalProfit = 0;
		foreach ($this->portofolios()->get() as $portofolio) {
			$profit = $portofolio->nominal * (1+ ($portofolio->project_batch->roi_high / 100));
			$totalProfit+=$profit;
		}

		return $totalProfit;
	}

	public function plusBalance($nominal){
		$balance_now = $this->balance + $nominal;
		$update = $this->update([
			'balance' => $balance_now
		]);

		return $update;
	}

	public function minusBalance($nominal){
		$balance_now = $this->balance - $nominal;
		if($balance_now>=0){
			$update = $this->update([
				'balance' => $balance_now
			]);
			return $update;
		}

		return false;
	}
}

<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class UserAddress
 * 
 * @property int $id
 * @property int $user_id
 * @property string $label
 * @property string|null $recipient_name
 * @property string $location_code
 * @property string $address_detail
 * @property string $postal_code
 * @property string $no_hp
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property User $user
 * @property Collection|User[] $users
 *
 * @package App\Models
 */
class UserAddress extends Model
{
	protected $table = 'user_addresses';

	protected $casts = [
		'user_id' => 'int'
	];

	protected $fillable = [
		'user_id',
		'label',
		'recipient_name',
		'location_code',
		'address_detail',
		'postal_code',
		'no_hp'
	];

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function users()
	{
		return $this->hasMany(User::class, 'main_address_id');
	}
}

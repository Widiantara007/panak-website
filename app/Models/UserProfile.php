<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class UserProfile
 * 
 * @property int $id
 * @property int $user_id
 * @property string|null $sex
 * @property string|null $ktp_number
 * @property string|null $ktp_image
 * @property string|null $selfie_image
 * @property string|null $npwp_number
 * @property string|null $npwp_image
 * @property Carbon|null $birthday
 * @property string|null $job
 * @property string|null $signature
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * 
 * @property User $user
 *
 * @package App\Models
 */
class UserProfile extends Model
{
	use SoftDeletes;
	protected $table = 'user_profiles';

	protected $casts = [
		'user_id' => 'int'
	];

	protected $dates = [
		'birthday'
	];

	protected $fillable = [
		'user_id',
		'sex',
		'ktp_number',
		'ktp_image',
		'selfie_image',
		'npwp_number',
		'npwp_image',
		'birthday',
		'job',
		'signature',
		'verification_status',
		'verified_at',
		'verification_feedback'
	];

	public function user()
	{
		return $this->belongsTo(User::class);
	}
}

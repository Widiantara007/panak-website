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
 * Class Bank
 * 
 * @property int $id
 * @property string $name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * 
 * @property Collection|User[] $users
 *
 * @package App\Models
 */
class Bank extends Model
{

	protected $table = 'banks';
	public $timestamps = false;


	protected $fillable = [
		'name',
		'code'
	];

	public function users()
	{
		return $this->belongsToMany(User::class, 'user_banks')
					->withPivot('id', 'holder_name', 'account_number', 'deleted_at')
					->withTimestamps();
	}
}

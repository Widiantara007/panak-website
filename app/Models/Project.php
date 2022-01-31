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
 * Class Project
 * 
 * @property int $id
 * @property int $owner_id
 * @property string $name
 * @property string|null $type
 * @property string|null $location_code
 * @property string|null $description
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * 
 * @property ProjectOwner $project_owner
 * @property Collection|ProjectBatch[] $project_batches
 * @property Collection|UserPortofolio[] $user_portofolios
 *
 * @package App\Models
 */
class Project extends Model
{
	use SoftDeletes;
	protected $table = 'projects';

	protected $casts = [
		'owner_id' => 'int'
	];

	protected $fillable = [
		'owner_id',
		'name',
		'type',
		'location_code',
		'image',
		'risk_grade',
		'prospektus_file',
		'description'
	];

	public function project_owner()
	{
		return $this->belongsTo(ProjectOwner::class, 'owner_id');
	}

	public function project_batches()
	{
		return $this->hasMany(ProjectBatch::class);
	}

	public function user_portofolios()
	{
		return $this->hasMany(UserPortofolio::class);
	}
	public function generateAlias(){
		$project_name = (string)$this->name;
		$words = preg_split("/[\s,_-]+/", $project_name);
		$acronym = "";

		foreach ($words as $w) {
		$acronym .= $w[0];
		}
		return strtoupper($acronym);
    }

	
}

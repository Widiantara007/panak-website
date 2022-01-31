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
 * Class ProjectOwner
 * 
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * 
 * @property Collection|Project[] $projects
 *
 * @package App\Models
 */
class ProjectOwner extends Model
{
	use SoftDeletes;
	protected $table = 'project_owners';

	protected $fillable = [
		'name',
		'description'
	];

	public function projects()
	{
		return $this->hasMany(Project::class, 'owner_id');
	}
}

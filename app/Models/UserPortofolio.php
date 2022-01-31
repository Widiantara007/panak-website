<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class UserPortofolio
 * 
 * @property int $id
 * @property int $user_id
 * @property int $project_id
 * @property int $project_batch_id
 * @property int $lot
 * @property float $nominal
 * @property float|null $return_nominal
 * @property int $quota
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * 
 * @property ProjectBatch $project_batch
 * @property Project $project
 * @property User $user
 * @property Collection|Transaction[] $transactions
 *
 * @package App\Models
 */
class UserPortofolio extends Model
{
	use SoftDeletes;
	protected $table = 'user_portofolios';

	protected $casts = [
		'user_id' => 'int',
		'project_id' => 'int',
		'project_batch_id' => 'int',
		'lot' => 'int',
		'nominal' => 'float',
		'return_nominal' => 'float',
		'quota' => 'int'
	];

	protected $fillable = [
		'user_id',
		'project_id',
		'project_batch_id',
		'lot',
		'nominal',
		'return_nominal',
		'quota',
		'contract_number',
		'cbc_file',
		'certificate_file'
	];

	public function project_batch()
	{
		return $this->belongsTo(ProjectBatch::class)->withTrashed();
	}

	public function project()
	{
		return $this->belongsTo(Project::class)->withTrashed();
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function transactions()
	{
		return $this->hasMany(Transaction::class);
	}

	public function countProfit()
	{
		if(!empty($this->return_nominal)){
			return $this->return_nominal-$this->nominal;
		}
		return 0;
	}

	public function generateContractNumber(){
		$project_alias = $this->project->generateAlias();
		$batch_number = str_pad($this->project_batch->batch_no, 3, '0', STR_PAD_LEFT);
		$porto_id = str_pad($this->id, 5, '0', STR_PAD_LEFT);
		$rand_str = Controller::generateRandomString(3);

		$contract_number = $project_alias.$batch_number.$porto_id.$rand_str;
		return $contract_number;
	}

	public function profitPercentage(){
		$percentage = round($this->countProfit()/$this->nominal*100, 2);
		return $percentage;
	}
}

<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class ProjectBatch
 * 
 * @property int $id
 * @property int $project_id
 * @property int $batch_no
 * @property float|null $minimum_fund
 * @property float|null $maximum_fund
 * @property float|null $target_nominal
 * @property int|null $lot
 * @property float|null $roi_low
 * @property float|null $roi_high
 * @property Carbon|null $start_date
 * @property Carbon|null $end_date
 * @property string $status
 * @property float|null $gross_income
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * 
 * @property Project $project
 * @property Collection|UserPortofolio[] $user_portofolios
 *
 * @package App\Models
 */
class ProjectBatch extends Model
{
	use SoftDeletes;
	protected $table = 'project_batches';

	protected $casts = [
		'project_id' => 'int',
		'batch_no' => 'int',
		'minimum_fund' => 'float',
		'maximum_fund' => 'float',
		'target_nominal' => 'float',
		'lot' => 'int',
		'roi_low' => 'float',
		'roi_high' => 'float',
		'gross_income' => 'float'
	];

	protected $dates = [
		'start_date',
		'end_date'
	];

	protected $fillable = [
		'project_id',
		'batch_no',
		'minimum_fund',
		'maximum_fund',
		'target_nominal',
		'lot',
		'roi_low',
		'roi_high',
		'roi',
		'start_date',
		'end_date',
		'status',
		'gross_income',
		'is_yearly'
	];

	public function project()
	{
		return $this->belongsTo(Project::class)->withTrashed();
	}

	public function daysLeft()
	{
		$daysLeft = Carbon::parse(Carbon::now())->diffInDays($this->start_date, false);
		return $daysLeft >= 0 ? $daysLeft: 0 ;
	}

	public function period()
	{
		$start = Carbon::parse($this->start_date);
		$end = Carbon::parse($this->end_date);
		$day = $end->diffInDays($start);
		// round every 0.5
		$period = ceil($day/15)/2;
		return $period;
	}

	public function user_portofolios()
	{
		return $this->hasMany(UserPortofolio::class);
	}

	public function totalInvestments()
	{
		return $this->user_portofolios()->sum('nominal');
	}

	public function totalPercentage()
	{
		return round(($this->totalInvestments()/$this->target_nominal*100));
	}

	public function fullName()
	{
		return $this->project->name.' - Batch '.$this->batch_no;
	}

	public function isFullyFunded()
	{
		$isFullyFunded = ($this->totalPercentage() >= 100) || ($this->status != 'funding');
		return $isFullyFunded;
	}
	
	 public function getRangeROI()
	 {
		 return $this->roi_low.' - '.$this->roi_high;
	 }

	 public function totalLot()
	 {
		return $this->user_portofolios()->sum('lot');
	 }

	 public function countLot($nominal)
	 {
		 return $nominal/$this->minimum_fund;
	 }
}

<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;


/**
 * Class Product
 * 
 * @property int $id
 * @property string $title
 * @property string|null $description
 * @property string $link
 * @property string $image
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * 
 * @property Collection|Cart[] $carts
 * @property Collection|OrderDetail[] $order_details
 *
 * @package App\Models
 */

class slider extends Model
{
    protected $table = 'sliders';

    protected $fillable = [
		'title',
		'description',
		'link',
		'image',
	];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EdunakCategory extends Model
{
    use HasFactory, SoftDeletes;
	protected $fillable = [
        'category'
    ];

    public function articles(){
        return $this->hasMany(EdunakArticle::class, 'category_id');
    }
}

<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class EdunakArticle extends Model
{
    use HasFactory;
    use Sluggable;
    
    protected $casts = [
        'tags' => 'array'
    ];
    protected $fillable = [
        'category_id',
        'title',
        'slug',
        'cover_image',
        'content',
        'tags',
        'is_published',
    ];


    public function category(){
        return $this->belongsTo(EdunakCategory::class);
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
}

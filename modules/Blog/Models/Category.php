<?php

namespace Modules\Blog\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Blog\Database\Factories\BlogCategoryFactory;
use Modules\Support\Models\BaseModel;
use Modules\Support\Traits\ActivityLog;
use Modules\Support\Traits\Searchable;

class Category extends BaseModel
{
    use ActivityLog, HasFactory, Searchable, Sluggable, SoftDeletes;

    protected $table = 'blog_categories';

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    protected $appends = ['image_url'];

    protected $casts = [
        'is_visible' => 'boolean',
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name',
            ],
        ];
    }

    public function getImageUrlAttribute(): ?string
    {
        if ($this->image) {
            return asset("storage/blog/{$this->image}");
        }

        return null;
    }

    protected static function newFactory(): Factory
    {
        return BlogCategoryFactory::new();
    }
}

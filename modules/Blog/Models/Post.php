<?php

namespace Modules\Blog\Models;

use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Database\Factories\BlogPostFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Support\Models\BaseModel;
use Modules\Support\Traits\ActivityLog;
use Modules\Support\Traits\Searchable;

class Post extends BaseModel
{
    use ActivityLog, HasFactory, Searchable, Sluggable, SoftDeletes;

    protected $table = 'blog_posts';

    protected $appends = ['image_url'];

    protected static function newFactory(): Factory
    {
        return BlogPostFactory::new();
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title',
            ],
        ];
    }

    public function getStatusAttribute(): string
    {
        if ($this->published_at and Carbon::now()->greaterThan($this->published_at)) {
            return 'Published';
        }

        return 'Draft';
    }

    public function getImageUrlAttribute(): ?string
    {
        if ($this->image) {
            return asset("blog/{$this->image}");
        }

        return null;
    }
}

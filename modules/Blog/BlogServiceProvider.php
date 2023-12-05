<?php

namespace Modules\Blog;

use Modules\Support\BaseServiceProvider;
use Modules\Blog\Observers\PostObserver;
use Modules\Blog\Models\Post;

class BlogServiceProvider extends BaseServiceProvider
{
    protected $namespace = 'Modules\Blog\Http\Controllers';

    public function boot()
    {
        parent::boot();

        Post::observe(PostObserver::class);
    }
}

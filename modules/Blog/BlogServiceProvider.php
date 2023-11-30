<?php

namespace Modules\Blog;

use Modules\Support\BaseServiceProvider;

class BlogServiceProvider extends BaseServiceProvider
{
    protected $namespace = 'Modules\Blog\Http\Controllers';

    public function boot()
    {
        parent::boot();
    }
}

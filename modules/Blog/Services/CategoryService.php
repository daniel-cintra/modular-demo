<?php

namespace Modules\Blog\Services;

use Modules\Blog\Models\Category;
use Illuminate\Support\Str;

class CategoryService
{
    public function get(): array
    {
        return Category::orderBy('name')
            ->get()
            ->map(fn ($category) => [
                'value' => $category->id,
                'label' => Str::limit($category->name, 25),
            ])
            ->all();
    }
}

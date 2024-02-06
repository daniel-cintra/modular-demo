<?php

namespace Modules\Blog\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Inertia\Response;
use Modules\Blog\Http\Requests\CategoryValidate;
use Modules\Blog\Models\Category;
use Modules\Support\Http\Controllers\BackendController;
use Modules\Support\Traits\EditorImage;
use Modules\Support\Traits\UploadFile;

class CategoryController extends BackendController
{
    use EditorImage, UploadFile;

    public function index(): Response
    {
        $categories = Category::orderBy('name')
            ->search(request('searchContext'), request('searchTerm'))
            ->paginate(request('rowsPerPage', 10))
            ->withQueryString()
            ->through(fn ($category) => [
                'id' => $category->id,
                'image_url' => $category->image_url,
                'name' => Str::limit($category->name, 50),
                'is_visible' => $category->is_visible,
            ]);

        return inertia('BlogCategory/CategoryIndex', [
            'categories' => $categories,
        ]);
    }

    public function create(): Response
    {
        return inertia('BlogCategory/CategoryForm');
    }

    public function store(CategoryValidate $request): RedirectResponse
    {

        $categoryData = $request->validated();

        if ($request->hasFile('image')) {
            $categoryData = array_merge($categoryData, $this->uploadFile('image', 'blog', 'originalUUID', 'public'));
        }

        Category::create($categoryData);

        return redirect()->route('blogCategory.index')
            ->with('success', 'Category created.');
    }

    public function edit(int $id): Response
    {
        $category = Category::find($id);

        return inertia('BlogCategory/CategoryForm', [
            'category' => $category,
        ]);
    }

    public function update(CategoryValidate $request, int $id): RedirectResponse
    {
        $category = Category::findOrFail($id);

        $categoryData = $request->validated();

        if ($request->hasFile('image')) {
            $categoryData = array_merge($categoryData, $this->uploadFile('image', 'blog', 'originalUUID', 'public'));
        } elseif ($request->input('remove_previous_image')) {
            $categoryData['image'] = null;
        } else {
            unset($categoryData['image']);
        }

        $category->update($categoryData);

        return redirect()->route('blogCategory.index')
            ->with('success', 'Category updated.');
    }

    public function destroy(int $id): RedirectResponse
    {
        Category::findOrFail($id)->delete();

        return redirect()->route('blogCategory.index')
            ->with('success', 'Category deleted.');
    }
}

<?php

namespace Modules\Blog\Http\Controllers;

use Modules\Support\Http\Controllers\BackendController;
use Modules\Blog\Http\Requests\CategoryValidate;
use Modules\Blog\Models\Category;
use Illuminate\Http\RedirectResponse;
use Inertia\Response;

class CategoryController extends BackendController
{
    public function index(): Response
    {
        $categorys = Category::orderBy('name')
            ->search(request('searchContext'), request('searchTerm'))
            ->paginate(request('rowsPerPage', 10))
            ->withQueryString()
            ->through(fn ($category) => [
                    'id' => $category->id,
                    // 'name' => $category->name,
                    'created_at' => $category->created_at->format('d/m/Y H:i') . 'h'
            ]);

        return inertia('Blog/CategoryIndex', [
            'categorys' => $categorys
        ]);
    }

    public function create(): Response
    {
        return inertia('Blog/CategoryForm');
    }

    public function store(CategoryValidate $request): RedirectResponse
    {
        Category::create($request->validated());

        return redirect()->route('category.index')
            ->with('success', 'Category created.');
    }

    public function edit(int $id): Response
    {
        $category = Category::find($id);

        return inertia('Blog/CategoryForm', [
            'category' => $category
        ]);
    }

    public function update(CategoryValidate $request, int $id)
    {
        $category = Category::findOrFail($id);

        $category->update($request->validated());

        return redirect()->route('category.index')
            ->with('success', 'Category updated.');
    }

    public function destroy(int $id)
    {
        Category::findOrFail($id)->delete();

        return redirect()->route('category.index')
            ->with('success', 'Category deleted.');
    }
}

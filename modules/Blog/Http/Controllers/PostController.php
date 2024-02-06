<?php

namespace Modules\Blog\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Inertia\Response;
use Modules\Blog\Http\Requests\PostValidate;
use Modules\Blog\Models\Post;
use Modules\Blog\Services\AuthorService;
use Modules\Blog\Services\CategoryService;
use Modules\Support\Http\Controllers\BackendController;
use Modules\Support\Traits\EditorImage;
use Modules\Support\Traits\UploadFile;

class PostController extends BackendController
{
    use EditorImage, UploadFile;

    protected string $uploadImagePath = 'storage/app/public/blog';

    public function index(): Response
    {
        $posts = Post::orderBy('id', 'desc')
            ->search(request('searchContext'), request('searchTerm'))
            ->paginate(request('rowsPerPage', 10))
            ->withQueryString()
            ->through(fn ($post) => [
                'id' => $post->id,
                'image_url' => $post->image_url,
                'title' => $post->title,
                'status' => $post->status,
            ]);

        return inertia('BlogPost/PostIndex', [
            'posts' => $posts,
        ]);
    }

    public function create(CategoryService $categoryService, AuthorService $authorService): Response
    {
        return inertia('BlogPost/PostForm', [
            'categories' => $categoryService->get(),
            'authors' => $authorService->get(),
        ]);
    }

    public function store(PostValidate $request): RedirectResponse
    {
        $postData = $request->validated();

        if ($request->hasFile('image')) {
            $postData = array_merge($postData, $this->uploadFile('image', 'blog', 'originalUUID', 'public'));
        }

        Post::create($postData);

        return redirect()->route('blogPost.index')
            ->with('success', 'Post created.');
    }

    public function edit(CategoryService $categoryService, AuthorService $authorService, int $id): Response
    {
        return inertia('BlogPost/PostForm', [
            'post' => Post::find($id),
            'categories' => $categoryService->get(),
            'authors' => $authorService->get(),
        ]);
    }

    public function update(PostValidate $request, int $id): RedirectResponse
    {

        $post = Post::findOrFail($id);

        $postData = $request->validated();

        if ($request->hasFile('image')) {
            $postData = array_merge($postData, $this->uploadFile('image', 'blog', 'originalUUID', 'public'));
        } elseif ($request->input('remove_previous_image')) {
            $postData['image'] = null;
        } else {
            unset($postData['image']);
        }

        $post->update($postData);

        return redirect()->route('blogPost.index')
            ->with('success', 'Post updated.');
    }

    public function destroy(int $id): RedirectResponse
    {
        Post::findOrFail($id)->delete();

        return redirect()->route('blogPost.index')
            ->with('success', 'Post deleted.');
    }
}

<?php

namespace Modules\Blog\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Inertia\Response;
use Modules\Blog\Http\Requests\PostValidate;
use Modules\Blog\Models\Post;
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

    public function create(): Response
    {
        return inertia('BlogPost/PostForm');
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

    public function edit(int $id): Response
    {
        $post = Post::find($id);

        return inertia('BlogPost/PostForm', [
            'post' => $post,
        ]);
    }

    public function update(PostValidate $request, int $id): RedirectResponse
    {
        $post = Post::findOrFail($id);

        $postData = $request->validated();

        if ($request->input('remove_previous_image')) {
            $postData = array_merge($postData, ['image' => null]);
        }

        if ($request->hasFile('image')) {
            $postData = array_merge($postData, $this->uploadFile('image', 'blog', 'originalUUID', 'public'));
        }

        $post->update($postData);

        return redirect()->route('blogPost.index')
            ->with('success', 'Post updated.');
    }

    public function destroy(int $id)
    {
        Post::findOrFail($id)->delete();

        return redirect()->route('blogPost.index')
            ->with('success', 'Post deleted.');
    }
}

<?php

use Illuminate\Support\Facades\Route;

// Posts
Route::post('blog-post/upload-editor-image', [
    'uses' => 'PostController@uploadEditorImage',
])
    ->name('blogPost.uploadEditorImage')
    ->can('Blog: Post - Create')
    ->can('Blog: Post - Edit');

Route::get('blog-post', [
    'uses' => 'PostController@index',
])
    ->name('blogPost.index')
    ->can('Blog: Post - List');

Route::get('blog-post/create', [
    'uses' => 'PostController@create',
])
    ->name('blogPost.create')
    ->can('Blog: Post - Create');

Route::post('blog-post', [
    'uses' => 'PostController@store',
])
    ->name('blogPost.store')
    ->can('Blog: Post - Create');

Route::get('blog-post/{id}/edit', [
    'uses' => 'PostController@edit',
])
    ->name('blogPost.edit')
    ->can('Blog: Post - Edit');

Route::put('blog-post/{id}', [
    'uses' => 'PostController@update',
])
    ->name('blogPost.update')
    ->can('Blog: Post - Edit');

Route::delete('blog-post/{id}', [
    'uses' => 'PostController@destroy',
])
    ->name('blogPost.destroy')
    ->can('Blog: Post - Delete');

// Categories
Route::post('blog-category/upload-editor-image', [
    'uses' => 'CategoryController@uploadEditorImage',
])
    ->name('blogCategory.uploadEditorImage')
    ->can('Blog: Category - Create')
    ->can('Blog: Category - Edit');

Route::get('blog-category', [
    'uses' => 'CategoryController@index',
])
    ->name('blogCategory.index')
    ->can('Blog: Category - List');

Route::get('blog-category/create', [
    'uses' => 'CategoryController@create',
])
    ->name('blogCategory.create')
    ->can('Blog: Category - Create');

Route::post('blog-category', [
    'uses' => 'CategoryController@store',
])
    ->name('blogCategory.store')
    ->can('Blog: Category - Create');

Route::get('blog-category/{id}/edit', [
    'uses' => 'CategoryController@edit',
])
    ->name('blogCategory.edit')
    ->can('Blog: Category - Edit');

Route::put('blog-category/{id}', [
    'uses' => 'CategoryController@update',
])
    ->name('blogCategory.update')
    ->can('Blog: Category - Edit');

Route::delete('blog-category/{id}', [
    'uses' => 'CategoryController@destroy',
])
    ->name('blogCategory.destroy')
    ->can('Blog: Category - Delete');

// Authors
Route::get('blog-author', [
    'uses' => 'AuthorController@index',
])
    ->name('blogAuthor.index')
    ->can('Blog: Author - List');

Route::get('blog-author/create', [
    'uses' => 'AuthorController@create',
])
    ->name('blogAuthor.create')
    ->can('Blog: Author - Create');

Route::post('blog-author', [
    'uses' => 'AuthorController@store',
])
    ->name('blogAuthor.store')
    ->can('Blog: Author - Create');

Route::get('blog-author/{id}/edit', [
    'uses' => 'AuthorController@edit',
])
    ->name('blogAuthor.edit')
    ->can('Blog: Author - Edit');

Route::put('blog-author/{id}', [
    'uses' => 'AuthorController@update',
])
    ->name('blogAuthor.update')
    ->can('Blog: Author - Edit');

Route::delete('blog-author/{id}', [
    'uses' => 'AuthorController@destroy',
])
    ->name('blogAuthor.destroy')
    ->can('Blog: Author - Delete');

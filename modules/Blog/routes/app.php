<?php

use Illuminate\Support\Facades\Route;

// Posts
Route::post('blog-post/upload-editor-image', [
    'uses' => 'PostController@uploadEditorImage',
])->name('blogPost.uploadEditorImage');

Route::get('blog-post', [
    'uses' => 'PostController@index',
])->name('blogPost.index');

Route::get('blog-post/create', [
    'uses' => 'PostController@create',
])->name('blogPost.create');

Route::get('blog-post/{id}/edit', [
    'uses' => 'PostController@edit',
])->name('blogPost.edit');

Route::post('blog-post', [
    'uses' => 'PostController@store',
])->name('blogPost.store');

Route::put('blog-post/{id}', [
    'uses' => 'PostController@update',
])->name('blogPost.update');

Route::delete('blog-post/{id}', [
    'uses' => 'PostController@destroy',
])->name('blogPost.destroy');

// Categories
Route::post('blog-category/upload-editor-image', [
    'uses' => 'CategoryController@uploadEditorImage',
])->name('blogCategory.uploadEditorImage');

Route::get('blog-category', [
    'uses' => 'CategoryController@index',
])->name('blogCategory.index');

Route::get('blog-category/create', [
    'uses' => 'CategoryController@create',
])->name('blogCategory.create');

Route::get('blog-category/{id}/edit', [
    'uses' => 'CategoryController@edit',
])->name('blogCategory.edit');

Route::post('blog-category', [
    'uses' => 'CategoryController@store',
])->name('blogCategory.store');

Route::put('blog-category/{id}', [
    'uses' => 'CategoryController@update',
])->name('blogCategory.update');

Route::delete('blog-category/{id}', [
    'uses' => 'CategoryController@destroy',
])->name('blogCategory.destroy');

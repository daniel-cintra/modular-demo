<?php

use Illuminate\Support\Facades\Route;

Route::get('user', [
    'uses' => 'UserController@index',
])
    ->name('user.index')
    ->can('Acl: User - List');

Route::get('user/create', [
    'uses' => 'UserController@create',
])
    ->name('user.create')
    ->can('Acl: User - Create');

Route::get('user/{id}/edit', [
    'uses' => 'UserController@edit',
])
    ->name('user.edit')
    ->can('Acl: User - Edit');

Route::post('user', [
    'uses' => 'UserController@store',
])
    ->name('user.store')
    ->can('Acl: User - Create');

Route::put('user/{id}', [
    'uses' => 'UserController@update',
])
    ->name('user.update')
    ->can('Acl: User - Edit');

Route::delete('user/{id}', [
    'uses' => 'UserController@destroy',
])
    ->name('user.destroy')
    ->can('Acl: User - Delete');

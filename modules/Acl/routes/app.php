<?php

use Illuminate\Support\Facades\Route;

//acl
Route::get('acl/get-user-roles-and-permissions', [
    'uses' => 'UserController@getUserRolesAndPermissions',
]);

//acl - permission
Route::get('acl-permission', [
    'uses' => 'PermissionController@index',
])
    ->name('aclPermission.index')
    ->can('Acl: Permission - List');

Route::get('acl-permission/create', [
    'uses' => 'PermissionController@create',
])
    ->name('aclPermission.create')
    ->can('Acl: Permission - Create');

Route::post('acl-permission', [
    'uses' => 'PermissionController@store',
])
    ->name('aclPermission.store')
    ->can('Acl: Permission - Create');

Route::get('acl-permission/{id}/edit', [
    'uses' => 'PermissionController@edit',
])
    ->name('aclPermission.edit')
    ->can('Acl: Permission - Edit');

Route::put('acl-permission/{id}', [
    'uses' => 'PermissionController@update',
])
    ->name('aclPermission.update')
    ->can('Acl: Permission - Edit');

Route::delete('acl-permission/{id}', [
    'uses' => 'PermissionController@destroy',
])
    ->name('aclPermission.destroy')
    ->can('Acl: Permission - Delete');

//acl - role
Route::get('acl-role', [
    'uses' => 'RoleController@index',
])
    ->name('aclRole.index')
    ->can('Acl: Role - List');

Route::get('acl-role/create', [
    'uses' => 'RoleController@create',
])
    ->name('aclRole.create')
    ->can('Acl: Role - Create');

Route::post('acl-role', [
    'uses' => 'RoleController@store',
])
    ->name('aclRole.store')
    ->can('Acl: Role - Create');

Route::get('acl-role/{id}/edit', [
    'uses' => 'RoleController@edit',
])
    ->name('aclRole.edit')
    ->can('Acl: Role - Edit');

Route::put('acl-role/{id}', [
    'uses' => 'RoleController@update',
])
    ->name('aclRole.update')
    ->can('Acl: Role - Edit');

Route::delete('acl-role/{id}', [
    'uses' => 'RoleController@destroy',
])
    ->name('aclRole.destroy')
    ->can('Acl: Role - Delete');

//acl - role => permissions
Route::get('acl-role-permission/{id}/edit', [
    'uses' => 'RolePermissionController@edit',
])
    ->name('aclRolePermission.edit')
    ->can('Acl: Role - Manage Permissions');

Route::put('acl-role-permission/{id}', [
    'uses' => 'RolePermissionController@update',
])
    ->name('aclRolePermission.update')
    ->can('Acl: Role - Manage Permissions');

//acl - user role
Route::get('acl-user-role/{id}/edit', [
    'uses' => 'UserRoleController@edit',
])
    ->name('aclUserRole.edit')
    ->can('Acl: User - Manage Roles');

Route::put('acl-user-role/{id}', [
    'uses' => 'UserRoleController@update',
])
    ->name('aclUserRole.update')
    ->can('Acl: User - Manage Roles');

//acl - user => permissions
Route::get('acl-user-permission/{id}/edit', [
    'uses' => 'UserPermissionController@edit',
])
    ->name('aclUserPermission.edit')
    ->can('Acl: User - Manage Permissions');

Route::put('acl-user-permission/{id}', [
    'uses' => 'UserPermissionController@update',
])
    ->name('aclUserPermission.update')
    ->can('Acl: User - Manage Permissions');

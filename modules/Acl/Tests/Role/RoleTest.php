<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;
use Modules\User\Models\User;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->role = Role::create(['name' => 'root', 'guard_name' => 'user']);
    $this->user->assignRole('root');

    $this->loggedRequest = $this->actingAs($this->user);
});

test('role list can be rendered', function () {
    $response = $this->loggedRequest->get('/acl-role');

    $response->assertStatus(200);

    $response->assertInertia(
        fn (Assert $page) => $page
            ->component('AclRole/RoleIndex')
            ->has(
                'roles.data',
                1,
                fn (Assert $page) => $page
                    ->where('id', $this->role->id)
                    ->where('name', $this->role->name)
                    ->where('guard_name', $this->role->guard_name)
            )
    );
});

test('role can be created', function () {
    $response = $this->loggedRequest->post('/acl-role', [
        'name' => 'Role Name',
    ]);

    $roles = Role::all();

    $this->assertCount(2, $roles);
    $this->assertEquals('Role Name', $roles->last()->name);

    $response->assertRedirect('/acl-role');
});

test('role edit can be rendered', function () {
    $response = $this->loggedRequest->get('/acl-role/'.$this->role->id.'/edit');

    $response->assertStatus(200);

    $response->assertInertia(
        fn (Assert $page) => $page
            ->component('AclRole/RoleForm')
            ->has(
                'role',
                fn (Assert $page) => $page
                    ->where('id', $this->role->id)
                    ->where('name', $this->role->name)
                    ->where('guard_name', $this->role->guard_name)
                    ->etc()
            )
    );
});

test('role can be updated', function () {

    $role2 = Role::create(['name' => 'content author', 'guard_name' => 'user']);

    $response = $this->loggedRequest->put('/acl-role/'.$role2->id, [
        'name' => 'z Role Name',
    ]);

    $response->assertRedirect('/acl-role');

    $redirectResponse = $this->loggedRequest->get('/acl-role');
    $redirectResponse->assertInertia(
        fn (Assert $page) => $page
            ->component('AclRole/RoleIndex')
            ->has(
                'roles.data.1',
                fn (Assert $page) => $page
                    ->where('id', $role2->id)
                    ->where('name', 'z Role Name')
                    ->where('guard_name', $this->role->guard_name)
            )
    );
});

test('role can be deleted', function () {
    $role2 = Role::create(['name' => 'content author', 'guard_name' => 'user']);

    $response = $this->loggedRequest->delete('/acl-role/'.$role2->id);

    $response->assertRedirect('/acl-role');

    $this->assertCount(1, Role::all());
});

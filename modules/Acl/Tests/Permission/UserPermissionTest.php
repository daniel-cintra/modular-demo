<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;
use Modules\Acl\Services\GetUserPermissions;
use Modules\User\Models\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

beforeEach(function () {
    $this->user = User::factory()->create();
    Role::create(['name' => 'root']);
    $this->user->assignRole('root');

    $this->loggedRequest = $this->actingAs($this->user);

    $this->permission = Permission::create(['name' => 'first', 'guard_name' => 'user']);
    $this->permission2 = Permission::create(['name' => 'second', 'guard_name' => 'user']);

    $this->user->syncPermissions([$this->permission->id]);
});

test('user permissions can be rendered', function () {
    $response = $this->loggedRequest->get('/acl-user-permission/'.$this->user->id.'/edit');

    $response->assertStatus(200);

    $response->assertInertia(
        fn (Assert $page) => $page
            ->component('AclUserPermission/UserPermissionForm')
            ->has(
                'user',
                fn (Assert $page) => $page
                    ->where('id', $this->user->id)
                    ->etc()
            )
            ->has(
                'userPermissions',
                1,
                fn (Assert $page) => $page
                    ->where('id', $this->permission->id)
                    ->where('name', $this->permission->name)
            )
            ->has(
                'permissions',
                2
            )
    );
});

test('user permissions can be updated', function () {
    $response = $this->loggedRequest->put('/acl-user-permission/'.$this->user->id, [
        'userPermissions' => [$this->permission2->id],
    ]);

    $response->assertRedirect('/user');

    $userPermissions = (new GetUserPermissions)->run($this->user->id);

    $this->assertCount(1, $userPermissions);
    $this->assertEquals($this->permission2->id, $userPermissions[0]['id']);
});

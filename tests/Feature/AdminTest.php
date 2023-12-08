<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Role;
use App\Models\User;
use App\Models\Module;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminTest extends TestCase
{
    use RefreshDatabase,WithFaker;

    /**
     * @test
     * */
    public function can_create_roles()
    {
        $this->adminSignIn();

        $this->get('/admin/roles')->assertOk();

        $attributes = Role::factory()->raw(['name' => 'Testing']);

        $attributes['modules'] = Module::factory(5)->create()->pluck('id')->toArray();

        $response = $this->post('/admin/roles', $attributes);

        $this->assertDatabaseHas('modules_access', ['module_id' => 5, 'role_id' => 2]);

        $response->assertRedirect('/admin/roles');
    }

    /**
     * @test
     * */
    public function created_role_name_must_be_unique()
    {
        $this->adminSignIn();

        $attributes = [
            'name' => 'Accountant',
            'is_admin' => false
        ];

        $accountant = Role::factory()->raw($attributes);
        $sales = Role::factory()->raw($attributes);

        $this->post('/admin/roles', $sales);

        $this->post('/admin/roles', $accountant)
            ->assertSessionHasErrors('name');
    }

    /**
     * @test
     * */
    public function can_view_registration_page()
    {
        $admin = $this->adminSignIn();

        $this->get('/admin/users')
            ->assertOk();
    }

    /**
     * @test
     * */
    public function can_view_all_users()
    {
        $this->adminSignIn();

        $this->get('/admin/users')
            ->assertOk()
            ->assertSee('Admin');
    }

    /**
     * @test
     * */
    public function can_create_users()
    {
        $this->adminSignIn();

        $attributes = [
            'name' => 'Test',
            'email' => 'test@example.com',
            'password' => 'password',
            'role_id' => Role::factory()->create(['name' => 'Accounts','is_admin' => false])->id
        ];
        $this->post('/admin/users', $attributes)
            ->assertRedirect('/admin/users');
    }

    /**
     * @test
     * */
    public function can_create_user_and_fields_are_required()
    {
        $this->adminSignIn();

        $this->post('/admin/users', [])
            ->assertSessionHasErrors('name')
            ->assertSessionHasErrors('email')
            ->assertSessionHasErrors('password')
            ->assertSessionHasErrors('role_id');
    }

    /**
     * @test
     * */
    public function cannot_create_user_with_duplicate_email()
    {
        $this->adminSignIn();

        $user = User::factory()->create([
            'email' => 'pavneet@gmail.com'
        ]);

        $this->post('/admin/users', [
            'role_id' => Role::factory()->create()->id,
            'name' =>'test',
            'email' => 'pavneet@gmail.com',
            'password' => 'password'
        ])->assertSessionHasErrors('email');
    }

    /**
     * @test
     * */
    public function can_delete_user()
    {
        $user = User::factory()->create();
        $this->adminSignIn($user);

        $this->delete('/admin/users/'.$user->id)
            ->assertRedirect('/admin/users');

        $this->assertDatabaseMissing('users', [
            'name' => $user->name
        ]);
    }

    /**
     * @test
     * */
    public function can_view_modules_list_and_create_pages()
    {
        $this->adminSignIn();

        $this->get('/admin/modules')->assertOk();

        $this->get('/admin/modules/create')->assertOk();
    }

    /**
     * @test
     * */
    public function can_create_module()
    {
        $this->adminSignIn();

        $attributes = Module::factory()->raw();
        $resource = $this->post('/admin/modules', $attributes);

        $this->assertDatabaseHas('modules', $attributes);

        $resource->assertRedirect('/admin/modules');
    }

    /**
     * @test
     * */
    public function can_update_module()
    {
        $this->adminSignIn();

        $module = Module::factory()->create();

        $this->patch('/admin/modules/'.$module->id, [
            'name' => 'Updated'
        ]);

        $module->refresh();

        $this->assertDatabaseHas('modules', ['name' => 'Updated']);

        $this->get("/admin/modules/{$module->id}")
            ->assertSee($module->name);
    }

    /**
     * @test
     * */
    public function can_delete_module()
    {
        $this->adminSignIn();

        $module = Module::factory()->create();

        $this->delete("/admin/modules/{$module->id}")
            ->assertRedirect('/admin/modules');

        $this->assertDatabaseMissing('modules', $module->only('id'));
    }

    /**
     * @test
     * */
    public function non_admin_cannot_view_admin_authorized_pages()
    {
        $user = User::factory()->create([
            'role_id' => Role::factory()->create(['name' => 'Accountant', 'is_admin' => false])
        ]);

        $this->actingAs($user)->get('/admin/users')
            ->assertStatus(403);

        $this->actingAs($user)->get('/admin/roles')
            ->assertStatus(403);

        $this->actingAs($user)->get('/admin/modules')
            ->assertStatus(403);

        $module = Module::factory()->create();
        $this->actingAs($user)->get('/admin/modules/'.$module->id)
            ->assertStatus(403);
    }

    /**
     * @test
     * */
    public function non_admin_cannot_create_roles()
    {
        $user = User::factory()->create([
            'role_id' => Role::factory()->create(['name' => 'Accountant', 'is_admin' => false])
        ]);

        $this->actingAs($user)
            ->post('/admin/roles')
            ->assertStatus(403);
    }

    /**
     * @test
     * */
    public function non_admin_cannot_create_users()
    {
        $user = User::factory()->create([
            'role_id' => Role::factory()->create(['name' => 'Accountant', 'is_admin' => false])
        ]);

        $attributes = [
            'name' => 'Test',
            'email' => 'test@example.com',
            'password' => 'password',
            'role_id' => Role::factory()->create(['name' => 'Accounts'])->id
        ];

        $this->actingAs($user)->post('/admin/users', $attributes)
        ->assertStatus(403);
    }

    /**
     * @test
     * */
    public function non_admin_cannot_delete_user()
    {
        // $this->withoutExceptionHandling();
        $user = User::factory()->create([
            'role_id' => Role::factory()->create(['is_admin' => false, 'name'=>'Sales'])
        ]);

        $this->actingAs($user)
            ->delete('/admin/users/'.$user->id)
            ->assertStatus(403);
    }

    /**
     * @test
     * */
    public function non_admin_cannot_create_modules()
    {
        $user = User::factory()->create([
            'role_id' => Role::factory()->create(['name' => 'Accountant', 'is_admin' => false])
        ]);

        $attributes = [
            'name' => 'Test',
            'slug' => 'slug'
        ];

        $this->actingAs($user)->post('/admin/modules', $attributes)
        ->assertStatus(403);
    }
}

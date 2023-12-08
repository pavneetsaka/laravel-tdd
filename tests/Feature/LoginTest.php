<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     * */
    public function user_can_authenticate()
    {
        $this->withoutExceptionHandling();
        $password = "password";

        $user = User::factory()->create([
            'email' => 'pavneet@v2solutions.com',
            'password' => $password
        ]);

        $response = $this->post('/admin/login', [
                'email' => $user->email,
                'password' => $password
            ]);

        $this->assertAuthenticated();

        $response->assertRedirect('/admin/dashboard');

        $this->get('/admin/dashboard')->assertOk();
    }

    /**
     * @test
     * */
    public function user_cannot_authenticate_with_unregistered_email()
    {
        $user = User::factory()->create([
            'email' => 'pavneet@gmail.com',
            'password' => 'password'
        ]);

        $this->post('/admin/login', [
            'email' => 'pavneet@v2solutions.com',
            'password' => 'password'
        ])->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    /**
     * @test
     * */
    public function user_cannot_authenticate_with_wrong_password()
    {
        $user = User::factory()->create();

        $response = $this->post('/admin/login', [
            'email' => $user->email,
            'password' => 'wrong-password'
        ])->assertSessionHasErrors('password');

        $this->assertGuest();
    }

    /**
     * @test
     * */
    public function autheticated_user_can_logout()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/admin/logout');

        $this->assertGuest();
        $response->assertRedirect('/');
    }
}

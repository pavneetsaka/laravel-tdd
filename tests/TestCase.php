<?php

namespace Tests;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function adminSignIn($admin = null)
    {
        $admin = $admin ?: User::factory()->create();

        return $this->actingAs($admin);
    }
}

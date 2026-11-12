<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class DatabaseSeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_seeds_demo_user_and_admin_accounts(): void
    {
        $this->seed();
        $this->seed();

        $user = User::where('email', 'user@example.com')->firstOrFail();
        $admin = User::where('email', 'admin@example.com')->firstOrFail();

        $this->assertDatabaseCount('users', 2);
        $this->assertSame('user', $user->role);
        $this->assertSame('admin', $admin->role);
        $this->assertTrue(Hash::check('DemoPass123!', $user->password));
        $this->assertTrue(Hash::check('DemoPass123!', $admin->password));

        $this->post(route('login.process'), [
            'email' => 'user@example.com',
            'password' => 'DemoPass123!',
        ])->assertRedirect(route('home'));
        $this->assertAuthenticatedAs($user);

        $this->post(route('logout'))->assertRedirect(route('home'));

        $this->post(route('login.process'), [
            'email' => 'admin@example.com',
            'password' => 'DemoPass123!',
        ])->assertRedirect(route('home'));
        $this->assertAuthenticatedAs($admin);
    }
}

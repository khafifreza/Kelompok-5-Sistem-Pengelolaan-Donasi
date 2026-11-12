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
        $this->assertSame(User::ROLE_DONOR, $user->role);
        $this->assertSame(User::ROLE_ADMIN, $admin->role);
        $this->assertTrue(Hash::check('DemoPass123!', $user->password));
        $this->assertTrue(Hash::check('DemoPass123!', $admin->password));

        $this->post(route('login.process'), [
            'email' => 'user@example.com',
            'password' => 'DemoPass123!',
            'role' => User::ROLE_DONOR,
        ])->assertRedirect(route('dashboard'));
        $this->assertAuthenticatedAs($user);

        $this->post(route('logout'))->assertRedirect(route('home'));

        $this->post(route('login.process'), [
            'email' => 'admin@example.com',
            'password' => 'DemoPass123!',
            'role' => User::ROLE_ADMIN,
        ])->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticatedAs($admin);
    }
}

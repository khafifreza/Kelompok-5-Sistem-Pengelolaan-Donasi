<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_register_login_view_dashboard_and_logout(): void
    {
        $credentials = [
            'email' => 'donatur@example.com',
            'password' => 'Password123!',
        ];

        $this->post(route('register.process'), [
            'name' => 'Donatur Demo',
            ...$credentials,
            'phone' => '081234567890',
        ])->assertRedirect(route('home'))
            ->assertSessionHas('open_modal', 'loginRoleModal')
            ->assertSessionHas('success', 'Pendaftaran berhasil. Silakan masuk dengan akun Anda.');

        $this->assertGuest();
        $this->get(route('home'))
            ->assertOk()
            ->assertSee('Pendaftaran berhasil. Silakan masuk dengan akun Anda.');

        $this->post(route('login.process'), [...$credentials, 'role' => User::ROLE_DONOR])
            ->assertRedirect(route('dashboard'));

        $this->assertAuthenticated();
        $this->get(route('dashboard'))
            ->assertOk()
            ->assertSee('Halo, Donatur Demo')
            ->assertSee(route('logout'), false);
        $this->get(route('home'))
            ->assertOk()
            ->assertSee('Dashboard')
            ->assertSee('Donatur Demo')
            ->assertSee(route('logout'), false);

        $this->post(route('logout'))->assertRedirect(route('home'));
        $this->assertGuest();
    }

    public function test_admin_login_redirects_to_the_admin_dashboard(): void
    {
        $user = User::factory()->create([
            'name' => 'Admin Demo',
            'email' => 'admin@example.com',
            'role' => User::ROLE_ADMIN,
            'password' => 'Password123!',
        ]);

        $this->get(route('login'))
            ->assertRedirect(route('home'))
            ->assertSessionHas('open_modal', 'loginRoleModal');

        $this->get(route('home'))
            ->assertOk()
            ->assertSee('Masuk sebagai siapa?')
            ->assertSee('Kelola program dan pantau donasi')
            ->assertSee('Berbagi kebaikan dan lihat riwayat donasi');

        $this->post(route('login.process'), [
            'email' => $user->email,
            'password' => 'Password123!',
            'role' => User::ROLE_ADMIN,
        ])->assertRedirect(route('admin.dashboard'));

        $this->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('Selamat datang, Admin Demo')
            ->assertSee(route('logout'), false);
    }

    public function test_login_rejects_an_account_that_does_not_match_the_selected_role(): void
    {
        $user = User::factory()->create([
            'role' => User::ROLE_DONOR,
            'password' => 'Password123!',
        ]);

        $this->from(route('home'))
            ->post(route('login.process'), [
                'email' => $user->email,
                'password' => 'Password123!',
                'role' => User::ROLE_ADMIN,
            ])
            ->assertRedirect(route('home'))
            ->assertSessionHasErrors('email')
            ->assertSessionHas('open_modal', 'loginModal')
            ->assertSessionHas('_old_input.role', User::ROLE_ADMIN);

        $this->assertGuest();
    }
}

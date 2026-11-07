<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginRateLimitTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_is_limited_after_five_failed_attempts_from_the_same_client(): void
    {
        config(['app.debug' => false]);

        for ($attempt = 0; $attempt < 5; $attempt++) {
            $this->from(route('home'))
                ->post(route('login.process'), [
                    '_form' => 'login',
                    'email' => 'limited@example.com',
                    'password' => 'wrong-password',
                    'role' => 'donor',
                ])
                ->assertRedirect(route('home'));
        }

        $this->from(route('home'))
            ->post(route('login.process'), [
                '_form' => 'login',
                'email' => 'limited@example.com',
                'password' => 'wrong-password',
                'role' => 'donor',
            ])
            ->assertTooManyRequests()
            ->assertSee('Terlalu banyak percobaan');
    }
}

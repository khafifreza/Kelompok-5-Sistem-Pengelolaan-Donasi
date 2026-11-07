<?php

namespace Tests\Feature;

use App\Models\Program;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class ValidationErrorHandlingTest extends TestCase
{
    use RefreshDatabase;

    public function test_invalid_donation_keeps_form_data_and_shows_indonesian_errors(): void
    {
        $program = Program::create($this->programData());

        $this->from(route('program.show', $program))
            ->followingRedirects()
            ->post(route('donasi.store', $program), [
                '_form' => 'donation',
                'amount' => '9.000',
                'donor_name' => 'Nama Donatur',
                'donor_email' => 'donatur@example.com',
            ])
            ->assertOk()
            ->assertSee('Minimal donasi Rp 10.000.')
            ->assertSee('value="9.000"', false)
            ->assertSee('value="Nama Donatur"', false)
            ->assertSee('Periksa kembali data donasi Anda:');

        $this->assertDatabaseCount('donations', 0);
    }

    public function test_missing_guest_donation_details_are_rejected_with_field_errors(): void
    {
        $program = Program::create($this->programData());

        $this->from(route('program.show', $program))
            ->post(route('donasi.store', $program), ['_form' => 'donation'])
            ->assertRedirect()
            ->assertSessionHasErrors(['amount', 'donor_name', 'donor_email'])
            ->assertSessionHasErrors([
                'donor_name' => 'Nama donatur wajib diisi.',
                'donor_email' => 'Email donatur wajib diisi.',
            ]);

        $this->assertDatabaseCount('donations', 0);
    }

    public function test_not_found_page_shows_a_friendly_message(): void
    {
        config(['app.debug' => false]);

        $this->get('/halaman-yang-tidak-ada')
            ->assertNotFound()
            ->assertSee('Halaman tidak ditemukan')
            ->assertSee('Kembali ke beranda');
    }

    public function test_server_error_page_does_not_expose_exception_details(): void
    {
        config(['app.debug' => false]);
        Route::get('/test-server-error', fn () => abort(500));

        $this->get('/test-server-error')
            ->assertServerError()
            ->assertSee('Terjadi kesalahan')
            ->assertDontSee('Stack trace');
    }

    public function test_registration_validation_uses_indonesian_messages(): void
    {
        $this->from(route('home'))
            ->post(route('register.process'), [
                '_form' => 'register',
                'name' => '',
                'email' => 'not-an-email',
                'phone' => 'invalid',
                'password' => 'short',
            ])
            ->assertRedirect(route('home'))
            ->assertSessionHasErrors(['name', 'email', 'phone', 'password'])
            ->assertSessionHasErrors([
                'name' => 'nama wajib diisi.',
                'email' => 'Format email tidak valid.',
            ]);
    }

    /**
     * @return array<string, string|int>
     */
    private function programData(): array
    {
        return [
            'title' => 'Program Pendidikan',
            'category' => 'Pendidikan',
            'description' => 'Bantuan pendidikan.',
            'target_amount' => 1000000,
            'status' => Program::STATUS_ACTIVE,
        ];
    }
}

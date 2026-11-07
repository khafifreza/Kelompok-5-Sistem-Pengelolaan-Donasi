<?php

namespace Tests\Feature;

use App\Models\Donation;
use App\Models\Program;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminDataTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_pages_show_database_data_instead_of_mock_records(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);
        $donor = User::factory()->create();
        $program = Program::create($this->programData());
        $donation = Donation::create($this->donationData($program, $donor, 'INV-LIVE'));

        $this->actingAs($admin)
            ->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee($program->title)
            ->assertSee('Donasi Berhasil');

        $this->get(route('admin.program'))
            ->assertOk()
            ->assertSee($program->title)
            ->assertSee('name="title"', false);

        $this->get(route('admin.donasi', ['status' => Donation::STATUS_PENDING]))
            ->assertOk()
            ->assertSee($donation->invoice)
            ->assertSee('Konfirmasi');

        $this->get(route('admin.donatur'))
            ->assertOk()
            ->assertSee($donor->name)
            ->assertDontSee('Sarah Wijaya');
    }

    public function test_admin_can_update_and_delete_a_program_without_donations(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);
        $program = Program::create($this->programData());

        $this->actingAs($admin)
            ->put(route('admin.programs.update', $program), $this->programData([
                'title' => 'Program Diperbarui',
                'target_amount' => 150000000,
                'status' => Program::STATUS_CLOSED,
            ]))
            ->assertRedirect();

        $this->assertDatabaseHas('programs', [
            'id' => $program->id,
            'title' => 'Program Diperbarui',
            'target_amount' => 150000000,
            'status' => Program::STATUS_CLOSED,
        ]);

        $this->delete(route('admin.programs.destroy', $program))
            ->assertRedirect();

        $this->assertModelMissing($program);
    }

    public function test_admin_cannot_delete_a_program_with_donation_history(): void
    {
        config(['app.debug' => false]);
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);
        $donor = User::factory()->create();
        $program = Program::create($this->programData());
        Donation::create($this->donationData($program, $donor, 'INV-PROTECTED'));

        $this->actingAs($admin)
            ->delete(route('admin.programs.destroy', $program))
            ->assertConflict()
            ->assertSee('Aksi tidak dapat diproses');

        $this->assertModelExists($program);
    }

    public function test_admin_program_validation_returns_indonesian_errors_without_creating_data(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);

        $this->actingAs($admin)
            ->post(route('admin.programs.store'), [
                '_form' => 'program-create',
                'title' => '',
                'category' => '',
                'description' => '',
                'target_amount' => 1000,
            ])
            ->assertRedirect()
            ->assertSessionHasErrors(['title', 'category', 'description', 'target_amount'])
            ->assertSessionHasErrors(['title' => 'Nama program wajib diisi.']);

        $this->assertDatabaseCount('programs', 0);
    }

    public function test_admin_program_list_filters_by_title_category_and_status(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);
        Program::create($this->programData());
        Program::create($this->programData([
            'title' => 'Program Kesehatan',
            'category' => 'Kesehatan',
            'status' => Program::STATUS_CLOSED,
        ]));

        $this->actingAs($admin)
            ->get(route('admin.program', [
                'q' => 'Pendidikan',
                'category' => 'Pendidikan',
                'status' => Program::STATUS_ACTIVE,
            ]))
            ->assertOk()
            ->assertSee('Program Pendidikan')
            ->assertDontSee('Program Kesehatan');
    }

    public function test_donor_is_forbidden_from_admin_pages_with_a_friendly_403_page(): void
    {
        config(['app.debug' => false]);

        $this->actingAs(User::factory()->create())
            ->get(route('admin.dashboard'))
            ->assertForbidden()
            ->assertSee('Akses ditolak');
    }

    /**
     * @return array<string, mixed>
     */
    private function programData(array $overrides = []): array
    {
        return array_merge([
            'title' => 'Program Pendidikan',
            'category' => 'Pendidikan',
            'description' => 'Bantuan pendidikan untuk anak.',
            'image' => 'https://example.com/program.jpg',
            'target_amount' => 120000000,
            'status' => Program::STATUS_ACTIVE,
        ], $overrides);
    }

    /**
     * @return array<string, mixed>
     */
    private function donationData(Program $program, User $donor, string $invoice): array
    {
        return [
            'program_id' => $program->id,
            'user_id' => $donor->id,
            'invoice' => $invoice,
            'donor_name' => $donor->name,
            'donor_email' => $donor->email,
            'amount' => 50000,
            'status' => Donation::STATUS_PENDING,
        ];
    }
}

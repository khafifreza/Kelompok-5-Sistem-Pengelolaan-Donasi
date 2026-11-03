<?php

namespace Tests\Feature;

use App\Models\Donation;
use App\Models\Program;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DonationBackendTest extends TestCase
{
    use RefreshDatabase;

    public function test_program_pages_use_active_database_programs(): void
    {
        $activeProgram = Program::create($this->programData());
        Program::create($this->programData([
            'title' => 'Program Ditutup',
            'status' => Program::STATUS_CLOSED,
        ]));

        $this->get(route('program.index'))
            ->assertOk()
            ->assertSee($activeProgram->title)
            ->assertDontSee('Program Ditutup');

        $this->get(route('program.show', $activeProgram->id))
            ->assertOk()
            ->assertSee($activeProgram->description);
    }

    public function test_guest_can_create_a_pending_donation(): void
    {
        $program = Program::create($this->programData());

        $this->post(route('donasi.store', $program->id), [
            'amount' => '100.000',
            'donor_name' => 'Donatur Tamu',
            'donor_email' => 'tamu@example.com',
            'is_anonymous' => '1',
        ])->assertRedirect(route('program.show', $program->id));

        $this->assertDatabaseHas('donations', [
            'program_id' => $program->id,
            'user_id' => null,
            'donor_name' => 'Donatur Tamu',
            'amount' => 100000,
            'is_anonymous' => true,
            'status' => Donation::STATUS_PENDING,
        ]);
    }

    public function test_registration_persists_a_donor_account_with_a_hashed_password(): void
    {
        $this->post(route('register.process'), [
            'name' => 'Donatur Baru',
            'email' => 'baru@example.com',
            'phone' => '081234567890',
            'password' => 'rahasia123',
        ])->assertRedirect(route('home'));

        $user = User::where('email', 'baru@example.com')->firstOrFail();

        $this->assertSame(User::ROLE_DONOR, $user->role);
        $this->assertSame('081234567890', $user->phone);
        $this->assertNotSame('rahasia123', $user->password);
    }

    public function test_donor_dashboard_requires_authentication_and_only_lists_the_current_users_donations(): void
    {
        $program = Program::create($this->programData());
        $otherProgram = Program::create($this->programData(['title' => 'Donasi Milik Orang Lain']));
        $user = User::factory()->create();

        Donation::create($this->donationData($program, $user, 'INV-OWNED'));
        Donation::create($this->donationData($otherProgram, User::factory()->create(), 'INV-OTHER'));

        $this->get(route('dashboard'))->assertRedirect(route('login'));

        $this->actingAs($user)
            ->get(route('dashboard'))
            ->assertOk()
            ->assertSee($program->title)
            ->assertDontSee($otherProgram->title);
    }

    public function test_only_admins_can_access_admin_routes_and_confirm_pending_donations(): void
    {
        $program = Program::create($this->programData());
        $donation = Donation::create($this->donationData($program, null, 'INV-PENDING'));

        $this->get(route('admin.dashboard'))->assertRedirect(route('login'));

        $this->actingAs(User::factory()->create())
            ->get(route('admin.dashboard'))
            ->assertForbidden();

        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);

        $this->actingAs($admin)
            ->patch(route('admin.donations.update', $donation), ['status' => Donation::STATUS_SUCCESS])
            ->assertRedirect();

        $this->assertDatabaseHas('donations', [
            'id' => $donation->id,
            'status' => Donation::STATUS_SUCCESS,
        ]);
        $this->assertNotNull($donation->fresh()->paid_at);
    }

    public function test_admin_can_create_a_program(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);
        $programData = $this->programData();
        unset($programData['status']);

        $this->actingAs($admin)
            ->post(route('admin.programs.store'), $programData)
            ->assertRedirect();

        $this->assertDatabaseHas('programs', [
            'title' => 'Program Pendidikan',
            'target_amount' => 120000000,
            'status' => Program::STATUS_ACTIVE,
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    private function programData(array $overrides = []): array
    {
        return array_merge([
            'title' => 'Program Pendidikan',
            'category' => 'Pendidikan',
            'description' => 'Dukungan pendidikan untuk anak-anak.',
            'image' => 'https://example.com/program.jpg',
            'target_amount' => 120000000,
            'status' => Program::STATUS_ACTIVE,
        ], $overrides);
    }

    /**
     * @return array<string, mixed>
     */
    private function donationData(Program $program, ?User $user, string $invoice): array
    {
        return [
            'program_id' => $program->id,
            'user_id' => $user?->id,
            'invoice' => $invoice,
            'donor_name' => $user?->name ?? 'Donatur Anonim',
            'donor_email' => $user?->email,
            'amount' => 100000,
            'is_anonymous' => false,
            'status' => Donation::STATUS_PENDING,
        ];
    }
}

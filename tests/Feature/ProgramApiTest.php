<?php

namespace Tests\Feature;

use App\Models\Donation;
use App\Models\Program;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProgramApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_program_list_returns_active_programs_as_json_with_raised_amount(): void
    {
        $program = Program::create($this->programData());
        Program::create($this->programData([
            'title' => 'Program Ditutup',
            'status' => Program::STATUS_CLOSED,
        ]));
        Donation::create([
            'program_id' => $program->id,
            'invoice' => 'INV-API-001',
            'donor_name' => 'Donatur',
            'amount' => 50000,
            'status' => Donation::STATUS_SUCCESS,
        ]);
        Donation::create([
            'program_id' => $program->id,
            'invoice' => 'INV-API-002',
            'donor_name' => 'Donatur',
            'amount' => 25000,
            'status' => Donation::STATUS_PENDING,
        ]);

        $this->getJson('/api/programs')
            ->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.id', $program->id)
            ->assertJsonPath('data.0.title', $program->title)
            ->assertJsonPath('data.0.target_amount', 120000000)
            ->assertJsonPath('data.0.raised_amount', 50000);
    }

    public function test_program_detail_returns_json_and_closed_programs_are_not_found(): void
    {
        $program = Program::create($this->programData());
        $closedProgram = Program::create($this->programData([
            'title' => 'Program Ditutup',
            'status' => Program::STATUS_CLOSED,
        ]));

        $this->getJson("/api/programs/{$program->id}")
            ->assertOk()
            ->assertJsonPath('data.id', $program->id)
            ->assertJsonPath('data.description', $program->description);

        $this->getJson("/api/programs/{$closedProgram->id}")
            ->assertNotFound()
            ->assertJsonPath('message', 'Data atau endpoint tidak ditemukan.');
    }

    public function test_not_found_api_response_is_json_without_an_accept_header(): void
    {
        $this->get('/api/programs/9999')
            ->assertNotFound()
            ->assertJsonPath('message', 'Data atau endpoint tidak ditemukan.');
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
}

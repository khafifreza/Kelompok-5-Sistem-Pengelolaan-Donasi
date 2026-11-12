<?php

namespace Tests\Feature;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class DatabaseMigrationCompatibilityTest extends TestCase
{
    use RefreshDatabase;

    public function test_legacy_roles_are_upgraded_without_duplicate_columns(): void
    {
        Schema::table('users', function (Blueprint $table): void {
            $table->dropColumn(['phone', 'role']);
        });

        Schema::table('users', function (Blueprint $table): void {
            $table->string('phone')->nullable();
            $table->enum('role', ['user', 'admin'])->default('user');
        });

        DB::table('users')->insert([
            [
                'name' => 'Legacy Donor',
                'email' => 'legacy-donor@example.test',
                'password' => 'password-hash',
                'phone' => '081234567890',
                'role' => 'user',
            ],
            [
                'name' => 'Legacy Admin',
                'email' => 'legacy-admin@example.test',
                'password' => 'password-hash',
                'phone' => '081234567891',
                'role' => 'admin',
            ],
        ]);

        $migration = require database_path('migrations/2026_11_03_000001_add_phone_and_role_to_users_table.php');
        $migration->up();

        $this->assertDatabaseHas('users', [
            'email' => 'legacy-donor@example.test',
            'role' => 'donor',
        ]);
        $this->assertDatabaseHas('users', [
            'email' => 'legacy-admin@example.test',
            'role' => 'admin',
        ]);

        DB::table('users')->insert([
            'name' => 'New Donor',
            'email' => 'new-donor@example.test',
            'password' => 'password-hash',
            'phone' => null,
        ]);

        $this->assertDatabaseHas('users', [
            'email' => 'new-donor@example.test',
            'role' => 'donor',
        ]);
    }
}

<?php

namespace Database\Seeders;

use App\Models\Program;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'user@example.com'],
            [
                'name' => 'Demo User',
                'phone' => '081234567890',
                'role' => 'user',
                'password' => 'DemoPass123!',
            ],
        );

<<<<<<< HEAD
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        foreach ([
            [
                'title' => 'Pendidikan untuk Anak Pelosok',
                'category' => 'Pendidikan',
                'image' => 'https://images.unsplash.com/photo-1497633762265-9d179a990aa6?auto=format&fit=crop&w=800&q=80',
                'target_amount' => 120000000,
                'description' => 'Membantu anak-anak di daerah pelosok mendapatkan akses pendidikan yang layak.',
            ],
            [
                'title' => 'Paket Pangan Keluarga Prasejahtera',
                'category' => 'Kemanusiaan',
                'image' => 'https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?auto=format&fit=crop&w=800&q=80',
                'target_amount' => 80000000,
                'description' => 'Menyediakan paket pangan untuk keluarga prasejahtera.',
            ],
            [
                'title' => 'Layanan Kesehatan Desa',
                'category' => 'Kesehatan',
                'image' => 'https://images.unsplash.com/photo-1532629345422-7515f3d16bb6?auto=format&fit=crop&w=800&q=80',
                'target_amount' => 75000000,
                'description' => 'Menyediakan layanan kesehatan gratis untuk warga desa.',
            ],
        ] as $program) {
            Program::firstOrCreate(
                ['title' => $program['title']],
                $program + ['status' => Program::STATUS_ACTIVE],
            );
        }
=======
        User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Demo Admin',
                'phone' => '081234567891',
                'role' => 'admin',
                'password' => 'DemoPass123!',
            ],
        );
>>>>>>> 6d5f733fc120634abe6fc415774effda697c01a7
    }
}

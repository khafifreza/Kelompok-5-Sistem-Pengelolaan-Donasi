<?php

namespace App\Http\Controllers;

class ProgramController extends Controller
{
    private $programs = [
        1 => [
            'id' => 1,
            'title' => 'Pendidikan untuk Anak Pelosok',
            'category' => 'Pendidikan',
            'progress' => 71,
            'raised' => 'Rp 84.750.000',
            'target' => 'Rp 120.000.000',
            'description' => 'Program ini bertujuan untuk menyediakan akses pendidikan berkualitas bagi anak-anak di daerah pelosok Indonesia.',
            'image' => 'https://images.unsplash.com/photo-1497633762265-9d179a990aa6?w=600&q=80',
            'donors' => [
                ['name' => 'Andi Pratama', 'amount' => 'Rp 1.500.000'],
                ['name' => 'Sarah Wijaya', 'amount' => 'Rp 2.000.000'],
            ],
        ],
        2 => [
            'id' => 2,
            'title' => 'Paket Pangan Keluarga Prasejahtera',
            'category' => 'Kemanusiaan',
            'progress' => 78,
            'raised' => 'Rp 62.400.000',
            'target' => 'Rp 80.000.000',
            'description' => 'Menyediakan paket sembako bulanan untuk keluarga prasejahtera.',
            'image' => 'https://images.unsplash.com/photo-1593113598332-cd288d649433?w=600&q=80',
            'donors' => [
                ['name' => 'Budi Santoso', 'amount' => 'Rp 750.000'],
            ],
        ],
        3 => [
            'id' => 3,
            'title' => 'Layanan Kesehatan Desa',
            'category' => 'Kesehatan',
            'progress' => 50,
            'raised' => 'Rp 37.500.000',
            'target' => 'Rp 75.000.000',
            'description' => 'Menyediakan layanan kesehatan gratis untuk masyarakat desa.',
            'image' => 'https://images.unsplash.com/photo-1509099836639-18ba1795216d?w=600&q=80',
            'donors' => [
                ['name' => 'Rizky Admin', 'amount' => 'Rp 3.000.000'],
            ],
        ],
    ];

    public function index()
    {
        return view('program.index', ['programs' => $this->programs]);
    }

    public function show($id)
    {
        if (!isset($this->programs[$id])) {
            abort(404);
        }
        return view('program.show', ['program' => $this->programs[$id]]);
    }
}
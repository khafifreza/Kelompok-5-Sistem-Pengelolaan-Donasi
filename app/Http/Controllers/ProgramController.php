<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProgramController extends Controller
{
    private function getDummyPrograms()
    {
        return [
            [
                'id' => 1,
                'title' => 'Pendidikan untuk Anak Pelosok',
                'category' => 'Pendidikan',
                'image' => 'https://images.unsplash.com/photo-1497633762265-9d179a990aa6?auto=format&fit=crop&w=800&q=80',
                'progress' => 71,
                'raised' => 'Rp 84.750.000',
                'target' => 'Rp 120.000.000',
                'description' => 'Membantu anak-anak di daerah pelosok mendapatkan akses pendidikan yang layak.',
                'donors' => [['name' => 'Andi', 'amount' => 'Rp 1.000.000'], ['name' => 'Budi', 'amount' => 'Rp 500.000']]
            ],
            [
                'id' => 2,
                'title' => 'Paket Pangan Keluarga Prasejahtera',
                'category' => 'Kemanusiaan',
                'image' => 'https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?auto=format&fit=crop&w=800&q=80',
                'progress' => 78,
                'raised' => 'Rp 62.400.000',
                'target' => 'Rp 80.000.000',
                'description' => 'Menyediakan paket pangan untuk keluarga prasejahtera.',
                'donors' => [['name' => 'Citra', 'amount' => 'Rp 2.000.000']]
            ],
        ];
    }

    public function index()
    {
        $programs = $this->getDummyPrograms();
        return view('program.index', compact('programs'));
    }

    public function show($id)
    {
        $programs = $this->getDummyPrograms();
        $program = collect($programs)->firstWhere('id', $id);
        
        if (!$program) {
            abort(404);
        }

        return view('program.show', compact('program'));
    }
}
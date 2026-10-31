<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $programs = $this->getDummyPrograms();
        return view('pages.home', compact('programs'));
    }

    public function donatur()
    {
        $donations = [
            ['date' => '24 Jun 2025', 'program' => 'Pendidikan untuk Anak Pelosok', 'amount' => 'Rp 1.000.000', 'status' => 'Berhasil'],
            ['date' => '10 Jun 2025', 'program' => 'Paket Pangan Keluarga', 'amount' => 'Rp 750.000', 'status' => 'Berhasil'],
            ['date' => '28 Mei 2025', 'program' => 'Layanan Kesehatan Desa', 'amount' => 'Rp 500.000', 'status' => 'Pending'],
        ];
        return view('pages.donatur', compact('donations'));
    }

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
            [
                'id' => 3,
                'title' => 'Layanan Kesehatan Desa',
                'category' => 'Kesehatan',
                'image' => 'https://images.unsplash.com/photo-1532629345422-7515f3d16bb6?auto=format&fit=crop&w=800&q=80',
                'progress' => 50,
                'raised' => 'Rp 37.500.000',
                'target' => 'Rp 75.000.000',
                'description' => 'Menyediakan layanan kesehatan gratis untuk warga desa.',
                'donors' => [['name' => 'Dewi', 'amount' => 'Rp 3.000.000']]
            ],
        ];
    }
}
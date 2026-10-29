<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    public function index()
    {
        $programs = [
            [
                'id' => 1,
                'title' => 'Pendidikan untuk Anak Pelosok',
                'category' => 'Pendidikan',
                'progress' => 71,
                'raised' => 'Rp 84.750.000',
                'target' => 'Rp 120.000.000',
                'image' => 'https://images.unsplash.com/photo-1643214410415-de1976ad74ff?auto=format&fit=crop&w=800&q=80',
            ],
            [
                'id' => 2,
                'title' => 'Paket Pangan Keluarga Prasejahtera',
                'category' => 'Kemanusiaan',
                'progress' => 78,
                'raised' => 'Rp 62.400.000',
                'target' => 'Rp 80.000.000',
                'image' => 'https://images.unsplash.com/photo-1630568419655-6dfb1ca30cfa?auto=format&fit=crop&w=800&q=80',
            ],
            [
                'id' => 3,
                'title' => 'Layanan Kesehatan Desa',
                'category' => 'Kesehatan',
                'progress' => 50,
                'raised' => 'Rp 37.500.000',
                'target' => 'Rp 75.000.000',
                'image' => 'https://images.unsplash.com/photo-1599717460927-8101594d1418?auto=format&fit=crop&w=800&q=80',
            ],
        ];

        return view('pages.home', compact('programs'));
    }
}
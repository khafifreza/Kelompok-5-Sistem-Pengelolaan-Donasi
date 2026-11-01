<?php

namespace App\Http\Controllers;

class AdminController extends Controller
{
    public function index()
    {
        return view('pages.admin');
    }

    public function donasi()
    {
        return view('pages.admin_donasi');
    }

    public function program()
    {
        return view('pages.admin_program');
    }

    public function penyaluran()
    {
        return view('pages.admin_penyaluran');
    }

    public function donatur()
    {
        return view('pages.admin_donatur');
    }

    public function laporan()
    {
        return view('pages.admin_laporan');
    }
}
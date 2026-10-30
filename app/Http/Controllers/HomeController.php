<?php

namespace App\Http\Controllers;

use App\Models\Program;

class HomeController extends Controller
{
    public function index()
    {
        $programs = Program::active()
            ->withRaised()
            ->orderBy('id')
            ->take(3)
            ->get()
            ->map(fn (Program $program) => $program->toCard());

        return view('pages.home', compact('programs'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Program;

class ProgramController extends Controller
{
    public function index()
    {
        $programs = Program::active()
            ->withRaised()
            ->orderBy('id')
            ->get()
            ->map(fn (Program $program) => $program->toCard());

        return view('program.index', ['programs' => $programs]);
    }

    public function show($id)
    {
        $program = Program::withRaised()->findOrFail($id); // 404 otomatis bila tidak ada

        return view('program.show', ['program' => $program->toDetail()]);
    }
}

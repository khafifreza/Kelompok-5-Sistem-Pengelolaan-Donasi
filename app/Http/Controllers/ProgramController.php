<?php

namespace App\Http\Controllers;

use App\Models\Program;

class ProgramController extends Controller
{
    public function index()
    {
        $programs = Program::active()
            ->withRaised()
            ->get()
            ->map(fn (Program $program) => $program->toCard())
            ->all();

        return view('program.index', compact('programs'));
    }

    public function show($id)
    {
        $program = Program::active()
            ->withRaised()
            ->findOrFail($id)
            ->toDetail();

        return view('program.show', compact('program'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Program;
use Illuminate\Http\JsonResponse;

class ProgramApiController extends Controller
{
    public function index(): JsonResponse
    {
        $programs = Program::active()
            ->withRaised()
            ->orderBy('id')
            ->get()
            ->map(fn (Program $program): array => $this->programData($program))
            ->values();

        return response()->json(['data' => $programs]);
    }

    public function show(int $id): JsonResponse
    {
        $program = Program::active()
            ->withRaised()
            ->findOrFail($id);

        return response()->json(['data' => $this->programData($program)]);
    }

    /**
     * @return array<string, int|string|null>
     */
    private function programData(Program $program): array
    {
        return [
            'id' => $program->id,
            'title' => $program->title,
            'category' => $program->category,
            'description' => $program->description,
            'image' => $program->image,
            'target_amount' => $program->target_amount,
            'raised_amount' => $program->raisedAmount(),
            'status' => $program->status,
        ];
    }
}

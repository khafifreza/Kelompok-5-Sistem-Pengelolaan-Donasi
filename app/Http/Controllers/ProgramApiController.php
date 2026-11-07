<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProgramResource;
use App\Models\Program;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;

class ProgramApiController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $programs = Program::active()
            ->withRaised()
            ->orderBy('id')
            ->get();

        return ProgramResource::collection($programs);
    }

    public function show(int $id): JsonResource
    {
        $program = Program::active()
            ->withRaised()
            ->findOrFail($id);

        return new ProgramResource($program);
    }
}

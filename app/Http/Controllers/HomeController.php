<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\Program;

class HomeController extends Controller
{
    public function index()
    {
        $programs = Program::active()
            ->withRaised()
            ->get()
            ->map(fn (Program $program) => $program->toCard())
            ->all();

        return view('pages.home', compact('programs'));
    }

    public function donatur()
    {
        $user = request()->user();
        $userDonations = $user->donations()
            ->with('program')
            ->latest()
            ->get();

        $donations = $userDonations->map(fn (Donation $donation) => [
            'date' => $donation->created_at->locale('id')->isoFormat('D MMM YYYY'),
            'program' => $donation->program->title,
            'amount' => Program::rupiah($donation->amount),
            'status' => match ($donation->status) {
                Donation::STATUS_SUCCESS => 'Berhasil',
                Donation::STATUS_FAILED => 'Gagal',
                default => 'Pending',
            },
        ]);
        $summary = [
            'total_amount' => (int) $userDonations
                ->where('status', Donation::STATUS_SUCCESS)
                ->sum('amount'),
            'successful_count' => $userDonations
                ->where('status', Donation::STATUS_SUCCESS)
                ->count(),
            'program_count' => $userDonations
                ->where('status', Donation::STATUS_SUCCESS)
                ->pluck('program_id')
                ->unique()
                ->count(),
        ];

        return view('pages.donatur', compact('donations', 'summary'));
    }
}

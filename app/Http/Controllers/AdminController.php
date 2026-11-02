<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\Program;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index()
    {
        $stats = [
            'total_raised' => Donation::success()->sum('amount'),
            'pending_count' => Donation::where('status', Donation::STATUS_PENDING)->count(),
            'active_program_count' => Program::active()->count(),
            'donor_count' => User::whereHas('donations')->count(),
        ];
        $recentDonations = Donation::with('program')
            ->latest()
            ->limit(10)
            ->get();
        $dailyDonations = collect(range(6, 0))
            ->mapWithKeys(function (int $daysAgo): array {
                $date = now()->subDays($daysAgo)->toDateString();

                return [$date => Donation::success()->whereDate('paid_at', $date)->sum('amount')];
            });

        return view('pages.admin', compact('stats', 'recentDonations', 'dailyDonations'));
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

    public function storeProgram(Request $request)
    {
        Program::create($this->validateProgram($request));

        return back()->with('success', 'Program berhasil dibuat.');
    }

    public function updateProgram(Request $request, Program $program)
    {
        $program->update($this->validateProgram($request));

        return back()->with('success', 'Program berhasil diperbarui.');
    }

    public function updateDonation(Request $request, Donation $donation)
    {
        $validated = $request->validate([
            'status' => ['required', 'in:success,failed'],
        ]);

        DB::transaction(function () use ($donation, $validated): void {
            $lockedDonation = Donation::query()
                ->whereKey($donation->id)
                ->lockForUpdate()
                ->firstOrFail();

            abort_unless($lockedDonation->status === Donation::STATUS_PENDING, 409);

            if ($validated['status'] === Donation::STATUS_SUCCESS) {
                $lockedDonation->markAsPaid();

                return;
            }

            $lockedDonation->update([
                'status' => Donation::STATUS_FAILED,
                'paid_at' => null,
            ]);
        });

        return back()->with('success', 'Status donasi berhasil diperbarui.');
    }

    /**
     * @return array<string, mixed>
     */
    private function validateProgram(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:100'],
            'description' => ['required', 'string'],
            'image' => ['nullable', 'url', 'max:2048'],
            'target_amount' => ['required', 'integer', 'min:10000', 'max:1000000000000'],
            'status' => ['sometimes', 'required', 'in:active,closed'],
        ]);
    }
}

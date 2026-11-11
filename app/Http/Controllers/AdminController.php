<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProgramRequest;
use App\Models\Donation;
use App\Models\Program;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function index(): View
    {
        $stats = [
            'total_raised' => Donation::success()->sum('amount'),
            'pending_count' => Donation::where('status', Donation::STATUS_PENDING)->count(),
            'active_program_count' => Program::active()->count(),
            'donor_count' => User::where('role', User::ROLE_DONOR)->count(),
        ];
        $recentDonations = Donation::with('program')
            ->latest()
            ->limit(10)
            ->get();

        return view('pages.admin', compact('stats', 'recentDonations'));
    }

    public function donasi(Request $request): View
    {
        $querySearch = $request->query('q');
        $search = is_string($querySearch) ? trim($querySearch) : '';
        $status = $request->query('status');

        $donations = Donation::query()
            ->with(['program', 'user'])
            ->when($search !== '', function ($query) use ($search): void {
                $query->where(function ($query) use ($search): void {
                    $query->where('invoice', 'like', "%{$search}%")
                        ->orWhere('donor_name', 'like', "%{$search}%")
                        ->orWhere('donor_email', 'like', "%{$search}%")
                        ->orWhereHas('program', fn ($programQuery) => $programQuery->where('title', 'like', "%{$search}%"));
                });
            })
            ->when(
                in_array($status, [Donation::STATUS_PENDING, Donation::STATUS_SUCCESS, Donation::STATUS_FAILED], true),
                fn ($query) => $query->where('status', $status),
            )
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('pages.admin_donasi', compact('donations', 'search', 'status'));
    }

    public function program(Request $request): View
    {
        $querySearch = $request->query('q');
        $search = is_string($querySearch) ? trim($querySearch) : '';
        $status = $request->query('status');
        $queryCategory = $request->query('category');
        $category = is_string($queryCategory) ? trim($queryCategory) : '';
        $categories = Program::query()->distinct()->orderBy('category')->pluck('category');

        $programs = Program::query()
            ->withRaised()
            ->withCount('donations')
            ->when($search !== '', fn ($query) => $query->where('title', 'like', "%{$search}%"))
            ->when(
                in_array($status, [Program::STATUS_ACTIVE, Program::STATUS_CLOSED], true),
                fn ($query) => $query->where('status', $status),
            )
            ->when($category !== '' && $categories->contains($category), fn ($query) => $query->where('category', $category))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('pages.admin_program', compact('programs', 'categories', 'search', 'status', 'category'));
    }

    public function penyaluran(): View
    {
        return view('pages.admin_penyaluran');
    }

    public function donatur(Request $request): View
    {
        $querySearch = $request->query('q');
        $search = is_string($querySearch) ? trim($querySearch) : '';
        $donors = User::query()
            ->where('role', User::ROLE_DONOR)
            ->withCount('donations')
            ->withSum([
                'donations as successful_donations_amount' => fn ($query) => $query->where('status', Donation::STATUS_SUCCESS),
            ], 'amount')
            ->when($search !== '', function ($query) use ($search): void {
                $query->where(function ($query) use ($search): void {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('pages.admin_donatur', compact('donors', 'search'));
    }

    public function laporan(): View
    {
        $stats = [
            'successful_amount' => Donation::success()->sum('amount'),
            'pending_amount' => Donation::where('status', Donation::STATUS_PENDING)->sum('amount'),
            'donor_count' => User::where('role', User::ROLE_DONOR)->count(),
        ];
        $monthlyReports = collect(range(5, 0))->map(function (int $monthsAgo): array {
            $month = now()->startOfMonth()->subMonths($monthsAgo);
            $totals = Donation::query()
                ->selectRaw('status, SUM(amount) as total, COUNT(*) as transactions')
                ->whereBetween('created_at', [$month->copy()->startOfMonth(), $month->copy()->endOfMonth()])
                ->groupBy('status')
                ->get()
                ->keyBy('status');

            return [
                'period' => $month->locale('id')->isoFormat('MMMM YYYY'),
                'success' => (int) ($totals->get(Donation::STATUS_SUCCESS)?->total ?? 0),
                'pending' => (int) ($totals->get(Donation::STATUS_PENDING)?->total ?? 0),
                'transactions' => (int) $totals->sum('transactions'),
            ];
        });

        return view('pages.admin_laporan', compact('stats', 'monthlyReports'));
    }

    public function storeProgram(ProgramRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        unset($validated['image']);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('programs', 'public');
        }

        Program::create($validated);

        return back()->with('success', 'Program berhasil dibuat.');
    }

    public function updateProgram(ProgramRequest $request, Program $program): RedirectResponse
    {
        $validated = $request->validated();
        unset($validated['image']);

        if ($request->hasFile('image')) {
            $previousImage = $program->getRawOriginal('image');
            $validated['image'] = $request->file('image')->store('programs', 'public');
            $program->update($validated);

            if ($previousImage && ! Str::startsWith($previousImage, ['http://', 'https://'])) {
                Storage::disk('public')->delete($previousImage);
            }
        } else {
            $program->update($validated);
        }

        return back()->with('success', 'Program berhasil diperbarui.');
    }

    public function destroyProgram(Program $program): RedirectResponse
    {
        DB::transaction(function () use ($program): void {
            $lockedProgram = Program::query()
                ->whereKey($program->id)
                ->lockForUpdate()
                ->firstOrFail();

            abort_if(
                $lockedProgram->donations()->exists(),
                409,
                'Program tidak dapat dihapus karena sudah memiliki riwayat donasi.',
            );

            $lockedProgram->delete();
        });

        return back()->with('success', 'Program berhasil dihapus.');
    }

    public function updateDonation(Request $request, Donation $donation): RedirectResponse
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
}

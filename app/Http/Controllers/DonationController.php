<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\Program;
use Illuminate\Http\Request;

class DonationController extends Controller
{
    public function store(Request $request, $id)
    {
        $program = Program::active()->findOrFail($id);

        // Terima input seperti "Rp 50.000" -> 50000
        if ($request->has('amount')) {
            $request->merge(['amount' => preg_replace('/\D/', '', (string) $request->input('amount'))]);
        }

        $validated = $request->validate([
            'amount' => ['required', 'integer', 'min:10000', 'max:1000000000'],
            'donor_name' => [$request->user() ? 'nullable' : 'required', 'string', 'max:100'],
            'donor_email' => ['nullable', 'email', 'max:255'],
            'message' => ['nullable', 'string', 'max:500'],
            'is_anonymous' => ['nullable', 'boolean'],
        ], [
            'amount.min' => 'Minimal donasi Rp 10.000.',
            'donor_name.required' => 'Nama donatur wajib diisi.',
        ]);

        $user = $request->user();

        $donation = Donation::create([
            'program_id' => $program->id,
            'user_id' => $user?->id,
            'invoice' => Donation::generateInvoice(),
            'donor_name' => $validated['donor_name'] ?? $user->name,
            'donor_email' => $validated['donor_email'] ?? $user?->email,
            'amount' => $validated['amount'],
            'message' => $validated['message'] ?? null,
            'is_anonymous' => $request->boolean('is_anonymous'),
            'status' => Donation::STATUS_PENDING,
        ]);

        return redirect()
            ->route('program.show', $program->id)
            ->with('success', "Terima kasih! Donasi {$donation->invoice} menunggu konfirmasi pembayaran.");
    }
}

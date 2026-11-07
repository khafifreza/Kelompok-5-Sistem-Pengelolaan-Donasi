<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDonationRequest;
use App\Models\Donation;
use App\Models\Program;

class DonationController extends Controller
{
    public function store(StoreDonationRequest $request, int $id)
    {
        $program = Program::active()->findOrFail($id);
        $validated = $request->validated();

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

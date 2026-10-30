<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

#[Fillable([
    'program_id', 'user_id', 'invoice', 'donor_name', 'donor_email',
    'amount', 'message', 'is_anonymous', 'status', 'paid_at',
])]
class Donation extends Model
{
    public const STATUS_PENDING = 'pending';
    public const STATUS_SUCCESS = 'success';
    public const STATUS_FAILED = 'failed';

    protected function casts(): array
    {
        return [
            'amount' => 'integer',
            'is_anonymous' => 'boolean',
            'paid_at' => 'datetime',
        ];
    }

    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeSuccess(Builder $query): Builder
    {
        return $query->where('status', self::STATUS_SUCCESS);
    }

    /** Nama yang ditampilkan ke publik ("Anonim" bila donatur menyembunyikan nama). */
    protected function displayName(): Attribute
    {
        return Attribute::get(fn () => $this->is_anonymous ? 'Anonim' : $this->donor_name);
    }

    public static function generateInvoice(): string
    {
        do {
            $invoice = 'INV-'.now()->format('ymd').'-'.Str::upper(Str::random(6));
        } while (self::where('invoice', $invoice)->exists());

        return $invoice;
    }

    /** Dipanggil saat pembayaran terkonfirmasi (admin / callback payment gateway). */
    public function markAsPaid(): bool
    {
        return $this->update([
            'status' => self::STATUS_SUCCESS,
            'paid_at' => now(),
        ]);
    }
}

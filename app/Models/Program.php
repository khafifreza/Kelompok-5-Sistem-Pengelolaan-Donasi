<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['title', 'category', 'description', 'image', 'target_amount', 'status'])]
class Program extends Model
{
    public const STATUS_ACTIVE = 'active';
    public const STATUS_CLOSED = 'closed';

    protected function casts(): array
    {
        return [
            'target_amount' => 'integer',
        ];
    }

    public function donations(): HasMany
    {
        return $this->hasMany(Donation::class);
    }

    /** Hanya donasi yang sudah berhasil (dipakai untuk total & daftar donatur). */
    public function paidDonations(): HasMany
    {
        return $this->donations()->where('status', Donation::STATUS_SUCCESS);
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', self::STATUS_ACTIVE);
    }

    /** Menambahkan kolom virtual `raised_amount` (total donasi sukses) dalam satu query. */
    public function scopeWithRaised(Builder $query): Builder
    {
        return $query->withSum([
            'donations as raised_amount' => fn ($q) => $q->where('status', Donation::STATUS_SUCCESS),
        ], 'amount');
    }

    public function raisedAmount(): int
    {
        return (int) ($this->raised_amount ?? $this->paidDonations()->sum('amount'));
    }

    public function progressPercent(): int
    {
        if ($this->target_amount <= 0) {
            return 0;
        }

        return (int) min(100, round($this->raisedAmount() / $this->target_amount * 100));
    }

    public static function rupiah(int|float $number): string
    {
        return 'Rp '.number_format($number, 0, ',', '.');
    }

    /**
     * Format untuk kartu program (home & daftar program).
     * Kuncinya sama dengan data hardcode sebelumnya agar view tidak berubah.
     */
    public function toCard(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'category' => $this->category,
            'progress' => $this->progressPercent(),
            'raised' => self::rupiah($this->raisedAmount()),
            'target' => self::rupiah($this->target_amount),
            'image' => $this->image,
        ];
    }

    /** Format untuk halaman detail program (termasuk 5 donatur terbaru). */
    public function toDetail(): array
    {
        $donors = $this->paidDonations()
            ->latest('id')
            ->limit(5)
            ->get()
            ->map(fn (Donation $donation) => [
                'name' => $donation->display_name,
                'amount' => self::rupiah($donation->amount),
            ])
            ->all();

        return $this->toCard() + [
            'description' => $this->description,
            'donors' => $donors,
        ];
    }
}

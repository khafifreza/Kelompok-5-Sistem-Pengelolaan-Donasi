@extends('layouts.app')

@section('title', $program['title'])

@section('content')
<section class="program-detail">
    <div class="wrap">
        <a href="{{ route('program.index') }}" class="back-link"><i class="bi bi-arrow-left"></i> Kembali ke Program</a>
        <div class="detail-grid">
            <div class="detail-image">
                <img src="{{ $program['image'] }}" alt="{{ $program['title'] }}">
            </div>
            <div class="detail-content">
                <span class="badge-category">{{ $program['category'] }}</span>
                <h1>{{ $program['title'] }}</h1>
                <p class="description">{{ $program['description'] }}</p>
                
                <div class="progress-info">
                    <div class="progress-label"><span>Terkumpul</span><strong>{{ $program['progress'] }}%</strong></div>
                    <div class="progress"><i style="width: {{ $program['progress'] }}%;"></i></div>
                    <div class="amount-detail">
                        <strong>{{ $program['raised'] }}</strong>
                        <span>dari target {{ $program['target'] }}</span>
                    </div>
                </div>
                
                <div class="donor-list">
                    <h3>Donatur Terbaru</h3>
                    <ul>
                        @foreach($program['donors'] as $donor)
                        <li>
                            <span class="donor-name">{{ $donor['name'] }}</span>
                            <span class="donor-amount">{{ $donor['amount'] }}</span>
                        </li>
                        @endforeach
                    </ul>
                </div>
                
                <button class="btn btn-primary btn-block" onclick="openModal('donasiModalProgram')">Donasi Sekarang</button>
            </div>
        </div>
    </div>
</section>

<div class="modal-overlay" id="donasiModalProgram">
    <div class="modal-box donasi-modal">
        <button class="modal-close" onclick="closeModal('donasiModalProgram')">✕</button>
        <div class="modal-header">
            <h2>Donasi untuk: {{ $program['title'] }}</h2>
        </div>
        
        <form method="POST" action="{{ route('donasi.store', $program['id']) }}">
            @csrf
            <div class="form-group">
                <label>Nominal Donasi (Rp)</label>
                <div class="input-with-prefix">
                    <span class="prefix">Rp</span>
                    <input type="text" name="amount" id="donasiAmount" value="100.000" required>
                </div>
                <small class="form-hint">Minimal Rp 10.000</small>
            </div>

            @guest
            <div class="form-group">
                <label>Nama Donatur</label>
                <input type="text" name="donor_name" required placeholder="Nama Anda">
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="donor_email" required placeholder="email@contoh.com">
            </div>
            @endguest

            <div class="form-group">
                <label class="checkbox-label-custom">
                    <input type="checkbox" name="is_anonymous" value="1">
                    <span>Sembunyikan nama saya (Hamba Allah)</span>
                </label>
            </div>

            <div class="form-group">
                <label>Pesan/Doa (Opsional)</label>
                <textarea name="message" class="form-select-custom" rows="3" placeholder="Tuliskan pesan atau doa..."></textarea>
            </div>

            <button type="submit" class="modal-btn">Lanjutkan Pembayaran <i class="bi bi-arrow-right"></i></button>
        </form>
    </div>
</div>

<script>
    document.getElementById('donasiAmount').addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        e.target.value = new Intl.NumberFormat('id-ID').format(value);
    });
</script>
@endsection
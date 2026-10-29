@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
<section class="hero wrap">
    <div class="hero-copy">
        <div class="eyebrow">Platform kebaikan terpercaya</div>
        <h1>Bantu Sesama <br>dengan <em>Transparan.</em></h1>
        <p>Setiap kebaikan berarti. Salurkan bantuan dengan aman, pantau dampaknya, dan hadirkan harapan bagi mereka yang membutuhkan.</p>
        
        <div class="hero-buttons">
            <a href="{{ route('program.index') }}" class="btn btn-primary">Mulai Berbagi <i class="bi bi-arrow-right"></i></a>
        </div>

        <div class="trust-row">
            <div class="avatars">
                <span style="background: #c4956a;">AR</span>
                <span style="background: #6b8e7b;">DS</span>
                <span style="background: #4a7c6f;">FM</span>
            </div>
            <div>
                <strong>4.8/5</strong>
                <small>Dipercaya 3.200+ donatur</small>
            </div>
        </div>
    </div>

    <div class="hero-visual">
        <div class="hero-shape"></div>
        <img src="https://images.unsplash.com/photo-1720238281687-dcc6d8a6e7d4?auto=format&fit=crop&w=800&q=85" alt="Relawan">
    
        <div class="floating-card safe-card">
            <i class="bi bi-shield-check"></i>
            <span style="font-weight: 600; font-size: 14px; color: var(--primary);">Donasi aman & tercatat</span>
        </div>
    
        <div class="floating-card impact-card">
            <div class="float-icon">
                <i class="bi bi-heart"></i>
            </div>
            <div>
                <small style="display: block; color: var(--text-muted); font-size: 12px; margin-bottom: 2px;">Dampak bulan ini</small>
                <strong style="font-size: 15px; color: var(--text-dark);">1.248 orang terbantu</strong>
            </div>
        </div>
    </div>
</section>

<section class="stats-band" id="transparansi">
    <div class="wrap stats-grid">
        <div>
            <div class="stats-top">
                <span>Total Terkumpul</span>
                <small>+18% bulan ini</small>
            </div>
            <strong>Rp 2,8 M</strong>
        </div>
        <div>
            <div class="stats-top">
                <span>Telah Tersalurkan</span>
                <small>85% tersalurkan</small>
            </div>
            <strong>Rp 2,4 M</strong>
        </div>
        <div>
            <div class="stats-top">
                <span>Penerima Manfaat</span>
                <small>di 34 wilayah</small>
            </div>
            <strong>12.480</strong>
        </div>
    </div>
</section>

<section class="program-section" id="program">
    <div class="wrap">
        <div class="section-heading">
            <div>
                <div class="eyebrow">Program pilihan</div>
                <h2>Berbagi untuk perubahan nyata</h2>
                <p style="color: var(--text-muted); margin:0;">Pilih program yang paling dekat dengan kepedulianmu.</p>
            </div>
            <a href="{{ route('program.index') }}" class="see-all">Lihat semua program <i class="bi bi-arrow-right"></i></a>
        </div>

        <div class="program-grid">
            @foreach($programs as $program)
            <article class="program-card">
                <div class="program-image">
                    <img src="{{ $program['image'] }}" alt="{{ $program['title'] }}">
                    <span>{{ $program['category'] }}</span>
                </div>
                <div class="program-content">
                    <h3>{{ $program['title'] }}</h3>
                    <div class="progress-label"><span>Terkumpul</span><strong>{{ $program['progress'] }}%</strong></div>
                    <div class="progress"><i style="width: {{ $program['progress'] }}%;"></i></div>
                    <div class="amount"><strong>{{ $program['raised'] }}</strong><span>dari {{ $program['target'] }}</span></div>
                    <a href="{{ route('program.show', $program['id']) }}" class="btn btn-outline-custom">Donasi Sekarang <i class="bi bi-arrow-right"></i></a>
                </div>
            </article>
            @endforeach
        </div>
    </div>
</section>
@endsection
@extends('layouts.app')

@section('title', 'Program')

@section('content')
<section class="program-section">
    <div class="wrap">
        <div class="section-heading">
            <div>
                <div class="eyebrow">Semua Program</div>
                <h2>Daftar Program Donasi</h2>
                <p style="color: var(--text-muted); margin:0;">Pilih program yang ingin Anda dukung.</p>
            </div>
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
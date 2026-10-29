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
                
                <a href="#" class="btn btn-primary btn-block">Donasi Sekarang</a>
            </div>
        </div>
    </div>
</section>
@endsection
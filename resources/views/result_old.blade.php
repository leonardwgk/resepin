{{-- @extends('layouts.app')

@section('content')
<div class="container">
    
    <div class="row mb-5">
        <div class="col-12 text-center">
            <h2 class="fw-bold mb-3">Kamu punya bahan-bahan ini:</h2>
            
            <div class="d-flex justify-content-center flex-wrap gap-2">
                @foreach($ingredients as $item)
                    <span class="badge bg-white text-dark border px-4 py-2 rounded-pill fs-6 shadow-sm">
                        <i class="bi bi-check-circle-fill text-success me-2"></i> {{ ucfirst($item) }}
                    </span>
                @endforeach
            </div>
        </div>
    </div>

    <hr class="border-secondary opacity-10 my-5">

    <div class="row mb-4">
        <div class="col-12">
            <h3 class="fw-bold"><i class="bi bi-journal-bookmark-fill text-warning me-2"></i> Rekomendasi Masakan</h3>
            <p class="text-muted">Berdasarkan bahan yang kamu punya, kamu bisa masak ini:</p>
        </div>
    </div>

    <div class="row g-4">
        @forelse($recipes as $meal)
        <div class="col-md-4 col-lg-3">
            <div class="card h-100">
                <div class="position-relative">
                    <img src="{{ $meal['strMealThumb'] }}" class="card-img-top" alt="{{ $meal['strMeal'] }}" style="height: 200px; object-fit: cover;">
                </div>
                
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title fw-bold fs-6">{{ Str::limit($meal['strMeal'], 40) }}</h5>
                    
                    <div class="mt-auto pt-3">
                        <a href="{{ route('resep.show', $meal['idMeal']) }}" class="btn btn-outline-dark btn-sm rounded-pill w-100">
                            Lihat Resep
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <div class="text-muted">
                <i class="bi bi-emoji-frown display-1"></i>
                <p class="mt-3">Yah, kami tidak menemukan resep yang cocok dengan bahan itu.</p>
            </div>
        </div>
        @endforelse
    </div>

    <div class="text-center mt-5">
        <a href="/" class="btn btn-link text-decoration-none text-muted">
            <i class="bi bi-arrow-left"></i> Coba foto bahan lain
        </a>
    </div>

</div>
@endsection --}}

@extends('layouts.app')

@section('content')
<div class="container">
    
    <div class="row mb-4">
        <div class="col-12 text-center">
            <h6 class="text-uppercase text-muted fw-bold">Hasil Penglihatan AI</h6>
            <h2 class="fw-bold mb-3">Kamu punya bahan:</h2>
            <div class="d-flex justify-content-center flex-wrap gap-2">
                @foreach($ingredients as $item)
                    <a href="{{ route('search.manual', $item) }}" class="text-decoration-none">
                        <span class="badge bg-white text-dark border px-4 py-2 rounded-pill fs-6 shadow-sm">
                            <i class="bi bi-check-circle-fill text-success me-2"></i> {{ ucfirst($item) }}
                        </span>
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    <div class="row mb-4 justify-content-center">
        <div class="col-md-10">
            @if($status == 'perfect_match')
                <div class="alert alert-success border-0 shadow-sm d-flex align-items-center rounded-4" role="alert">
                    <i class="bi bi-stars fs-1 me-3 text-success"></i>
                    <div>
                        <h5 class="fw-bold mb-1">Perfect Match!</h5>
                        <p class="mb-0">Kami menemukan resep yang menggabungkan <strong>{{ ucfirst($primary_ing) }}</strong> dan <strong>{{ ucfirst($secondary_ing) }}</strong> sekaligus!</p>
                    </div>
                </div>
            @elseif($status == 'fallback')
                <div class="alert alert-warning border-0 shadow-sm d-flex align-items-center rounded-4" role="alert">
                    <i class="bi bi-exclamation-triangle fs-1 me-3 text-warning"></i>
                    <div>
                        <h5 class="fw-bold mb-1">Kombinasi Sulit Ditemukan</h5>
                        <p class="mb-0">Tidak ada resep yang memakai {{ ucfirst($primary_ing) }} & {{ ucfirst($secondary_ing) }} bersamaan. Ini rekomendasi olahan <strong>{{ ucfirst($primary_ing) }}</strong> saja.</p>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <div class="row g-4">
        @forelse($recipes as $meal)
        <div class="col-md-4 col-lg-3">
            <div class="card h-100">
                <div class="position-relative">
                    <img src="{{ $meal['strMealThumb'] }}" class="card-img-top" alt="{{ $meal['strMeal'] }}" style="height: 200px; object-fit: cover;">
                </div>
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title fw-bold fs-6">{{ Str::limit($meal['strMeal'], 40) }}</h5>
                    <div class="mt-auto pt-3">
                        <a href="{{ route('resep.show', $meal['idMeal']) }}" class="btn btn-outline-dark btn-sm rounded-pill w-100">
                            Lihat Resep
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <p class="text-muted">Maaf, tidak ditemukan resep untuk bahan ini.</p>
        </div>
        @endforelse
    </div>

    <div class="text-center mt-5">
        <a href="/" class="btn btn-link text-decoration-none text-muted"><i class="bi bi-arrow-left"></i> Coba foto ulang</a>
    </div>
</div>
@endsection
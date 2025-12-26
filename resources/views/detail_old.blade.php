@extends('layouts.app')

@section('content')
<div class="container pb-5">
    
    <a href="{{ route('home') }}" class="btn btn-outline-secondary rounded-pill mb-4">
        <i class="bi bi-arrow-left me-2"></i>Kembali
    </a>

    <div class="row g-5">
        <div class="col-lg-5">
            <div class="card border-0 shadow-lg overflow-hidden rounded-4 sticky-top" style="top: 100px; z-index: 1;">
                <img src="{{ $meal['strMealThumb'] }}" class="card-img-top" alt="{{ $meal['strMeal'] }}">
                <div class="card-body p-4 bg-white">
                    <h1 class="fw-bold mb-2">{{ $meal['strMeal'] }}</h1>
                    <span class="badge bg-warning text-dark me-2">
                        <i class="bi bi-globe"></i> {{ $meal['strArea'] }}
                    </span>
                    <span class="badge bg-danger">
                        <i class="bi bi-tag"></i> {{ $meal['strCategory'] }}
                    </span>
                    
                    @if(!empty($meal['strYoutube']))
                    <div class="d-grid mt-4">
                        <a href="{{ $meal['strYoutube'] }}" target="_blank" class="btn btn-danger rounded-pill">
                            <i class="bi bi-youtube me-2"></i>Tonton Video Masak
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-7">
            
            <div class="card border-0 shadow-sm rounded-4 mb-4 p-4">
                <h4 class="fw-bold mb-4 text-primary"><i class="bi bi-basket me-2"></i>Bahan-bahan</h4>
                <ul class="list-group list-group-flush">
                    @foreach($ingredients as $ing)
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-3">
                        <span class="fw-medium text-dark">{{ $ing['item'] }}</span>
                        <span class="badge bg-light text-dark border rounded-pill px-3 py-2">
                            {{ $ing['measure'] }}
                        </span>
                    </li>
                    @endforeach
                </ul>
            </div>

            <div class="card border-0 shadow-sm rounded-4 p-4">
                <h4 class="fw-bold mb-4 text-primary"><i class="bi bi-list-ol me-2"></i>Cara Membuat</h4>
                <div class="text-muted" style="line-height: 1.8; white-space: pre-line;">
                    {{ $meal['strInstructions'] }}
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
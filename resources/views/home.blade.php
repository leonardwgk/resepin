@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center align-items-center">
        <div class="col-md-8 col-lg-6 text-center">
            
            <h1 class="display-4 fw-bold mb-3">Ada bahan apa<br>di kulkas?</h1>
            <p class="lead text-muted mb-5">
                Upload foto bahan makananmu, biar <span class="navbar-brand">Resep<span class="oranye">.in</span></span> yang carikan resep enak buat kamu masak hari ini.
            </p>

            <form action="{{ route('analyze') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="card p-3 mb-4">
                    <input type="file" name="image" id="file-input" class="d-none" accept="image/*" onchange="previewImage(event)" required>
                    
                    <label for="file-input" class="upload-area">
                        <div id="upload-placeholder">
                            <i class="bi bi-cloud-arrow-up text-secondary display-1"></i>
                            <h5 class="mt-3 fw-bold text-dark">Klik untuk Upload Foto</h5>
                        </div>
                        <img id="image-preview" src="#" alt="Preview" style="max-width: 100%; max-height: 300px; border-radius: 15px; display: none; margin: 0 auto;">
                    </label>
                </div>

                <button type="submit" class="btn btn-primary btn-lg w-100 py-3 shadow-lg">
                    Cari Resep
                </button>
            </form>

        </div>
    </div>
</div>
@endsection
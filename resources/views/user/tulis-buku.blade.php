@extends('layouts.app')

@section('title', 'Tulis Buku Baru')

@section('content')
<style>
    .writing-container {
        max-width: 1000px;
        margin: 0 auto;
    }
    
    .writing-card {
        border: none;
        border-radius: 20px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
    }
    
    .card-header-custom {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 20px 20px 0 0 !important;
        padding: 25px;
    }
    
    .form-control, .form-select {
        border-radius: 10px;
        border: 2px solid #e9ecef;
        padding: 12px 15px;
        transition: all 0.3s ease;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }
    
    .form-label {
        font-weight: 600;
        color: #495057;
        margin-bottom: 8px;
    }
    
    textarea.form-control {
        min-height: 300px;
        font-family: 'Georgia', serif;
        font-size: 16px;
        line-height: 1.8;
    }
    
    .btn-submit {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        padding: 15px 40px;
        border-radius: 50px;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .btn-submit:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
    }
    
    .info-box {
        background: #f8f9fa;
        border-left: 4px solid #667eea;
        padding: 15px;
        border-radius: 10px;
        margin-bottom: 25px;
    }
    
    .upload-area {
        border: 2px dashed #dee2e6;
        border-radius: 10px;
        padding: 20px;
        text-align: center;
        transition: all 0.3s ease;
        cursor: pointer;
    }
    
    .upload-area:hover {
        border-color: #667eea;
        background: #f8f9fa;
    }
    
    .preview-image {
        max-width: 200px;
        max-height: 300px;
        margin-top: 15px;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }
</style>

<div class="container writing-container my-5 py-4">
    <div class="card writing-card">
        <div class="card-header card-header-custom">
            <div class="d-flex align-items-center">
                <i class="fas fa-pen-fancy fa-2x me-3"></i>
                <div>
                    <h3 class="mb-0">Tulis Buku Baru</h3>
                    <p class="mb-0 opacity-75">Bagikan cerita dan karya Anda dengan dunia</p>
                </div>
            </div>
        </div>
        
        <div class="card-body p-4">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    <strong>Berhasil!</strong> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>Terjadi kesalahan:</strong>
                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="info-box">
                <i class="fas fa-info-circle me-2 text-primary"></i>
                <strong>Info:</strong> Buku yang Anda kirim akan melalui proses validasi oleh admin sebelum ditampilkan di aplikasi.
            </div>

            <form action="{{ url('/tulis-buku/store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="row g-4">
                    <!-- Judul Buku -->
                    <div class="col-md-6">
                        <label class="form-label">
                            <i class="fas fa-heading me-2 text-primary"></i>Judul Buku
                        </label>
                        <input type="text" 
                               name="title" 
                               class="form-control" 
                               placeholder="Masukkan judul buku yang menarik..."
                               value="{{ old('title') }}"
                               required>
                    </div>

                    <!-- Penulis -->
                    <div class="col-md-6">
                        <label class="form-label">
                            <i class="fas fa-user-edit me-2 text-primary"></i>Nama Penulis
                        </label>
                        <input type="text" 
                               name="author" 
                               class="form-control" 
                               placeholder="Nama Anda sebagai penulis"
                               value="{{ old('author', Auth::user()->name) }}"
                               required>
                    </div>

                    <!-- Genre -->
                    <div class="col-md-6">
                        <label class="form-label">
                            <i class="fas fa-bookmark me-2 text-primary"></i>Genre
                        </label>
                        <select name="genre" class="form-select" required>
                            <option value="">-- Pilih Genre --</option>
                            <option value="Pemrograman" {{ old('genre') == 'Pemrograman' ? 'selected' : '' }}>Pemrograman</option>
                            <option value="Novel" {{ old('genre') == 'Novel' ? 'selected' : '' }}>Novel</option>
                            <option value="Hobi" {{ old('genre') == 'Hobi' ? 'selected' : '' }}>Hobi</option>
                            <option value="Horror" {{ old('genre') == 'Horror' ? 'selected' : '' }}>Horror</option>
                            <option value="Romance" {{ old('genre') == 'Romance' ? 'selected' : '' }}>Romantis</option>
                            <option value="Fantasi" {{ old('genre') == 'Fantasi' ? 'selected' : '' }}>Fantasi</option>
                            <option value="Komedi" {{ old('genre') == 'Komedi' ? 'selected' : '' }}>Komedi</option>
                            <option value="Misteri" {{ old('genre') == 'Misteri' ? 'selected' : '' }}>Misteri</option>
                            <option value="Biografi" {{ old('genre') == 'Biografi' ? 'selected' : '' }}>Biografi</option>
                            <option value="Sejarah" {{ old('genre') == 'Sejarah' ? 'selected' : '' }}>Sejarah</option>
                        </select>
                    </div>

                    <!-- Tahun Terbit -->
                    <div class="col-md-6">
                        <label class="form-label">
                            <i class="fas fa-calendar-alt me-2 text-primary"></i>Tahun Terbit
                        </label>
                        <input type="number" 
                               name="year" 
                               class="form-control" 
                               value="{{ old('year', date('Y')) }}"
                               min="1900" 
                               max="{{ date('Y') }}"
                               required>
                    </div>

                    <!-- Cover Buku -->
                    <div class="col-12">
                        <label class="form-label">
                            <i class="fas fa-image me-2 text-primary"></i>Cover Buku
                        </label>
                        <div class="upload-area" onclick="document.getElementById('imageUpload').click()">
                            <i class="fas fa-cloud-upload-alt fa-3x text-muted mb-3"></i>
                            <p class="mb-0">Klik atau drag & drop untuk upload cover buku</p>
                            <small class="text-muted">Format: JPG, PNG (Max: 2MB)</small>
                        </div>
                        <input type="file" 
                               name="image" 
                               id="imageUpload"
                               class="d-none" 
                               accept="image/*"
                               onchange="previewImage(event)">
                        <div id="imagePreview" class="text-center"></div>
                    </div>

                    <!-- Isi Buku -->
                    <div class="col-12">
                        <label class="form-label">
                            <i class="fas fa-book me-2 text-primary"></i>Isi Buku / Konten
                        </label>
                        <textarea name="content" 
                                  class="form-control" 
                                  placeholder="Mulai menulis cerita Anda di sini...&#10;&#10;Contoh:&#10;&#10;Bab 1: Awal Petualangan&#10;&#10;Suatu hari di sebuah desa kecil..."
                                  required>{{ old('content') }}</textarea>
                        <div class="mt-2 text-end">
                            <small class="text-muted">
                                <i class="fas fa-lightbulb me-1"></i>
                                Tips: Gunakan paragraf yang jelas dan menarik untuk pembaca
                            </small>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="col-12 text-center mt-4">
                        <button type="submit" class="btn btn-primary btn-submit btn-lg">
                            <i class="fas fa-paper-plane me-2"></i>Kirim Naskah untuk Validasi
                        </button>
                        <div class="mt-3">
                            <a href="{{ url('/dashboard') }}" class="text-muted">
                                <i class="fas fa-arrow-left me-1"></i>Kembali ke Dashboard
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Panduan Menulis -->
    <div class="card writing-card mt-4">
        <div class="card-body p-4">
            <h5 class="mb-3">
                <i class="fas fa-question-circle me-2 text-info"></i>Panduan Menulis
            </h5>
            <div class="row">
                <div class="col-md-4">
                    <div class="d-flex mb-3">
                        <i class="fas fa-check-circle text-success me-2 mt-1"></i>
                        <div>
                            <strong>Judul Menarik</strong>
                            <p class="text-muted mb-0">Buatlah judul yang eye-catching dan menggambarkan isi buku</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="d-flex mb-3">
                        <i class="fas fa-check-circle text-success me-2 mt-1"></i>
                        <div>
                            <strong>Cover Berkualitas</strong>
                            <p class="text-muted mb-0">Gunakan cover yang menarik dan berkualitas baik</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="d-flex mb-3">
                        <i class="fas fa-check-circle text-success me-2 mt-1"></i>
                        <div>
                            <strong>Konten Original</strong>
                            <p class="text-muted mb-0">Pastikan konten adalah karya original Anda sendiri</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function previewImage(event) {
    const reader = new FileReader();
    reader.onload = function() {
        const preview = document.getElementById('imagePreview');
        preview.innerHTML = `
            <img src="${reader.result}" class="preview-image" alt="Preview Cover">
            <p class="mt-2 text-success"><i class="fas fa-check-circle me-2"></i>Cover berhasil dipilih</p>
        `;
    }
    reader.readAsDataURL(event.target.files[0]);
}
</script>
@endsection

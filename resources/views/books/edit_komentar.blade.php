@extends('layouts.app')

@section('content')
<div class="komentar-container">

<link rel="stylesheet" href="{{ asset('css/edit_komentar.css') }}">

    <div class="komentar-card">
        <h1>Edit Komentar</h1>

        @if(session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert-error">{{ session('error') }}</div>
        @endif

        <form action="{{ route('komentar.update', $komentar->id) }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label>Komentar:</label>
                <textarea name="komentar" required>{{ $komentar->komentar }}</textarea>
            </div>

            <div class="form-group file-group">
                <label class="file-label">
                    <input type="file" name="image" hidden>
                    Ganti Gambar (Opsional)
                </label>
                <span class="file-info">Tidak ada file yang dipilih</span>
            </div>

            @if($komentar->image_path)
                <p>Gambar saat ini:</p>
                <img src="{{ asset('uploads/'.$komentar->image_path) }}" width="150">
            @endif

            <div style="margin-top:10px;">
                <button type="submit" class="btn btn-primary">Update Komentar</button>
                <a href="/komentar" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>

</div>

<script>
document.querySelector('input[name="image"]').addEventListener('change', function(){
    const info = document.querySelector('.file-info');
    info.textContent = this.files[0] ? this.files[0].name : "Tidak ada file yang dipilih";
});
</script>
@endsection

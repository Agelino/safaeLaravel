@extends('layouts.app')

@section('content')

<link rel="stylesheet" href="{{ asset('css/komentar.css') }}">

<div class="komentar-container">

    <!-- FORM TAMBAH KOMENTAR -->
    <div class="komentar-card">
        <h1>Bagian Komentar</h1>

        <p class="user-auto">
            Silakan tulis komentar Anda :
            <strong>{{ Auth::check() ? Auth::user()->name : "Anonymous" }}</strong>
        </p>

        <form action="/komentar/simpan" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <textarea name="komentar" placeholder="Komentar Anda" required></textarea>
            </div>

            <div class="form-group file-group">
                <label class="file-label">
                    <input type="file" name="image" hidden>
                    Pilih Gambar
                </label>
                <span class="file-info">Tidak ada file yang dipilih</span>
            </div>

            <button type="submit" class="btn-kirim">Kirim Komentar</button>
        </form>
    </div>


    <!-- LIST KOMENTAR -->
    <div class="komentar-list">
        <h2>Semua Komentar</h2>

        @foreach ($komentar as $c)
        <div class="komentar-item">

            <strong class="username">{{ $c->username }}</strong>
            <p class="text">{{ $c->komentar }}</p>

            @if($c->image_path)
                <img src="{{ asset('uploads/' . $c->image_path) }}" class="komentar-img">
            @endif

            @if(Auth::check() && Auth::id() == $c->user_id)
            <div style="margin-top:10px; display:flex; gap:10px;">

                <!-- BUTTON EDIT FIXED -->
                <a href="{{ route('komentar.edit', $c->id) }}" class="btn btn-warning">Edit</a>

                <!-- BUTTON HAPUS FIXED -->
                <form action="{{ route('komentar.hapus', $c->id) }}" method="POST"
                      onsubmit="return confirm('Yakin ingin menghapus komentar ini?')">
                    @csrf
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </form>

            </div>
            @endif

        </div>
        @endforeach

    </div>

</div>

<script>
document.querySelector('input[name="image"]').addEventListener('change', function(){
    const info = document.querySelector('.file-info');
    info.textContent = this.files[0] ? this.files[0].name : "Tidak ada file yang dipilih";
});
</script>

@endsection

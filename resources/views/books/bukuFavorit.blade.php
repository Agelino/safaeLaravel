@extends('layouts.app')

@section('content')
<div class="container mt-4">

  <!-- Tombol Back -->
  <a href="{{ url('home') }}" class="btn btn-secondary mb-3">
    <i class="fa-solid fa-arrow-left"></i> Back
  </a>

  <h1 class="mb-4">Pilih Buku Favorit Anda</h1>

  <div class="d-flex flex-wrap gap-3">
    @foreach ($books as $book)
      <div class="card shadow-sm" style="width: 18rem;">
        <img src="{{ asset($book['image']) }}" class="card-img-top" alt="{{ $book['title'] }}">
        <div class="card-body text-center">
          <h5 class="card-title">{{ $book['title'] }}</h5>
          <p class="card-text">Oleh: {{ $book['author'] }}</p>
          <form method="POST" action="{{ route('tambah.favorit') }}">
            @csrf
            <input type="hidden" name="title" value="{{ $book['title'] }}">
            <input type="hidden" name="author" value="{{ $book['author'] }}">
            <input type="hidden" name="image" value="{{ $book['image'] }}">
            <button type="submit" class="btn btn-primary">Tambah ke Favorit</button>
          </form>
        </div>
      </div>
    @endforeach
  </div>

  <h2 class="mt-5 mb-3 text-center">Daftar Buku Favorit</h2>

  <div class="d-flex flex-wrap gap-3 justify-content-center">
    @forelse ($favorites as $book)
      <div class="card shadow-sm" style="width: 18rem;">
        <img src="{{ asset($book['image']) }}" class="card-img-top" alt="{{ $book['title'] }}">
        <div class="card-body text-center">
          <h5 class="card-title">{{ $book['title'] }}</h5>
          <p class="card-text">Oleh: {{ $book['author'] }}</p>
          <form method="POST" action="{{ route('hapus.favorit') }}">
            @csrf
            <input type="hidden" name="title" value="{{ $book['title'] }}">
            <button type="submit" class="btn btn-danger">Hapus</button>
          </form>
        </div>
      </div>
    @empty
      <p>Belum ada buku favorit.</p>
    @endforelse
  </div>

</div>
@endsection

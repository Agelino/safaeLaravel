@extends('layouts.admin') {{-- pastikan layout sesuai dengan admin layout --}}

@section('title', 'Kelola Komentar Admin')

@section('content')
<link rel="stylesheet" href="{{ asset('css/komentar.css') }}">

<div class="container">
    <h1>Kelola Semua Komentar</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="komentar-list">
        @forelse($komentar as $c)
            <div class="komentar-item">
                <strong>{{ $c->username }}</strong> - 
                <em>Buku ID: {{ $c->book_id }}, Halaman: {{ $c->page }}</em>
                <p>{{ $c->komentar }}</p>

                @if($c->image_path)
                    <img src="{{ asset('uploads/' . $c->image_path) }}" width="200">
                @endif

                <form action="{{ route('admin.komentar.hapus', $c->id) }}" method="POST" 
                      onsubmit="return confirm('Yakin ingin menghapus komentar ini?')"
                      style="margin-top:10px;">
                    @csrf
                    <button type="submit" class="btn btn-danger btn-sm">
                        🗑 Hapus
                    </button>
                </form>
            </div>
        @empty
            <p>Tidak ada komentar.</p>
        @endforelse
    </div>
</div>
@endsection

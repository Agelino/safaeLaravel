@extends('layouts.app')

@section('content')

<link rel="stylesheet" href="{{ asset('css/komentar.css') }}">

<div class="komentar-container">

    <a href="{{ route('book.show', [$bookId, $page]) }}" class="btn-back">
        ← Kembali ke Bacaan
    </a>

    <div class="komentar-card">
        <h1>Komentar</h1>

        <form action="{{ route('komentar.simpan') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <input type="hidden" name="book_id" value="{{ $bookId }}">
            <input type="hidden" name="page" value="{{ $page }}">

            <textarea name="komentar" placeholder="Tulis komentar..." required></textarea>

            <input type="file" name="image">

            <button type="submit" class="btn-kirim">
                Kirim
            </button>
        </form>
    </div>

    <div class="komentar-list">
        @forelse($komentar as $c)
            <div class="komentar-item">

                <strong class="username">{{ $c->username }}</strong>
                <p class="text">{{ $c->komentar }}</p>

                @if($c->image_path)
                    <img src="{{ asset('uploads/' . $c->image_path) }}" class="komentar-img">
                @endif

           
                @if(Auth::check() && Auth::id() == $c->user_id)
                    <div style="margin-top:10px; display:flex; gap:10px;">

                        <a href="{{ route('komentar.edit', $c->id) }}"
                           class="btn btn-warning btn-sm">
                            ✏️ Edit
                        </a>

                        <form action="{{ route('komentar.hapus', $c->id) }}"
                              method="POST"
                              onsubmit="return confirm('Yakin ingin menghapus komentar ini?')">
                            @csrf
                            <button type="submit" class="btn btn-danger btn-sm">
                                🗑 Hapus
                            </button>
                        </form>

                    </div>
                @endif

            </div>
        @empty
            <p style="text-align:center; opacity:0.7;">
                Belum ada komentar di halaman ini.
            </p>
        @endforelse
    </div>

</div>

@endsection

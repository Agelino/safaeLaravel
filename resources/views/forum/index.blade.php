@extends('layouts.app')

@section('content')
<h3 class="mb-3 fw-bold">Forum Diskusi Buku</h3>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<form method="GET" action="{{ route('forum.index') }}" class="mb-3">
    <select name="genre_id" class="form-select" onchange="this.form.submit()">
        <option value="">-- Pilih Genre --</option>
        @foreach($genres as $genre)
            <option value="{{ $genre->id }}" {{ $selectedGenre == $genre->id ? 'selected' : '' }}>
                {{ $genre->nama_genre }}
            </option>
        @endforeach
    </select>
</form>

@if(!$currentGenre)
    <p class="text-muted">Silakan pilih genre dulu 📚</p>
@else
    <h5 class="fw-bold mb-3">
        Topik: <span class="text-primary">{{ $currentGenre->nama_genre }}</span>
    </h5>

    @auth
        <a href="{{ route('forum.create', $currentGenre->id) }}" class="btn btn-success mb-3">
            + Tambah Topik Baru
        </a>
    @else
        <div class="alert alert-info">Silakan login untuk membuat topik.</div>
    @endauth

    @if($topics->isEmpty())
        <p class="text-muted">Belum ada topik 😢</p>
    @endif

    <div class="list-group">
        @foreach($topics as $topic)
            <a href="{{ route('forum.detail', $topic->id) }}"
               class="list-group-item list-group-item-action mb-2 shadow-sm">
                <strong>{{ $topic->judul }}</strong><br>
                <small class="text-muted">Oleh: {{ $topic->user->nama_depan ?? 'User' }}</small>
            </a>
        @endforeach
    </div>
@endif

@endsection

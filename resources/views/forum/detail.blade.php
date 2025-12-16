@extends('layouts.app')

@section('content')
<a href="/forum?genre_id={{ $topic->genre_id }}" class="btn btn-outline-primary btn-sm mb-3">⬅ Kembali</a>

<div class="p-4 bg-white shadow rounded mb-4">
    <h3 class="fw-bold text-primary">{{ $topic->judul }}</h3>
    <p class="text-muted">
        ✍ Oleh: {{ $topic->user->nama_depan ?? $topic->user->name }} • 
        {{ $topic->created_at->format('d M Y H:i') }}
    </p>

    <p class="mt-3">{{ $topic->isi }}</p>

    @if($topic->gambar)
        <img src="{{ asset('uploads/topics/' . $topic->gambar) }}"
            class="rounded shadow-sm mt-3" style="max-width: 100%; max-height: 400px; object-fit: cover;">
    @endif

    @if($topic->file)
        <div class="mt-3">
            📄 <a href="{{ asset('uploads/topics/' . $topic->file) }}" target="_blank" class="btn btn-outline-secondary btn-sm">
                Download Lampiran
            </a>
        </div>
    @endif

    @auth
        @if(Auth::id() == $topic->user_id)
        <div class="mt-4 d-flex gap-2">
            <a href="{{ route('forum.edit', $topic->id) }}" class="btn btn-warning btn-sm">✏ Edit</a>
            <a href="{{ route('forum.destroy', $topic->id) }}" class="btn btn-danger btn-sm"
                onclick="return confirm('Yakin hapus topik ini?')">
                🗑 Hapus
            </a>
        </div>
        @endif
    @endauth
</div>

<h5 class="fw-bold mb-3">💬 Komentar</h5>

@forelse($topic->comments as $comment)
<div class="p-3 bg-light rounded shadow-sm mb-2">
    <strong class="text-dark">{{ $comment->user->nama_depan ?? $comment->user->name }}</strong><br>
    <span>{{ $comment->isi }}</span>
</div>
@empty
<p class="text-muted">Belum ada komentar.</p>
@endforelse


@auth
<form method="POST" action="{{ route('forum.comment') }}" class="mt-3">
    @csrf
    <input type="hidden" name="topic_id" value="{{ $topic->id }}">
    <textarea name="isi" class="form-control mb-3 shadow-sm" placeholder="Tulis komentar..." required></textarea>
    <button class="btn btn-primary w-100">Kirim Komentar</button>
</form>
@endauth

@endsection

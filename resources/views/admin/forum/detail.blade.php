@extends('layouts.layoutsAdmin')




@section('title', 'Detail Forum')

@section('content')
<div class="container-fluid mt-4">
    <a href="{{ route('admin.forum.index') }}" class="btn btn-secondary btn-sm mb-3">⬅ Kembali</a>

    <div class="card mb-4">
        <div class="card-body">
            <h4 class="fw-bold">{{ $topic->judul }}</h4>

            <p class="text-muted mb-1">
                Genre: <strong>{{ $topic->genre->nama_genre ?? '-' }}</strong>
            </p>

            <p class="text-muted mb-3">
                Oleh: {{ $topic->user->nama_depan ?? 'User' }} • {{ $topic->created_at->format('d M Y H:i') }}
            </p>

            <p>{{ $topic->isi }}</p>

            @if($topic->gambar)
                <img src="{{ asset('uploads/topics/'.$topic->gambar) }}" class="img-fluid rounded mt-3">
            @endif

            @if($topic->file)
                <div class="mt-3">
                    📄 <a href="{{ asset('uploads/topics/'.$topic->file) }}" target="_blank"
                        class="btn btn-outline-secondary btn-sm">Lihat Lampiran</a>
                </div>
            @endif
        </div>
    </div>

    <h5 class="fw-bold mb-3">Komentar</h5>

    @foreach($topic->comments as $comment)
        <div class="card mb-2">
            <div class="card-body">
                <strong>{{ $comment->user->nama_depan ?? 'User' }}</strong>
                <small class="text-muted"> • {{ $comment->created_at->format('d M Y H:i') }}</small>
                <p class="mt-2">{{ $comment->isi }}</p>

                <a href="{{ route('admin.forum.destroy', $comment->id) }}"
                   onclick="return confirm('Hapus komentar ini?')"
                   class="btn btn-danger btn-sm">Hapus</a>
            </div>
        </div>
    @endforeach
</div>
@endsection

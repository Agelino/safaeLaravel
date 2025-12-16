@extends('layouts.app')

@section('content')

<div class="container mt-4">

    <h2 class="mb-3">📖 Riwayat Baca</h2>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($histories->count() == 0)
        <div class="alert alert-info">
            Belum ada riwayat baca.
        </div>
    @else

        <div class="row">
            @foreach($histories as $history)
                <div class="col-md-4 mb-3">
                    <div class="card shadow-sm">

                        {{-- COVER BUKU --}}
                        @if ($history->book && $history->book->image_path)
                            <img
                                src="{{ $history->book->image_path }}"
                                alt="Cover {{ $history->book->title }}"
                                class="card-img-top"
                                style="height: 200px; object-fit: cover;">
                        @else
                            <div class="bg-secondary text-white d-flex align-items-center justify-content-center"
                                 style="height: 200px;">
                                Tidak Ada Cover
                            </div>
                        @endif

                        <div class="card-body">

                            <h5 class="card-title">
                                {{ $history->book->title ?? 'Buku tidak ditemukan' }}
                            </h5>

                            <p class="text-muted mb-1">
                                Penulis: {{ $history->book->author ?? '-' }}
                            </p>

                            <p class="mb-1">
                                Genre: {{ $history->book->genre ?? '-' }}
                            </p>

                            <p class="mb-1">
                                Tahun: {{ $history->book->year ?? '-' }}
                            </p>

                            <p class="mb-1">
                                Progress: <strong>{{ $history->progress }}</strong>
                            </p>

                            <p class="text-muted small mb-3">
                                Terakhir dibaca: {{ $history->last_read_at ?? '-' }}
                            </p>

                            <a href="{{ route('book.show', [$history->book->id, $history->progress]) }}"
                               class="btn btn-primary w-100 mb-2">
                                Lanjutkan Membaca
                            </a>

                            <form action="{{ route('reading.history.delete', $history->id) }}"
                                  method="POST"
                                  onsubmit="return confirm('Hapus riwayat ini?')">
                                @csrf
                                @method('DELETE')

                                <button class="btn btn-danger w-100">
                                    Hapus Riwayat
                                </button>
                            </form>

                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    @endif

</div>

@endsection

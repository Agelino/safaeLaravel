@extends('layouts.app')

@section('title', 'Buku Favorit')

@section('content')
<div class="container">

    <h3 class="mb-4">❤️ Buku Favorit Saya</h3>

    <div class="row">
        @forelse ($favorites as $fav)
            <div class="col-md-3 mb-3">
                <div class="card h-100 border-danger">

                    {{-- LINK KE FULL BACAAN --}}
                    <a href="{{ route('fullbacaan.show', $fav->book->id) }}"
                       class="text-decoration-none text-dark">

                        {{-- COVER --}}
                        @if (!empty($fav->book->image_path))
                            <img src="{{ asset($fav->book->image_path) }}"
                                 class="card-img-top"
                                 alt="{{ $fav->book->title }}">
                        @else
                            <img src="https://via.placeholder.com/300x200?text=No+Image"
                                 class="card-img-top"
                                 alt="No Image">
                        @endif

                        <div class="card-body text-center">
                            <h6>{{ $fav->book->title }}</h6>
                            <p class="text-muted">{{ $fav->book->author }}</p>
                        </div>
                    </a>

                    {{-- HAPUS FAVORIT --}}
                    <div class="card-footer bg-white text-center">
                        <form action="{{ route('favorite.hapus') }}" method="POST">
                            @csrf
                            <input type="hidden" name="book_id" value="{{ $fav->book->id }}">
                            <button class="btn btn-danger btn-sm">
                                ❌ Hapus dari Favorit
                            </button>
                        </form>
                    </div>

                </div>
            </div>
        @empty
            <p class="text-muted text-center">Belum ada buku favorit.</p>
        @endforelse
    </div>

</div>
@endsection

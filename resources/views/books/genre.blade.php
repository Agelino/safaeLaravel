@extends('layouts.app')

@section('title', 'Genre Buku')

@section('content')

<link rel="stylesheet" href="{{ asset('css/genre.css') }}">

<!-- Filter dan Search -->
<div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
    <div class="filter-bar">

        <a href="{{ route('genre.index') }}"
           class="btn btn-outline-primary {{ empty($genre) ? 'active' : '' }}">
            Semua
        </a>

        @foreach($all_genres as $g)
            <a href="{{ route('genre.index', ['genre' => $g]) }}"
               class="btn btn-outline-primary {{ $genre == $g ? 'active' : '' }}">
                {{ $g }}
            </a>
        @endforeach

    </div>

    <form method="GET" action="{{ route('genre.index') }}" class="search-bar">
        <input type="text"
               name="search"
               class="form-control"
               placeholder="Cari buku..."
               value="{{ $search }}">
        <button class="btn btn-primary">
            <i class="fa fa-search"></i>
        </button>
    </form>
</div>

<!-- Grid Buku -->
<div class="row g-2">
    @forelse($books_to_show as $book)
        <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
            <div class="card h-100">

                {{-- COVER BUKU --}}
                @if (!empty($book->image_path))
                    <img src="{{ $book->image_path }}"
                         class="card-img-top"
                         alt="{{ $book->title }}">
                @else
                    <img src="https://via.placeholder.com/300x200?text=No+Image"
                         class="card-img-top"
                         alt="No Image">
                @endif

                <div class="card-body">
                    <h6 class="card-title">{{ $book->title }}</h6>
                    <p><strong>Author:</strong> {{ $book->author }}</p>
                    <p><strong>Genre:</strong> {{ $book->genre }}</p>
                    <p><strong>Year:</strong> {{ $book->year }}</p>
                </div>

                <div class="card-footer bg-white text-center">
                    <a href="{{ route('fullbacaan.show', $book->id) }}"
                       class="btn btn-sm btn-info text-white">
                        <i class="fa fa-eye"></i>
                    </a>
                </div>

            </div>
        </div>
    @empty
        <p class="text-center text-muted">Tidak ada buku ditemukan.</p>
    @endforelse
</div>

@endsection

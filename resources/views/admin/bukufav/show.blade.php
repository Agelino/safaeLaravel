@extends('layouts.layoutsAdmin') 

@section('title', 'Detail Buku Favorit')

@section('content')
<div class="container">
    <h3 class="mb-4">📖 Detail Buku Favorit User</h3>

    <div class="card">
        <div class="row g-0">
            <div class="col-md-4">
                @if ($favorite->book->image_path)
                    <img src="{{ asset($favorite->book->image_path) }}"
                         class="img-fluid rounded-start">
                @else
                    <img src="https://via.placeholder.com/300x400">
                @endif
            </div>

            <div class="col-md-8">
                <div class="card-body">
                    <h4>{{ $favorite->book->title }}</h4>
                    <p><strong>Penulis:</strong> {{ $favorite->book->author }}</p>
                    <p><strong>User:</strong> {{ $favorite->user->username }}</p>
                    <p><strong>Email:</strong> {{ $favorite->user->email }}</p>
                    <p><strong>Ditambahkan:</strong>
                        {{ $favorite->created_at->format('d M Y') }}
                    </p>

                    <a href="{{ route('admin.favorit.index') }}"
                       class="btn btn-secondary mt-3">
                        ⬅ Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

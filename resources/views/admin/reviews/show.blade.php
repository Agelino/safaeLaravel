@extends('layouts.layoutsAdmin')

@section('title', 'Detail Ulasan')

@section('content')

<link rel="stylesheet" href="{{ asset('css/admin-reviews.css') }}">

<div class="container mt-4">

    <h2 class="mb-4">Detail Ulasan</h2>

    <div class="card">
        <div class="card-header">
            <strong>Ulasan oleh:</strong> {{ $review->user->nama_depan ?? $review->user->name ?? 'User' }}
        </div>

        <div class="card-body">

            <p><strong>Buku:</strong> {{ $review->book->title ?? 'Tidak ada' }}</p>
            <p><strong>Rating:</strong> {{ $review->rating }} / 5</p>
            <p><strong>Tanggal:</strong> {{ $review->created_at->format('d M Y H:i') }}</p>

            <hr>

            <p><strong>Isi Ulasan:</strong></p>
            <p>{{ $review->komentar }}</p>

            <hr>

            <a href="{{ route('admin.reviews.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>

            <form action="{{ route('admin.reviews.destroy', $review->id) }}" 
                  method="POST" 
                  class="d-inline"
                  onsubmit="return confirm('Yakin ingin menghapus ulasan ini?')">

                @csrf
                @method('DELETE')

                <button class="btn btn-danger">
                    <i class="fas fa-trash"></i> Hapus
                </button>

            </form>

        </div>
    </div>

</div>

@endsection

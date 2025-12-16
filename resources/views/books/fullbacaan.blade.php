@extends('layouts.app')

@section('title', $buku->title . ' - Halaman ' . $page)

@section('content')

<link rel="stylesheet" href="{{ asset('css/fullbacaan.css') }}">

<div class="container">
    <h1>{{ $buku->title }}</h1>
    <div class="info">
        <p><strong>Penulis:</strong> {{ $buku->author }}</p>
        <p><strong>Genre:</strong> {{ $buku->genre }}</p>
        <p><strong>Halaman:</strong> {{ $page }}/{{ $totalHalaman }}</p>
    </div>

    <p>{{ $halaman }}</p>

  
    <div class="buttons d-flex gap-2 flex-wrap">

       
        @if($page > 1)
            <a href="{{ route('book.show', ['id' => $buku->id, 'page' => $page - 1]) }}" class="btn btn-blue">
                ← Sebelumnya
            </a>
        @endif

     
        @if($page < $totalHalaman)
            <a href="{{ route('book.show', ['id' => $buku->id, 'page' => $page + 1]) }}" class="btn btn-blue">
                Selanjutnya →
            </a>
        @else
          
            <a href="#" onclick="alert('🎉 Kamu telah selesai membaca buku ini!')" class="btn btn-blue">
                Selesai Membaca
            </a>

   
            <a href="{{ route('ulasan.index', ['id' => $buku->id]) }}" class="btn btn-yellow">
                ⭐ Beri Ulasan Buku
            </a>
        @endif

        <a href="{{ route('genre.index') }}" class="btn btn-blue">
            📚 Daftar Buku
        </a>

        <a href="/komentar" class="btn btn-yellow">
            💬 Komentar
        </a>

    </div>
</div>

@endsection
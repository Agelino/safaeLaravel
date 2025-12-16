@extends('layouts.app')

@section('content')
<h4 class="mb-3">Tambah Topik Baru</h4>

<div class="card p-4 shadow">
<form action="{{ route('forum.store') }}" method="POST" enctype="multipart/form-data">
    @csrf


    <input type="hidden" name="genre_id" value="{{ $genre_id }}">


    <label class="form-label">Judul Topik</label>
    <input type="text" class="form-control mb-3" name="judul" placeholder="Judul topik..." required>

    <label class="form-label">Isi Topik</label>
    <textarea class="form-control mb-3" name="isi" rows="4" placeholder="Tulis isi..." required></textarea>

    <label class="form-label">Upload Gambar (Opsional)</label>
    <input type="file" class="form-control mb-3" name="gambar">

    <label class="form-label">Upload File Tambahan (Opsional)</label>
    <input type="file" class="form-control mb-4" name="file">

    <button class="btn btn-blue w-100">Simpan</button>
</form>
</div>

@endsection

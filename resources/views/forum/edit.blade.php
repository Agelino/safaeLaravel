@extends('layouts.app')

@section('content')
<h4>Edit Topik</h4>
<form action="{{ route('forum.update', $topic->id) }}" method="POST">
    @csrf
    <input type="text" class="form-control mb-2" name="judul" value="{{ $topic->judul }}" required>
    <textarea class="form-control mb-2" name="isi" rows="4" required>{{ $topic->isi }}</textarea>
    <button class="btn btn-warning w-100">Update</button>
</form>
@endsection

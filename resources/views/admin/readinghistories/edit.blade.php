@extends('layouts.layoutsAdmin')

@section('content')
<div class="container py-4">

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">

            <h3 class="fw-bold mb-4">Edit Riwayat Baca</h3>

            <form action="{{ route('kelolariwayat.update', $history->id) }}" 
                  method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">User</label>
                    <select name="user_id" class="form-select">
    @foreach ($users as $user)
        <option value="{{ $user->id }}"
            {{ $history->user_id == $user->id ? 'selected' : '' }}>
            
            {{ $user->name 
                ?? $user->username 
                ?? ($user->nama_depan . ' ' . $user->nama_belakang) 
                ?? 'User Tanpa Nama' }}
                
        </option>
    @endforeach
</select>

                </div>

                <div class="mb-3">
                    <label class="form-label">Buku</label>
                    <select name="book_id" class="form-select">
                        @foreach ($books as $book)
                            <option value="{{ $book->id }}"
                                {{ $history->book_id == $book->id ? 'selected' : '' }}>
                                {{ $book->title }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Progress (%)</label>
                    <input type="number" class="form-control" 
                           name="progress" value="{{ $history->progress }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Tanggal Terakhir Baca</label>
                    <input type="date" class="form-control" 
                           name="last_read_at" value="{{ $history->last_read_at }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Bukti Progress</label><br>

                    @if ($history->bukti_progress)
                        <a href="{{ asset('uploads/bukti_progress/' . $history->bukti_progress) }}"
                           target="_blank" class="btn btn-outline-info btn-sm mb-2">
                           Lihat File Saat Ini
                        </a>
                    @endif

                    <input type="file" class="form-control" name="bukti_progress">
                </div>

                <button class="btn btn-primary w-100">Update</button>

            </form>

        </div>
    </div>

</div>
@endsection

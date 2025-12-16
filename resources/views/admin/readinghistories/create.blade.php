@extends('layouts.layoutsAdmin')

@section('content')
<div class="container py-4">

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">

            <h3 class="fw-bold mb-4">Tambah Riwayat Baca</h3>

            <form action="{{ route('kelolariwayat.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label class="form-label">User</label>
                    <select name="user_id" class="form-select">
                        <option value="">-- Pilih User --</option>

                        @foreach ($users as $user)
                            <option value="{{ $user->id }}">
                                {{ $user->name 
                                    ?? $user->username 
                                    ?? ($user->nama_depan . ' ' . $user->nama_belakang) }}
                            </option>
                        @endforeach

                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Buku</label>
                    <select name="book_id" class="form-select">
                        <option value="">-- Pilih Buku --</option>

                        @foreach ($books as $book)
                            <option value="{{ $book->id }}">
                                {{ $book->title }}
                            </option>
                        @endforeach

                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Progress (%)</label>
                    <input type="number" class="form-control" name="progress" placeholder="Contoh: 45">
                </div>

                <div class="mb-3">
                    <label class="form-label">Tanggal Terakhir Baca</label>
                    <input type="date" class="form-control" name="last_read_at">
                </div>

                <div class="mb-3">
                    <label class="form-label">Bukti Progress (Foto atau PDF)</label>
                    <input type="file" class="form-control" name="bukti_progress">
                </div>

                <button class="btn btn-primary w-100">
                    Simpan Riwayat
                </button>

            </form>

        </div>
    </div>

</div>
@endsection

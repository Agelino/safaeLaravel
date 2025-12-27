@extends('layouts.layoutsAdmin')

@section('title', 'Tambah User')

@section('content')
<main class="col-lg-10 col-md-9 ms-sm-auto px-4 pt-3">

    <div class="container" style="max-width: 650px;">

        {{-- HEADER --}}
        <div class="mb-4">
            <h3 class="fw-bold mb-1">Tambah User</h3>
            <small class="text-muted">
                Tambahkan akun pengguna baru ke dalam sistem
            </small>
        </div>

        {{-- CARD FORM --}}
        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-body p-4">

                <form action="{{ route('admin.users.store') }}" method="POST">
                    @csrf

                    {{-- USERNAME --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Username
                        </label>
                        <input type="text"
                               name="username"
                               class="form-control form-control-lg @error('username') is-invalid @enderror"
                               placeholder="Masukkan username"
                               value="{{ old('username') }}"
                               required>
                        @error('username')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- EMAIL --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Email
                        </label>
                        <input type="email"
                               name="email"
                               class="form-control form-control-lg @error('email') is-invalid @enderror"
                               placeholder="contoh@email.com"
                               value="{{ old('email') }}"
                               required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- PASSWORD --}}
                    <div class="mb-4">
                        <label class="form-label fw-semibold">
                            Password
                        </label>
                        <input type="password"
                               name="password"
                               class="form-control form-control-lg @error('password') is-invalid @enderror"
                               placeholder="Minimal 6 karakter"
                               required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- ACTION BUTTON --}}
                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.users.index') }}"
                           class="btn btn-light px-4">
                            Batal
                        </a>
                        <button class="btn btn-primary px-4">
                            <i class="fas fa-save me-1"></i> Simpan User
                        </button>
                    </div>

                </form>

            </div>
        </div>

    </div>

</main>
@endsection

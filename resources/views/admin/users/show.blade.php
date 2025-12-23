@extends('layouts.layoutsAdmin')

@section('title', 'Detail User')

@section('content')
<main class="col-lg-10 col-md-9 ms-sm-auto px-4 pt-2">

    <div class="container" style="max-width: 700px;">

        {{-- HEADER --}}
        <div class="mb-3">
            <h3 class="fw-bold mb-1">Detail User</h3>
            <small class="text-muted">
                Informasi lengkap data pengguna
            </small>
        </div>

        {{-- CARD --}}
        <div class="card shadow-sm border-0">
            <div class="card-body text-center">

                {{-- FOTO PROFIL --}}
                @if($user->profile_image)
                    <img
                        src="{{ asset('storage/' . $user->profile_image) }}"
                        alt="Foto Profil"
                        class="rounded-circle mb-3 border"
                        style="width: 120px; height: 120px; object-fit: cover;">
                @else
                    <div
                        class="rounded-circle bg-light d-flex align-items-center justify-content-center mx-auto mb-3"
                        style="width: 120px; height: 120px;">
                        <i class="fas fa-user fa-3x text-muted"></i>
                    </div>
                @endif

                {{-- INFO USER --}}
                <div class="text-start mt-3">
                    <p><strong>ID:</strong> {{ $user->id }}</p>
                    <p><strong>Username:</strong> {{ $user->username }}</p>
                    <p><strong>Email:</strong> {{ $user->email }}</p>
                </div>

                {{-- TOMBOL --}}
                <a href="{{ route('admin.users.index') }}"
                   class="btn btn-secondary mt-3">
                    <i class="fas fa-arrow-left me-1"></i> Kembali
                </a>

            </div>
        </div>

    </div>

</main>
@endsection

@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')

<style>
    .profile-wrapper {
        max-width: 900px;
        margin: 0 auto;
        padding: 40px 20px;
    }

    .profile-card {
        background: #fff;
        border-radius: 20px;
        padding: 80px 40px 40px;
        position: relative;
        box-shadow: 0 20px 40px rgba(0,0,0,0.1);
    }

    .profile-avatar {
        position: absolute;
        top: -60px;
        left: 40px;
    }

    .profile-avatar img {
        width: 120px;
        height: 120px;
        object-fit: cover;
        border-radius: 50%;
        border: 6px solid #fff;
        background: #f1f3f5;
    }

    .profile-name {
        font-size: 24px;
        font-weight: 700;
    }

    .profile-item {
        background: #f8f9fa;
        border-radius: 14px;
        padding: 14px 16px;
        margin-bottom: 14px;
        font-size: 14px;
    }

    .profile-item i {
        color: #0d6efd;
        margin-right: 8px;
    }

    .btn-rounded {
        border-radius: 30px;
        padding: 8px 18px;
        font-size: 14px;
    }

    @media (max-width: 768px) {
        .profile-avatar {
            left: 50%;
            transform: translateX(-50%);
        }

        .profile-card {
            padding-top: 100px;
            text-align: center;
        }
    }
</style>

<div class="profile-wrapper">

    <div class="profile-card">

        {{-- FOTO PROFIL --}}
        <div class="profile-avatar">
            <img src="{{ $profile->foto_profil
                ? asset($profile->foto_profil)
                : 'https://ui-avatars.com/api/?name='.$profile->username.'&background=0d6efd&color=fff' }}"
                 alt="Foto Profil">
        </div>

        {{-- HEADER PROFIL --}}
        <div class="mb-4 ms-md-5 ps-md-5">
            <div class="profile-name">
                {{ $profile->username }}
            </div>
            <p class="text-muted mb-0">Akun Safae</p>
        </div>

        {{-- INFO --}}
        <div class="row mt-4">
            <div class="col-md-6">
                <div class="profile-item">
                    <i class="bi bi-link-45deg"></i>
                    <strong>Social Media</strong><br>
                    <span class="text-muted">
                        {{ $profile->social_media ?? 'Belum diisi' }}
                    </span>
                </div>
            </div>

            <div class="col-md-6">
                <div class="profile-item">
                    <i class="bi bi-person-lines-fill"></i>
                    <strong>Bio</strong><br>
                    <span class="text-muted">
                        {{ $profile->bio ?? 'Belum ada bio' }}
                    </span>
                </div>
            </div>
        </div>

        {{-- ACTION --}}
        <div class="d-flex flex-wrap gap-2 mt-4">
            <a href="{{ route('profile.edit') }}" class="btn btn-primary btn-rounded">
                <i class="bi bi-pencil-square"></i> Edit Profil
            </a>

            <form action="{{ route('profile.delete') }}" method="POST"
                  onsubmit="return confirm('Yakin ingin menghapus akun?')">
                @csrf
                <button class="btn btn-danger btn-rounded">
                    <i class="bi bi-trash"></i> Hapus Akun
                </button>
            </form>

            <a href="{{ route('profile') }}" class="btn btn-secondary btn-rounded">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>

    </div>
</div>

@endsection

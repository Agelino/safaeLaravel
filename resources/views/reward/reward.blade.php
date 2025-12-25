@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/reward.css') }}">

<div class="reward-wrapper">

    <h2 class="text-center mb-4">🏆 Leaderboard</h2>

    <div class="reward-layout">

        <!-- ================= LEADERBOARD ================= -->
        <div class="leaderboard">

            <!-- TOP 3 -->
            <div class="top-three">
                @foreach($ranking->take(3) as $index => $user)
                    <div class="top-card rank-{{ $index + 1 }}">
                        <span class="badge-rank">{{ $index + 1 }}</span>

                        <img
                            src="{{ $user->foto_profil
                                ? asset($user->foto_profil)
                                : 'https://ui-avatars.com/api/?name='.$user->username }}"
                            class="avatar">

                        <h5>{{ $user->username }}</h5>
                        <p>⭐ {{ $user->points }} pts</p>
                    </div>
                @endforeach
            </div>

            <!-- LIST 4+ -->
            <div class="rank-list">
                @foreach($ranking->skip(3) as $index => $user)
                    <div class="rank-item">
                        <span class="rank-number">{{ $index + 4 }}</span>

                        <img
                            src="{{ $user->foto_profil
                                ? asset($user->foto_profil)
                                : 'https://ui-avatars.com/api/?name='.$user->username }}"
                            class="avatar-sm">

                        <strong>{{ $user->username }}</strong>
                        <span class="points">{{ $user->points }} pts</span>
                    </div>
                @endforeach
            </div>

        </div>

        <!-- ================= USER LOGIN CARD ================= -->
        @if($currentUser)
        <div class="user-point-card">
            <p>⭐ {{ $currentUser->points }} pts</p>

            <img
                src="{{ $currentUser->foto_profil
                    ? asset($currentUser->foto_profil)
                    : 'https://ui-avatars.com/api/?name='.$currentUser->username }}"
                class="avatar-lg">

            <h5>{{ $currentUser->username }}</h5>

            <a href="{{ route('pembayaran.index') }}"
               class="btn btn-light btn-sm mt-2">
                Beli poin →
            </a>
        </div>
        @endif

    </div>

</div>
@endsection

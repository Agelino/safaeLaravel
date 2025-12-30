@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/reward.css') }}">

<div class="reward-wrapper">

    <h2 class="text-center mb-4">🏆 Leaderboard</h2>

    <div class="reward-layout">

        <div class="leaderboard">

            <div class="top-three">
                @foreach($ranking->take(3) as $index => $user)
                    <div class="top-card rank-{{ $index + 1 }}">
                        <span class="badge-rank">{{ $index + 1 }}</span>

                        @if($user->foto_profil)
                            <img src="{{ asset('storage/' . $user->foto_profil) }}"
                                 class="rounded-circle mb-2"
                                 width="48"
                                 height="48"
                                 style="object-fit: cover;">
                        @else
                            <img src="https://ui-avatars.com/api/?name={{ $user->username }}"
                                 class="rounded-circle mb-2"
                                 width="48"
                                 height="48">
                        @endif

                        <h5>{{ $user->username }}</h5>
                        <p>⭐ {{ $user->points }} pts</p>
                    </div>
                @endforeach
            </div>

            <div class="rank-list">
                @foreach($ranking->skip(3) as $index => $user)
                    <div class="rank-item">
                        <span class="rank-number">{{ $index + 4 }}</span>

                        @if($user->foto_profil)
                            <img src="{{ asset('storage/' . $user->foto_profil) }}"
                                 class="avatar-sm"
                                 style="object-fit: cover;">
                        @else
                            <img src="https://ui-avatars.com/api/?name={{ $user->username }}"
                                 class="avatar-sm">
                        @endif

                        <strong>{{ $user->username }}</strong>
                        <span class="points">{{ $user->points }} pts</span>
                    </div>
                @endforeach
            </div>

        </div>

        @if($currentUser)
        <div class="user-point-card">

            <p>⭐ {{ $currentUser->points }} pts</p>

            @if(Auth::user()->foto_profil)
                <img src="{{ asset('storage/' . Auth::user()->foto_profil) }}"
                     class="rounded-circle mb-2"
                     width="48"
                     height="48"
                     style="object-fit: cover;">
            @else
                <img src="https://ui-avatars.com/api/?name={{ Auth::user()->username }}"
                     class="rounded-circle mb-2"
                     width="48"
                     height="48">
            @endif

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

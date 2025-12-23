@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/reward.css') }}">

<div class="reward-wrapper">

    <h2 class="text-center mb-4">🏆 Leaderboard</h2>

    <!-- TOP 3 -->
    <div class="top-three">
        @foreach($ranking->take(3) as $index => $user)
            <div class="top-card rank-{{ $index + 1 }}">
                <span class="badge-rank">{{ $index + 1 }}</span>

                <img src="{{ asset('images/'.$user->photo) }}" class="avatar">

                <h5>{{ $user->username }}</h5>
                <p>⭐ {{ $user->points }} pts</p>
            </div>
        @endforeach
    </div>

    <!-- LIST 4 - 5 -->
    <div class="rank-list">
        @foreach($ranking->skip(3) as $index => $user)
            <div class="rank-item">
                <span class="rank-number">{{ $index + 4 }}</span>

                <img src="{{ asset('images/'.$user->photo) }}" class="avatar-sm">

                <strong>{{ $user->username }}</strong>

                <span class="points">{{ $user->points }} pts</span>
            </div>
        @endforeach
    </div>

    <!-- USER LOGIN CARD -->
    @if($currentUser)
    <div class="user-point-card">
        <p>⭐ {{ $currentUser->points }} pts</p>

        <img src="{{ asset('images/'.$currentUser->photo) }}" class="avatar-lg">

        <h5>{{ $currentUser->username }}</h5>
        
        <a href="#" class="btn btn-light btn-sm mt-2">Beli poin →</a>
    </div>
    @endif

</div>
@endsection

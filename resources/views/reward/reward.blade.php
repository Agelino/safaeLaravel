@extends('layouts.app')

@section('content')
<div class="leaderboard text-center">
    <h1>🏆 Peringkat Tertinggi</h1>
    <div class="ranking-container d-flex justify-content-center align-items-end mt-4">
        @php
            $colors = ['#ffcc70', '#95afc0', '#dff9fb', '#dcdde1'];
        @endphp

        @foreach($ranking as $i => $user)
            <div class="rank-card mx-2 p-3 rounded shadow-sm" 
                 style="height: {{ 240 - $i * 20 }}px; background: {{ $colors[$i] }}">
                <div class="name fw-bold">
                    {{ $user['nama'] }} 
                    @if($loop->first)
                        👑
                    @endif
                </div>
                <div class="points">+{{ $user['poin'] }} ⭐</div>

               <img src="{{ asset('images/' . $user['foto']) }}" 
                alt="{{ $user['nama'] }}"
                 class="rounded-circle"
                width="60" height="60"
                style="object-fit: cover; border: 2px solid #fff;">

                     
                <div class="rank-label mt-2">{{ $loop->iteration }}</div>
            </div>
        @endforeach
    </div>
</div>

@if($currentUser)
<div style="position: fixed; top: 90px; right: 30px; background: #fff; border-radius: 12px; padding: 15px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); width: 200px; text-align: center; z-index: 999;">
    <h5 style="margin: 0; font-weight: bold;">{{ $currentUser['nama'] }}</h5>
    <p style="margin: 5px 0 0 0;">⭐ Poin: <strong>{{ $currentUser['poin'] }}</strong></p>

    <img src="{{ asset('images/' . $user['foto']) }}" 
     alt="{{ $user['nama'] }}"
     class="rounded-circle"
     width="60" height="60"
     style="object-fit: cover; border: 2px solid #fff;">

</div>
@endif
@endsection

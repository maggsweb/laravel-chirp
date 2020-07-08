@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="text-primary">
            {{ $user->username }}
        </h2>
        <hr>
        @if(Auth::user()->isNotTheUser($user))
            @if(Auth::user()->isFollowing($user))
                <a class="btn btn-primary" href="{{ route('users.unfollow', $user) }}">UnFollow</a>
            @else
                <a class="btn btn-success" href="{{ route('users.follow', $user) }}">Follow</a>
            @endif
        @endif

        <br>
        <br>
        <hr>

        @foreach($user->posts as $post)
            <div>
                <div class="lead">{{ $post->body }}</div>
                <div class="text-muted">{{ $post->humanDate }}</div>
            </div>
            <hr>
        @endforeach
    </div>
@endsection


@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <div class="row">

        <div class="col-md-2">

            <img src="{{ Auth::user()->avatar }}" alt="{{ Auth::user()->username }}" height="80">
            <hr>
            <h2 class="text-primary">
                {{ Auth::user()->username }}
            </h2>

            <h2>Following</h2>
            @foreach($following as $user)
                <p><a class="btn btn-primary" href="{{ route('users', $user) }}">{{ $user->username }}</a></p>
            @endforeach
            <hr>
            <h2>Followers</h2>
            @foreach($followers as $user)
                <p><a class="btn btn-success" href="{{ route('users', $user) }}">{{ $user->username }}</a></p>
            @endforeach

        </div>

        <div class="col-md-10">
            <div id="root"></div>
        </div>

    </div>

</div>
@endsection

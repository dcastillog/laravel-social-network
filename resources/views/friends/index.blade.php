@extends('layouts.app')

@section('content')
    <div class="row">
        @forelse($friends as $friend)
            <div class="col-md-3">
                @include('partials.user', ['user' => $friend])
            </div>
        @empty
            <p>No tienes amigos aún</p>
        @endforelse
    </div>

@endsection


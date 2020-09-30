@extends('layouts.app')

@section('content')
    @foreach($friendshipRequests as $friendshipRequest)
        <accept-friendship-button 
            {{-- dusk="accept-friendship" --}}
            :sender="{{ $friendshipRequest->sender }}"
            friendship-status="{{ $friendshipRequest->status }}"
        />
    @endforeach
@endsection
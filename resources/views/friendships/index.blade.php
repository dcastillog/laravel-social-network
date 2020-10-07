@extends('layouts.app')

@section('content')
    @foreach($friendshipRequests as $friendshipRequest)
        <accept-friendship-button 
            :sender="{{ $friendshipRequest->sender }}"
            friendship-status="{{ $friendshipRequest->status }}"
        />
    @endforeach
@endsection
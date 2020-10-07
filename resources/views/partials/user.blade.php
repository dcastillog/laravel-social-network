<div class="card border-0 bg-light shadow-sm">
    <img src="{{ $user->avatar }}" alt="{{ $user->name }}" class="card-img-top">
    <div class="card-body">
        
        <h5 class="card-title"><a href="{{ route('users.show', $user) }}">{{ $user->name }}</a> </h5>
        @if(auth()->id() !== $user->id)
            <request-friendship-button 
                class="btn btn-primary btn-block"
                dusk="request-friendship" 
                :recipient="{{ $user }}"
            />
        @endif
    </div>
</div>
@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-8 mx-auto">
                <div class="card ">
                    <status-form />
                </div>
                
                <statuses-list />
            </div>
        </div>
    </div>
@endsection
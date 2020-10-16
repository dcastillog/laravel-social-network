<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="user" content="{{ Auth::user() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    
    {{-- Font Awesome 5.14.0 --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css">

    {{-- Styles --}}
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
</head>
<body>
    
    <div id="app">
        {{-- @include('partials.navbar') --}}
        
        <navbar></navbar>

        <main class="py-4">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-3">
                        <left-sidebar></left-sidebar>
                    </div>
        
                    <div class="col-md-6 mx-auto">
                        <router-view></router-view>
                    </div>
        
                    <div class="col-md-3 bg-dark">
                        {{-- <right-sidebar /> --}}
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
    <script src="{{ mix('js/app.js') }}" defer></script>
</body>
</html>

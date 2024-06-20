<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])


    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">

            <!-- Page Content -->
            <main>

                <style>
                    body{
                        background-color: #f8f9fa;
                    }
                </style>
                
                <div class="container">
                    <h1>Entry Summary:</h1>
                    <p><strong>Entry ID:</strong> {{ $entry->confirmation_code }}</p>
                    <div class="row">
                        @php
                            $entryTeams = $entry->teams()->get();
                        @endphp
                        @foreach($entryTeams as $entryTeam)
                            @if(isset($entryTeam->team) && $entryTeam->team)
                                <div class="col-md-4">
                                    <div class="card mb-4">
                                        <img src="{{ $entryTeam->team->featured_url }}" class="card-img-top" alt="Product Image">
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $entryTeam->conference }}</h5>
                                            <p class="card-text">{{ $entryTeam->team->name }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>

            </main>
        </div>


    </body>
</html>

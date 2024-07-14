<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- SEO -->
        <meta name="description" content="Welcome to the Road to Jansanity $1 Million Dollar Playoff Challenge! Here's your chance to showcase your college football expertise and compete for $1 million dollars.">
        <meta name="keywords" content="Jansanity25, Jansanity, College Football, $1 Million Dollar Playoff Challenge">
        <meta name="robots" content="index, follow">
        <meta property="og:title" content="Welcome to the Road to Jansanity $1 Million Dollar Playoff Challenge!">
        <meta property="og:description" content="Here's your chance to showcase your college football expertise and compete for $1 million dollars.">
        <meta property="og:image" content="{{ asset('images/logo.jpg') }}">
        <meta property="og:url" content="{{ url('/') }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        @stack('head_scripts')


    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">

            <!-- Page Heading -->
            @include('components.header')

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

        @include('components.footer')

        @stack('footer_scripts')


    </body>
</html>

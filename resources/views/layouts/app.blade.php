<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="light">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&amp;display=swap" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            body {
                font-family: "Inter", sans-serif;
            }
            .material-symbols-outlined {
                font-variation-settings:
                    "FILL" 0,
                    "wght" 400,
                    "GRAD" 0,
                    "opsz" 24;
            }
            .chart-bar {
                transition: height 1s ease-in-out;
            }
        </style>
    </head>
    <body class="bg-background text-on-background min-h-screen antialiased">
        
        @include('layouts.navigation')

        <div class="sm:ml-64 pt-16 transition-all duration-300">
            
            @isset($header)
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-6">
                    {{ $header }}
                </div>
            @endisset

            <main class="max-w-7xl mx-auto p-4 sm:p-6 lg:p-8">
                {{ $slot }}
            </main>
        </div>

    </body>
</html>
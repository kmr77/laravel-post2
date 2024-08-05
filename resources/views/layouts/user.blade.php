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
    <body>
        <div class="font-sans text-gray-900 antialiased">
            {{-- ここから貼り付けます --}}
            <div class="w-full container mx-auto">
                <div class="w-full flex items-center justify-between">
                    <a href="{{route('top')}}">
                        <img src="{{asset('logo/inu-logo.jpg')}}" style="max-height:80px;" alt="">
                    </a>
                </div>
            </div>
            {{-- ここまで貼り付けた箇所 --}}
            <div class="w-full container mx-auto">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
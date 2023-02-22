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

        <link rel="stylesheet" href="{{url('css/style_sheet.css')}}">
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>

                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
            <script >
                var icon=document.getElementById('icon');
                icon.onclick=function (){
                    document.body.classList.toggle("light_mode");
                    if(document.body.classList.contains("light_mode")){
                        icon.src="images/moon.png";

                    }
                    else{
                        icon.src="images/sun.png";
                    }
                }
                var icon_resp=document.getElementById('icon_resp');
                icon_resp.onclick=function (){
                    document.body.classList.toggle("light_mode");
                    if(document.body.classList.contains("light_mode")){
                        icon_resp.src="images/moon.png";

                    }
                    else{
                        icon_resp.src="images/sun.png";
                    }
                }
            </script>
        </div>
    </body>
</html>

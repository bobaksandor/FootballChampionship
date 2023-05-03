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
    <header>
        <nav class="bg-gray-200 px-4 py-2 ">
            <div class="flex justify-between">
              <div class="flex items-center space-x-4 text-3xl">
                <a href="/" class="text-gray-800 font-bold text-lg"><img class="w-10 h-10" src="https://cdn.pixabay.com/photo/2013/07/13/10/51/football-157930__340.png" alt=""></a>
                <ul class="flex space-x-4">
                  <li><a href="{{route('games.index')}}" class="text-blue-500 hover:text-blue-700">Mérkőzések</a></li>
                  <li><a href="{{route('teams.index')}}" class="text-blue-500 hover:text-blue-700">Csapatok</a></li>
                  <li><a href="{{route('tables.index')}}" class="text-blue-500 hover:text-blue-700">Tabella</a></li>
                  <li><a href="" class="text-blue-500 hover:text-blue-700">Kedvenceim</a></li>
                </ul>
              </div>
              <div class="flex items-center space-x-4">
                {{-- <a href="" class="text-gray-800 font-bold">Login</a> --}}
                
                @guest
                    <a class="text-gray-800 font-bold" href="{{ route('login') }}">Login</a>
                    <a href="" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700">Sign up</a>
                @else
                    @auth
                        <p class="mr-7">Szia, {{ Auth::user() -> name }}!</p>
                    
                    @endauth
                    <a class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700" href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                        Logout
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                    
                @endguest
              </div>
            </div>
          </nav>
          
          
    </header>
    <body class="font-sans text-gray-900 antialiased bg-gray-200">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-200">
            {{-- <div>
                <a href="/">
                    <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
                </a>
            </div> --}}

            <div class="w-full mt-6 px-6 py-4 bg-gray-200 shadow-md overflow-hidden sm:rounded-lg">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Kezdőlap</title>
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<header>
    <nav class="bg-gray-200 px-4 py-2">
        <div class="flex justify-between">
          <div class="flex items-center space-x-4">
            <a href="/" class="text-gray-800 font-bold text-lg"><img class="w-7 h-7" src="https://cdn.pixabay.com/photo/2013/07/13/10/51/football-157930__340.png" alt=""></a>
            <ul class="flex space-x-4">
              <li><a href="{{route('games.index')}}" class="text-blue-500 hover:text-blue-700">Mérkőzések</a></li>
              <li><a href="{{route('teams.index')}}" class="text-blue-500 hover:text-blue-700">Csapatok</a></li>
              <li><a href="" class="text-blue-500 hover:text-blue-700">Tabella</a></li>
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
<body class="p-4 text-center bg-gray-200">
    {{-- @guest
        <a class="mt-4 mb-6 inline-block p-2 bg-sky-700 hover:bg-sky-900 text-white" href="{{ route('login') }}">Login</a>
    @else
        <a class="mt-4 mb-6 inline-block p-2 bg-sky-700 hover:bg-sky-900 text-white" href="{{ route('logout') }}"
            onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
            Logout
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    @endguest --}}
    <p class="mb-4">Üdvözöljük. Ön egy labdarugó bajnokság kezdőoldalán van.</p>
    {{-- <ul class="flex space-x-4 justify-center">
        <li><a href="{{route('games.index')}}" class="text-blue-500 hover:text-blue-700">Mérkőzések</a></li>
        <li><a href="" class="text-blue-500 hover:text-blue-700">Csapatok</a></li>
        <li><a href="" class="text-blue-500 hover:text-blue-700">Tabella</a></li>
        <li><a href="" class="text-blue-500 hover:text-blue-700">Kedvenceim</a></li>
    </ul> --}}
    <div class="flex justify-center items-center h-screen">
        <img src="https://cdn.pixabay.com/photo/2013/07/13/10/51/football-157930__340.png" alt="image" class="mx-auto">
    </div>
    

</body>

</html>
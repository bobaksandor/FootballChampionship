<x-guest-layout bg-gray-200>
    @if (auth()->user() != null && auth()->user()->is_admin)
        <a class="ml-10 inline-block p-2 bg-sky-700 hover:bg-sky-900 text-white text-center" href="{{ route('games.create') }}">Új mérkőzés hozzáadása</a>
    @endif
    
    <div class="mx-auto flex flex-col bg-gray-200">
    <h1 class="text-4xl font-bold mb-4">Élő meccsek</h1>
      <ul class="border border-gray-300 rounded-md divide-y divide-gray-300 text-center">
            @forelse ($live as $game)
            <a href="{{ route('games.show', ['game' => $game->id]) }}">
                <li class="flex flex-col text-3xl text-center justify-center"> 
                    <div class="flex flex-row justify-center">
                        @if ($game->homeTeam->image == "placeholder")
                            <img class="w-7 h-7" src="https://thumbs.dreamstime.com/b/vector-logo-template-soccer-ball-color-91657652.jpg" alt="">
                        @else
                            <img class="w-7 h-7" src="{{ asset('storage/images/' . $game->homeTeam->image) }}" alt="">
                        @endif
                        {{$game->homeTeam->name}} 
                        @if ($game->start < now())
                            {{$results->where('game_id', $game->id)->first()['homeScore']}}
                        @endif -
                    
                        @if ($game->start < now())
                            {{$results->where('game_id', $game->id)->first()['awayScore']}}
                        @endif
                        {{$game->awayTeam->name}}
                        @if ($game->awayTeam->image == "placeholder")
                            <img class="w-7 h-7" src="https://thumbs.dreamstime.com/b/vector-logo-template-soccer-ball-color-91657652.jpg" alt="">
                        @else
                            <img class="w-7 h-7" src="{{ asset('storage/images/' . $game->awayTeam->image) }}" alt="">
                        @endif
                    </div>
                    <br>
                    <p class="">{{$game->start}}</p>
                    @if (auth()->user() != null && auth()->user()->is_admin)
                        <div class="flex flex-row justify-center mt-4">
                            <a class="ml-10 inline-block p-2 bg-sky-700 hover:bg-sky-900 text-white" href="{{ route('games.openEdit', ['game' => $game->id]) }}">Módosít</a>
                                    
                            <form action="{{ route('games.destroy', ['game' => $game->id])}}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="ml-10 inline-block p-2 bg-red-700 hover:bg-red-900 text-white">Törlés</button>
                            </form>
                        </div>
                                
                    @endif
                    <hr class="border-1 border-gray-500 my-4">
                </li>
            </a>
            @empty
                Nincsenek meccsek.
            @endforelse
      </ul>
      <h1 class="text-4xl font-bold mb-4">Összes meccs</h1>
      <ul class="border border-gray-300 rounded-md divide-y divide-gray-300 text-center">
            @forelse ($games as $game)
            <a href="{{ route('games.show', ['game' => $game->id]) }}">
                    <li class="flex flex-col text-3xl text-center justify-center"> 
                        <div class="flex flex-row justify-center">
                            @if ($game->homeTeam->image == "placeholder")
                                <img class="w-7 h-7" src="https://thumbs.dreamstime.com/b/vector-logo-template-soccer-ball-color-91657652.jpg" alt="">
                            @else
                                <img class="w-7 h-7" src="{{ asset('storage/images/' . $game->homeTeam->image) }}" alt="">
                            @endif
                            {{$game->homeTeam->name}} 
                            @if ($game->start < now())
                                {{$results->where('game_id', $game->id)->first()['homeScore']}}
                            @endif -
                        
                            @if ($game->start < now())
                                {{$results->where('game_id', $game->id)->first()['awayScore']}}
                            @endif
                            {{$game->awayTeam->name}}
                            @if ($game->awayTeam->image == "placeholder")
                                <img class="w-7 h-7" src="https://thumbs.dreamstime.com/b/vector-logo-template-soccer-ball-color-91657652.jpg" alt="">
                            @else
                                <img class="w-7 h-7" src="{{ asset('storage/images/' . $game->awayTeam->image) }}" alt="">
                            @endif
                        </div>
                        <br>
                        <p class="">{{$game->start}}</p>
                        
                        @if (auth()->user() != null && auth()->user()->is_admin)
                        <div class="flex flex-row justify-center mt-4">
                            <a class="ml-10 inline-block p-2 bg-sky-700 hover:bg-sky-900 text-white" href="{{ route('games.openEdit', ['game' => $game->id]) }}">Módosít</a>
                                    
                            <form action="{{ route('games.destroy', ['game' => $game->id])}}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="ml-10 inline-block p-2 bg-red-700 hover:bg-red-900 text-white">Törlés</button>
                            </form>
                        </div>
                                
                    @endif
                        <hr class="border-1 border-gray-500 my-4">
                    </li>
                </a>
            @empty
                Nincsenek meccsek.
            @endforelse
      </ul>
    </div>
    {{ $games->links() }}
  </x-guest-layout>
  
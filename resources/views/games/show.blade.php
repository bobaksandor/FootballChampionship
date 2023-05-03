<x-guest-layout>
    @if (auth()->user() != null && auth()->user()->is_admin && $game->start < now() && !$game->finished)
        <div class="text-center text-6xl">                      
            <form action="{{ route('games.update', ['game' => $game->id])}}" method="POST">
                @csrf
                @method('PATCH')
                <input type="hidden" name="start" value="{{$game->start}}">
                <input type="hidden" name="finished" value="{{true}}">
                <input type="hidden" name="home_team_id" value="{{$game->homeTeam}}">
                <input type="hidden" name="away_team_id" value="{{$game->awayTeam}}">
                <input type="hidden" name="which" value="lezar">
                <button type="submit" class="ml-10 inline-block p-2 bg-sky-700 hover:bg-sky-900 text-white">Befejez</button>
            </form>
        </div>
    @endif

    <div class="mx-auto flex flex-col bg-gray-200">
        <h1 class="mb-4">Adatok</h1>
        <div class="mb-8">
            <div class=" flex flex-row justify-center text-5xl">
                @if ($game->homeTeam->image == "placeholder")
                    <img class="w-11 h-11" src="https://thumbs.dreamstime.com/b/vector-logo-template-soccer-ball-color-91657652.jpg" alt="">
                @else
                    <img class="w-11 h-11" src="{{ asset('storage/images/' . $game->homeTeam->image) }}" alt="">
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
                    <img class="w-11 h-11" src="https://thumbs.dreamstime.com/b/vector-logo-template-soccer-ball-color-91657652.jpg" alt="">
                @else
                    <img class="w-11 h-11" src="{{ asset('storage/images/' . $game->awayTeam->image) }}" alt="">
                @endif
            </div>
            <p class="mt-5 text-3xl text-center">{{$game->start}}</p>
        </div>
        <h1 class="mb-4">Események</h1>
        @if ($game->start < now())
            <ul class="border border-gray-300 rounded-md divide-y divide-gray-300 text-center">
                @foreach ($game->events->sortBy('minute') as $event)
                    <li class="flex flex-col text-3xl text-center justify-center mg mb-4 mt-4"> 
                        <div class="flex flex-row justify-center">
                            {{$players->firstWhere('id', $event->player_id)->team->name}} |
                            {{$event->type}} |
                            {{$event->minute}}. perc |
                            {{$players->firstWhere('id', $event->player_id)->name}}
                            @if (auth()->user() != null && auth()->user()->is_admin && !$game->finished)
                                
                                <form action="{{ route('events.destroy', ['event' => $event->id])}}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="ml-10 inline-block p-2 bg-sky-700 hover:bg-sky-900 text-white">Törlés</button>
                                </form>
                                
                            @endif
                        </div>
                        <br>
                        
                    </li>
                @endforeach
        </ul>
        @else
            <p class=" text-3xl border border-gray-300 rounded-md divide-y divide-gray-300 text-center">Még nem kezdődött el</p>
        @endif
    </div>
    @if ($game->start < now() && !$game->finished && auth()->user() != null && auth()->user()->is_admin)
        <div class="text-center">
            <h1 class="mt-4">Új esemény hozzáadaása</h1>
            <form class="mt-4" action="{{route('events.store')}}" method="post" enctype="multipart/form-data">
                @csrf
                Perc: <input class="mt-4" id="minute" type="text" name="minute" value="{{ old('minute') }}"><br>
                @error('minute')
                    {{ $message }}<br>
                @enderror
                Esemény:
                <select class="mt-4" id="type" name="type">
                    <option value="gól">Gól</option>
                    <option value="öngól">Öngól</option>
                    <option value="sárga lap">Sárga lap</option>
                    <option value="piros lap">Piros lap</option>
                  </select><br>
                @error('type')
                    {{ $message }}<br>
                @enderror
                Játékos: 
                <select class="mt-4" id="player" name="player">
                    @foreach (($game->homeTeam->players->sortBy('number')->concat($game->awayTeam->players->sortBy('number'))) as $player)
                    
                        <option value="{{$player->id}}">{{$player->team->name}} | {{$player->number}} | {{$player->name}}</option>
                    
                    @endforeach
                </select><br>
                @error('player')
                    {{ $message }}<br>
                @enderror
                <input value="{{$game->id}}" name="passGame" type="hidden">
                <button  type="submit" class="mt-4 inline-block p-2 bg-sky-700 hover:bg-sky-900 text-white">Mentés</button>
            </form>
        </div>
    @endif
</x-guest-layout>
<x-guest-layout bg-gray-200>
    @if (auth()->user() != null && auth()->user()->is_admin)
        <a class="ml-10 inline-block p-2 bg-sky-700 hover:bg-sky-900 text-white text-center" href="{{ route('teams.playerCreator', ['team' => $team]) }}">Új játékos hozzáadása a csapathoz</a>
    @endif
    <div class="flex flex-row justify-center text-3xl">
        @if ($team->image == "placeholder")
            <img class="w-10 h-10 mr-7" src="https://thumbs.dreamstime.com/b/vector-logo-template-soccer-ball-color-91657652.jpg" alt="">  
        @else
            <img class="w-10 h-10 mr-7" src="{{ asset('storage/images/' . $team->image) }}" alt="">    
        @endif
        <p class="ml-7 mr-7">{{$team->name}}</p> 
        <p class="ml-7">{{$team->shortname}}</p>
    </div>
    <div>
        <h1>Mérkőzések</h1>
        <ul class="border border-gray-300 rounded-md divide-y divide-gray-300 text-center">
            @forelse ($games as $game)
            <li class="flex flex-col text-3xl text-center justify-center"> 
                <div class="flex flex-row justify-center">
                    @if ($game->homeTeam->image == "placeholder")
                        <img class="w-7 h-7" src="https://thumbs.dreamstime.com/b/vector-logo-template-soccer-ball-color-91657652.jpg" alt="">
                    @else
                        <img class="w-7 h-7" src="{{ asset('storage/images/' . $game->homeTeam->image) }}" alt="">
                    @endif

                    @if ($game->homeTeam->id == $team->id)
                        <p class="text-red-800 mr-4">{{$game->homeTeam->name}}</p>
                    @else
                        <p class="mr-4">{{$game->homeTeam->name}}</p>
                    @endif
                    
                    @if ($game->start < now())
                        {{$results->where('game_id', $game->id)->first()['homeScore']}}
                    @endif -
                
                    @if ($game->start < now())
                        {{$results->where('game_id', $game->id)->first()['awayScore']}}
                    @endif
                    
                    @if ($game->awayTeam->id == $team->id)
                        <p class="text-red-800 ml-4">{{$game->awayTeam->name}}</p>
                    @else
                        <p class="ml-4">{{$game->awayTeam->name}}</p>
                    @endif
                    @if ($game->awayTeam->image == "placeholder")
                        <img class="w-7 h-7" src="https://thumbs.dreamstime.com/b/vector-logo-template-soccer-ball-color-91657652.jpg" alt="">
                    @else
                        <img class="w-7 h-7" src="{{ asset('storage/images/' . $game->awayTeam->image) }}" alt="">
                    @endif
                </div>
                <br>
                <p class="">{{$game->start}}</p>
                <hr class="border-1 border-gray-500 my-4">
            </li>
            @empty
            
                Nincsenek mérkőzések.
            @endforelse
        </ul>
    </div>
    <div>
        <h1>Játékosok</h1>
        <table class="table-auto w-full">
            <thead>
              <tr>
                <th class="px-4 py-2 text-left">Játékos</th>
                <th class="px-4 py-2 text-left">Születési év</th>
                <th class="px-4 py-2 text-left">Gólok</th>
                <th class="px-4 py-2 text-left">Öngólok</th>
                <th class="px-4 py-2 text-left">Sárga lapok</th>
                <th class="px-4 py-2 text-left">Piros lapok</th>
              </tr>
            </thead>
            <tbody>
              @foreach($players as $player)
              <tr class="border-b-2 border-gray-200 hover:bg-gray-100">
                <td class="px-4 py-2">{{ $player->name }}</td>
                <td class="px-4 py-2">{{ $player->birthdate }}</td>
                <td class="px-4 py-2">{{ count($events->where('player_id', $player->id)->where('type', 'gól')) }}</td>
                <td class="px-4 py-2">{{ count($events->where('player_id', $player->id)->where('type', 'öngól')) }}</td>
                <td class="px-4 py-2">{{ count($events->where('player_id', $player->id)->where('type', 'sárga lap')) }}</td>
                <td class="px-4 py-2">{{ count($events->where('player_id', $player->id)->where('type', 'piros lap')) }}</td>
              </tr>
              @endforeach
            </tbody>
          </table>
          
    </div>
</x-guest-layout>
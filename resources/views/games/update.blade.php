<x-guest-layout bg-gray-200>
    @if (auth()->user() != null && auth()->user()->is_admin)
        <h1>{{$game->id}} módosítása</h1>
        <form class="mt-4" action="{{route('games.update', ['game' => $game->id])}}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            Kezdési idő: 
            <input type="datetime-local" id="start" name="start" value="{{ $game->start->format('Y-m-d\TH:i') }}"><br>
            @error('start')
                {{ $message }}<br>
            @enderror
            Hazai csapat:
            <select class="mt-4" id="homeTeam" name="homeTeam">
                @foreach ($teams as $team)
                    @if ($team == $game->homeTeam)
                        <option selected value="{{$team->id}}">{{$team->name}}</option>
                    @else
                        <option value="{{$team->id}}">{{$team->name}}</option>
                    @endif
                @endforeach
            </select><br>
            @error('homeTeam')
                {{ $message }}<br>
            @enderror
            Vendég csapat:
            <select class="mt-4" id="awayTeam" name="awayTeam">
                @foreach ($teams as $team)
                    @if ($team == $game->awayTeam)
                        <option selected value="{{$team->id}}">{{$team->name}}</option>
                    @else
                        <option value="{{$team->id}}">{{$team->name}}</option>
                    @endif
                @endforeach
            </select><br>
            @error('awayTeam')
                {{ $message }}<br>
            @enderror
            <input type="hidden" name="which" value="frissit">
            <button  type="submit" class="mt-4 inline-block p-2 bg-sky-700 hover:bg-sky-900 text-white">Mentés</button>
        </form>
    @else
        
    @endif
    
</x-guest-layout>
<x-guest-layout bg-gray-200>
    @if (auth()->user() != null && auth()->user()->is_admin)
        <h1>Új meccs</h1>
        <form class="mt-4" action="{{route('games.store')}}" method="post" enctype="multipart/form-data">
            @csrf
            Kezdési idő: 
            <input type="datetime-local" id="start" name="start" value="{{ old('start') }}"><br>
            @error('start')
                {{ $message }}<br>
            @enderror
            Hazai csapat:
            <select class="mt-4" id="homeTeam" name="homeTeam" value="{{ old('homeTeam') }}">
                @foreach ($teams as $team)
                
                    <option value="{{$team->id}}">{{$team->name}}</option>
                
                @endforeach
            </select><br>
            @error('homeTeam')
                {{ $message }}<br>
            @enderror
            Vendég csapat:
            <select class="mt-4" id="awayTeam" name="awayTeam" value="{{ old('awayTeam') }}">
                @foreach ($teams as $team)
                
                    <option value="{{$team->id}}">{{$team->name}}</option>
                
                @endforeach
            </select><br>
            @error('awayTeam')
                {{ $message }}<br>
            @enderror
            <button  type="submit" class="mt-4 inline-block p-2 bg-sky-700 hover:bg-sky-900 text-white">Mentés</button>
        </form>
    @else
        
    @endif
    
</x-guest-layout>
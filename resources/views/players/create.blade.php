<x-guest-layout bg-gray-200>
    @if (auth()->user() != null && auth()->user()->is_admin)
        <h1>Új játékos a(z) {{$team->name}} csapatnak</h1>
        <form class="mt-4" action="{{route('players.store')}}" method="post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="team_id" id="team_id" value="{{$team->id}}">
            Név: 
            <input class="mb-4" type="text" id="name" name="name" value="{{old('name')}}"><br>
            @error('name')
                {{ $message }}<br>
            @enderror
            Mezszám:
            <input class="mb-4" type="text" id="number" name="number" value="{{old('number')}}"><br>
            @error('number')
                {{ $message }}<br>
            @enderror
            Születési idő:
            <input  type="date" id="birthdate" name="birthdate" value="{{ old('birthdate') }}"><br>
            @error('birthdate')
                {{ $message }}<br>
            @enderror
            <button  type="submit" class="mt-4 inline-block p-2 bg-sky-700 hover:bg-sky-900 text-white">Mentés</button>
        </form>
    @else
        
    @endif
    
</x-guest-layout>
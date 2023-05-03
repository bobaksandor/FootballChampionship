<x-guest-layout bg-gray-200>
    @if (auth()->user() != null && auth()->user()->is_admin)
        <h1>Új csapat</h1>
        <form class="mt-4" action="{{route('teams.store')}}" method="post" enctype="multipart/form-data">
            @csrf
            Csapatnév: 
            <input type="text" name="name" id="name" value="{{ old('name') }}"><br>
            @error('name')
                {{ $message }}<br>
            @enderror
            Rövid csapatnév(maximum 4 karakter):
            <input type="text" name="shortname" id="shortname" value="{{ old('shortname') }}"><br>
            @error('shortname')
                {{ $message }}<br>
            @enderror
            Kép:
            <input type="file" name="image" id="image"><br>
            @error('image')
                {{ $message }}<br>
            @enderror
            <button  type="submit" class="mt-4 inline-block p-2 bg-sky-700 hover:bg-sky-900 text-white">Mentés</button>
        </form>
    @else
        
    @endif
    
</x-guest-layout>
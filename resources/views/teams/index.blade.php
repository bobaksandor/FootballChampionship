<x-guest-layout bg-gray-200>
    @if (auth()->user() != null && auth()->user()->is_admin)
        <a class="ml-10 inline-block p-2 bg-sky-700 hover:bg-sky-900 text-white text-center" href="{{ route('teams.create') }}">Új csapat hozzáadása</a>
    @endif
    @forelse ($teams as $team)
        <a href="{{ route('teams.show', ['team' => $team->id]) }}">
                <li class="flex flex-col text-3xl text-center justify-center"> 
                    <div class="flex flex-row justify-center">
                        @if ($team->image == "placeholder")
                            <img class="w-10 h-10 mr-7" src="https://thumbs.dreamstime.com/b/vector-logo-template-soccer-ball-color-91657652.jpg" alt="">  
                        @else
                            <img class="w-10 h-10 mr-7" src="{{ asset('storage/images/' . $team->image) }}" alt="">    
                        @endif
                        
                        <p class="ml-7 mr-7">{{$team->name}}</p> 
                        <p class="ml-7">{{$team->shortname}}</p>
                        {{-- <p class="ml-7">{{$team->id}}</p> --}}
                    </div>
                    <div class="flex justify-center mt-5">
                        <a class="ml-10 inline-block p-2 bg-sky-700 hover:bg-sky-900 text-white wid w-1/5 justify-center" href="{{ route('teams.openEdit', ['team' => $team->id]) }}">Módosít</a>
                    </div>
                    <br>
                    
                    <hr class="border-1 border-gray-500 my-4">
                </li>
            </a>
        @empty
            Nincsenek csapatok.
        @endforelse
</x-guest-layout>
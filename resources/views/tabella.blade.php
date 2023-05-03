<x-guest-layout bg-gray-200>
    @php
        $counter = 1;
    @endphp
    <h1 class="text-center">Tabella</h1>
    <table class="table-auto w-full">
        <thead>
          <tr>
            <th class="px-4 py-2 text-left">Csapat</th>
            <th class="px-4 py-2 text-left">Lőtt gólok</th>
            <th class="px-4 py-2 text-left">Kapott gólok</th>
            <th class="px-4 py-2 text-left">Gól különbség</th>
            <th class="px-4 py-2 text-left">Pontszám</th>
            <th class="px-4 py-2 text-left">Helyezés</th>
          </tr>
        </thead>
        <tbody>
          @foreach($standings as $team)
          <tr class="border-b-2 border-gray-200 hover:bg-gray-100">
            <td class="px-4 py-2">{{ $team['name'] }}</td>
            <td class="px-4 py-2">{{ $team['scored'] ?? "" }}</td>
            <td class="px-4 py-2">{{ $team['conceded'] ?? "" }}</td>
            <td class="px-4 py-2">{{ $team['diff'] ?? ""}}</td>
            <td class="px-4 py-2">{{ $team['points'] ?? "" }}</td>
            <td class="px-4 py-2">{{ $counter }}</td>
            @php
                $counter++;
            @endphp
          </tr>
          @endforeach
        </tbody>
      </table>
</x-guest-layout>
<x-app-layout>
    <x-slot name="header">
        <h2 class="py-3 text-xl font-semibold leading-tight text-gray-800">
            Scorecards - {{ucfirst(auth()->user()->currentTeam->name)}}
        </h2>
    </x-slot>

    <div class="h-full mb-4 ml-48 mr-4 md:ml-48">
    {{-- @livewire('scorecards') --}}
    </div>


</x-app-layout>

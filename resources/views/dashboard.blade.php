<x-app-layout>
    <x-slot name="header">
        <h2 class="py-3 text-xl font-semibold leading-tight text-gray-800">
            DashBoard -  {{ucfirst(auth()->user()->currentTeam->name)}}
        </h2>
    </x-slot>



    <div class="h-full mt-4 ml-14 md:ml-48">

        {{-- <div class="px-4 py-4 m-4 overflow-hidden shadow-xl bg-gray-50 sm:rounded-lg">

            @livewire('scorecards')
        </div> --}}


        <div class="grid grid-cols-1 gap-4 p-4 lg:grid-cols-1">

            @livewire('components.dashboard.objective-progress')

            {{-- @livewire('components.dashboard.scorecard-statistics') --}}

        </div>

        @livewire('components.dashboard.team-users')
        <div class="grid grid-cols-2 gap-1 lg:grid-cols-2">



        </div>
        {{-- @livewire('components.dashboard.user-scorecard-statistics') --}}

        {{-- <div class="grid grid-cols-1 gap-4 p-4 lg:grid-cols-3">
            <div class="col-span-2">

                @livewire('components.dashboard.objective-progress')
            </div>
            @livewire('components.dashboard.latest-objectives')
        </div> --}}

        {{-- @livewire('components.dashboard.team-users') --}}

        {{-- <div class="p-4 "> --}}
            {{-- @livewire('components.dashboard.scorecard-statistics') --}}
        {{-- </div> --}}

        {{-- @livewire('components.dashboard.user-scorecard-statistics') --}}

    </div>
    @livewire('objectives')
        <div class="h-full mt-4 ml-14 md:ml-48">
            @livewire('components.dashboard.statics-cards')
        </div>



</x-app-layout>

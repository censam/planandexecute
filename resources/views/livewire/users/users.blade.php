    <x-app-layout>

        @if (auth()->user()->hasTeamPermission(auth()->user()->currentTeam,'user:read'))
        <x-slot name="header">
            <h2 class="py-3 text-xl font-semibold leading-tight text-gray-800">
                Users -  {{ucfirst(auth()->user()->currentTeam->name)}}
            </h2>
        </x-slot>
        <livewire:objectives/>
        {{-- <div class="h-full mt-4 ml-14 md:ml-48">
            <div class="px-4 py-4 m-4 mr-8 overflow-hidden bg-white shadow-xl sm:rounded-lg">
                <livewire:scorecards/>
            </div>
        </div> --}}


        @else
        <div class="bg-gradient-to-r from-blue-900 to-green-500">
            <div class="flex items-center justify-center w-9/12 min-h-screen py-16 m-auto">
            <div class="p-10 pb-8 overflow-hidden bg-white shadow sm:rounded-lg">
            <div class="pt-8 text-center border-t border-gray-200">
            <h1 class="font-bold text-purple-400 text-9xl">401</h1>
            <h1 class="py-8 text-6xl font-medium">Oops! Page not Authorized</h1>
            <p class="px-12 pb-8 text-2xl font-medium">Oops! The page you are looking for have not permission.</p>

            </div>
            </div>
            </div>
            </div>
        @endif

    </x-app-layout>

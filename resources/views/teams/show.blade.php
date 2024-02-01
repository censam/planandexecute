<x-app-layout>
    <x-slot name="header">
        <h2 class="py-3 text-xl font-semibold leading-tight text-gray-800">
            {{ __('Team Settings') }}
        </h2>
    </x-slot>
    {{-- {{env('Teams')}} --}}
    {{-- @dd($user->ownsTeam($team)) --}}
    {{-- @dd($user->hasTeamRole($team, 'admin'));
    @dd($user->teamRole($team)); --}}
    @php
        // auth()->user()->switchTeam($user->teams[0]);

    @endphp

    {{-- @dd($user->teams[0]); --}}
    <div>
        <div class="py-10 mx-auto max-w-7xl md:max-w-6xl lg:max-w-5xl sm:px-6 lg:px-8 ">
            @livewire('teams.update-team-name-form', ['team' => $team])

            @livewire('teams.team-member-manager', ['team' => $team])

            @if (Gate::check('delete', $team) && ! $team->personal_team)
                <x-jet-section-border />

                <div class="mt-10 sm:mt-0">
                    @livewire('teams.delete-team-form', ['team' => $team])
                </div>
            @endif
        </div>
    </div>
</x-app-layout>

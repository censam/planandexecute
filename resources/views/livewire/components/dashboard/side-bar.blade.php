<style>
    /* Compiled dark classes from Tailwind */
    .dark .dark\:divide-gray-700> :not([hidden])~ :not([hidden]) {
        border-color: rgba(55, 65, 81);
    }

    .dark .dark\:bg-gray-50 {
        background-color: rgba(249, 250, 251);
    }

    .dark .dark\:bg-gray-100 {
        background-color: rgba(243, 244, 246);
    }

    .dark .dark\:bg-gray-600 {
        background-color: rgba(75, 85, 99);
    }

    .dark .dark\:bg-gray-700 {
        background-color: rgba(55, 65, 81);
    }

    .dark .dark\:bg-gray-800 {
        background-color: rgba(31, 41, 55);
    }

    .dark .dark\:bg-gray-900 {
        background-color: rgba(17, 24, 39);
    }

    .dark .dark\:bg-red-700 {
        background-color: rgba(185, 28, 28);
    }

    .dark .dark\:bg-green-700 {
        background-color: rgba(4, 120, 87);
    }

    .dark .dark\:hover\:bg-gray-200:hover {
        background-color: rgba(229, 231, 235);
    }

    .dark .dark\:hover\:bg-gray-600:hover {
        background-color: rgba(75, 85, 99);
    }

    .dark .dark\:hover\:bg-gray-700:hover {
        background-color: rgba(55, 65, 81);
    }

    .dark .dark\:hover\:bg-gray-900:hover {
        background-color: rgba(17, 24, 39);
    }

    .dark .dark\:border-gray-100 {
        border-color: rgba(243, 244, 246);
    }

    .dark .dark\:border-gray-400 {
        border-color: rgba(156, 163, 175);
    }

    .dark .dark\:border-gray-500 {
        border-color: rgba(107, 114, 128);
    }

    .dark .dark\:border-gray-600 {
        border-color: rgba(75, 85, 99);
    }

    .dark .dark\:border-gray-700 {
        border-color: rgba(55, 65, 81);
    }

    .dark .dark\:border-gray-900 {
        border-color: rgba(17, 24, 39);
    }

    .dark .dark\:hover\:border-gray-800:hover {
        border-color: rgba(31, 41, 55);
    }

    .dark .dark\:text-white {
        color: rgba(255, 255, 255);
    }

    .dark .dark\:text-gray-50 {
        color: rgba(249, 250, 251);
    }

    .dark .dark\:text-gray-100 {
        color: rgba(243, 244, 246);
    }

    .dark .dark\:text-gray-200 {
        color: rgba(229, 231, 235);
    }

    .dark .dark\:text-gray-400 {
        color: rgba(156, 163, 175);
    }

    .dark .dark\:text-gray-500 {
        color: rgba(107, 114, 128);
    }

    .dark .dark\:text-gray-700 {
        color: rgba(55, 65, 81);
    }

    .dark .dark\:text-gray-800 {
        color: rgba(31, 41, 55);
    }

    .dark .dark\:text-red-100 {
        color: rgba(254, 226, 226);
    }

    .dark .dark\:text-green-100 {
        color: rgba(209, 250, 229);
    }

    .dark .dark\:text-blue-400 {
        color: rgba(96, 165, 250);
    }

    .dark .group:hover .dark\:group-hover\:text-gray-500 {
        color: rgba(107, 114, 128);
    }

    .dark .group:focus .dark\:group-focus\:text-gray-700 {
        color: rgba(55, 65, 81);
    }

    .dark .dark\:hover\:text-gray-100:hover {
        color: rgba(243, 244, 246);
    }

    .dark .dark\:hover\:text-blue-500:hover {
        color: rgba(59, 130, 246);
    }

    .active {
        color: rgba(55, 65, 81);
    }

    /* Custom style */
    .header-right {
        width: calc(100% - 3.5rem);
    }

    .sidebar:hover {
        width: 13rem;
    }

    .user-li:hover {
        width: 26rem;
    }

    @media only screen and (min-width: 768px) {
        .header-right {
            width: calc(100% - 16rem);
        }
    }

    /* width */
    ::-webkit-scrollbar {
        width: 10px;
    }

    /* Track */
    ::-webkit-scrollbar-track {
        background: #f1f1f1;
    }

    /* Handle */
    ::-webkit-scrollbar-thumb {
        background: rgba(30, 58, 138, .5);
    }

    /* Handle on hover */
    ::-webkit-scrollbar-thumb:hover {
        background: rgba(245, 158, 11, .5);
    }
</style>
<div
    class="fixed top-0 left-0 z-10 flex flex-col h-full text-white transition-all duration-300 bg-blue-900 border-none w-14 hover:w-64 md:w-48 dark:bg-gray-900 sidebar">
    <!-- Sidebar -->
    <div class="flex flex-col justify-between flex-grow overflow-x-hidden overflow-y-auto">
        <ul class="flex flex-col py-4 space-y-1">
            <li class="hidden px-5 md:block">
                <div class="flex flex-row items-center h-8 mb-3">
                    <div class="text-sm font-light font-extrabold tracking-wide text-gray-100 uppercase border-b-2">
                        Plan-And-Execute</div>
                </div>
            </li>

            <li>
                <a href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')"
                    class="{{ (request()->is('dashboard')) ? 'bg-blue-800 text-white-600 text-white-800 border-blue-500 ' : '' }}  relative flex flex-row items-center pr-6 border-l-4 border-transparent h-11 focus:outline-none hover:bg-blue-800 dark:hover:bg-gray-600 text-white-600 hover:text-white-800 hover:border-blue-500 dark:hover:border-gray-800">
                    <span class="inline-flex items-center justify-center ml-4">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                            </path>
                        </svg>
                    </span>
                    <span class="ml-2 text-sm tracking-wide truncate">{{ __('Dashboard') }}</span>
                </a>
            </li>

            <li class="mb-96">
                <a href="{{ route('objectives') }}" :active="request()->routeIs('objectives')"
                    class="{{ (request()->is('objectives')) ? 'bg-blue-800 text-white-600 text-white-800 border-blue-500 ' : '' }}  relative flex flex-row items-center pr-6 border-l-4 border-transparent h-11 focus:outline-none hover:bg-blue-800 dark:hover:bg-gray-600 text-white-600 hover:text-white-800 hover:border-blue-500 dark:hover:border-gray-800">
                    <span class="inline-flex items-center justify-center ml-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                        </svg>
                    </span>
                    <span class="ml-2 text-sm tracking-wide truncate">{{ __('Objectives') }}</span>
                </a>
            </li>



            <li class="hidden md:block">
                <div class="flex flex-row items-center h-8 p-5 mt-5 border-t border-b ">
                    <div class="text-sm font-light tracking-wide text-gray-100 uppercase ">Settings</div>
                </div>
            </li>

            <li>
                <a href="{{ route('profile.show') }}"
                    class="relative flex flex-row items-center pr-6 border-l-4 border-transparent h-11 focus:outline-none hover:bg-blue-800 dark:hover:bg-gray-600 text-white-600 hover:text-white-800 hover:border-blue-500 dark:hover:border-gray-800">
                    <span class="inline-flex items-center justify-center ml-4">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </span>
                    <span class="ml-2 text-sm tracking-wide truncate"> {{ __('Profile') }}</span>
                </a>
            </li>
            @if ($canEditTeam)
            <li>
                <a href="{{ route('teams.show', Auth::user()->currentTeam->id) }}"
                    class="relative flex flex-row items-center pr-6 border-l-4 border-transparent h-11 focus:outline-none hover:bg-blue-800 dark:hover:bg-gray-600 text-white-600 hover:text-white-800 hover:border-blue-500 dark:hover:border-gray-800">
                    <span class="inline-flex items-center justify-center ml-4">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                            </path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </span>
                    <span class="ml-2 text-sm tracking-wide truncate">Team Settings</span>
                </a>
            </li>
            @endif

            <li>
                <form method="POST" action="{{ route('current-team.update') }}">
                    @method('PUT')
                    @csrf

                    <!-- Hidden Team ID -->
                    <input type="hidden" name="team_id" value="{{ auth()->user()->personalTeam()->id }}">
                    <a href="#" onclick="event.preventDefault(); this.closest('form').submit();"
                        class="relative flex flex-row items-center pr-6 border-l-4 border-transparent h-11 focus:outline-none hover:bg-blue-800 dark:hover:bg-gray-600 text-white-600 hover:text-white-800 hover:border-blue-500 dark:hover:border-gray-800">
                        <span class="inline-flex items-center justify-center ml-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 16v2a2 2 0 01-2 2H5a2 2 0 01-2-2v-7a2 2 0 012-2h2m3-4H9a2 2 0 00-2 2v7a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-1m-1 4l-3 3m0 0l-3-3m3 3V3" />
                            </svg>
                        </span>
                        <span class="ml-2 text-sm tracking-wide truncate">Personal Team</span>
                    </a>
                </form>
            </li>


            {{-- <li class="mb-96">
            <a href="{{ route('scorecards') }}" :active="request()->routeIs('scorecards')"
            class="{{ (request()->is('scorecards')) ? 'bg-blue-800 text-white-600 text-white-800 border-blue-500 ' : '' }}
            relative flex flex-row items-center pr-6 border-l-4 border-transparent h-11 focus:outline-none
            hover:bg-blue-800 dark:hover:bg-gray-600 text-white-600 hover:text-white-800 hover:border-blue-500
            dark:hover:border-gray-800">
            <span class="inline-flex items-center justify-center ml-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                </svg>
            </span>
            <span class="ml-2 text-sm tracking-wide truncate">{{ __('Scorecards') }}</span>
            </a>
            </li> --}}

            @if ($canEditTeam)
            <li class="hidden md:block">
                <div class="flex flex-row items-center h-8 p-5 mt-5 border-t ">
                    <div class="text-sm font-light tracking-wide text-gray-100 uppercase ">Team Users</div>
                </div>
            </li>
            <li class="hidden md:block">
                <div class="flex flex-row items-center h-8 p-5 -mt-5 border-b">
                    <div class="text-xs font-light tracking-wide text-gray-100 uppercase ">( {{$current_team->name}} )</div>
                </div>
            </li>
            @foreach ($current_team->allUsers() as $user)

            <li class="user-li">
                <a href="{{ route('user.show',$user->id) }}" :active="request()->routeIs('user.show')"
                    class="{{ (request()->routeIs('user.show',$user->id) && (request()->route()->parameters['id']==$user->id)) ? 'bg-blue-800 text-white-600 text-white-800 border-blue-500 ' : '' }}  relative flex flex-row items-center pr-6 border-l-4 border-transparent h-8 focus:outline-none hover:bg-blue-800 dark:hover:bg-gray-600 text-white-600 hover:text-white-800 hover:border-blue-500 dark:hover:border-gray-800">
                    <span class="inline-flex items-center justify-center ml-4">
                        <img src="{{$user->profile_photo_url}}" class="inline object-cover w-6 h-6 mr-2 rounded-full "
                            alt="">
                    </span>
                    <span class="ml-2 text-sm tracking-wide capitalize truncate">{{$user->name}}</span>
                </a>
            </li>

            @endforeach

            @endif

        </ul>
        <p class="hidden px-5 py-3 mb-2 text-xs text-center md:block">Copyright @2021</p>
    </div>
    <!-- ./Sidebar -->
</div>

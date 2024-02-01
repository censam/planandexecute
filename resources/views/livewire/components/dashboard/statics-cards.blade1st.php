<div class="grid grid-cols-1 gap-6 p-4 sm:grid-cols-3 lg:grid-cols-3">


    {{-- teams card start --}}
    <div class="relative px-6 py-6 my-4 bg-white bg-red-100 shadow-xl rounded-3xl">
        <div class="absolute flex items-center px-4 py-4 text-white bg-red-500 rounded-full shadow-xl left-4 -top-6">
            <!-- svg  -->
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>

        </div>
        <div class="mt-5">
            <span
                class="inline-flex items-center w-10 px-4 py-0 text-center text-white bg-red-500 rounded-full shadow-xl left-4">
                {{$countTeams}}
            </span>
            <span class="my-2 text-xl font-semibold">{{Str::plural('Team', $countTeams)}}</span>

            <div class="my-2 border-t-2 border-white"></div>

            <div class="flex justify-between">
                <span class="w-4/6"></span>
                <span
                    class="w-2/6 px-5 py-1 text-xs font-extrabold text-center text-red-600 bg-red-300 rounded-full">Owner</span>
            </div>

            @foreach (auth()->user()->ownedTeams as $ownTeams)

            <div class="flex my-3 space-x-2 text-base text-gray-600">
                <!-- svg  -->
                <span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 " fill="none" viewBox="0 0 24 24"
                        stroke="gray">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </span>
                <div class="flex justify-between w-full">
                    <span class="w-4/6 text-sm">{{$ownTeams->name}} </span>
                    <span class="px-2 py-1 text-xs text-center text-gray-700 capitalize bg-white rounded-full">Super
                        Admin</span>
                </div>

            </div>

            @endforeach

            <div class="border-t-2 border-white"></div>

            <div class="flex justify-between">
                <span class="w-4/6"></span>
                <span
                    class="w-2/6 px-5 py-1 mt-3 text-xs font-extrabold text-center text-red-600 bg-red-300 rounded-full">Member</span>
            </div>

            @foreach (auth()->user()->teams as $teams)

            <div class="flex my-3 space-x-2 text-base text-gray-600">
                <!-- svg  -->
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 " fill="none" viewBox="0 0 24 24" stroke="gray">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                <div class="flex justify-between w-full">
                    <span class="w-5/6 text-sm font-thin">{{$teams->name}} </span>
                    <span
                        class="w-2/6 px-2 py-1 text-xs text-center text-gray-700 capitalize bg-white rounded-full">{{ Str::title(str_replace('_', ' ', $teams->membership->role)) }}</span>
                </div>

            </div>

            @endforeach

        </div>
    </div>
    {{-- teams card end --}}


    {{-- users card start --}}
    <div class="relative px-6 py-6 my-4 bg-white bg-green-100 shadow-xl rounded-3xl">
        <div class="absolute flex items-center px-4 py-4 text-white bg-green-500 rounded-full shadow-xl left-4 -top-6">
            <!-- svg  -->
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
            </svg>
        </div>
        <div class="mt-8">
            <span
                class="inline-flex items-center w-10 px-4 py-0 text-center text-white bg-green-500 rounded-full shadow-xl left-4">
                {{(auth()->user()->currentTeam->allUsers()->count())}}
            </span>
            <span class="my-2 text-xl font-semibold ">{{Str::plural('Member', auth()->user()->currentTeam->allUsers()->count())}}</span>
            <span class="float-right mt-2 text-xs font-semibold text-right">in <span
                    class="px-3 py-1 text-xs font-semibold text-center text-right text-red-700 bg-red-300 rounded-full">{{auth()->user()->currentTeam->name}}</span></span>
            <div class="my-2 border-t-2 border-white"></div>

            @foreach (Arr::shuffle(auth()->user()->currentTeam->allUsers()->toArray()) as $key => $teamMember)

            @if ($key < 6) <div class="inline-flex w-full px-2 py-1 text-left text-gray-600 bg-gray-100 rounded-md">
                <span class="w-1/6"> <img src="{{$teamMember['profile_photo_url']}}"
                        class="inline object-cover w-8 h-8 mr-2 border-2 rounded-full" alt=""> </span>
                <span class="w-3/6 text-sm font-thin">{{ucfirst($teamMember['name'])}}</span>
                <span class="w-2/6 h-6 px-2 py-1 mt-1 text-xs text-center bg-white rounded-full">
                    @if (isset($teamMember['membership']))
                    {{ Str::title(str_replace('_', ' ', $teamMember['membership']['role'])) }} @else Owner @endif
                </span>
        </div>
        @endif
        @endforeach

        @if (count(auth()->user()->currentTeam->allUsers()) > 6)
        <span class="text-xs text-right text-gray-600">{{count(auth()->user()->currentTeam->allUsers())-6}} more
            here...</span>
        @endif
    </div>






</div>
{{-- users card end --}}




{{-- objectives card start --}}
<div class="relative px-6 py-6 my-4 bg-white bg-yellow-100 shadow-xl rounded-3xl">
    <div class="absolute flex items-center px-4 py-4 text-white bg-yellow-500 rounded-full shadow-xl left-4 -top-6">
        <!-- svg  -->
        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
        </svg>
    </div>
    <div class="mt-8">
        <span
            class="inline-flex items-center w-10 px-4 py-0 text-center text-white bg-yellow-500 rounded-full shadow-xl left-4">
            {{$team_objectives_count}}
        </span>
        <span class="my-2 text-xl font-semibold ">{{Str::plural('Objective', $team_objectives_count)}}</span>
        <span class="float-right mt-2 text-xs font-semibold text-right">in <span
                class="px-3 py-1 text-xs font-semibold text-center text-right text-red-700 bg-red-300 rounded-full">{{auth()->user()->currentTeam->name}}</span></span>
        <div class="my-2 border-t-2 border-white"></div>

        <table class="w-full table-fixed">
            <thead>
                <tr
                    class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                    <th class="w-2/12 px-2 py-3">User</th>
                    <th class="px-2 py-3 md:w-1/12 xl:w-6/12">Name</th>
                    <th class="px-2 py-3 ">Due Date</th>

                </tr>
            </thead>
            <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                @if (count($latest_team_objectives ) >= 1)

                @foreach($latest_team_objectives as $objective)


                <tr
                    class="text-gray-700 bg-gray-50 dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-900 dark:text-gray-400">
                    <td class="w-1/6 px-2">
                        <div class="flex items-center text-sm">
                            <img src="{{ ucfirst($objective->user->profile_photo_url) }}"
                                class="inline object-cover w-8 h-8 mr-2 border-2 rounded-full" title="{{$objective->user->name}}">
                        </div>
                    </td>
                    <td class="px-2 py-3">
                        <div class="flex items-center text-sm truncate ">
                         {{ Str::limit($objective->name ,40)}}
                        </div>
                    </td>

                    <td class="w-1/12 px-2 py-3 text-xs text-center">



                @if($objective->completed!= '1')
                    @if (($objective->due_date) <= (date("Y-m-d h:i:s", strtotime("+2 day"))))
                    <span
                            class="px-2 py-1 text-xs font-semibold leading-tight text-red-700 bg-red-100 rounded-full dark:bg-red-700 dark:text-red-100">
                            {!! date('d-M-y', strtotime($objective->due_date)) !!} @if($objective->completed == '2') ** @endif</span>
                    @else
                            <span
                                class="px-2 py-1 font-semibold leading-tight text-yellow-700 bg-yellow-100 rounded-full dark:bg-yellow-700 dark:text-yellow-100">{!!
                                date('d-M-y', strtotime($objective->due_date)) !!} @if($objective->completed == '2') ** @endif </span>
                    @endif
                @else
                    <span class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100">Completed</span>
                @endif

                    </td>

                </tr>
                @endforeach

                @else
                <tr class="">
                    <td colspan="3">
                        <div class="w-full px-4 py-4 font-thin text-center bg-gray-100 rounded">No Objectives Found
                        </div>
                    </td>
                </tr>
                @endif


            </tbody>
        </table>
        @if ( $team_objectives_count > 4)
        <span class="py-4 text-xs text-right text-gray-600">latest 5 objectives here...</span><br>
        @endif
        <span class="py-4 text-xs text-left text-gray-600">In Progress noted with **</span>

    </div>
</div>
</div>

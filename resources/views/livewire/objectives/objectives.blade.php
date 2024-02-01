@if (request()->routeIs('objectives'))
<x-slot name="header">
    <div class="flex justify-between">

        <h2 class="py-3 text-xl font-semibold leading-tight text-gray-800">
            Manage Objectives - {{ucfirst(auth()->user()->currentTeam->name)}}
        </h2>
        @include('livewire.objectives.menu')
    </div>
</x-slot>
@elseif (request()->routeIs('due_objectives'))
<x-slot name="header">
<div class="flex justify-between">

    <h2 class="py-3 text-xl font-semibold leading-tight text-gray-800">
        Due Objectives - {{ucfirst(auth()->user()->currentTeam->name)}}
    </h2>
    @include('livewire.objectives.menu')
</div>
</x-slot>
@elseif (request()->routeIs('objectives.show'))
<x-slot name="header">
    <h2 class="py-3 text-xl font-semibold leading-tight text-gray-800">
        View Objective - {{ucfirst(auth()->user()->currentTeam->name)}}
    </h2>
</x-slot>
@endif


<div class="h-full mt-4 mb-10 ml-14 md:ml-44">
    <div class="mx-auto md:max-w-7xl sm:px-6 lg:px-8 lg:max-w-full">
        <div class="px-4 py-4 overflow-hidden bg-white shadow-xl sm:rounded-lg">

            @if (isset($objective_message['count']) && $objective_message['count'])
            <div class="text-white px-3 py-2 border-0 rounded relative mb-4 bg-{{$objective_message['color']}}-400">
                <span class="inline-block mr-5 text-xl align-middle">
                    <i class="fas fa-bell"></i>
                </span>
                <span class="inline-block mr-8 align-middle">
                    <p class="text-sm font-semibold">{!!$objective_message['message']!!}</p>
                </span>
                <button
                    class="absolute top-0 right-0 mt-2 mr-6 text-2xl font-semibold leading-none bg-transparent outline-none focus:outline-none">
                    <span wire:click="$set('objective_message','')">×</span>
                </button>
            </div>
            @elseif (isset($multiple_message['count']) && $multiple_message['count'])
            <div class="text-white px-3 py-2 border-0 rounded relative mb-4 bg-{{$multiple_message['color']}}-400">
                <span class="inline-block mr-5 text-xl align-middle">
                    <i class="fas fa-bell"></i>
                </span>
                <span class="inline-block mr-8 align-middle">
                    <p class="text-sm font-semibold">{!!$multiple_message['message']!!}</p>
                </span>
                <button
                    class="absolute top-0 right-0 mt-2 mr-6 text-2xl font-semibold leading-none bg-transparent outline-none focus:outline-none">
                    <span wire:click="$set('multiple_message','')">×</span>
                </button>
            </div>
            @endif
            @if($isKeyResultsProgomatic)
            @include('livewire.objectives.objective_change_popup')
            @endif

            @if (($loaded_route == 'objectives.show')||($loaded_route == 'due_objectives'))
            @else
            @include('livewire.objectives.actions_panel')
            @endif


            @if($isOpen && ($openType=='edit'))
            <div class="base-modal">
                @include('livewire.objectives.create')
            </div>
            @endif

            @if($isOpen && ($openType=='show'))
            <div class="base-modal">
                @include('livewire.objectives.show')
            </div>
            @endif


            @if($isOpen && ($openType=='review'))
            <div class="base-modal">
                @include('livewire.objectives.review', ['status' => 'review'])
            </div>
            @endif

            <div class="w-full overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr
                            class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                            <th class="w-48 px-4 py-3">Member</th>
                            <th class="px-4 py-3">Name</th>
                            <th class="px-4 py-3 truncate"></th>
                            <th class="px-4 py-3">Key Results</th>
                            <th class="px-4 py-3 text-center">Due Date</th>
                            <th class="px-4 py-3 text-center w-72">Action</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                        @if (count($objectives ) >= 1)

                        @foreach($objectives as $objective)

                        @if ($objective->team_id == auth()->user()->current_team_id)
                        <tr
                            class="text-gray-700 bg-gray-50 dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-900 dark:text-gray-400">
                            <td class="px-4 py-3">
                                <div class="flex items-center text-sm">
                                    {{-- {{ ucfirst($objective->id) }} --}}

                                    @if ($objective->objective_type == "1")
                                    <div class="-space-x-3">

                                        @foreach ($team_members as $key => $team_member)
                                        @if(in_array($team_member->id,explode(',',$objective->allowed_users)))
                                        <span x-data="{ tooltip: false }">
                                            <img x-on:mouseenter="tooltip = true" x-on:mouseleave="tooltip = false"
                                                class="inline object-cover w-10 h-10 border-2 border-blue-300 rounded-full "
                                                src="{{$team_member->profile_photo_url}}" alt="Profile image" />
                                            <div x-show="tooltip"
                                                class="absolute z-0 px-2 py-1 mt-1 font-semibold text-white uppercase bg-blue-300 border-blue-400 rounded-full shadow-lg border-1">
                                                {{$team_member->name}}
                                            </div>
                                        </span>
                                        @endif

                                        @endforeach
                                    </div>


                                    @else
                                    <span>
                                        <img src="{{ ucfirst($objective->user->profile_photo_url) }}"
                                            class="inline object-cover w-10 h-10 mr-2 border-2 border-yellow-300 rounded-full">

                                    </span>
                                    <div>
                                        {{ucwords($objective->user->name)}}
                                    </div>



                                    @endif
                                </div>
                            </td>
                            <td class="px-4 py-3 cursor-pointer" wire:click="show({{ $objective->id }})">
                                <div class="flex items-center text-sm ">
                                    {{ Str::limit($objective->name ,80)}}
                                </div>
                            </td>
                            <td class="px-4 py-3 text-sm ">
                                <livewire:components.chat-box :model="$objective" :wire:key="$objective->id" />
                            </td>

                            <td class="w-40 px-4 py-3 text-xs text-center ">
                                @if ($objective->other_key_results->count())
                                <span
                                    class="inline-flex items-center justify-center px-3 py-2 text-sm font-bold leading-none text-gray-100  {{($objective->completed_key_result_count==$objective->other_key_results->count())?'bg-green-500':'bg-pink-500'}}  rounded-full ">
                                    {{$objective->completed_key_result_count}} /
                                    {{$objective->other_key_results->count()}}
                                </span>
                                @else
                                <span
                                    class="inline-flex items-center justify-center px-3 py-2 text-sm font-bold leading-none text-gray-100 bg-gray-500 rounded-full ">
                                    0
                                </span>
                                @endif

                            </td>


                            <td class="px-4 py-3 text-xs text-center w-52">

                                <span class="block mb-1 text-xs font-semibold">{!! date('d-M-y',
                                    strtotime($objective->due_date)) !!}</span>
                                @if($objective->completed=='1')
                                <span
                                    class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100">Completed</span>
                                @elseif($objective->completed=='3')
                                <span
                                    class="px-2 py-1 font-semibold leading-tight text-red-700 bg-red-200 rounded-full dark:bg-red-700 dark:text-red-100">Missed</span>
                                @else
                                @if (($objective->due_date) <= (date("Y-m-d h:i:s", strtotime("+2 day")))) <span
                                    class="px-2 py-1 font-semibold leading-tight text-red-700 bg-red-100 rounded-full dark:bg-red-700 dark:text-red-100">
                                    {{ $objective->due_date->diffForHumans() }} @if($objective->completed == '2') **
                                    @endif</span>
                                    @else
                                    <span
                                        class="px-2 py-1 font-semibold leading-tight text-yellow-700 bg-yellow-100 rounded-full dark:bg-yellow-700 dark:text-yellow-100">{{ $objective->due_date->diffForHumans() }}
                                        @if($objective->completed == '2') ** @endif</span>
                                    @endif
                                    @endif


                            </td>
                            <td class="w-56 px-4 py-3 text-sm">
                                <div class="justify-between md:flex">
                                    @if($confirming===$objective->id)
                                    <button wire:click="confirmDelete(0)"
                                        class="px-1 my-1 text-green-500 transition duration-300 border border-green-500 rounded xl:px-1 md:px-1 hover:bg-green-600 hover:text-white focus:outline-none">No</button>

                                    <button wire:click="delete({{ $objective->id }})"
                                        class="px-1 text-white transition duration-300 bg-red-700 border border-red-700 rounded hover:bg-red-900 hover:text-white focus:outline-none">Sure?</button>
                                    @else

                                    @if ($objective->approved == 1)

                                    @if (($loaded_route=='objectives')||(!$isAdmin)||($loaded_route=='user.show'))
                                    <button wire:click="show({{ $objective->id }})"
                                        class="w-full px-1 py-1 mx-2 text-green-500 transition duration-300 border border-green-500 rounded xl:px-1 md:px-1 hover:bg-green-700 hover:text-white focus:outline-none">
                                        <svg wire:loading.delay wire:target="show({{ $objective->id }})"
                                            class="inline w-4 h-4 -ml-1 text-green-500 animate-spin"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                                stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor"
                                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                            </path>
                                        </svg>
                                        Show</button>
                                    @endif

                                    @if (($loaded_route=='objectives.show')&&($isAdmin))
                                    <button wire:click="show({{ $objective->id }})"
                                        class="w-full px-1 py-1 mx-2 text-green-500 transition duration-300 border border-green-500 rounded xl:px-1 md:1 hover:bg-green-600 hover:text-white focus:outline-none">
                                        <svg wire:loading.delay wire:target="show({{ $objective->id }})"
                                            class="inline w-4 h-4 -ml-1 text-green-500 animate-spin"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                                stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor"
                                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                            </path>
                                        </svg>
                                        Show</button>
                                    @endif


                                    @if((auth()->user()->id == $objective->user_id) || ($isAdmin))
                                    <button :key="{{$objective->id}}-edit0" wire:click="edit({{ $objective->id }})"
                                        class="w-full px-1 py-1 mx-2 text-blue-500 transition duration-300 border border-blue-500 rounded xl:px-1 md:px-1 hover:bg-blue-700 hover:text-white focus:outline-none">
                                        <svg wire:loading wire:target="edit({{ $objective->id }})"
                                            class="inline w-4 h-4 -ml-1 text-blue-500 animate-spin"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                                stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor"
                                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                            </path>
                                        </svg>
                                        Edit</button>
                                    @endif

                                    @else


                                    {{-- //review by user --}}
                                    <button wire:click="review({{ $objective->id }})"
                                        class="w-full px-1 mx-2 my-1 mr-1 text-black transition duration-300 bg-gray-200 border border-black rounded xl:px-1 md:px-1 hover:bg-black hover:text-white focus:outline-none">Review</button>

                                    @endif

                                    @if((auth()->user()->id == $objective->user_id) || ($isAdmin))
                                    <button wire:click="confirmDelete({{ $objective->id }})"
                                        class="px-1 py-1 mx-2 text-red-500 transition duration-300 border border-red-500 rounded xl:px-1 md:px-1 hover:bg-red-700 hover:text-white focus:outline-none">Delete</button>
                                    @endif
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @else
                        <tr class="">
                            <td colspan="6">
                                <div class="w-full px-4 py-4 font-semibold text-center bg-gray-100 rounded">Please
                                    Switch to the proper team to see this objective</div>
                            </td>
                        </tr>
                        @endif

                        @endforeach

                        @else
                        <tr class="">
                            <td colspan="6">
                                <div class="w-full px-4 py-4 font-semibold text-center bg-gray-100 rounded">No
                                    Objectives Found</div>
                            </td>
                        </tr>
                        @endif


                    </tbody>
                </table>
            </div>
            {{-- @if (isset($objectives->links())) --}}
            <div class="px-4 py-2">{{$objectives->links()}}</div>
            {{-- @endif --}}

        </div>
    </div>
</div>

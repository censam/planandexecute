<x-slot name="header">
    <div class="flex justify-between">
    <h2 class="py-3 text-xl font-semibold leading-tight text-gray-800">
        Archieved Objectives - {{ucfirst(auth()->user()->currentTeam->name)}}
    </h2>
    @include('livewire.objectives.menu')
    </div>
</x-slot>



<div class="h-full mt-4 mb-10 ml-14 md:ml-44">
    <div class="mx-auto md:max-w-7xl sm:px-6 lg:px-8 lg:max-w-full">
        <div class="px-4 py-4 overflow-hidden bg-white shadow-xl sm:rounded-lg">



            @if($isOpen && ($openType=='show'))
            <div class="base-modal">
                @include('livewire.objectives.show')
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
                            <th class="px-4 py-3 text-center">Deleted Date</th>
                            <th class="px-4 py-3 text-center w-72">Action</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                        @if (count($objectives ) >= 1)

                        @foreach($objectives as $objective)


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
                            <td class="px-4 py-3">
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
                                    strtotime($objective->deleted_at)) !!}</span>
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
                                        class="px-2 py-1 font-semibold leading-tight text-yellow-700 bg-yellow-100 rounded-full dark:bg-yellow-700 dark:text-yellow-100">{{ $objective->deleted_at->diffForHumans() }}
                                        @if($objective->completed == '2') ** @endif</span>
                                    @endif
                                    @endif


                            </td>
                            <td class="w-56 px-4 py-3 text-sm">
                                <div class="justify-between md:flex">


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


                                    @if ($isAdmin)
                                    <button wire:click="confirmObjectiveRestore({{ $objective->id }})"
                                        class="w-full px-1 py-1 mx-2 text-yellow-400 transition duration-300 border border-yellow-400 rounded xl:px-1 md:px-1 hover:bg-yellow-500 hover:text-white focus:outline-none">
                                        <svg wire:loading.delay wire:target="restore({{ $objective->id }})"
                                            class="inline w-4 h-4 -ml-1 text-yellow-400 animate-spin"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                                stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor"
                                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                            </path>
                                        </svg>
                                        Restore</button>
                                    @endif




                                    @if($isAdmin)
                                    <button wire:click="confirmObjectiveHardDelete({{ $objective->id }})"
                                        class="px-1 py-1 mx-2 text-red-500 transition duration-300 border border-red-500 rounded xl:px-1 md:px-1 hover:bg-red-700 hover:text-white focus:outline-none">Delete</button>
                                    @endif

                                </div>
                            </td>
                        </tr>




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

    {{-- //starting restore feature --}}
    @if ($isObjRestoreOpen)
    <div class="fixed z-30 overflow-hidden inset-1" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">

          <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" aria-hidden="true"></div>

          <!-- This element is to trick the browser into centering the modal contents. -->
          <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>


          <div class="absolute overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl right-1/3 top-1/4 sm:my-8 sm:align-middle sm:max-w-lg">
              <div class="px-4 pt-5 pb-4 bg-white sm:p-6 sm:pb-4">
                  <div class="sm:flex sm:items-start">
                      <div class="flex items-center justify-center flex-shrink-0 w-12 h-12 mx-auto bg-green-100 rounded-full sm:mx-0 sm:h-10 sm:w-10">
                          <!-- Heroicon name: outline/exclamation -->
                          <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                          </svg>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg font-medium leading-6 text-gray-900" id="modal-title">
                            Restore Objective
                        </h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500">
                                Are you sure you want to restore this objective?
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="px-4 py-3 bg-gray-50 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="button"  wire:click="restoreObjective({{$restoreConfirmedObjective}})" wire:loading.attr="disabled" class="inline-flex justify-center w-full px-4 py-2 text-base font-medium text-white bg-green-600 border border-transparent rounded-md shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:ml-3 sm:w-auto sm:text-sm">
                    Yes, Restore
                </button>
                <button type="button" wire:click="$set('isObjRestoreOpen', false)" wire:loading.attr="disabled" class="inline-flex justify-center w-full px-4 py-2 mt-3 text-base font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                    Cancel
                </button>
            </div>
        </div>
    </div>
    </div>
    @endif
    {{-- //ending restore feature --}}


    {{-- //starting hard delete feature --}}
    @if ($isObjHardDeleteOpen)
    <div class="fixed z-30 overflow-hidden inset-1" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">

          <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" aria-hidden="true"></div>

          <!-- This element is to trick the browser into centering the modal contents. -->
          <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>


          <div class="absolute overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl right-1/3 top-1/4 sm:my-8 sm:align-middle sm:max-w-lg">
              <div class="px-4 pt-5 pb-4 bg-white sm:p-6 sm:pb-4">
                  <div class="sm:flex sm:items-start">
                      <div class="flex items-center justify-center flex-shrink-0 w-12 h-12 mx-auto bg-red-200 rounded-full sm:mx-0 sm:h-10 sm:w-10">
                          <!-- Heroicon name: outline/exclamation -->
                          <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                          </svg>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg font-medium leading-6 text-gray-900" id="modal-title">
                            Delete Objective
                        </h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500">
                                Are you sure you want to delete this objective? Once an objective is deleted, all of its key results , nudges and its relevant data will be permanently deleted.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="px-4 py-3 bg-gray-50 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="button"  wire:click="hardDeleteObjective({{$hardDeleteConfirmedObjective}})" wire:loading.attr="disabled" class="inline-flex justify-center w-full px-4 py-2 text-base font-medium text-white bg-red-600 border border-transparent rounded-md shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                    Yes, Delete Permanently
                </button>
                <button type="button" wire:click="$set('isObjHardDeleteOpen', false)" wire:loading.attr="disabled" class="inline-flex justify-center w-full px-4 py-2 mt-3 text-base font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                    Cancel
                </button>
            </div>
        </div>
    </div>
    </div>
    @endif
    {{-- //ending hard delete feature --}}

</div>

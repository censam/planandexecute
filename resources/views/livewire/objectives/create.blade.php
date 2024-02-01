<div class="fixed inset-0 z-10 overflow-y-auto ease-out duration-400 ">
    <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity">
            <div class="absolute inset-0 bg-gray-500 opacity-100"></div>
        </div>
        <!-- This element is to trick the browser into centering the modal contents. -->
        <span style=" height: 100vh;overflow-y: hidden;" class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>
        <div class="inline-block w-3/6 overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl sm:my-8 sm:align-middle sm:max-w-lg-- sm:w-full--"
            role="dialog" aria-modal="true"  aria-labelledby="modal-headline">

            <div class="px-4 py-3 bg-gray-200 ">
                <div class="flex {{ $objective_id ? "" : "flow-root" }}">
                    @if ($objective_id)
                    <div class="w-4/12">
                        @if($current_objective->completed!=1)
                        @if (strpos(\Carbon\Carbon::parse($due_date)->diffForHumans(), 'ago') !== false)
                        <span
                            class="px-3 py-1 text-xs text-red-600 bg-red-200 rounded-full">{{ \Carbon\Carbon::parse($due_date)->diffForHumans() }}</span>
                        @else
                        <span
                            class="px-3 py-1 text-xs text-yellow-600 bg-yellow-200 rounded-full">{{ \Carbon\Carbon::parse($due_date)->diffForHumans() }}</span>
                        @endif
                        @else
                        <span class="px-3 py-1 text-xs text-green-700 bg-green-200 rounded-full">Completed</span>
                        @endif

                    </div>
                    <div class="w-1/12">
                        <button class="relative inline-flex rounded-md shadow-sm"  wire:click="openChat({{$current_objective->id}})" :key="$current_objective->id">

                            @if ($allCount>0)
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 opacity-80" viewBox="0 0 20 20" fill="green">
                              <path d="M2 5a2 2 0 012-2h7a2 2 0 012 2v4a2 2 0 01-2 2H9l-3 3v-3H4a2 2 0 01-2-2V5z" />
                              <path d="M15 7v2a4 4 0 01-4 4H9.828l-1.766 1.767c.28.149.599.233.938.233h2l3 3v-3h2a2 2 0 002-2V9a2 2 0 00-2-2h-1z" />
                            </svg>
                            @else
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="green">
                               <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z" />
                             </svg>
                            @endif

                              <svg  wire:loading.delay wire:target="openChat" class="absolute w-2 h-2 mt-1 ml-6 text-green animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="green" stroke-width="4"></circle>
                                <path class="opacity-75" fill="green" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                              </svg>
                        </button>
                    </div>
                    <div class="w-3/12">
                        <livewire:components.select-box hasTimeStamp='true' :options="$options"
                            :model="$current_objective" field="completed" :key="now()->timestamp" />
                    </div>

                    @endif

                    {{-- @if ($objective_id) --}}
                    <div class="text-right {{ $objective_id ? "w-7/12 " : "" }}">
                        <button wire:click.prevent="store()" type="button"
                            class="px-2 py-1 text-green-500 transition duration-300 border border-green-500 rounded w-44 hover:bg-green-600 hover:text-white focus:outline-none">
                            <svg  wire:loading wire:target="store" class="inline w-5 h-5 px-1 -ml-1 text-green-500 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                              </svg>
                            {{ $objective_id ? "Update Objective" : "Create" }}
                        </button>

                        <button wire:click="closeModal()" type="button"
                            class="px-3 py-1 text-gray-500 transition duration-300 border border-gray-500 rounded hover:bg-gray-600 hover:text-white focus:outline-none">
                            Cancel

                            <svg  wire:loading wire:target="closeModal" class="inline w-5 h-5 px-1 -ml-1 text-gray-500 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                              </svg>
                        </button>

                    </div>
                    {{-- @else
                        <button wire:click="closeModal()" type="button"
                                class="float-right px-3 py-1 text-gray-500 transition duration-300 border border-gray-500 rounded hover:bg-gray-600 hover:text-white focus:outline-none">
                                Cancel
                            </button>
                        @endif --}}
                </div>



            </div>

            <div class="px-4 pt-5 pb-4 bg-white sm:p-6 sm:pb-4">
                <div x-data={active:'primary'}>
                    <div class="flex justify-between mb-2">
                        <div>
                            <span @click="active = 'primary'" :class="{'bg-green-400': active === 'primary'}"
                                class="px-4 py-2 font-bold text-white bg-gray-300 hover:bg-gray-600 rounded-b-xl"
                                type="button">Primary</span>

                            <span @click="active = 'keyresults'" :class="{'bg-green-400': active === 'keyresults'}"
                                class="px-4 py-2 font-bold text-white bg-gray-300 hover:bg-gray-600 rounded-b-xl"
                                type="button">Key Results
                                @if (isset($current_objective->other_key_results))
                                <span class="px-2 font-semibold text-white bg-gray-700 rounded-full">
                                    {{count($current_objective->other_key_results)}}
                                </span>
                                @endif
                            </span>

                        </div>
                    </div>
                    <form>
                        <div>
                            <div x-show="active === 'primary'">
                                <form>
                                    <div class="">
                                        @if ($isAdmin)

                                        <div class="my-4">
                                            <label for="Objective Type"
                                                class="block mb-2 text-sm font-bold text-gray-700">Objective
                                                Type:</label>
                                                @if ($isCreate)
                                                    <select wire:model="objective_type" name="objective_type"
                                                        class="p-2 px-4 py-2 pr-8 leading-tight bg-white border border-gray-400 rounded shadow appearance-none hover:border-gray-500 focus:outline-none focus:shadow-outline">
                                                        <option value="0">Individual</option>
                                                        <option value="1"> Team</option>
                                                    </select>
                                                @elseif ($isEdit)
                                                {{ $objective_type == "1" ? "Team" : "Individual" }}
                                                @endif
                                        </div>

                                        @endif

                                        @if ($isAdmin)
                                            @if ($objective_type=='1')
                                                <div class="mb-4 ">
                                                    <label for="User"
                                                        class="block mb-2 text-sm font-bold text-gray-700"> Assigned Users:</label>
                                                    <div class="flex">
                                                        <div class="w-6/12">

                                                            @if ($isCreate)
                                                            <select wire:model="allowed_users" multiple  name="allowed_users" class="p-2 px-4 py-2 pr-8 leading-tight bg-white border border-gray-400 rounded shadow appearance-none hover:border-gray-500 focus:outline-none focus:shadow-outline">
                                                                <option value=''>Assign Multiple members</option>
                                                                @foreach($team_members as $key => $member)
                                                                <option value='{{$member->id}}'> {{ucwords($member->name)}}</option>
                                                                @endforeach
                                                             </select>
                                                            @error('allowed_user')
                                                            <span class="text-red-500">{{ $message }}</span>
                                                            @enderror


                                                            @endif

                                                            @if ($isEdit)
                                                            @foreach ($team_members as $key => $team_member)
                                                            @if(in_array($team_member->id,explode(',',$allowed_users)))
                                                            <span x-data="{ tooltip: false }">
                                                                <img x-on:mouseenter="tooltip = true" x-on:mouseleave="tooltip = false"  src="{{ $team_member->profile_photo_url }}"
                                                                class="inline object-cover w-10 h-10 mr-1 border-4 border-blue-300 rounded-full" >

                                                                <div x-cloak x-show="tooltip" class="absolute z-50 px-2 py-1 mt-1 font-semibold text-white uppercase bg-blue-500 border-2 border-blue-600 rounded-full">
                                                                   {{$team_member->name}}
                                                                  </div>
                                                                </span>
                                                            @endif

                                                            @endforeach
                                                            @endif

                                                        </div>

                                                        <div class="w-6/12">
                                                            @if ($isCreate)
                                                            {{-- <select class="py-1 uppercase bg-white rounded-md dark:bg-gray-800 dark:text-gray-300" name="timer" wire:model="timer">
                                                                <option value="">Select Time</option>
                                                                <option value="weekly">Weekly</option>
                                                                <option value="monthly">Monthly</option>
                                                                <option value="quarterly">Quarterly</option>
                                                                <option value="annual">Annual</option>
                                                            </select> --}}

                                                            @endif

                                                            @if ($isEdit)
                                                            {{-- <livewire:components.select-box hasTimeStamp='false' :options="$time_sort_options"
                                                            :model="$current_objective" field="timer" :key="now()->timestamp.'timer'" /> --}}

                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>

                                            @else
                                                <div class="mb-4 ">
                                                    <label for="User"
                                                        class="block mb-2 text-sm font-bold text-gray-700">User:</label>
                                                    <div class="flex">
                                                        <div class="w-6/12">
                                                            @if ($isCreate)
                                                            <livewire:components.users-dropdown field="user_id"
                                                                :owner="$user_id" />
                                                            @error('user_id') <span
                                                                class="text-red-500">{{ $message }}</span>@enderror
                                                            @endif

                                                            @if ($isEdit)
                                                            @foreach ($team_members as $key => $team_member)

                                                            @if($user_id==$team_member->id)
                                                            <span x-data="{ tooltip: false }">
                                                                <img x-on:mouseenter="tooltip = true" x-on:mouseleave="tooltip = false"  src="{{ $team_member->profile_photo_url }}"
                                                                class="inline object-cover w-10 h-10 mr-1 border-4 border-blue-300 rounded-full" >

                                                                <div x-cloak x-show="tooltip" class="absolute z-50 px-2 py-1 mt-1 font-semibold text-white uppercase bg-blue-500 border-2 rounded rounded-full border-graphite">
                                                                   {{$team_member->name}}
                                                                  </div>
                                                                </span>
                                                            @endif

                                                            @endforeach
                                                            @endif
                                                        </div>

                                                        <div class="w-6/12">
                                                            @if ($isCreate)
                                                            {{-- <select class="py-1 uppercase bg-white rounded-md dark:bg-gray-800 dark:text-gray-300" name="timer" wire:model="timer">
                                                                <option value="">Select Time</option>
                                                                <option value="weekly">Weekly</option>
                                                                <option value="monthly">Monthly</option>
                                                                <option value="quarterly">Quarterly</option>
                                                                <option value="annual">Annual</option>
                                                            </select> --}}

                                                            @endif

                                                            @if ($isEdit)
                                                            {{-- <livewire:components.select-box hasTimeStamp='false' :options="$time_sort_options"
                                                            :model="$current_objective" field="timer" :key="now()->timestamp.'timer'" /> --}}

                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        @endif


                                        <div class="mb-4">
                                            <label for="Name"
                                                class="block mb-2 text-sm font-bold text-gray-700">Name:</label>
                                            <input type="text"
                                                class="w-full px-3 py-2 leading-tight text-gray-700 border border-gray-200 rounded shadow appearance-none focus:bg-gray-100 focus:outline-none focus:shadow-outline"
                                                id="Name" placeholder="Enter Objective Name" wire:model.defer="name">
                                            @error('name') <span class="text-red-500">{{ $message }}</span>@enderror
                                        </div>
                                        <div class="mb-4">
                                            <label for="description"
                                                class="block mb-2 text-sm font-bold text-gray-700">Description:</label>
                                            <textarea rows="{{round(strlen($description)/60)}}" cols="50"
                                                class="w-full px-3 py-2 leading-tight text-gray-700 border border-gray-200 rounded shadow appearance-none focus:bg-gray-100 focus:outline-none focus:shadow-outline"
                                                id="description" wire:model.defer="description"
                                                placeholder="Enter Description"></textarea>
                                            @error('description') <span
                                                class="text-red-500">{{ $message }}</span>@enderror
                                        </div>
                                        <div class="mb-4">
                                            <label for="due_date" class="block mb-2 text-sm font-bold text-gray-700">Due
                                                Date:</label>
                                            <input type="date"
                                                class="w-full px-3 py-2 leading-tight text-gray-700 border border-gray-200 rounded shadow appearance-none focus:bg-gray-100 focus:outline-none focus:shadow-outline"
                                                id="due_date" placeholder="Enter Due Date" wire:model.defer="due_date">
                                            @error('due_date') <span class="text-red-500">{{ $message }}</span>@enderror
                                        </div>
                                        @if((isset($current_objective->completed))&&($current_objective->completed=='1'))
                                        <div class="mb-4">
                                            <label for="completed_note"
                                                class="block mb-2 text-sm font-bold text-gray-700">Completed
                                                Note:</label>
                                            <textarea rows="5" cols="5"
                                                class="w-full px-3 py-2 leading-tight text-gray-700 border border-gray-200 rounded shadow appearance-none focus:bg-gray-100 focus:outline-none focus:shadow-outline"
                                                id="completed_note" wire:model.defer="completed_note"
                                                placeholder="Enter Completed Note">
                                                </textarea>
                                            @error('completed_note') <span
                                                class="text-red-500">{{ $message }}</span>@enderror
                                        </div>
                                        @endif



                                    </div>

                            </div>
                            <div x-show="active === 'keyresults'">
                                <div class="mb-4" style="min-height: 200px">
                                    <label for="key_results" class="block mb-2 text-sm font-bold text-gray-700">Key
                                        results:</label>

                                    <livewire:components.key-result :objective="$current_objective" :objectiveTeammembers="$team_members"
                                        :key="now()->timestamp" viewtype="edit" />
                                </div>
                            </div>

                        </div>
                    </form>

                </div>

                <style>
                    body{
                    overflow: hidden;
                    background-color: rgb(202, 49, 49)
                    }

                    .base-modal{
                        height: 500px;
                        overflow: hidden;

                    }
                </style>
            </div>
        </div>

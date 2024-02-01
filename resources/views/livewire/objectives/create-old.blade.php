<div class="fixed inset-0 z-10 overflow-y-auto ease-out duration-400 ">
    <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity">
            <div class="absolute inset-0 bg-gray-500 opacity-100"></div>
        </div>
        <!-- This element is to trick the browser into centering the modal contents. -->
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>
        <div class="inline-block w-3/6 overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl sm:my-8 sm:align-middle sm:max-w-lg-- sm:w-full--"
            role="dialog" aria-modal="true" aria-labelledby="modal-headline">
            <form wire:submit.prevent="store">
                <div class="px-4 py-3 bg-gray-200">
                    <div class="flex">
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

                    <div class="w-3/12">
                        <livewire:components.select-box :options="$options" :model="$current_objective" field="completed" :key="now()->timestamp"/>
                        </div>

                        @endif

                        <div class="w-5/12  {{ $objective_id ? "text-right" : "text-left" }}">

                            <button wire:click.prevent="store()" type="button"
                                class="px-3 py-1 text-green-500 transition duration-300 border border-green-500 rounded w-44 hover:bg-green-600 hover:text-white focus:outline-none">
                                Save
                            </button>

                            <button wire:click="closeModal()" type="button"
                                class="px-3 py-1 text-gray-500 transition duration-300 border border-gray-500 rounded hover:bg-gray-600 hover:text-white focus:outline-none">
                                Cancel
                            </button>

                        </div>
                    </div>



                </div>

                <div class="px-4 pt-5 pb-4 bg-white sm:p-6 sm:pb-4">
                    <div class="">
                        @if ($isAdmin)
                        <div class="mb-4">
                            <label for="User" class="block mb-2 text-sm font-bold text-gray-700">User:</label>
                            <div class="w-6/12">
                               <livewire:components.users-dropdown  field="user_id" :owner="$user_id"/>
                               @error('user_id') <span class="text-red-500">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        @endif
                        <div class="mb-4">
                            <label for="Name" class="block mb-2 text-sm font-bold text-gray-700">Name:</label>
                            <input type="text"
                                class="w-full px-3 py-2 leading-tight text-gray-700 border border-gray-200 rounded shadow appearance-none focus:bg-gray-100 focus:outline-none focus:shadow-outline"
                                id="Name" placeholder="Enter Objective Name" wire:model.defer="name">
                            @error('name') <span class="text-red-500">{{ $message }}</span>@enderror
                        </div>
                        <div class="mb-4">
                            <label for="description"
                                class="block mb-2 text-sm font-bold text-gray-700">Description:</label>
                            <textarea rows="5" cols="50"
                                class="w-full px-3 py-2 leading-tight text-gray-700 border border-gray-200 rounded shadow appearance-none focus:bg-gray-100 focus:outline-none focus:shadow-outline"
                                id="description" wire:model.defer="description" placeholder="Enter Description"></textarea>
                            @error('description') <span class="text-red-500">{{ $message }}</span>@enderror
                        </div>
                        <div class="mb-4">
                            <label for="due_date" class="block mb-2 text-sm font-bold text-gray-700">Due Date:</label>
                            <input type="date"
                                class="w-full px-3 py-2 leading-tight text-gray-700 border border-gray-200 rounded shadow appearance-none focus:bg-gray-100 focus:outline-none focus:shadow-outline"
                                id="due_date" placeholder="Enter Due Date" wire:model.defer="due_date">
                            @error('due_date') <span class="text-red-500">{{ $message }}</span>@enderror
                        </div>
                        {{-- <div class="mb-4">
                            <label for="key_results" class="block mb-2 text-sm font-bold text-gray-700">Key
                                Results:</label>
                            <textarea rows="10" cols="50"
                                class="w-full px-3 py-2 leading-tight text-gray-700 border border-gray-200 rounded shadow appearance-none focus:bg-gray-100 focus:outline-none focus:shadow-outline"
                                id="key_results" wire:model.defer="key_results" placeholder="Enter Key Results">
                            </textarea>
                            @error('key_results') <span class="text-red-500">{{ $message }}</span>@enderror
                        </div>  --}}

                        <div class="mb-4">
                            <label for="key_results" class="block mb-2 text-sm font-bold text-gray-700">Key results:</label>
                            <livewire:components.key-result :objective="$current_objective" :key="now()->timestamp" viewtype="edit" />
                        </div>
                    </form> </div> </div> </div>

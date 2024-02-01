<div class="fixed inset-0 z-30 overflow-y-auto ease-out duration-400">
    <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity">
            <div class="absolute inset-0 bg-gray-500 opacity-100"></div>
        </div>
        <!-- This element is to trick the browser into centering the modal contents. -->
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>?
        <div class="inline-block w-3/6 overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl sm:my-8 sm:align-middle sm:max-w-lg-- sm:w-full--" role="dialog" aria-modal="true" aria-labelledby="modal-headline">

                <div class="px-4 py-3 bg-gray-200">
                    <div class="flex justify-between">
                        <div>
                        @if($completed!='1')
                            @if (strpos(\Carbon\Carbon::parse($due_date)->diffForHumans(), 'ago') !== false)
                                <span class="px-3 py-1 text-xs text-red-600 bg-red-200 rounded-full">{{ \Carbon\Carbon::parse($due_date)->diffForHumans() }}</span>
                            @else
                            <span class="px-3 py-1 text-xs text-yellow-600 bg-yellow-200 rounded-full">{{ \Carbon\Carbon::parse($due_date)->diffForHumans() }}</span>
                            @endif
                        @else
                            <span class="px-3 py-1 text-xs text-green-700 bg-green-200 rounded-full">Completed</span>
                        @endif
                        </div>

                        @if (!$current_objective->trashed())
                        <button class="relative inline-flex rounded-md shadow-sm"  wire:click="openChat({{$current_objective->id}})" :key="$current_objective->id">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="green">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z" />
                            </svg>

                            <svg  wire:loading.delay wire:target="openChat" class="absolute w-2 h-2 mt-1 ml-6 text-green animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="green" stroke-width="4"></circle>
                                <path class="opacity-75" fill="green" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>

                            {{-- @if ($unreadCount)
                              <span class="absolute top-0 right-0 flex w-4 h-4 -mt-1">
                                  <span class="absolute inline-flex w-full h-full bg-green-400 rounded-full opacity-60 animate-ping"></span>
                                <span class="relative inline-flex w-3 h-3 text-white bg-green-500 rounded-full px"></span>
                            </span>
                            @else
                            @endif --}}
                        </button>
                        @endif

                        <div>
                            <button wire:click="closeModal()" type="button" class="px-3 py-1 text-gray-500 transition duration-300 border border-gray-500 rounded hover:bg-gray-600 hover:text-white focus:outline-none">
                                <svg  wire:loading wire:target="closeModal" class="inline w-4 h-4 -ml-1 text-blue-500 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                  </svg>
                                Cancel
                            </button>
                        </div>
                      </div>



                </div>
                <div class="px-4 pt-5 pb-4 bg-white sm:p-6 sm:pb-4">
                    <div class="">
                        <div class="mb-4">


                            <label for="Name" class="block mb-2 text-lg font-semibold text-gray-700">Name:</label>
                            <div class="my-3 text-gray-700">{{$name}}</div>

                        </div>
                        <div class="mb-4">
                            <label for="description" class="block mb-2 text-lg font-semibold text-gray-700">Description:</label>
                            <div class="my-3 text-gray-700">{!!nl2br($description)!!}</div>

                        </div>
                        <div class="mb-4">
                            <label for="due_date" class="block mb-2 text-lg font-semibold text-gray-700">Due Date:</label>
                            <div class="my-3 text-gray-700">{{$due_date}}</div>

                        </div>
                        <div class="mb-4">
                            {{-- <label for="key_results" class="block mb-2 text-lg font-semibold text-gray-700">Key Results:</label> --}}
                            {{-- <div class="my-3 text-gray-700">{{$key_results}}</div> --}}

                        </div>

                        <div class="mb-4">
                            <livewire:components.key-result :objective="$current_objective" :key="now()->timestamp" viewtype="show" />
                        </div>

                    </div>
                </div>







        </div>
    </div>
</div>

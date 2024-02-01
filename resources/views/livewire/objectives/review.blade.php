<div class="fixed inset-0 z-30 overflow-y-auto ease-out duration-400">
    <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity">
            <div class="absolute inset-0 bg-gray-500 opacity-100"></div>
        </div>
        <!-- This element is to trick the browser into centering the modal contents. -->
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>?
        <div class="inline-block w-3/6 overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl sm:my-8 sm:align-middle sm:max-w-lg-- sm:w-full--" role="dialog" aria-modal="true" aria-labelledby="modal-headline">
            <form>
                <div class="px-4 py-3 bg-gray-200">
                    <div class="flex justify-between">
                        <div>
                            @if (strpos(\Carbon\Carbon::parse($due_date)->diffForHumans(), 'ago') !== false)
                                <span class="px-3 py-1 text-xs text-red-600 bg-red-200 rounded-full">{{ \Carbon\Carbon::parse($due_date)->diffForHumans() }}</span>
                            @else
                                <span class="px-3 py-1 text-xs text-yellow-600 bg-yellow-200 rounded-full">{{ \Carbon\Carbon::parse($due_date)->diffForHumans() }}</span>
                            @endif
                        </div>
                        @if((isset($status)) && ($status=='review'))
                        {{-- {{$status}} --}}
                        @endif
                        <div>
                            <button wire:click="closeModal()" type="button" class="px-3 py-1 text-gray-500 transition duration-300 border border-gray-500 rounded hover:bg-gray-600 hover:text-white focus:outline-none">
                                Cancel
                            </button>
                        </div>
                      </div>



                </div>
                <div class="px-4 pt-5 pb-4 bg-white sm:p-6 sm:pb-4">
                   <div x-data={active:'original'}>
                       <div class="flex justify-between mb-2">
                       <div>
                           <span @click="active = 'original'" class="px-4 py-2 font-bold text-white bg-green-300 hover:bg-green-600 rounded-b-3xl" type="button">Original</span>
                           @if (isset($current_objective->sub_objectives[0]))
                            <span @click="active = 'edited'" class="px-4 py-2 font-bold text-white bg-gray-300 hover:bg-gray-600 rounded-b-3xl" type="button" >Edited</span>
                           @endif
                        </div>

                       @if ($isAdmin)
                       <div class="inline-flex">
                        @if (isset($current_objective->sub_objectives[0]))
                        <span wire:click="keepOriginal({{$current_objective->id}})" class="h-10 px-4 py-2 mr-1 font-bold text-white bg-green-300 rounded hover:bg-gray-600" type="button" >Keep Original</span>
                        <span wire:click="keepEdited({{$current_objective->sub_objectives[0]->id}})" class="h-10 px-4 py-2 mr-1 font-bold text-white bg-gray-200 rounded hover:bg-gray-600" type="button" >Keep Edited</span>

                        @endif
                        </div>
                       @endif

                       </div>
                       <div>
                           <div x-show="active === 'original'">
                                @include('livewire.objectives.review_objective',['objective' => $current_objective,'color'=>'green'])
                            </div>
                           <div x-show="active === 'edited'">
                               @if (isset($current_objective->sub_objectives[0]))
                               @include('livewire.objectives.review_objective',['objective' => $current_objective->sub_objectives[0],'color'=>'gray'])
                               @endif
                            </div>

                       </div>

                       <div class="mb-4">
                        <livewire:components.key-result :objective="$current_objective" :key="now()->timestamp" viewtype="show" />
                    </div>

                   </div>


                </div>

            </form>
        </div>
    </div>
</div>

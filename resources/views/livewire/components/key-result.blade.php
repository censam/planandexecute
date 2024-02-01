<div>

    @if ($viewtype == 'show')

    <div class="mb-2">
        <hr>
    </div>

    @if (count($objective->other_key_results) > 0 )
    <div class="p-2 mb-2 font-semibold text-center text-gray-100 bg-gray-500 rounded-md">
        Key Results

        @if($objective->completed_key_result_count)

            @if ($objective->other_key_results->count())
            <span class="-mt-1 float-right inline-flex items-center justify-center px-3 py-2 text-sm font-bold leading-none text-gray-100  {{($objective->completed_key_result_count==$objective->other_key_results->count())?'bg-green-500':'bg-pink-500'}}  rounded-full ">
                {{$objective->completed_key_result_count}} / {{$objective->other_key_results->count()}}
            </span>
            @else
            <span class="inline-flex items-center justify-center float-right px-3 py-2 -mt-1 text-sm font-bold leading-none text-gray-100 bg-gray-500 rounded-full ">
                0
            </span>
            @endif
        @endif

    </div>
    @if (count($objective->other_key_results) > 0 )
    @foreach ($objective->other_key_results as $key_result)


    <div class="inline-flex w-full px-2 m-2 text-sm align-middle {{($highlight_id==$key_result->id)?' animate-pulse border-4 rounded border-green-200 p-3 ':''}} ">
        <span class="w-8"><svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                stroke="gray">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </span>
        <span class="w-10/12 px-2 text-gray-700"> {!!nl2br($key_result->content)!!} </span>
        @if ($key_result->assigned_user)
        <span class="w-48 px-2 py-1 pt-1 mr-2 text-xs text-center capitalize bg-blue-500 rounded-full text-gray-50"> {{($key_result->assigned_user)?$key_result->assigned_user->name:''}} </span>
        @else
        <span class="w-48"></span>
        @endif
        <span class="mt-2 text-xs w-36">
            @if($key_result->due_date)
            @if (strpos(\Carbon\Carbon::parse($key_result->due_date)->diffForHumans(), 'ago') !== false)
            <span class="px-3 py-1 text-xs text-red-600 bg-red-200 rounded-full">{!! date('d-M-y',
                strtotime($key_result->due_date)) !!}</span>
            @else
            <span class="px-3 py-1 text-xs text-yellow-600 bg-yellow-200 rounded-full">{!! date('d-M-y',
                strtotime($key_result->due_date)) !!}</span>
            @endif
            @else
            <span class="w-32 px-2 py-1 mt-1 text-xs bg-gray-400 rounded-full text-gray-50">No Due Date</span>
            @endif
        </span>


        <span class="float-right w-8 ">
        @if ($key_result->assign_user_id == auth()->user()->id)
        <span class="-mt-2">
        <livewire:components.toggle-button :model="$key_result" field='completed' on="Done" off="" color="green"
                width="10" :key="time().$key_result->id" />
            </span>
        @else
            @if ($key_result->completed)
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="#79f98f80" viewBox="0 0 24 24" stroke="#19bd3580">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            @else
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="gray">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M8 12h.01M12 12h.01M16 12h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            @endif
            @endif
        </span>
    </div> <br>
    @endforeach
    @endif
    @else
    <p class="p-2 font-semibold text-center text-gray-100 bg-gray-500 rounded-md h2 border-1">Key Results Not Added Here
    </p>
    @endif

    @endif


    @if ($viewtype == 'edit')

    <div>

        <div class="mb-3">

            @if (isset($objective->id))
            <div x-data x-init="$refs.addKeyResult.focus()">
                <form >
                    <input placeholder="Add a Key Result and Hit Enter"
                        class="w-full px-3 py-2 leading-tight text-gray-700 placeholder-gray-500 border border-gray-200 rounded shadow appearance-none focus:bg-gray-100 placeholder-opacity-60 focus:outline-none focus:shadow-outline"
                        type="text" name="content" wire:model.defer="content" wire:keydown.enter="addKeyResult"
                        x-ref="addKeyResult">
            </div>
            <input class="flex-1 w-7/12 p-2 mr-2 border border-gray-300 rounded" value="{{$objective->id}}"
                type="hidden" name="objective_id" wire:model.defer="objective_id">
            </form>
            @else

            <p
                class="p-2 text-sm font-semibold text-center text-gray-100 bg-green-500 rounded-md h2 border-1">
                First Complete Primary Tab Form Fields and Click 'Create', Then add key results Here</p>
            @endif

            {{-- <button wire:click.prevent="addKeyResult()" type="button"
                    class="px-3 py-1 text-green-500 transition duration-300 border border-green-500 rounded hover:bg-green-600 hover:text-white focus:outline-none">
                    Add a Key Result
                </button> <br> --}}

            @error('content') <span class="text-red-500 ">{{ $message }}</span>@enderror
        </div>

        <div>

            @if ($isKeyResultOpen)
            <div class="fixed z-30 overflow-hidden inset-1" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">

                  <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" aria-hidden="true"></div>

                  <!-- This element is to trick the browser into centering the modal contents. -->
                  <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>


                  <div class="absolute overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl ml-28 top-1/4 sm:my-8 sm:align-middle sm:max-w-lg">
                      <div class="px-4 pt-5 pb-4 bg-white sm:p-6 sm:pb-4">
                          <div class="sm:flex sm:items-start">
                              <div class="flex items-center justify-center flex-shrink-0 w-12 h-12 mx-auto bg-red-100 rounded-full sm:mx-0 sm:h-10 sm:w-10">
                                  <!-- Heroicon name: outline/exclamation -->
                                  <svg class="w-6 h-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-lg font-medium leading-6 text-gray-900" id="modal-title">
                                    Delete Key Result
                                </h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500">
                                        Are you sure you want to delete this key result?
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="px-4 py-3 bg-gray-50 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="button"  wire:click="delete({{$deleteConfirmedKeyResult}})" wire:loading.attr="disabled" class="inline-flex justify-center w-full px-4 py-2 text-base font-medium text-white bg-red-600 border border-transparent rounded-md shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                            Yes, Delete
                        </button>
                        <button type="button" wire:click="$set('isKeyResultOpen', false)" wire:loading.attr="disabled" class="inline-flex justify-center w-full px-4 py-2 mt-3 text-base font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
            </div>
            @endif



            @if (isset($objective->id) && (count($objective->other_key_results) > 0 ))


            @foreach ($objective->other_key_results as $key_result)

            <div class="inline-flex w-full px-2 mb-2 text-sm">
                <span class="w-8 mt-2" wire:click="confirmKeyResultDelete({{$key_result->id}})" wire::key="{{$key_result->id}}-kr">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 cursor-pointer" fill="none"
                        viewBox="0 0 24 24" stroke="red">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </span>

                {{-- <span class="w-8 mt-2" wire:click="delete({{$key_result->id}})">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 cursor-pointer" fill="none"
                        viewBox="0 0 24 24" stroke="red">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </span> --}}


                <span class="w-8 mt-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 cursor-move" fill="none" viewBox="0 0 24 24"
                        stroke="gray">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </span>

                <div class="w-8/12 font-bold text-gray-700">

                    <livewire:components.inline-edit :model="'\App\Models\KeyResult'" :entity="$key_result"
                        :field="'content'" :key="'key_result'.$key_result->id" />
                </div>
                <span class="w-44 text-xs font-light mt-3.5 ">
                    <livewire:components.date-picker :model="'\App\Models\KeyResult'" :entity="$key_result"
                        :field="'due_date'" :key="'date-picker'.$key_result->id" />
                </span>
                @if ($objective->objective_type==1)
                <span class="w-4/12 text-xs font-light mt-2.5 mr-2">
                    @php
                    $objective_users = array('Assign User');
                    foreach (auth()->user()->currentTeam->allUsers() as $assign_user){
                    if(in_array($assign_user->id,explode(',',$objective->allowed_users))){
                    $objective_users[$assign_user->id] = $assign_user->name;
                    }
                    }
                    @endphp
                    <livewire:components.select-box :options="$objective_users" :model="$key_result"
                        field="assign_user_id" :key="'assign_user_id_'.now()->timestamp" />
                    @endif
                </span>
                <span class="w-8 mt-1">
                    <livewire:components.toggle-button :model="$key_result" field='completed' on="" off="" color="green"
                        width="12" :key="time().$key_result->id" />
                </span>

            </div>
            @endforeach
            @endif
        </div>
    </div>
</div>
@endif






</div>

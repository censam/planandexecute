<div>
    @if ($viewtype == 'show')

    <h1>Show ScoreCard History</h1>

    @endif


    @if ($viewtype == 'edit')

    <div>
        <div class="mb-3">

            <div x-data x-init="$refs.addScoreCardHistory.focus()">
                @if ($isAdmin)
                <form wire:submit.prevent="addScoreCardHistory">
                    <input placeholder="Add a Record and Hit Enter"
                    class="w-full px-3 py-2 leading-tight text-gray-700 placeholder-gray-500 border border-gray-200 rounded shadow appearance-none focus:bg-gray-100 placeholder-opacity-60 focus:outline-none focus:shadow-outline"
                    type="text" name="note" wire:model.defer="note" wire:keydown.enter=""
                    x-ref="addScoreCardHistory">
                    <input class="flex-1 w-7/12 p-2 mr-2 border border-gray-300 rounded" value="{{$scorecard->id}}" type="hidden" name="scorecard_id" wire:model.defer="scorecard_id">
                </form>
                @endif
            </div>


            {{-- <button wire:click.prevent="addScoreCardHistory()" type="button"
                class="px-3 py-1 text-green-500 transition duration-300 border border-green-500 rounded hover:bg-green-600 hover:text-white focus:outline-none">
                Add a Key Result
            </button> --}}
            <br>

            @error('note') <span class="text-red-500 ">{{ $message }}</span>@enderror
        </div>

        <div id="scorecard-history">

            @if (session()->has('scorecard_history_msg'))
            <div class="absolute px-2 py-2 text-red-700 bg-red-100 border border-red-400 rounded left-1/2" role="alert">
                <span class="block sm:inline">{{ session('scorecard_history_msg') }}.</span>
            </div>
            @endif


            @foreach ($scorecard->histories as $history)

            <div class="inline-flex w-full px-2 mb-2 text-sm">
                @if ($isAdmin)
                <span class="w-8 mt-2" wire:click="delete({{$history->id}})">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 cursor-pointer" fill="none"
                        viewBox="0 0 24 24" stroke="red">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </span>
                @endif


                <span class="w-8 mt-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 cursor-move" fill="none" viewBox="0 0 24 24"
                        stroke="gray">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </span>

                <div class="w-8/12 font-bold text-gray-700">

                    <livewire:components.inline-edit :model="'\App\Models\ScorecardHistory'" :entity="$history"
                        :field="'note'" :key="'history'.$history->id" />
                </div>
                <span class="w-44 text-xs font-light mt-3.5 ">
                    <livewire:components.date-picker :model="'\App\Models\ScorecardHistory'" :entity="$history"
                        :field="'due_date'" :key="'date-picker'.$history->id" />
                </span>

                <span class="w-8 mt-1">
                    <livewire:components.toggle-button :model="$history" field='completed' on="" off="" color="green"
                        width="12" :key="time().$history->id" />
                </span>

            </div>
            @endforeach
        </div>

    </div>

    @endif

</div>

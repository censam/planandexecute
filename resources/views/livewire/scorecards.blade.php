<div x-data="{ list: false }">
    <div>

        @if (isset($scorecard_message['count']) && $scorecard_message['count'])
            <div class="text-white px-3 py-2  mt-4 mx-4 border-0 rounded relative mb-2 bg-{{$scorecard_message['color']}}-400">
                <span class="inline-block mr-5 text-xl align-middle">
                  <i class="fas fa-bell"></i>
                </span>
                <span class="inline-block mr-8 align-middle">
                    <p class="text-sm font-semibold">{!!$scorecard_message['message']!!}</p>
                </span>
                <button class="absolute top-0 right-0 mt-2 mr-6 text-2xl font-semibold leading-none bg-transparent outline-none focus:outline-none">
                  <span wire:click="$set('scorecard_message','')">×</span>
                </button>
              </div>
        @endif


        <div class="flex items-center justify-between px-4 ">

            <livewire:scorecards.create />



            @if($isOpen && ($openType=='edit'))
                @include('livewire.scorecards.edit')
            @endif


            <span>
                <select class="py-1 uppercase bg-white rounded-md dark:bg-gray-800 dark:text-gray-300"
                    name="sortingTimer" wire:model="sortingTimer">
                    <option value="all" selected="selected">All</option>
                    <option value="weekly">Weekly</option>
                    <option value="bi-weekly">Bi-Weekly</option>
                    <option value="monthly">Monthly</option>
                    <option value="quarterly">Quarterly</option>
                    <option value="annual">Annual</option>
                </select>

                <select class="py-1 uppercase bg-white rounded-md dark:bg-gray-800 dark:text-gray-300" name="sorting"
                    wire:model="sorting">
                    <option value="all" selected="selected">Due Range</option>
                    <option value="weekly">Due in This Week</option>
                    <option value="monthly">Due in This Month</option>
                    <option value="quarterly">Due in This Quarter</option>
                    <option value="annual">Due in This Year</option>
                </select>


                <button
                    class="flex items-center float-right w-16 h-8 mx-3 transition duration-300 bg-white rounded-full shadow focus:outline-none"
                    x-on:click="list = ! list">
                    <div id="switch-toggle"
                        class="relative p-1 text-white transition duration-500 transform -translate-x-2 rounded-full"
                        :class="list ? 'bg-yellow-500 ml-10' : 'bg-green-500'">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" :class="list ? 'hidden' : ''"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                        </svg>

                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" :class="list ? '' : 'hidden'"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                        </svg>
                    </div>
                </button>


            </span>

        </div>

    </div>


    @if (count($scoreCards) > 0 )
    <div id="scorecard-main" class="ml-4" :class="list ? '' : 'grid grid-cols-2'">
        @foreach ($scoreCards as $eachScoreCard)
        <div class="mt-4 mr-4">
            @include('livewire.scorecards.simple-scorecard')
        </div>
        @endforeach
    </div>
    @else
    <div class="px-2 py-4 m-5 font-semibold text-center rounded bg-gray-50 ">No Scorecards Found</div>
    @endif
    <div class="px-4 py-2">{{$scoreCards->links()}}</div>
</div>

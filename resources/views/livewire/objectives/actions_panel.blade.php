<div class="flex items-center justify-between">
    <button wire:click="create()" class="px-4 py-2 my-3 font-bold text-white bg-blue-500 rounded hover:bg-blue-700">
        <svg  wire:loading.delay wire:target="create" class="inline w-4 h-4 -ml-1 text-white animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
          </svg>
        Create New Objective
    </button>

    {{-- <input type="text" wire:model.debounce.300ms="search" name="search" id="search" class="w-1/3 py-1 placeholder-gray-400 uppercase bg-white rounded-md dark:bg-gray-800 dark:text-gray-500" autocomplete="off" placeholder="search"> --}}

    <div class="relative w-1/3 pt-2 mx-auto text-gray-600">
            <input autocomplete="off" wire:model.debounce.300ms="search" class="w-full h-10 px-5 pr-16 text-sm bg-white border-2 border-gray-400 rounded-lg focus:outline-none"
            type="search" name="search" placeholder="Search">
            <button type="submit" class="absolute top-0 right-0 mt-5 mr-4">
              <svg class="w-4 h-4 text-gray-600 fill-current" xmlns="http://www.w3.org/2000/svg"
              xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px"
                viewBox="0 0 56.966 56.966" style="enable-background:new 0 0 56.966 56.966;" xml:space="preserve"
                width="512px" height="512px">
                <path
                  d="M55.146,51.887L41.588,37.786c3.486-4.144,5.396-9.358,5.396-14.786c0-12.682-10.318-23-23-23s-23,10.318-23,23  s10.318,23,23,23c4.761,0,9.298-1.436,13.177-4.162l13.661,14.208c0.571,0.593,1.339,0.92,2.162,0.92  c0.779,0,1.518-0.297,2.079-0.837C56.255,54.982,56.293,53.08,55.146,51.887z M23.984,6c9.374,0,17,7.626,17,17s-7.626,17-17,17  s-17-7.626-17-17S14.61,6,23.984,6z" />
              </svg>
            </button>
        </div>

        <span>

            <select class="py-1 uppercase bg-white rounded-md dark:bg-gray-800 dark:text-gray-300" name="sortingStatus" wire:model="sortingStatus">
            <option value="all" selected="selected">By Status</option>
            @foreach ($sortingStatusArr as $key => $sortingStatus)
            <option value="{{$key}}" selected="selected">{{$sortingStatus}}</option>
            @endforeach
        </select>

        <select class="py-1 uppercase bg-white rounded-md dark:bg-gray-800 dark:text-gray-300" name="sorting" wire:model="sorting">
            <option value="all" selected="selected">By Due Range</option>
            <option value="weekly">Due in This Week</option>
            <option value="monthly">Due in This Month</option>
            <option value="quarterly">Due in This Quarter</option>
            <option value="annual">Due in This Year</option>
        </select>

    </span>
</div>

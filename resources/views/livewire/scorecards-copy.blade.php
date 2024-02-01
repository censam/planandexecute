<div>
<div>
    <div class="flex items-center justify-between px-4 ">

        <livewire:scorecards.create/>

        <span>
            <select class="py-1 uppercase bg-white rounded-md dark:bg-gray-800 dark:text-gray-300"
                name="sortingTimer" wire:model="sortingTimer">
                <option value="all" selected="selected">All</option>
                <option value="weekly">Weekly</option>
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
                onclick="toggleViewMode()">
                <div id="switch-toggle"
                    class="relative p-1 text-white transition duration-500 transform -translate-x-2 bg-yellow-500 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
            </button>

        </span>

    </div>
</div>


<div  id="scorecard-main">
    @foreach ($scoreCards as $eachScoreCard)
    <div class="mt-4 ml-4 mr-4">
        @include('livewire.scorecards.scorecard')
    </div>
    @endforeach
</div>


<script>
    const switchToggle = document.querySelector('#switch-toggle');
    const scorecardMain = document.querySelector('#scorecard-main');
    let isGridmode = false;
    if(localStorage.getItem('isGridmode')=='true'){
     isGridmode = true;
    }

    const gridIcon = `<svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
    </svg>`

    const listIcon = `<svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
    </svg>`

    function toggleViewMode (){
      isGridmode = !isGridmode
      localStorage.setItem('isGridmode', isGridmode)
      switchviewMode()
    }

    function switchviewMode (){
      if (isGridmode) {
        switchToggle.classList.remove('bg-yellow-500','-translate-x-2')
        switchToggle.classList.add('bg-gray-700','translate-x-full')
        switchToggle.classList.add('bg-gray-700','translate-x-full')
        setTimeout(() => {
            switchToggle.innerHTML = gridIcon
            scorecardMain.classList.add('grid', 'grid-cols-3')
        }, 250);
      } else {
        switchToggle.classList.add('bg-yellow-500','-translate-x-2')
        switchToggle.classList.remove('bg-gray-700','translate-x-full')

        setTimeout(() => {
            switchToggle.innerHTML = listIcon
            scorecardMain.classList.remove('grid', 'grid-cols-3')
        }, 250);
      }
    }

    switchviewMode()
</script>
</div>

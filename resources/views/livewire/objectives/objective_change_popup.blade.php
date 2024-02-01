<div class="fixed z-30 overflow-hidden inset-1" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">

      <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" aria-hidden="true"></div>

      <!-- This element is to trick the browser into centering the modal contents. -->
      <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>


      <div class="absolute overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl right-1/3 top-1/4 sm:my-8 sm:align-middle sm:max-w-lg">
          <div class="px-4 pt-5 pb-4 bg-white sm:p-6 sm:pb-4">
              <div class="sm:flex sm:items-start">
                  <div class="flex items-center justify-center flex-shrink-0 w-12 h-12 mx-auto bg-green-200 rounded-full sm:mx-0 sm:h-10 sm:w-10">
                      <!-- Heroicon name: outline/exclamation -->
                      <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                      </svg>
                </div>
                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                    <h3 class="text-lg font-medium leading-6 text-gray-900" id="modal-title">

                        @if(isset($keyResultsProgomaticData['completed']))
                            @if($keyResultsProgomaticData['completed']==1)
                                Change Objective Status to 'Completed'.
                            @elseif($keyResultsProgomaticData['completed']==2)
                                Change Objective Status to 'In Progress'.
                            @endif
                        @endif


                    </h3>
                    <div class="mt-2">
                        <p class="text-sm text-gray-500">
                        @if(isset($keyResultsProgomaticData['completed']))
                            @if($keyResultsProgomaticData['completed']==1)
                            Wow , Looks Like you completed all key results.
                            Do you want to change this objective status to 'Completed' ?
                            @elseif($keyResultsProgomaticData['completed']==2)
                            Looks Like you already started .
                            Do you want to change this objective status to 'In Progress' ?
                            @endif
                        @endif

                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="px-4 py-3 bg-gray-50 sm:px-6 sm:flex sm:flex-row-reverse">
            <button type="button"  wire:click="ChangeObjectiveStatus({{$keyResultsProgomaticData['id']}},{{$keyResultsProgomaticData['completed']}})" wire:loading.attr="disabled" class="inline-flex justify-center w-full px-4 py-2 text-base font-medium text-white bg-green-600 border border-transparent rounded-md shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:ml-3 sm:w-auto sm:text-sm">
                @if(($keyResultsProgomaticData['completed']))
                @if($keyResultsProgomaticData['completed']==1)
                Yes, Change to 'COMPLETED'
                @elseif($keyResultsProgomaticData['completed']==2)
                Yes, Change to 'IN-PROGRESS'
                @endif
            @endif
            </button>
            <button type="button" wire:click="$set('isKeyResultsProgomatic', false)" wire:loading.attr="disabled" class="inline-flex justify-center w-full px-4 py-2 mt-3 text-base font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                No
            </button>
        </div>
    </div>
</div>
</div>

<div class="relative flex flex-col w-full min-w-0 break-words rounded shadow-lg bg-gray-50 dark:bg-gray-800">
    <div class="px-0 mb-0 border-0 rounded-t">
      <div class="flex flex-wrap items-center px-4 py-2">
        <div class="relative flex-1 flex-grow w-full max-w-full">
          <h3 class="text-base font-semibold text-gray-900 dark:text-gray-50">Recently Due Date Objectives</h3>
        </div>

        <div class="relative flex-1 flex-grow w-full max-w-full text-right">
          <a class="px-3 py-1 mb-1 mr-1 text-xs font-bold text-white uppercase transition-all duration-150 ease-linear bg-red-500 rounded outline-none dark:bg-gray-100 active:bg-red-600 dark:text-gray-800 dark:active:text-gray-700 focus:outline-none" href="/due_objectives"> {{$today_due_objectives->count()}}</a>
        </div>
      </div>
      <div class="block w-full">
        <div class="px-4 py-3 text-xs font-semibold text-left text-gray-500 uppercase align-middle bg-gray-100 border border-l-0 border-r-0 border-gray-200 border-solid dark:bg-gray-600 dark:text-gray-100 dark:border-gray-500 whitespace-nowrap">
          From This Week
        </div>
        @if (count($today_due_objectives)> 0)

        <ul class="my-1">
            @foreach ($today_due_objectives as $today_due_objective)
          <li class="flex px-4">
            <div class="flex-shrink-0 w-6 h-6 my-2 mr-3 bg-yellow-500 rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-100" fill="none" viewBox="-3 -3 30 30" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                  </svg>
            </div>
            <div class="flex items-center flex-grow py-2 text-sm text-gray-600 border-b border-gray-100 dark:border-gray-400 dark:text-gray-100">
              <div class="flex items-center justify-between flex-grow">
                <div class="inline-flex self-center">
                   <img src="{{$today_due_objective->user->profile_photo_url}}" class="inline object-cover w-8 h-8 mr-2 border-2 rounded-full"> <span> {{ Str::limit($today_due_objective->name ,70)}}</span>
                </div>
                <div class="flex-shrink-0 ml-2"></div>
                <div class="flex-shrink-0 ml-2">
                    @if($today_due_objective->completed!=1)
                    @if (strpos(\Carbon\Carbon::parse($today_due_objective->due_date)->diffForHumans(), 'ago') !== false)
                    <span
                        class="px-3 py-1 text-xs text-red-600 bg-red-200 rounded-full">{{ \Carbon\Carbon::parse($today_due_objective->due_date)->diffForHumans() }}</span>
                    @else
                    <span
                        class="px-3 py-1 text-xs text-yellow-600 bg-yellow-200 rounded-full">{{ \Carbon\Carbon::parse($today_due_objective->due_date)->diffForHumans() }}</span>
                    @endif
                @else
                    <span class="px-3 py-1 text-xs text-green-700 bg-green-200 rounded-full">Completed</span>
                @endif
                </div>
              </div>
            </div>
          </li>
            @endforeach
        </ul>
        @else
                <tr class="">
                    <td colspan="3">
                        <div class="w-full px-4 py-4 font-thin text-center bg-gray-100 rounded">No Objectives Found
                        </div>
                    </td>
                </tr>
                @endif
      </div>
    </div>
  </div>

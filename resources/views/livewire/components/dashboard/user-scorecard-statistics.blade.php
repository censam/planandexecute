<div class="mx-4 mt-4">
     @if ($canReadStatistics)
    <!-- Client Table -->
    <div class="w-full overflow-hidden rounded-lg shadow-xl">

      <div class="w-full mb-10 overflow-x-auto">

        <div class="flex flex-wrap items-center px-4 py-2 bg-gray-50">
            <div class="relative flex-1 flex-grow w-full max-w-full">
              <h3 class="text-base font-semibold text-gray-900 uppercase dark:text-gray-50">USERS' SCORECARD STATISTICS</h3>
            </div>

            <div class="relative flex-1 flex-grow w-full max-w-full text-right">
              </div>
          </div>

        <table class="w-full">
          <thead>
            <tr class="px-4 py-3 text-xs font-semibold text-left text-gray-500 uppercase align-middle bg-gray-100 border border-l-0 border-r-0 border-gray-200 border-solid dark:bg-gray-600 dark:text-gray-100 dark:border-gray-500 whitespace-nowrap">
              <th class="px-4 py-3">Members</th>
              <th class="px-4 py-3">All</th>
              <th class="px-4 py-3">Recurring</th>
              <th class="px-4 py-3">Finished</th>
              <th class="px-4 py-3">Not Started</th>
              <th class="px-4 py-3">Recurring<br>-Due <span class="text-xs italic font-thin">(Records)</span></th>
              <th class="px-4 py-3">Recurring<br>-Completed<span class="text-xs italic font-extralight">(Records)</span> </th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
            @foreach ($user_statistics as $key => $teamMember)
            <tr class="text-gray-700 bg-gray-50 dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-900 dark:text-gray-400">
              <td class="px-4 py-3">
                <div class="flex items-center text-sm">
                  <div class="relative hidden w-8 h-8 mr-3 rounded-full md:block">
                    <img class="inline object-cover w-8 h-8 mr-2 border-2 rounded-full" src="{{$teamMember->profile_photo_url}}" alt="" loading="lazy" />
                    <div class="absolute inset-0 rounded-full shadow-inner" aria-hidden="true"></div>
                  </div>
                  <div>
                    <p class="font-semibold capitalize">{{$teamMember->name}}</p>
                    <p class="text-xs text-gray-600 dark:text-gray-400"></p>
                  </div>
                </div>
              </td>
              <td class="px-4 py-3 text-sm">
                <span class="px-2 py-1 font-semibold leading-tight text-gray-500 rounded-full dark:bg-gray-500 dark:text-gray-100">  {{$teamMember->all_count}} </span>
              </td>
              <td class="px-4 py-3 text-sm ">
                <span class="px-2 py-1 font-semibold leading-tight text-gray-500 rounded-full dark:bg-gray-500 dark:text-gray-100">  {{$teamMember->recurring_count}}</span>
              </td>
              <td class="px-4 py-3 text-sm">
                <span class="px-2 py-1 font-semibold leading-tight text-gray-500 rounded-full dark:bg-gray-500 dark:text-gray-100">  {{$teamMember->finished_count}} </span>
              </td>
              <td class="px-4 py-3 text-sm">
                <span class="px-2 py-1 font-semibold leading-tight text-gray-500 rounded-full dark:bg-gray-500 dark:text-gray-100">  {{$teamMember->not_started_count}} </span>
              </td>
              <td class="px-4 py-3 text-sm">
                <span class="px-2 py-1 font-semibold leading-tight text-gray-500 rounded-full dark:bg-gray-500 dark:text-gray-100">  {{$teamMember->recurring_due_count}} </span>
              </td>
              <td class="px-4 py-3 text-sm ">
                <span class="px-2 py-1 font-semibold leading-tight text-gray-500 rounded-full dark:bg-gray-500 dark:text-gray-100"> {{$teamMember->recurring_completed_count}}</span>
              </td>
            </tr>
             @endforeach

          </tbody>
        </table>
      </div>

    </div>
    <!-- ./Client Table -->
     @endif
  </div>

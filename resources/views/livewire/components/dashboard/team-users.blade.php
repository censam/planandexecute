<div class="mx-4 mt-4">
    @if ($canReadStatistics)
    <!-- Client Table -->
    <div class="w-full overflow-hidden rounded-lg shadow-xl">

      <div class="w-full mb-10 overflow-x-auto">

        <div class="flex flex-wrap items-center px-4 py-2 bg-gray-50">
            <div class="relative flex-1 flex-grow w-full max-w-full">
              <h3 class="text-base font-semibold text-gray-900 uppercase dark:text-gray-50">Users' Objectives STATISTICS</h3>
            </div>

            <div class="relative flex-1 flex-grow w-full max-w-full text-right">
              </div>
          </div>

        <table class="w-full">
          <thead>
            <tr class="px-4 py-3 text-xs font-semibold text-left text-gray-500 uppercase align-middle bg-gray-100 border border-l-0 border-r-0 border-gray-200 border-solid dark:bg-gray-600 dark:text-gray-100 dark:border-gray-500 whitespace-nowrap">
              <th class="px-4 py-3">Members</th>
              <th class="px-4 py-3">Percentage</th>
              <th class="px-4 py-3">All</th>
              <th class="px-4 py-3">Not Started</th>
              <th class="px-4 py-3">In - Progress</th>
              <th class="px-4 py-3">Reviewing</th>
              <th class="px-4 py-3">Not Completed</th>
              <th class="px-4 py-3">Completed</th>
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
                    <p class="font-semibold">{{ucwords($teamMember->name)}}</p>
                    <p class="text-xs text-gray-600 dark:text-gray-400"></p>
                </div>
            </div>
              </td>
              <td class="px-4 text-sm ">
                <span class="font-semibold leading-tight text-gray-500 rounded-full py dark:bg-gray-500 dark:text-gray-100">

                @php
                if($teamMember->all_count){
                    $completed_percentage = round(($teamMember->completed_count/$teamMember->all_count)*100,2).'%';
                    $in_progress_percentage = round(($teamMember->in_progress_count/$teamMember->all_count)*100,2).'%';
                    $missed_percentage = round(($teamMember->missed_count/$teamMember->all_count)*100,2).'%';

                }else{
                    $completed_percentage = '0%';
                    $in_progress_percentage = '0%';
                    $missed_percentage = '0%';

                }
                @endphp

                <div class="flex items-center p-1">
                    <span class="w-10 mr-2 text-xs">{{$completed_percentage}}</span>
                    <div class="relative w-full">
                      <div class="flex h-4 overflow-hidden text-xs bg-green-300 rounded">
                        <div style="width: {{$completed_percentage}}" class="flex flex-col justify-center p-1 text-xs text-center text-white bg-green-700 shadow-none whitespace-nowrap"> Completed </div>
                      </div>
                    </div>
                </div>

                <div class="flex items-center p-1">
                    <span class="w-10 mr-2 text-xs">{{$in_progress_percentage}}</span>
                    <div class="relative w-full">
                      <div class="flex h-4 overflow-hidden text-xs bg-indigo-300 rounded">
                        <div style="width: {{$in_progress_percentage}}" class="flex flex-col justify-center p-1 text-center text-white bg-indigo-700 shadow-none whitespace-nowrap"> In Progress </div>
                      </div>
                    </div>
                </div>

                <div class="flex items-center p-1">
                    <span class="w-10 mr-2 text-xs">{{$missed_percentage}}</span>
                    <div class="relative w-full">
                      <div class="flex h-4 overflow-hidden text-xs bg-red-300 rounded">
                        <div style="width: {{$missed_percentage}}" class="flex flex-col justify-center p-1 text-center text-white bg-red-700 shadow-none whitespace-nowrap"> Missed  </div>
                      </div>
                    </div>
                </div>

            </span>
              </td>
              <td class="px-4 py-3 text-sm">
                <span class="px-2 py-1 font-semibold leading-tight text-gray-500 rounded-full dark:bg-gray-500 dark:text-gray-100">  {{$teamMember->all_count}} </span>
              </td>
              <td class="px-4 py-3 text-sm ">
                <span class="px-2 py-1 font-semibold leading-tight text-gray-500 rounded-full dark:bg-gray-500 dark:text-gray-100">  {{$teamMember->not_started_count}} </span>
              </td>
              <td class="px-4 py-3 text-sm">
                <span class="px-2 py-1 font-semibold leading-tight text-gray-500 rounded-full dark:bg-gray-500 dark:text-gray-100">  {{$teamMember->in_progress_count}} </span>
              </td>
              <td class="px-4 py-3 text-sm ">
                <span class="px-2 py-1 font-semibold leading-tight text-gray-500 rounded-full dark:bg-gray-500 dark:text-gray-100">  {{$teamMember->in_reviewing_count}} </span>
              </td>
              <td class="px-4 py-3 text-sm">
                <span class="px-2 py-1 font-semibold leading-tight text-gray-500 rounded-full dark:bg-gray-500 dark:text-gray-100">  {{$teamMember->not_completed_count}} </span>
              </td>
              <td class="px-4 py-3 text-sm ">
                <span class="px-2 py-1 font-semibold leading-tight text-gray-500 rounded-full dark:bg-gray-500 dark:text-gray-100"> {{$teamMember->completed_count}}</span>
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

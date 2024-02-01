<div class="relative flex flex-col w-full min-w-0 mb-4 break-words rounded shadow-lg lg:mb-0 bg-gray-50 dark:bg-gray-800">
    <!-- Social Traffic -->
    <div class="px-0 mb-0 border-0 rounded-t">
      <div class="flex flex-wrap items-center px-4 py-2">
        <div class="relative flex-1 flex-grow w-full max-w-full">
          <h3 class="text-sm font-semibold text-gray-900 uppercase dark:text-gray-50">Objectives & Key Results Statistics</h3>
        </div>
        <div class="text-right ">
         <a href="{{route('objectives')}}" class="px-3 py-1 mb-1 mr-1 text-xs font-bold text-white uppercase transition-all duration-150 ease-linear bg-blue-500 rounded outline-none dark:bg-gray-100 active:bg-blue-600 dark:text-gray-800 dark:active:text-gray-700 focus:outline-none" type="button">See all</a>
        </div>
      </div>
      <div class="block w-full overflow-x-auto">
        <table class="items-center w-full bg-transparent border-collapse">
          <thead>
            <tr>
              <th class="px-4 py-3 text-xs font-semibold text-left text-gray-500 uppercase align-middle bg-gray-100 border border-l-0 border-l-4 border-r-0 border-gray-200 border-yellow-500 border-solid dark:bg-gray-600 dark:text-gray-100 dark:border-gray-500 whitespace-nowrap">Objective Type</th>
              <th class="px-2 py-2 text-xs font-semibold text-left text-gray-500 uppercase align-middle bg-gray-100 border border-l-0 border-r-0 border-gray-200 border-yellow-500 border-solid dark:bg-gray-600 dark:text-gray-100 dark:border-gray-500 whitespace-nowrap">Count</th>
              <th class="px-4 py-3 text-xs font-semibold text-left text-gray-500 uppercase align-middle bg-gray-100 border border-l-0 border-r-0 border-gray-200 border-yellow-500 border-solid dark:bg-gray-600 dark:text-gray-100 dark:border-gray-500 whitespace-nowrap min-w-140-px">Progress</th>
            </tr>
          </thead>
          <tbody>
            <tr class="text-gray-700 dark:text-gray-100">
              <th class="p-4 px-4 text-xs text-left align-middle border-t-0 border-l-0 border-r-0 whitespace-nowrap">Completed</th>
              <td class="p-4 px-4 text-xs align-middle border-t-0 border-l-0 border-r-0 whitespace-nowrap">{{$completed_objectives_count}}</td>
              <td class="p-4 px-4 text-xs align-middle border-t-0 border-l-0 border-r-0 whitespace-nowrap">
                <div class="flex items-center">
                  <span class="mr-2">{{$completed_objectives_percentage}}</span>
                  <div class="relative w-full">
                    <div class="flex h-2 overflow-hidden text-xs bg-green-200 rounded">
                      <div style="width: {{$completed_objectives_percentage}}" class="flex flex-col justify-center text-center text-white bg-green-600 shadow-none whitespace-nowrap"></div>
                    </div>
                  </div>
                </div>
              </td>
            </tr>
            <tr class="text-gray-700 dark:text-gray-100">
                <th class="p-4 px-4 text-xs text-left align-middle border-t-0 border-l-0 border-r-0 whitespace-nowrap">Missed</th>
                <td class="p-4 px-4 text-xs align-middle border-t-0 border-l-0 border-r-0 whitespace-nowrap">{{$missed_objectives_count}}</td>
                <td class="p-4 px-4 text-xs align-middle border-t-0 border-l-0 border-r-0 whitespace-nowrap">
                  <div class="flex items-center">
                    <span class="mr-2">{{$missed_objectives_percentage}}</span>
                    <div class="relative w-full">
                      <div class="flex h-2 overflow-hidden text-xs bg-pink-200 rounded">
                        <div style="width: {{$missed_objectives_percentage}}" class="flex flex-col justify-center text-center text-white bg-pink-600 shadow-none whitespace-nowrap"></div>
                      </div>
                    </div>
                  </div>
                </td>
              </tr>
            <tr class="text-gray-700 dark:text-gray-100">
              <th class="p-4 px-4 text-xs text-left align-middle border-t-0 border-l-0 border-r-0 whitespace-nowrap">Reviewing</th>
              <td class="p-4 px-4 text-xs align-middle border-t-0 border-l-0 border-r-0 whitespace-nowrap">{{$reviewing_objectives_count}}</td>
              <td class="p-4 px-4 text-xs align-middle border-t-0 border-l-0 border-r-0 whitespace-nowrap">
                <div class="flex items-center">
                  <span class="mr-2">{{$reviewing_objectives_percentage}}</span>
                  <div class="relative w-full">
                    <div class="flex h-2 overflow-hidden text-xs bg-gray-200 rounded">
                      <div style="width: {{$reviewing_objectives_percentage}}" class="flex flex-col justify-center text-center text-white bg-gray-500 shadow-none whitespace-nowrap"></div>
                    </div>
                  </div>
                </div>
              </td>
            </tr>
            <tr class="text-gray-700 dark:text-gray-100">
              <th class="p-4 px-4 text-xs text-left align-middle border-t-0 border-l-0 border-r-0 whitespace-nowrap">Not Completed</th>
              <td class="p-4 px-4 text-xs align-middle border-t-0 border-l-0 border-r-0 whitespace-nowrap">{{$not_complete_objectives_count}}</td>
              <td class="p-4 px-4 text-xs align-middle border-t-0 border-l-0 border-r-0 whitespace-nowrap">
                <div class="flex items-center">
                  <span class="mr-2">{{$not_complete_objectives_percentage}}</span>
                  <div class="relative w-full">
                    <div class="flex h-2 overflow-hidden text-xs bg-purple-200 rounded">
                      <div style="width: {{$not_complete_objectives_percentage}}" class="flex flex-col justify-center text-center text-white bg-purple-500 shadow-none whitespace-nowrap"></div>
                    </div>
                  </div>
                </div>
              </td>
            </tr>
            <tr class="text-gray-700 dark:text-gray-100">
              <th class="p-4 px-4 text-xs text-left align-middle border-t-0 border-l-0 border-r-0 whitespace-nowrap">In-Progress</th>
              <td class="p-4 px-4 text-xs align-middle border-t-0 border-l-0 border-r-0 whitespace-nowrap">{{$in_progress_objectives_count}}</td>
              <td class="p-4 px-4 text-xs align-middle border-t-0 border-l-0 border-r-0 whitespace-nowrap">
                <div class="flex items-center">
                  <span class="mr-2">{{$in_progress_objectives_percentage}}</span>
                  <div class="relative w-full">
                    <div class="flex h-2 overflow-hidden text-xs bg-red-200 rounded">
                      <div style="width: {{$in_progress_objectives_percentage}}" class="flex flex-col justify-center text-center text-white bg-red-500 shadow-none whitespace-nowrap"></div>
                    </div>
                  </div>
                </div>
              </td>
            </tr>
            <tr class="text-gray-700 dark:text-gray-100">
              <th class="p-4 px-4 text-xs text-left align-middle border-t-0 border-l-0 border-r-0 whitespace-nowrap">Not Started</th>
              <td class="p-4 px-4 text-xs align-middle border-t-0 border-l-0 border-r-0 whitespace-nowrap">{{$not_started_count}}</td>
              <td class="p-4 px-4 text-xs align-middle border-t-0 border-l-0 border-r-0 whitespace-nowrap">
                <div class="flex items-center">
                  <span class="mr-2">{{$not_started_objectives_percentage}}</span>
                  <div class="relative w-full">
                    <div class="flex h-2 overflow-hidden text-xs bg-blue-200 rounded">
                      <div style="width: {{$not_started_objectives_percentage}}" class="flex flex-col justify-center text-center text-white bg-blue-700 shadow-none whitespace-nowrap"></div>
                    </div>
                  </div>
                </div>
              </td>
            </tr>
          </tbody>
        </table>

        <table class="items-center w-full bg-transparent border-collapse">
            <thead>
              <tr>
                <th class="px-2 py-3 text-xs font-semibold text-left text-gray-500 uppercase align-middle bg-gray-100 border border-l-0 border-l-4 border-r-0 border-gray-200 border-blue-400 border-solid dark:bg-gray-600 dark:text-gray-100 dark:border-gray-500 whitespace-nowrap">Key Result Type</th>
                <th class="px-2 py-3 text-xs font-semibold text-left text-gray-500 uppercase align-middle bg-gray-100 border border-l-0 border-r-0 border-gray-200 border-blue-400 border-solid dark:bg-gray-600 dark:text-gray-100 dark:border-gray-500 whitespace-nowrap">All</th>
                <th class="px-2 py-3 text-xs font-semibold text-left text-gray-500 uppercase align-middle bg-gray-100 border border-l-0 border-r-0 border-gray-200 border-blue-400 border-solid dark:bg-gray-600 dark:text-gray-100 dark:border-gray-500 whitespace-nowrap">Completed</th>
                <th class="px-2 py-3 text-xs font-semibold text-left text-gray-500 uppercase align-middle bg-gray-100 border border-l-0 border-r-0 border-gray-200 border-blue-400 border-solid dark:bg-gray-600 dark:text-gray-100 dark:border-gray-500 whitespace-nowrap">Pending</th>
                <th class="px-2 py-3 text-xs font-semibold text-left text-gray-500 uppercase align-middle bg-gray-100 border border-l-0 border-r-0 border-gray-200 border-blue-400 border-solid dark:bg-gray-600 dark:text-gray-100 dark:border-gray-500 whitespace-nowrap">Late</th>
                <th class="px-2 py-3 text-xs font-semibold text-left text-gray-500 uppercase align-middle bg-gray-100 border border-l-0 border-r-0 border-gray-200 border-blue-400 border-solid dark:bg-gray-600 dark:text-gray-100 dark:border-gray-500 whitespace-nowrap min-w-140-px">Completed Progress</th>
              </tr>
            </thead>
            <tbody>
              <tr class="text-gray-700 dark:text-gray-100">
                <th class="p-4 px-2 text-xs text-left align-middle border-t-0 border-l-0 border-r-0 whitespace-nowrap">Team</th>
                <td class="p-4 px-2 text-xs align-middle border-t-0 border-l-0 border-r-0 whitespace-nowrap">{{$team_key_result_count}}</td>
                <td class="p-4 px-2 text-xs align-middle border-t-0 border-l-0 border-r-0 whitespace-nowrap">{{$team_key_result_completed_count}}</td>
                <td class="p-4 px-2 text-xs align-middle border-t-0 border-l-0 border-r-0 whitespace-nowrap">{{$team_key_result_not_completed_count}}</td>
                <td class="p-4 px-2 text-xs align-middle border-t-0 border-l-0 border-r-0 whitespace-nowrap">{{$team_key_result_late_count}}</td>
                <td class="p-4 px-2 text-xs align-middle border-t-0 border-l-0 border-r-0 whitespace-nowrap">
                  <div class="flex items-center">
                    <span class="mr-2">{{$team_key_result_completed_percentage}}</span>
                    <div class="relative w-full">
                      <div class="flex h-2 overflow-hidden text-xs bg-blue-200 rounded">
                        <div style="width: {{$team_key_result_completed_percentage}}" class="flex flex-col justify-center text-center text-white bg-blue-600 shadow-none whitespace-nowrap"></div>
                      </div>
                    </div>
                  </div>
                </td>
              </tr>

              <tr class="text-gray-700 dark:text-gray-100">
                <th class="p-4 px-2 text-xs text-left align-middle border-t-0 border-l-0 border-r-0 whitespace-nowrap">Individual</th>
                <td class="p-4 px-2 text-xs align-middle border-t-0 border-l-0 border-r-0 whitespace-nowrap">{{$individual_key_result_count}}</td>
                <td class="p-4 px-2 text-xs align-middle border-t-0 border-l-0 border-r-0 whitespace-nowrap">{{$individual_key_result_completed_count}}</td>
                <td class="p-4 px-2 text-xs align-middle border-t-0 border-l-0 border-r-0 whitespace-nowrap">{{$individual_key_result_not_completed_count}}</td>
                <td class="p-4 px-2 text-xs align-middle border-t-0 border-l-0 border-r-0 whitespace-nowrap">{{$individual_key_result_late_count}}</td>
                <td class="p-4 px-2 text-xs align-middle border-t-0 border-l-0 border-r-0 whitespace-nowrap">
                  <div class="flex items-center">
                    <span class="mr-2">{{$individual_key_result_completed_percentage}}</span>
                    <div class="relative w-full">
                      <div class="flex h-2 overflow-hidden text-xs bg-yellow-200 rounded">
                        <div style="width: {{$individual_key_result_completed_percentage}}" class="flex flex-col justify-center text-center text-white bg-yellow-600 shadow-none whitespace-nowrap"></div>
                      </div>
                    </div>
                  </div>
                </td>
              </tr>

            </tbody>
          </table>
      </div>
    </div>
    <!-- ./Social Traffic -->
  </div>

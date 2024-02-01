<div>
@php
    if(($eachScoreCard->next_due_date) <=  (date("Y-m-d h:i:s", strtotime("+3 day"))) && ($eachScoreCard->incompleted_histories_count)){
        $next_due_date_class = 'text-red-500 border-red-200  border-2';
    }else{
        $next_due_date_class = 'border';
    }
@endphp
<div class="w-full p-4 bg-white  {{$next_due_date_class}} shadow-lg rounded-2xl dark:bg-gray-700 ">


    <div :class="list ? 'grid grid-cols-2 ' : ''">


    <div :class="list ? 'border-r-4 pr-3' : ''">
    <div class="flex items-center justify-between mb-6" >
        <div class="flex items-center">
            <span class="relative p-1 border-2 border-blue-200 rounded-xl">
                <img src="{{$eachScoreCard->user->profile_photo_url}}" class="inline object-cover w-10 h-10 border-yellow-300 rounded-lg border-1">
            </span>
            <div class="flex flex-col">
                <span class="w-full ml-2 font-bold text-black text-md dark:text-white" >
                    {{$eachScoreCard->title}}
                </span>

            </div>
        </div>
        <div class="flex items-center">
        @if ($eachScoreCard->histories->count())
            <span class="w-12 flex items-center px-2 py-1 text-xs font-semibold  rounded-md m-1  {{($eachScoreCard->completed_histories_count==$eachScoreCard->histories->count())?'bg-green-200 text-green-500':'bg-pink-200 text-pink-500'}} l ">
                {{$eachScoreCard->completed_histories_count}} / {{$eachScoreCard->histories->count()}}
            </span>
            @else
            <span class="flex items-center px-2 py-1 m-1 text-xs font-semibold text-gray-700 bg-gray-300 rounded-md ">
                0
            </span>
        @endif

                <div class="p-2">
                  <div class="relative inline-block text-left dropdown">
                    <span class="rounded-md shadow-sm">
                      <button class="text-gray-400"><svg width="20" height="20" fill="currentColor" viewBox="0 0 1792 1792" xmlns="http://www.w3.org/2000/svg"><path d="M1088 1248v192q0 40-28 68t-68 28h-192q-40 0-68-28t-28-68v-192q0-40 28-68t68-28h192q40 0 68 28t28 68zm0-512v192q0 40-28 68t-68 28h-192q-40 0-68-28t-28-68v-192q0-40 28-68t68-28h192q40 0 68 28t28 68zm0-512v192q0 40-28 68t-68 28h-192q-40 0-68-28t-28-68v-192q0-40 28-68t68-28h192q40 0 68 28t28 68z"></path></svg></button>
                    </span>
                    <div class="invisible transition-all duration-300 origin-top-right transform scale-95 -translate-y-2 opacity-0 dropdown-menu">


                        <div class="absolute right-0 w-auto mt-2 origin-top-right bg-white border border-gray-200 divide-y divide-gray-100 rounded-md shadow-lg outline-none" aria-labelledby="headlessui-menu-button-1" id="headlessui-menu-items-117" role="menu">



                          <span class="flex py-1 text-center">
                            @if($confirming===$eachScoreCard->id)
                            <button wire:click="notConfirmdelete()" href="javascript:void(0)" tabindex="1" class="flex justify-between w-full px-1 py-1 m-1 text-sm leading-5 text-center text-gray-700 rounded hover:bg-green-400 hover:text-white"  role="menuitem">
                                NO
                            </button>

                            <a wire:click="delete({{ $eachScoreCard->id }})" href="javascript:void(0)" tabindex="2" class="flex justify-between w-full px-1 py-1 m-1 text-sm leading-5 text-center text-gray-700 rounded hover:bg-red-400 hover:text-white"  role="menuitem">
                                YES
                            </a>

                            @else
                          <a href="javascript:void(0)" tabindex="0" class="flex justify-between w-full px-1 py-1 m-1 text-sm leading-5 text-center text-gray-700 rounded hover:bg-blue-400 hover:text-white"  role="menuitem" x-on:click="list = ! list">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                              </svg>
                          </a>
                           <a wire:click="edit({{ $eachScoreCard->id }})" href="javascript:void(0)" tabindex="0" class="flex justify-between w-full px-1 py-1 m-1 text-sm leading-5 text-center text-gray-700 rounded hover:bg-green-400 hover:text-white"  role="menuitem">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                          </a>
                          @if ($isAdmin)
                          <a wire:click="confirmDelete({{ $eachScoreCard->id }})" href="javascript:void(0)" tabindex="1" class="flex justify-between w-full px-1 py-1 m-1 text-sm leading-5 text-center text-gray-700 rounded hover:bg-red-400 hover:text-white"  role="menuitem">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                          </a>
                          @endif

                          @endif

                        </span>
                    </div>
                    </div>
                  </div>
                </div>

        </div>
    </div>
    <div class="flex items-center justify-between mb-4 space-x-12">

        @php
            if($eachScoreCard->completed=='1'){
                $class = 'text-green-500 bg-green-200';
            }elseif($eachScoreCard->completed=='2'){
                $class = 'text-yellow-600 bg-yellow-200';
            }elseif($eachScoreCard->completed=='0'){
                $class = 'text-red-500 bg-red-200';
            }else{
                $class = 'text-gray-500 bg-gray-200';

            }
        @endphp

        <span class="flex items-center px-2 py-1 text-xs font-semibold uppercase {{$class}} rounded-md">

            @php
            if($eachScoreCard->completed=='1'){
                $progress = 'Finished';
            }elseif($eachScoreCard->completed=='2'){
                $progress = 'Recurring';
            }elseif($eachScoreCard->completed=='0'){
                $progress = 'Not Started';
            }else{
                $progress = '--';
            }
        @endphp
            {{$progress}}
        </span>
        <span class="flex items-center px-2 py-1 text-xs font-semibold text-red-400 uppercase bg-white border border-red-400 rounded-md">
            {{$eachScoreCard->timer}}
        </span>
    </div>
    <div class="block p-1 m-auto text-sm text-gray-800 bg-blue-100 rounded">
        {{$eachScoreCard->kpi_metric}}
    </div>
    <div class="block m-auto">
        <span class="py-2 text-sm text-gray-700"  :class="list ? '' : 'hidden'">
            {{-- {{$eachScoreCard}} --}}
           {{Str::limit($eachScoreCard->description, 500)}}
        </span>


        <span class="py-2 text-sm text-gray-700 "  :class="list ? 'hidden' : ''">
           {{Str::limit($eachScoreCard->description, 90)}}
        </span>
    </div>
    <div class="flex items-center justify-start hidden my-4 space-x-4">
        <span class="flex items-center px-2 py-1 text-xs font-semibold text-green-500 rounded-md bg-green-50">
            IOS APP
        </span>
        <span class="flex items-center px-2 py-1 text-xs font-semibold text-blue-500 bg-blue-100 rounded-md">
            UI/UX
        </span>
    </div>
    <div class="flex -space-x-2">

    </div>

    <div class="flex items-center justify-between my-2 space-x-12">
        @php

            if(isset($eachScoreCard->oldestHistory)&&(($eachScoreCard->oldestHistory->due_date) <=  (date("Y-m-d h:i:s", strtotime("+3 day"))))){
                $next_due_date_class = 'text-red-500 border-red-200 bg-red-50';
            }else{
                $next_due_date_class = 'text-green-400 border-green-400';
            }
        @endphp


        @if ($eachScoreCard->completed_histories_count!=$eachScoreCard->histories->count())
        <span class="flex items-center w-40 px-2 py-1 text-xs font-semibold bg-white border rounded-md {{$next_due_date_class}}">
            DUE :   {{($eachScoreCard->oldestHistory->due_date)? date('d-M-y', strtotime($eachScoreCard->oldestHistory->due_date)) :'---'}}
        </span>
        @endif


        <span class="flex items-center w-48 px-1 py-1 text-xs font-semibold text-gray-400 uppercase bg-white border border-gray-400 rounded-md">
            Since : {{date('d-M-y', strtotime($eachScoreCard->created_at)) }}
        </span>
    </div>
</div>

<div :class="list ? 'p-1' : 'hidden'" >
    <div class="overflow-x-auto">
        <div class="flex items-center justify-center bg-gray-100">
            <div class="w-full m-1">
                <div class="h-48 bg-white rounded shadow-md">
                    <table class="w-full table-auto max-h-2">
                        <thead>
                            <tr class="text-xs leading-normal text-gray-600 uppercase bg-gray-200">
                                <th class="w-5/12 px-2 py-2 text-left">Note</th>
                                <th class="w-3/12 px-2 py-2 text-left">Completed Date</th>
                                <th class="w-3/12 px-2 py-2 text-left">Due Date</th>


                            </tr>
                        </thead>
                        <tbody class="text-sm font-light text-gray-600">

                            @if (count($eachScoreCard->histories))

                            @foreach ($eachScoreCard->histories as $history)
                            <tr class="text-xs border-b border-gray-200 bg-gray-50 hover:bg-gray-100">
                                <td class="px-1 py-2 text-left ">
                                    <div class="flex items-center truncate">
                                        <span class="text-sm">{{Str::limit($history->note, 30)}}</span>
                                    </div>
                                </td>
                                <td class="px-1 py-2 text-center">
                                    @if ($history->completed_at)
                                    <span class="block mb-1 text-xs font-semibold">{!! date('d-M-y', strtotime($history->completed_at)) !!}</span>
                                    @endif

                                    <span class="w-8 mt-1">
                                        <livewire:components.toggle-button hasTimeStamp='true' :model="$history" field='completed' on="" off="" color="green"
                                            width="12" :key="time().$history->id" />
                                    </span>


                                </td>
                                <td class="px-2 py-2 text-center">
                                    <span class="block mb-1 text-xs font-semibold">{!! $history->due_date ? date('d-M-y', strtotime($history->due_date)): ''   !!}</span>
                                    @if($history->completed=='1')
                                        <span class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100">Completed</span>
                                    @else
                                        @if (($history->due_date) <=  (date("Y-m-d h:i:s", strtotime("+2 day"))))
                                            <span class="px-2 py-1 font-semibold leading-tight text-red-700 bg-red-100 rounded-full dark:bg-red-700 dark:text-red-100">{{ $history->due_date ? $history->due_date->diffForHumans(): 'Not Asiigned'  }} @if($history->completed == '2') ** @endif</span>
                                        @else
                                            <span class="px-2 py-1 font-semibold leading-tight text-yellow-700 bg-yellow-100 rounded-full dark:bg-yellow-700 dark:text-yellow-100">{{ $history->due_date->diffForHumans() }} @if($history->completed == '2') ** @endif</span>
                                        @endif
                                    @endif
                                </td>

                            </tr>
                            @endforeach

                            @else
                            <tr class=""><td colspan="3"><div class="w-full px-4 py-4 font-semibold text-center bg-gray-100 rounded">Records Not Found</div></td></tr>
                            @endif


                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

</div>


    <style>
        .dropdown:focus-within .dropdown-menu {
          opacity:1;
          transform: translate(0) scale(1);
          visibility: visible;
        }
            </style>
</div>
</div>

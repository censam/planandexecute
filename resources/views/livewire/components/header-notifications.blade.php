<div>
<style>
    [x-cloak] {
    display: none !important;
}
</style>



<div class="flex justify-center">

    <div x-data="{ dropdownOpen: false }"  class="relative mr-6">
        <button @click="dropdownOpen = !dropdownOpen" class="relative z-10 block p-1 {{($all_messages_count>0)?'bg-red-400':''}} rounded-md focus:outline-none">
            @if ($all_messages_count>0)
            {{-- <p class="absolute bg-red-600 bottom-2 justify-center mr-4 px-1 right-1.5 rounded-full text-white text-xs top-1  shadow-lg">{{$all_messages_count}}</p> --}}
            @endif
            <svg class="w-5 h-5 text-gray-800" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="white">
                <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z" />
            </svg>
        </button>


        <div x-show="dropdownOpen" x-cloak @click="dropdownOpen = false" class="fixed inset-0 z-10 w-full h-full"></div>

        <div x-show="dropdownOpen" x-cloak class="absolute right-0 z-20 mt-2 overflow-hidden bg-white rounded-md shadow-lg" style="width:28rem;">
            <div class="py-2">
                <svg  wire:loading.delay wire:target="openScorecard" class="absolute float-right w-6 h-6 text-sm text-green-400 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-10" cx="12" cy="12" r="10" stroke="blue" stroke-width="2"></circle>
                    <path class="opacity-95" fill="white" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>

                <svg  wire:loading.delay wire:target="openKeyResult" class="absolute float-right w-6 h-6 text-sm text-green-400 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-80" cx="12" cy="12" r="10" stroke="green" stroke-width="2"></circle>
                    <path class="opacity-95" fill="white" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>

                <svg  wire:loading.delay wire:target="openObjective" class="absolute float-right w-6 h-6 text-sm text-yellow-500 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="" cx="12" cy="12" r="10" stroke="orange" stroke-width="2"></circle>
                    <path class="opacity-95" fill="white" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>

                @if($isAdmin)
                @forelse ($not_approved_objectives as $not_approved_objective)

                <a href="#" wire:click="openReviewObjective({{ $not_approved_objective->parent_id }})"  class="{{($not_approved_objective->deleted_at?'cursor-not-allowed bg-gray-50':'hover:bg-gray-100')}} flex items-center px-4 py-3 -mx-2 border-b ">
                    <img class="object-cover w-8 h-8 mx-1 rounded-full" src="{{$not_approved_objective->user->profile_photo_url}}" alt="avatar">
                    <p class="mx-2 text-sm text-gray-600">
                        <span class="font-bold" href="#">{{$not_approved_objective->user->name}}</span> Waiting for review Objective <span class="font-bold text-blue-500" href="#">{{Str::limit($not_approved_objective->name,70)}}.</span> <span class="inline-block px-1 mx-1 text-black bg-gray-200 rounded-lg"> Objective for Review  </span> - {{$not_approved_objective->updated_at->diffForHumans(null,true,true)}}
                    </p>
                </a>
                @empty

                @endforelse
                @endif

                @forelse ($objective_notifications as $objective_notifi)
                @if ($objective_notifi->subject->deleted_at)
                <span class="{{($objective_notifi->subject->deleted_at?'cursor-not-allowed bg-gray-50':'hover:bg-gray-100')}} flex items-center px-4 py-3 -mx-2 border-b ">
                    <img class="object-cover w-8 h-8 mx-1 rounded-full" src="{{$objective_notifi->causer->profile_photo_url}}" alt="avatar">
                    <p class="mx-2 text-sm text-gray-600">
                        <span class="font-bold" href="#">{{$objective_notifi->causer->name}} </span> {{$objective_notifi->description}} <span class="font-bold text-blue-500" href="#">{{Str::limit($objective_notifi->subject->name,70)}}.</span> <span class="px-1 mx-1 text-white bg-yellow-500 rounded-lg"> Objective  </span> - {{$objective_notifi->subject->updated_at->diffForHumans(null,true,true)}}
                    </p>
                </span>

                @else
                <a href="#" wire:click="openObjective({{ $objective_notifi->id }})"  class="{{($objective_notifi->subject->deleted_at?'cursor-not-allowed bg-gray-50':'hover:bg-gray-100')}} flex items-center px-4 py-3 -mx-2 border-b ">
                    <img class="object-cover w-8 h-8 mx-1 rounded-full" src="{{$objective_notifi->causer->profile_photo_url}}" alt="avatar">
                    <p class="mx-2 text-sm text-gray-600">
                        <span class="font-bold" href="#">{{$objective_notifi->causer->name}} </span> {{$objective_notifi->description}} <span class="font-bold text-blue-500" href="#">{{Str::limit($objective_notifi->subject->name,70)}}.</span> <span class="inline-block px-1 mx-1 text-white bg-yellow-500 rounded-lg"> Objective  </span> - {{$objective_notifi->subject->updated_at->diffForHumans(null,true,true)}}
                    </p>
                </a>

                @endif

                @empty
                {{-- <p class="mx-2 text-sm text-center text-gray-600">
                    No New Objective Notifications
                </p> --}}
                @endforelse
                {{-- <hr class="h-1 bg-yellow-500"> --}}


                @forelse ($scorecards_notifications as $scorecard_notifi)
                <a href="#" wire:click="openScorecard({{ $scorecard_notifi->id }})"  wire:key="{{ $scorecard_notifi->id }}" class="flex items-center px-4 py-3 -mx-2 border-b hover:bg-gray-100">
                    <img class="object-cover w-8 h-8 mx-1 rounded-full" src="{{$scorecard_notifi->causer->profile_photo_url}}" alt="avatar">
                    <p class="mx-2 text-sm text-gray-600">
                        <span class="font-bold" href="#">{{ucwords($scorecard_notifi->causer->name)}} </span> {{$scorecard_notifi->description}} <span class="font-bold text-blue-500" href="#">{{ Str::limit($scorecard_notifi->subject->title,70)}}.</span> <span class="px-1 text-white bg-blue-400 rounded-lg whitespace-nowrap"> scorecard  </span> -  {{$scorecard_notifi->updated_at->diffForHumans(null,true,true)}}
                    </p>
                </a>

                @empty
                {{-- <p class="mx-2 text-sm text-center text-gray-600">
                    No New Scorecard Notifications
                </p> --}}
                @endforelse


                {{-- <hr class="h-1 bg-yellow-500">  --}}

                @forelse ($keyresults_notifications as $keyresults_notifi)
                <a href="#"  wire:click="openKeyResult({{ $keyresults_notifi->id }})" wire:key="{{ $keyresults_notifi->id }}" class="flex items-center px-4 py-3 -mx-2 border-b hover:bg-gray-100">
                    <img class="object-cover w-8 h-8 mx-1 rounded-full" src="{{$keyresults_notifi->causer->profile_photo_url}}" alt="avatar">
                    <p class="mx-2 text-sm text-gray-600">
                        <span class="font-bold" href="#">{{ucwords($keyresults_notifi->causer->name)}} </span> {{$keyresults_notifi->description}} <span class="font-bold text-blue-500" href="#">{{ Str::limit($keyresults_notifi->subject->content,70)}}.</span><span class="px-1 mx-1 text-white bg-green-400 rounded-lg whitespace-nowrap "> key result  </span> - {{$keyresults_notifi->updated_at->diffForHumans(null,true,true)}}
                    </p>
                </a>

                @empty
                {{-- <p class="mx-2 text-sm text-center text-gray-600">
                    No New KeyResults Notifications
                </p> --}}
                @endforelse



            </div>
            <a href="#" class="block py-2 font-bold text-center text-white bg-gray-800">See all notifications</a>
        </div>
    </div>



    <div x-data="{ dropdownOpen: false }"  class="relative mr-6" wire:poll.60s>
        <button @click="dropdownOpen = !dropdownOpen" class="relative z-10 block p-1 {{($unreadMessagesCount>0)?'bg-green-400':''}}   rounded-md focus:outline-none" wire:click='unreadMessages()'>
            @if ($unreadMessagesCount>0)
            <p  class="absolute bg-green-600 bottom-2 justify-center mr-4 px-1 right-1.5 rounded-full text-white text-xs top-1 shadow-lg"> {{$unreadMessagesCount}} </p>
            @endif

            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="white">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z" />
              </svg>
        </button>

        <div x-show="dropdownOpen" x-cloak @click="dropdownOpen = false" class="fixed inset-0 z-10 w-full h-full"></div>

        <div x-show="dropdownOpen" x-cloak class="absolute right-0 z-10 mt-2 overflow-hidden bg-white rounded-md shadow-lg" style="width:30rem;">
            <div class="py-2">
                <svg  wire:loading.delay wire:target="readNow" class="absolute float-right w-6 h-6 text-sm text-green-400 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-50" cx="12" cy="12" r="10" stroke="green" stroke-width="2"></circle>
                    <path class="opacity-95" fill="white" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                @if ($unreadMessageData)
                    @forelse ($unreadMessageData as $unreadMessage)
                        @if (isset($unreadMessage->chatbox->objectives))

                    <a href="#"  wire:click="readNow({{ $unreadMessage->chatbox->objectives->id }})" wire:key="{{ $unreadMessage->chatbox->objectives->id }}" class="flex items-center px-4 py-3 -mx-2 border-b hover:bg-gray-100">
                    <img class="object-cover w-8 h-8 mx-1 rounded-full" src="{{$unreadMessage->chatbox->user->profile_photo_url}}" alt="avatar">


                    <p class="mx-2 text-sm text-gray-600">
                        <span class="font-bold" >{{ucwords($unreadMessage->chatbox->user->name)}}</span> replied on the <span class="font-bold text-blue-500" href="#">{{Str::limit($unreadMessage->chatbox->objectives->name,20)}} </span> Objective
                        <br>
                        <span class="p-1 text-sm text-gray-600"> {!! Str::limit($unreadMessage->chatbox->content ,80) !!} <span style="font-size: 9px"  class="px-2 py-1 text-gray-400 bg-gray-100 rounded-xl">{{$unreadMessage->created_at->diffForHumans(null,true,true)}} </span> </span>
                    </p>

                                @endif
                    </a>

                    @empty
                    <p class="mx-2 text-sm text-center text-gray-600">
                        No New Chat Notification
                    </p>
                    @endforelse
                @endif

            </div>
            <a href="#" class="block py-2 font-bold text-center text-white bg-gray-800">See all notifications</a>
        </div>
    </div>
</div>






</div>

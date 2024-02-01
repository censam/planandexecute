<div>

    <div wire:poll.60s='unread()'>
        <button class="relative inline-flex rounded-md shadow-sm"  wire:click="openChat({{$type_id}})" :key="$type_id">

            @if ($allCount>0)
            <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 opacity-80" viewBox="0 0 20 20" fill="green">
              <path d="M2 5a2 2 0 012-2h7a2 2 0 012 2v4a2 2 0 01-2 2H9l-3 3v-3H4a2 2 0 01-2-2V5z" />
              <path d="M15 7v2a4 4 0 01-4 4H9.828l-1.766 1.767c.28.149.599.233.938.233h2l3 3v-3h2a2 2 0 002-2V9a2 2 0 00-2-2h-1z" />
            </svg>
            @else
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="green">
               <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z" />
             </svg>
            @endif

              <svg  wire:loading.delay wire:target="openChat" class="absolute w-3 h-3 mt-1 ml-6 text-green animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="green" stroke-width="4"></circle>
                <path class="opacity-75" fill="green" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
              </svg>

              @if ($unreadCount)
              <span class="absolute top-0 right-0 flex w-4 h-4 -mt-1">
                <span class="absolute inline-flex w-full h-full bg-green-400 rounded-full opacity-60 animate-ping"></span>
                <span class="relative inline-flex w-3 h-3 text-white bg-green-500 rounded-full px"></span>
              </span>
              @else

              @endif
        </button>



    </div>

    @if ($isOpen)
    <div class="base-modal">
    {{-- -----------------------------     --}}

            <div class="fixed inset-0 z-30 overflow-y-auto ease-out duration-400 ">
                <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                    <div class="fixed inset-0 transition-opacity">
                        <div class="absolute inset-0 bg-gray-500 opacity-70 "></div>
                    </div>
                    <!-- This element is to trick the browser into centering the modal contents. -->
                    <span style=" height: 100vh;overflow-y: hidden;" class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>
                    <div class="inline-block w-5/12 overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl sm:my-8 sm:align-middle sm:max-w-lg-- sm:w-full--"
                        role="dialog" aria-modal="true"  aria-labelledby="modal-headline">

                        <div class="px-4 py-3 bg-gray-200 ">
                            <div class="flssssex">
                                {{-- chat module start --}}
                                <div class="flex flex-col justify-between flex-1 p:2">
                                    <div class="flex justify-between py-3 border-b-2 border-gray-200 sm:items-center">
                                       <div class="flex items-center space-x-4">
                                          <img src="{{$model->user->profile_photo_url}}" alt="" class="inline object-cover w-10 h-10 mr-2 border-2 border-yellow-300 rounded-full">
                                          <div class="flex flex-col leading-tight">
                                             <div class="flex items-center mt-1 text-2xl">
                                                <span class="mr-3 text-gray-700">{{$model->name}}</span>


                                            </div>
                                            <span class="text-lg text-gray-600"></span>
                                        </div>
                                    </div>

                                    <div>


                                        @if($recordCount < $allCount)
                                        <button wire:click="loadChat()" type="button" class="inline-flex items-center justify-center w-10 h-10 text-gray-500 transition duration-500 ease-in-out rounded-full hover:bg-gray-300 focus:outline-none">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>

                                            <svg  wire:loading.delay wire:target="loadChat" class="absolute w-6 h-6 text-white animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-50" cx="12" cy="12" r="10" stroke="blue" stroke-width="2"></circle>
                                                <path class="opacity-95" fill="white" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                            </svg>

                                        </button>
                                        @endif

                                        <button wire:click="closeChat()" type="button" class="inline-flex items-center justify-center w-10 h-10 text-gray-500 transition duration-500 ease-in-out rounded-full hover:bg-gray-300 focus:outline-none">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </button>

                                    </div>



                                </div>
                                <div wire:poll.15s id="messages" class="flex flex-col p-3 overflow-y-auto scrolling-touch bg-gray-100 max-h-96 rounded-l-3xl scrollbar-thumb-blue scrollbar-thumb-rounded scrollbar-track-blue-lighter scrollbar-w-2">



                                    @forelse ($messages as $message )
                                        {{-- --{{$message->user->profile_photo_url}}-- --}}

                                        <div class="chat-message">
                                            <div class="flex items-end">
                                               <div class="flex flex-col items-start order-2 mx-2 space-y-1 text-sm max-w-prose">
                                                  <div>
                                                      <span class="inline-block px-2 py-1 text-white {{(($user_id != $message->user_id)?'bg-blue-500':'bg-gray-500')}} rounded-lg rounded-bl-none">{!!$message->content!!}</span>

                                                  </div>
                                              </div>
                                              <img src="{{$message->user->profile_photo_url}}" alt="My profile" class="order-1 w-9 h-9 border-2 rounded-full {{(($user_id != $message->user_id)?'border-blue-300':'border-gray-300')}}">
                                          </div>
                                          <span class="order-2 float-right font-thin" style="font-size: 10px">{{$message->created_at->format('h:i A,  j M')}}</span>
                                         </div>


                                        @empty
                                        <div class="w-full p-2 text-center text-white bg-gray-500 border border-gray-400 rounded-xl">
                                            No Messages Yet , Write Somthing Below
                                        </div>
                                        @endforelse



                                    </div>

                                    <div class="relative px-4 pt-4 mb-2 border-t-2 border-gray-200 sm:mb-0">
                                        {{-- <form wire:submit.prevent='sendMessage'> --}}
                                       <div class="relative flex">
                                        @if (!$model->trashed())

                                        <form wire:submit.prevent='sendMessage' class="w-full">
                                            {{-- <input wire:model.defer="content" type="text" placeholder="Write Something" class="w-full py-3 pl-5 pr-20 mr-3 leading-tight text-gray-600 placeholder-gray-600 bg-transparent bg-gray-200 border border-gray-500 border-none rounded-full appearance-none px-18 ring-1 ring-gray-400 focus:outline-none"> --}}
                                            <textarea wire:model.defer="content" placeholder="Write Something" class="w-full py-3 pl-5 pr-20 mr-3 leading-tight text-gray-600 placeholder-gray-600 bg-transparent bg-gray-200 border border-gray-500 border-none rounded-md appearance-none px-18 ring-1 ring-gray-400 focus:outline-none" name="" id="" cols="25" rows="3"></textarea>
                                        </form>



                                            <div class="absolute inset-y-0 right-0 items-center hidden sm:flex" x-data="{ show: false }">

                                                <div class="block" >
                                                    <div  x-show="show" class="absolute flex flex-col h-32 px-1 py-1 mb-12 overflow-y-scroll text-sm text-gray-500 bg-white border border-gray-300 rounded-lg shadow-lg -top-24 right-20 w-60">
                                                      <div class="grid grid-cols-6 gap-1 px-1 py-1 rounded-lg">
                                                          @forelse ($emoji_set as $key => $emoji)
                                                          <button wire:key='$emoji.$key'  wire:click="addEmoji('{{$emoji}}')" class="p-1 text-sm text-center hover:bg-gray-200 hover:text-white rounded-xl">{{$emoji}}</button>

                                                          @empty
                                                          <span class="p-2 hover:bg-gray-500 hover:text-white rounded-xl">A</span>

                                                          @endforelse


                                                      </div>

                                                    </div>
                                                  </div>



                                                <button @click="show = !show" :aria-expanded="show ? 'true' : 'false'" :class="{ 'active': show }" type="button" class="inline-flex items-center justify-center w-10 h-10 text-gray-500 transition duration-500 ease-in-out rounded-full hover:bg-gray-300 focus:outline-none">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6 text-gray-600">
                                                   <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                             </button>
                                             <button wire:click="sendMessage()" type="button" class="inline-flex items-center justify-center w-12 h-12 text-white transition duration-500 ease-in-out bg-blue-500 rounded-full hover:bg-blue-400 focus:outline-none">
                                                 <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-6 h-6 transform rotate-90">
                                                    <path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z"></path>
                                                </svg>

                                                <svg  wire:loading.delay wire:target="sendMessage" class="absolute w-12 h-12 text-red-300 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                    <circle class="opacity-25" cx="16" cy="16" r="14" stroke="currentColor" stroke-width="1"></circle>
                                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                                </svg>
                                            </button>
                                            </div>

                                            @endif


                                       </div>
                                        {{-- </form> --}}
                                    </div>
                                 </div>

                                 <style>
                                 .scrollbar-w-2::-webkit-scrollbar {
                                   width: 0.25rem;
                                   height: 0.25rem;
                                 }

                                 .scrollbar-track-blue-lighter::-webkit-scrollbar-track {
                                   --bg-opacity: 1;
                                   background-color: #f7fafc;
                                   background-color: rgba(247, 250, 252, var(--bg-opacity));
                                 }

                                 .scrollbar-thumb-blue::-webkit-scrollbar-thumb {
                                   --bg-opacity: 1;
                                   background-color: #edf2f7;
                                   background-color: rgba(237, 242, 247, var(--bg-opacity));
                                 }

                                 .scrollbar-thumb-rounded::-webkit-scrollbar-thumb {
                                   border-radius: 0.25rem;
                                 }

                                body{
                                overflow: hidden;
                                background-color: rgb(202, 49, 49)
                                }

                                .base-modal{
                                    height: 10px;
                                    overflow: hidden;

                                }

                                 </style>

                                 <script>
                                     const el = document.getElementById('messages')
                                     el.scrollTop = el.scrollHeight;

                                    window.addEventListener('messagebox_scrolled', event => {
                                        el.scrollTop = el.scrollHeight;
                                    })


                                 </script>
                                {{-- chat module end --}}




                            </div>
                        </div>
                    </div>
                </div>




    {{-- -----------------------------     --}}
    </div>
    @else

    @endif

</div>

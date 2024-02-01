<div
    x-data="
        {
             isEditing: false,
             isName: '{{ $isName }}',
             focus: function() {
                const textInput = this.$refs.textInput;
                textInput.focus();
                textInput.select();
             }
        }
    "
    x-cloak
>
    <div  x-show=!isEditing>
        <div x-on:click="isEditing = true; $nextTick(() => focus())" class="cursor-pointer ">
            @if ($origName)
            @if (strpos(\Carbon\Carbon::parse($origName)->diffForHumans(), 'ago') !== false)
            <span class="px-3 py-1 text-xs text-red-600 bg-red-200 rounded-full">{!! date('d-M-y',
                strtotime($origName)) !!}</span>
            @else
            <span class="px-3 py-1 text-xs text-yellow-600 bg-yellow-200 rounded-full">{!! date('d-M-y',
                strtotime($origName)) !!}</span>
            @endif

            @else
                <span class="cursor-pointer ">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="gray">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </span>
            @endif
        </div>
    </div>
    <div x-show=isEditing class="flex flex-col">
        <form class="" wire:submit.prevent="save">
            <input
                type="date"
                class="w-32 text-sm truncate border-b border-none outline-none h-7 focus:outline-none"
                x-ref="textInput"
                placeholder="07/04/2021"
                wire:model.defer="newName"
                x-on:keydown.enter="!isEditing"
                x-on:keydown.escape="isEditing = false"
                required
            >

            <div class="inline-flex -ml-0.5 w-32">
                <button type="button" class="inline-flex items-center justify-center w-1/2 h-5 text-gray-500 transition duration-500 ease-in-out w-/2 hover:bg-gray-300 focus:outline-none" title="Cancel" x-on:click="isEditing = false">Cancel</button>
                <button type="button" wire:click="clear" class="inline-flex items-center justify-center w-1/2 h-5 text-gray-500 transition duration-500 ease-in-out w-/2 hover:bg-gray-300 focus:outline-none" title="Cancel" x-on:click="isEditing = false">Clear</button>

                <button
                type="submit"
                class="inline-flex items-center justify-center w-1/2 h-5 text-gray-500 transition duration-500 ease-in-out hover:bg-gray-300 focus:outline-none"
                title="Save"
                x-on:click="isEditing = false"
                >Save</button>
            </div>
        </form>
        {{-- <small class="text-xs text-gray-400">Enter to save, Esc to cancel</small> --}}
    </div>
</div>


<style>
    input[type="date"]::-webkit-calendar-picker-indicator {
    color: rgba(0, 0, 0, 0);
    opacity: 1;
    display: block;
    width: 15px;
    height: 15px;
    margin-left: -3px;
    border-width: thin;
}
</style>

<div
    x-data="
        {
             isEditing: false,
             isName: `{{ $isName }}`,
             focus: function() {
                const textInput = this.$refs.textInput;
                textInput.focus();
                textInput.select();
             }
        }
    "
    x-cloak
>
    <div class="p-2" x-show=!isEditing>
        <span
            x-on:click="isEditing = true; $nextTick(() => focus())"
        >{{ $origName }}</span>
    </div>
    <div x-show=isEditing class="flex flex-col">
        <form class="flex" wire:submit.prevent="save">
            <input
                type="text"
                class="w-10/12 h-8 text-sm border-b border-none outline-none focus:outline-none"
                placeholder="100 characters max."
                x-ref="textInput"
                wire:model.lazy="newName"
                x-on:keydown.enter="!isEditing"
                x-on:keydown.escape="isEditing = false"
            >
            <button type="button" class="pl-2 focus:outline-none" title="Cancel" x-on:click="isEditing = false"><i class="fas fa-undo-alt"></i></button>
            <button
                type="submit"
                class="pl-1 text-green-700 focus:outline-none"
                title="Save"
                x-on:click="isEditing = false"
            ><i class="fas fa-check"></i></button>
        </form>
        <small class="text-xs text-gray-400">Enter to save, Esc to cancel</small>
    </div>
</div>

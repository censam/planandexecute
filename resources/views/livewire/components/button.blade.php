<div class="mt-1">
   <div class="relative inline-block w-16 mr-2 align-middle select-none transition duration-200 ease-in">
       <input wire:model="isActive" type="checkbox" name="toggle-{{$field_id}}" id="toggle-{{$field_id}}" class="focus:outline-none toggle-checkbox absolute block w-8 h-6 rounded-full bg-white border-4 appearance-none cursor-pointer">
       <label for="toggle" id="label-{{$field_id}}" class="toggle-label block overflow-hidden h-6 rounded-full bg-gray-300 cursor-pointer"></label>
   </div>
</div>

<style>
    .toggle-checkbox:checked{
        @apply:bg-blue-800;
        right:0;
        /* border-color:#680391; */
    }

    .toggle-checkbox:checked + .toggle-label{
        @apply:bg-yellow-600;
        right:0;
        /* background-color:rgba(217, 119, 6, .5); */
    }
</style>

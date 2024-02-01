<div>
    <select class="py-1 text-xs uppercase bg-white rounded-md dark:bg-gray-800 dark:text-gray-300" name="selecting" wire:model="selecting">
        @foreach ($options as $key => $option)
        <option value="{{$key}}" >{{$option}}</option>
        @endforeach
    </select>
    @if ($message)
    <span class="inline-flex"><svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="green">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
      </svg></span>
    @endif

</div>

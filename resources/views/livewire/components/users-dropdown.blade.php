<div>

    <select wire:model="selected_user"  name="{{$field}}" class="p-2 px-4 py-2 pr-8 leading-tight bg-white border border-gray-400 rounded shadow appearance-none hover:border-gray-500 focus:outline-none focus:shadow-outline">
        <option value=''>Assign a member</option>
        @foreach($team->allUsers() as $member)
        <option value='{{$member->id}}'> {{ucwords($member->name)}}</option>
        @endforeach
     </select>
</div>

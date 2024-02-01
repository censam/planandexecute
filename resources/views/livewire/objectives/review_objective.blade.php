
<div class="bg-{{$color}}-200 px-4 pt-5 pb-4 sm:p-6 sm:pb-4 rounded-lg">
<div class="">

    <div class="mb-4">
        <label for="Name" class="block text-lg font-semibold mb-2 text-gray-700">User Name:</label>
        <div class="my-3 text-gray-700 ">{{ucwords($objective->user->name)}}</div>

    </div>

    <div class="mb-4">
        <label for="Name" class="block text-lg font-semibold mb-2 text-gray-700">Name:</label>
        <div class="my-3 text-gray-700">{{$objective->name}}</div>

    </div>
    <div class="mb-4">
        <label for="description" class="block text-lg font-semibold mb-2 text-gray-700">Description:</label>
        <div class="my-3 text-gray-700">{{$objective->description}}</div>

    </div>
    <div class="mb-4">
        <label for="due_date" class="block text-lg font-semibold mb-2 text-gray-700">Due Date:</label>
        <div class="my-3 text-gray-700">{{$objective->due_date}}</div>

    </div>
    <div class="mb-4">
        <label for="key_results" class="block text-lg font-semibold mb-2 text-gray-700">Key Results:</label>
        <div class="my-3 text-gray-700">{{$objective->key_results}}</div>

    </div>
</div>

</div>



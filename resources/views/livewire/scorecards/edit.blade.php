<div>
    <div class="fixed inset-0 z-10 overflow-y-auto ease-out duration-400 ">
        <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity">
                <div class="absolute inset-0 bg-gray-500 opacity-100"></div>
            </div>
            <!-- This element is to trick the browser into centering the modal contents. -->
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>
            <div class="inline-block w-3/6 overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl sm:my-8 sm:align-middle sm:max-w-lg-- sm:w-full--"
                role="dialog" aria-modal="true" aria-labelledby="modal-headline">

                <div class="px-4 py-3 bg-gray-200">
                    <div class="flex">
                        <div class="w-4/12">
                        </div>

                        <div class="w-3/12">
                            @if ($isAdmin)
                            <livewire:components.select-box hasTimeStamp='false' :options="$options"
                                :model="$current_scorecard" field="completed" :key="now()->timestamp" />
                            @endif
                        </div>

                        <div class="w-5/12">
                            <span class="flex float-right">

                                <button wire:click.prevent="update()" type="button"
                                    class="px-3 py-1 mx-2 text-green-500 transition duration-300 border border-green-500 rounded w-44 hover:bg-green-600 hover:text-white focus:outline-none">
                                    Save
                                </button>

                                <button wire:click="closeModal()" type="button"
                                    class="float-right px-3 py-1 mx-2 text-gray-500 transition duration-300 border border-gray-500 rounded hover:bg-gray-600 hover:text-white focus:outline-none">
                                    Cancel
                                </button>

                            </span>
                        </div>


                    </div>
                </div>




                <div class="px-4 pt-5 pb-4 bg-white sm:p-6 sm:pb-4">
                    <div x-data={active:'scorecard-history'}>
                        <div class="flex justify-between mb-2">
                            <div>
                                <span @click="active = 'scorecard'" :class="{'bg-green-400': active === 'scorecard'}"
                                    class="px-4 py-2 font-bold text-white bg-gray-300 hover:bg-gray-600 rounded-b-xl"
                                    type="button">Scorecard</span>

                                <span @click="active = 'scorecard-history'"
                                    :class="{'bg-green-400': active === 'scorecard-history'}"
                                    class="px-4 py-2 font-bold text-white bg-gray-300 hover:bg-gray-600 rounded-b-xl"
                                    type="button">Scorecard History

                                    <span class="px-2 font-semibold text-white bg-gray-700 rounded-full">
                                        {{count($current_scorecard->histories)}}
                                    </span>

                                </span>

                            </div>
                        </div>

                        <div x-show="active === 'scorecard'">
                            <div class="flex w-full mb-4">
                                @if ($isAdmin)
                                <div class="w-6/12">
                                    <label for="assign_user" class="block mb-2 text-sm font-bold text-gray-700">Assign
                                        User:</label>
                                    <livewire:components.users-dropdown field="user_id" :owner="$user_id" />
                                    @error('user_id') <span class="text-red-500">{{ $message }}</span>@enderror
                                </div>
                                @endif

                                <div class="w-6/12">
                                    <label for="recurring_time"
                                        class="block mb-2 text-sm font-bold text-gray-700">Recurring Time:</label>
                                    <select
                                        class="w-48 p-2 px-4 py-2 pr-8 leading-tight bg-white border border-gray-400 rounded shadow appearance-none hover:border-gray-500 focus:outline-none focus:shadow-outline"
                                        name="timer" wire:model="timer">
                                        <option value="">Select Time</option>
                                        <option value="weekly">Weekly</option>
                                        <option value="bi-weekly">Bi-Weekly</option>
                                        <option value="monthly">Monthly</option>
                                        <option value="quarterly">Quarterly</option>
                                        <option value="annual">Annual</option>
                                    </select>
                                    @error('timer') <br> <span class="text-red-500">{{ $message }}</span>@enderror
                                </div>




                            </div>
                            <div class="mb-4">
                                <label for="Title" class="block mb-2 text-sm font-bold text-gray-700">Title:</label>
                                <input type="text"
                                    class="w-full px-3 py-2 leading-tight text-gray-700 border border-gray-200 rounded shadow appearance-none focus:bg-gray-100 focus:outline-none focus:shadow-outline"
                                    id="Title" placeholder="Enter ScoreCard Title" wire:model.defer="title">
                                @error('title') <span class="text-red-500">{{ $message }}</span>@enderror
                            </div>
                            <div class="mb-4">
                                <label for="next_due_date" class="block mb-2 text-sm font-bold text-gray-700">Next Due
                                    Date:</label>
                                <input type="date"
                                    class="w-full px-3 py-2 leading-tight text-gray-700 border border-gray-200 rounded shadow appearance-none focus:bg-gray-100 focus:outline-none focus:shadow-outline"
                                    id="next_due_date" placeholder="Enter Due Date" wire:model.defer="next_due_date">
                                @error('next_due_date') <span class="text-red-500">{{ $message }}</span>@enderror
                            </div>
                            <div class="mb-4">
                                <label for="Description"
                                    class="block mb-2 text-sm font-bold text-gray-700">Description:</label>
                                <textarea rows="5" cols="50"
                                    class="w-full px-3 py-2 leading-tight text-gray-700 border border-gray-200 rounded shadow appearance-none focus:bg-gray-100 focus:outline-none focus:shadow-outline"
                                    id="description" wire:model.defer="description"
                                    placeholder="Enter Description"></textarea>
                                @error('description') <span class="text-red-500">{{ $message }}</span>@enderror
                            </div>
                            <div class="mb-4">
                                <label for="kpi_metric" class="block mb-2 text-sm font-bold text-gray-700">KPI
                                    Goal:</label>
                                <input type="text"
                                    class="w-full px-3 py-2 leading-tight text-gray-700 border border-gray-200 rounded shadow appearance-none focus:bg-gray-100 focus:outline-none focus:shadow-outline"
                                    id="kpi_metric" placeholder="Enter KPI Goal" wire:model.defer="kpi_metric">
                                @error('kpi_metric') <span class="text-red-500">{{ $message }}</span>@enderror
                            </div>

                        </div> {{--  scorecard panel end --}}

                        <div x-show="active === 'scorecard-history'">
                            <div class="mb-4" style="min-height: 200px">
                                {{-- <label for="key_results" class="block mb-2 text-sm font-bold text-gray-700">Key
                                    results:</label> --}}

                                    <livewire:components.score-card-history :scorecard="$current_scorecard" :key="now()->timestamp" viewtype="edit" />

                            </div>
                        </div>



                    </div>


                </div>
            </div>
        </div>
    </div>
</div>

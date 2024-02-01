@props(['active'])

<div x-data="{
        activeTab: '{{ $active }}',
        tabs: [],
        tabHeadings: [],
        toggleTabs() {
            this.tabs.forEach(
                this.myfunc
            )
            this.tabs.forEach(
                tab => tab.showIfActive(this.activeTab)
            );
        },
        myfunc(item, index, arr){
            console.log(arr[0])
            {{-- item.showIfActive('second') --}}
        }

     }"
     x-init="() => {
        tabs = [...$refs.tabs.children];
        tabHeadings = tabs.map((tab, index) => {
            tab.__x.$data.id = (index + 1);
            return tab.__x.$data.name;
        });
        toggleTabs();

     }"
>
    <div class="mb-3"
         role="tablist"
    >
        <template x-for="(tab, index) in tabHeadings"
                  :key="index"
        >
            <button x-text="tab"
                    @click="activeTab = tab; toggleTabs();"
                    class="px-4 py-1 text-sm rounded hover:bg-blue-500 hover:text-white"
                    :class="tab === activeTab ? 'bg-blue-500 text-white' : 'text-gray-800'"
                    :id="`tab-${index + 1}`"
                    role="tab"
                    :aria-selected="(tab === activeTab).toString()"
                    :aria-controls="`tab-panel-${index + 1}`"
            ></button>
        </template>
    </div>

    <div x-ref="tabs">
        {{ $slot }}
    </div>
</div>

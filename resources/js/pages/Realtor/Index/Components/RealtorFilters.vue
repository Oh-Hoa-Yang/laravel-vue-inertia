<template>
    <form>
        <div class="mb-4 mt-4 flex flex-wrap gap-2">
            <div class="flex flex-nowrap items-center gap-2">
                <input 
                    v-model="filterForm.deleted"
                    type="checkbox" 
                    id="deleted" 
                    class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                />
                <label for="deleted">Deleted</label>
            </div>
        </div>
    </form>
</template>

<script setup>
import { router } from '@inertiajs/vue3';
import { debounce } from 'lodash';
import { reactive, watch } from 'vue';

const filterForm = reactive({
    deleted: false,
})

watch(
    // In old way, we use Inertia.get() and we need to import {Inertia} from '@inertiajs/inertia'
    // but now, we use router.get() and we need to import { router } from '@inertiajs/vue3'
    // debounce is used to prevent the function from being called too often --> tutorial explain: debounce returns a new function and function returned by the bounce whenever it's called in the timespan specified as the second argument to the bounce is being ignored and only the last call after this timespan passes is being actually called.
    // My words of explanation: if we set the debounce to 1s, and if the user click the button 0.5s and clicked again, the request will be cancelled and as long as 1s of time taken, only the debounce function works. 
    filterForm, debounce(() => router.get(
        route('realtor.listing.index'),
        filterForm,
        {
            preserveState: true,
            preserveScroll: true,
        }
    ), 1000)
)
</script>
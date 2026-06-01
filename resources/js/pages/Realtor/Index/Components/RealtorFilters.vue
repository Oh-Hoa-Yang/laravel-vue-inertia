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
import { reactive, watch } from 'vue';
import { router } from '@inertiajs/vue3';

const filterForm = reactive({
    deleted: false,
})

watch(
    // In old way, we use Inertia.get() and we need to import {Inertia} from '@inertiajs/inertia'
    // but now, we use router.get() and we need to import { router } from '@inertiajs/vue3'
    filterForm, () => router.get(
        route('realtor.listing.index'),
        filterForm,
        {
            preserveState: true,
            preserveScroll: true,
        }
    )
)
</script>
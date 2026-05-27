<template>
    <Filters />
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
        <!-- listing would be found under listings.data -->
        <Listing v-for="listing in listings.data" :key="listing.id" :listing="listing" />
    </div>

    <!-- conditional rendering - v-if -->
    <div v-if="listings.data.length" class="w-full flex justify-center mt-4 mb-4">
        <!-- .links is the property on this new object (in defineProps) that Laravel returns when you call this paginate (->paginate(10) in ListingController) -->
        <Pagination :links="listings.links" />
    </div>
</template>

<script setup>
import Pagination from '@/Components/UI/Pagination.vue';
import Filters from './Index/Components/Filters.vue';
import Listing from './Index/Components/Listing.vue';

defineProps({
    // Become an Object
    listings: Object,
})
</script>
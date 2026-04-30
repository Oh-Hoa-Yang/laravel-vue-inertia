<template>
<div v-for="listing in listings" :key="listing.id">
    <div>
        <Link :href="route('listing.show', {listing: listing.id})">
            <ListingAddress :listing="listing" />
        </Link>
    </div>å
    <div>
        <Link :href="route('listing.edit', {listing: listing.id})" >
            Edit
        </Link>
    </div>
    <div>
        <!-- The current Inertia version, no longeår needs to use 'as="button"', it automatically converts to button -->
        <Link :href="route('listing.destroy', {listing: listing.id})" method="DELETE" as="button">
            Delete
        </Link>
    </div>
</div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import ListingAddress from '../../Components/ListingAddress.vue';
defineProps({
    listings: Array,
})
</script>
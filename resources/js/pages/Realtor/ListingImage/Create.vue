<template>
    <!-- enctype="multipart/form-data" it's just something you need to do every time you upload files -->
    <form 
        enctype="multipart/form-data"
        method="POST" 
        :action="route('realtor.listing.image.store', {listing: listing.id})">
        <!-- This 'name' will be using inside the controller, not 'files' (edited) -->
         <!-- We accept multiple files always, even if you just upload one file for that. The name should contain square bracket like an array of things -->
        <input type="file" multiple name="images[]" /> 
        <button type="submit">Send</button>
    </form>
</template>

<script setup>
defineProps({
    listing: Object
})
</script>
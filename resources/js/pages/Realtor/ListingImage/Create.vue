<template>
    <Box>
        <template #header>
            Upload New Images
        </template>
        <form @submit.prevent="upload">
            <!-- This 'name' will be using inside the controller, not 'files' (edited) -->
             <!-- We accept multiple files always, even if you just upload one file for that. The name should contain square bracket like an array of things -->
            <input type="file" multiple @input="addFiles" /> 
            <button type="submit" class="btn-outline">Upload</button>
            <button type="reset" class="btn-outline" @click="reset">Reset</button>
        </form>
    </Box>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3';
import Box from '@/Components/UI/Box.vue';

const props = defineProps({
    listing: Object
})

const form = useForm({
    images: [],
})

const upload = () => {
    form.post(
        route('realtor.listing.image.store', { listing: props.listing.id}),
        {
            onSuccess: () => form.reset('images'),
        }
    )
}

const addFiles = (event) => {
    for (const image of event.target.files) {
        form.images.push(image)
    }
}

const reset = () => form.reset('images')
</script>
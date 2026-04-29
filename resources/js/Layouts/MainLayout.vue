<template>
    <Link href="/">Main Page</Link>&nbsp;
    <Link href="/hello">Show Page</Link>
    <!-- <div>The page with time {{ timer }}</div> -->
     <!-- Display the flash message -->
      <div v-if="flashSuccess" class="success">
        {{ flashSuccess }}
      </div>
      <div>
        {{ y }}
      </div>
    <slot></slot>
</template>

<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

const x = ref(0)
const y = computed(() => x.value * 2)
// import { ref } from 'vue';

// const timer = ref(0);

// setInterval(() => timer.value++, 1000);

// To access the data shared through this middleware, you will use page.props.value as this is a ref and then the structure of your data (in HandleInertiaRequests) is flash.success
// page.props.value.flash.success
const page = usePage()

const flashSuccess = computed(() => page.props.flash?.success )
</script>

<style scoped>
.success{
    background-color: green;
    color: white;
}
</style>
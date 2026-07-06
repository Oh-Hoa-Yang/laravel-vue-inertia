<template>
    <div>You need be verified first to see this page!</div>
    <div>
        <Link 
            :href="route('verification.send')" 
            method="POST" 
            class="text-indigo-600 dark:text-indigo-400"
        >
            Resend verification email
        </Link>
    </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
</script>
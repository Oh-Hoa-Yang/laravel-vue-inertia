<template>
    <Box>
        <template #header>Make an Offer</template>
        <div>
            <form action="">
                <input 
                    v-model.number="form.amount" 
                    type="text" 
                    class="input" 
                />
                <input 
                    v-model.number="form.amount"
                    class="mt-2 w-full h-4 bg-gray-200 rounded-lg appearance-none cursor-pointer dark:bg-gray-700" 
                    type="range" 
                    :min="min" 
                    :max="max" 
                    step="10000" 
                /> 

                <button type="submit" class="btn-outline w-full mt-2 text-sm">
                    Make an Offer
                </button>
            </form>
        </div>
        <div class="flex justify-between text-gray-500 mt-2">
            <div>Difference</div>
            <div>
                <Price :price="difference" />
            </div>
        </div>
    </Box>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3';
import { computed } from 'vue';
import Box from '@/Components/UI/Box.vue';
import Price from '../../../../Components/Price.vue';

const props = defineProps({
    listingId: Number, //we would need the listingId to make a call to the backend
    price: Number, //  Price is just a starting price that would be displayed on this form. 
})

const form = useForm({
    amount: props.price
})

const difference = computed(() => form.amount - props.price)

const min = computed(() => props.price / 2)
const max = computed(() => props.price * 2)
</script>
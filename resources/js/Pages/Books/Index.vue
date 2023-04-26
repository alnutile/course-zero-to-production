<template>
    <AppLayout title="Your Books">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight flex justify-between">
                Your Books

                <SecondaryButtonLink :href="route('books.create')" >create a book</SecondaryButtonLink>
            </h2>
        </template>


        <div class="max-w-7xl flex mx-auto p-4">
           <Cards :books="books"/>
        </div>
    </AppLayout>

</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from "@inertiajs/vue3"
import Cards from "./Partials/Cards.vue"
import SecondaryButtonLink from "@/Components/SecondaryButtonLink.vue";

defineProps({
    books: Object
})

</script>

<style scoped>

</style>

<template>
    <AppLayout :title="book.title">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Book {{ book.title }}
            </h2>
        </template>


        <div class="container mx-auto sm:px-6 lg:px-8 rounded rounded-lg border-gray-600
        bg-gray-800
        border mt-4
">
            <div class="text-white max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <h3 class="text-gray-400">Details</h3>
                <ul>
                    <li class="flex justify-start gap-2">
                        <Label>ID:</Label>
                        {{ book.id }}
                    </li>
                    <li class="flex justify-start gap-2">
                        <Label>Owner:</Label>
                        {{ book.owner.name }}</li>
                    <li class="flex justify-start gap-2">
                        <Label>ISBN:</Label>
                        {{ book.isbn }}</li>
                    <li class="flex justify-start gap-2">
                        <Label>Completed At:</Label>
                        <span v-if="book.completed_at">{{ book.completed_at }}</span><span v-else>not done</span>
                    </li>
                </ul>

            </div>
        </div>
    </AppLayout>

</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Label from "@/Components/Label.vue";


defineProps({
    book: Object
})




</script>

<style scoped>

</style>

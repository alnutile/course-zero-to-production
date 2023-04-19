<template>
    <AppLayout title="Your Books">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight flex justify-between">
                Your Books

                <Link :href="route('books.create')" class="underline">create</Link>
            </h2>
        </template>


        <div>
            <div class="text-white max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <div class="grid grid-cols-2 gap-4">
                    <div class="card card-side bg-base-100 shadow-xl rounded-none" v-for="book in books" :key="book.id">
                        <figure class="p-2">
                            <img :src="book.book_image_path" :alt="book.title"/>
                        </figure>
                        <div class="card-body ">
                            <h2 class="card-title">{{ book.title }}</h2>
                            <div class="card-actions justify-end">
                                <Link
                                    :href="route('books.show', {
                                        book: book.id
                                    })"
                                    class="btn btn-primary rounded-none">View</Link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>

</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from "@inertiajs/vue3"

defineProps({
    books: Object
})

</script>

<style scoped>

</style>

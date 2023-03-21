<template>
    <AppLayout title="Your Books">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Your Books
            </h2>
        </template>


        <div>
            <div class="text-white max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <div class="grid grid-cols-2 gap-4">
                    <div class="card card-side bg-base-100 shadow-xl" v-for="book in books" :key="book.id">
                        <figure>
                            <img src="/images/stock/photo-1635805737707-575885ab0820.jpg" alt="Movie"/>
                        </figure>
                        <div class="card-body">
                            <h2 class="card-title">{{ book.title }}</h2>
                            <p>Click the button to watch on Jetflix app.</p>
                            <div class="card-actions justify-end">
                                <button class="btn btn-primary">Watch</button>
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

defineProps({
    books: Object
})

</script>

<style scoped>

</style>

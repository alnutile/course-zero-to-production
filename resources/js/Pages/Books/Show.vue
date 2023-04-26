<template>
    <AppLayout :title="book.title">
        <template #header>
            <div class="flex mx-auto justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    Book {{ book.title }}
                </h2>
                <Link class="btn-xs" :href="route('books.edit', {book: book.id})">
                    <svg
                        class="w-4 h-4"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                    </svg>
                </Link>
            </div>
        </template>


        <div class="container mx-auto sm:px-6 lg:px-8  border-gray-600
        bg-gray-800
        border mt-4">
            <div class="text-white max-w-7xl
            mx-auto py-10 sm:px-6 lg:px-8
            grid grid-cols-2 gap-2
            ">
                <div>
                    <h3 class="text-gray-400">Details</h3>
                    <BookDetails :book="book"/>
                </div>
                <div>
                    <h3 class="text-gray-400">Chapters</h3>
                    <ul>
                        <li v-for="chapter in book.chapters" :key="chapter.id" class="truncate">
                            #{{ chapter.number }} - {{ chapter.content }}
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="container mx-auto sm:px-6 lg:px-8 border-gray-600
        bg-gray-800  border mt-4 pb-10 sm:py-4">
            <SectionTitle>
                <template #title>
                    Use OpenAI to kickoff a chapter
                </template>
                <template #description>
                    Add your context here about the chapter and we will send it to OpenAI to see what it comes up with.
                </template>
            </SectionTitle>

           <ChapterMaker :book="book">

           </ChapterMaker>
        </div>
    </AppLayout>

</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import BookDetails from "./Partials/BookDetails.vue";
import ChapterMaker from "./Partials/ChapterMaker.vue";
import { Link } from "@inertiajs/vue3";
import SectionTitle from "@/Components/SectionTitle.vue";
import {onMounted} from "vue";
import {useToast} from "vue-toastification";
const toast = useToast();

const props = defineProps({
    book: Object
})



</script>

<style scoped>

</style>

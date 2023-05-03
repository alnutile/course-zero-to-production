<template>
    <div class="divide-y divide-gray-200 overflow-hidden rounded-lg bg-slate-400 shadow sm:grid sm:grid-cols-2 sm:gap-px sm:divide-y-0">
        <div v-for="(book, bookId) in books" :key="book.id" :class="[bookId === 0 ? 'rounded-tl-lg rounded-tr-lg sm:rounded-tr-none' : '', bookId === 1 ? 'sm:rounded-tr-lg' : '', actionIdx === books.length - 2 ? 'sm:rounded-bl-lg' : '', bookId === books.length - 1 ? 'rounded-bl-lg rounded-br-lg sm:rounded-bl-none' : '', 'group relative bg-slate-800 p-6 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-500']">
            <div class="flex justify-start gap-4 items-center">
                <span  class="inline-flex rounded-lg p-3 ring-2 ring-slate-400">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                    </svg>
                </span>
                <h3 class="text-base font-semibold leading-6 text-gray-300  uppercase">
                    <Link :href="route('books.show', {
                                        book: book.id
                                    })" class="focus:outline-none">
                        <!-- Extend touch target to entire panel -->
                        <span class="absolute inset-0" aria-hidden="true" />
                        {{ book.title }}
                    </Link>
                </h3>
            </div>
            <div class="mt-8">

                <p class="mt-2 text-sm text-gray-400">
                    {{ book.summary }}
                </p>
            </div>
            <span class="pointer-events-none absolute right-6 top-6 text-gray-300 group-hover:text-gray-400" aria-hidden="true">
            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
              <path d="M20 4h1a1 1 0 00-1-1v1zm-1 12a1 1 0 102 0h-2zM8 3a1 1 0 000 2V3zM3.293 19.293a1 1 0 101.414 1.414l-1.414-1.414zM19 4v12h2V4h-2zm1-1H8v2h12V3zm-.707.293l-16 16 1.414 1.414 16-16-1.414-1.414z" />
            </svg>
          </span>
        </div>
    </div>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";

const props = defineProps({
    books: Array
})
</script>

<style scoped>

</style>

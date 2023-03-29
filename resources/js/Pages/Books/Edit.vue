<template>
    <AppLayout title="Edit">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Edit Book {{ book.title}} #{{book.id}}
            </h2>
        </template>


        <div class="container mx-auto sm:px-6 lg:px-8 rounded rounded-lg border-gray-600
        bg-gray-800
        border mt-4
">
            <div class="text-white max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <form @submit.prevent="submit">
                    <ResourceForm
                    v-model="form"
                    />

                    <div class="flex items-center justify-end mt-4">
                        <SecondaryButtonLink
                            :href="route('books.show', {book: book.id})">Back</SecondaryButtonLink>
                        <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                            Update
                        </PrimaryButton>
                    </div>
                </form>

            </div>
        </div>
    </AppLayout>

</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButtonLink from '@/Components/SecondaryButtonLink.vue';
import { useForm, Link } from "@inertiajs/vue3";
import ResourceForm from "./Partials/ResourceForm.vue";
import {useToast} from "vue-toastification";

const toast = useToast();


const props = defineProps({
    book: Object
})

const form = useForm({
    title: props.book.title,
    isbn: props.book.isbn,
    cover_image: props.book.book_image_path,
    owner_id: props.book.owner_id,
    completed_at: props.book.completed_at,
});

const submit = () => {
    form.put(route('books.update', {
        book: props.book.id
    }), {
        preserveScroll: false,
        onSuccess: params => {
          toast("Book updated")
        },
        onError: params => {
            toast.error("Error saving data")
            console.log("Error")
        }
    })
}


</script>

<style scoped>

</style>

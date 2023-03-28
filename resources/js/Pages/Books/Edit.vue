<template>
    <AppLayout title="Create a Book">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Create a Book
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
import { useForm } from "@inertiajs/vue3";
import ResourceForm from "./Partials/ResourceForm.vue";

defineProps({
    book: Object
})

const form = useForm({
    title: null,
    isbn: null,
    cover_image: null,
    owner_id: null,
});

const submit = () => {
    form.post(route('books.store'), {
        preserveScroll: true,
        onError: params => {
            console.log("Error")
        }
    })
}


</script>

<style scoped>

</style>

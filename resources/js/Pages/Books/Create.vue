<template>
    <AppLayout title="Create a Book">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Create a Book
            </h2>
        </template>


        <div>
            <div class="text-white max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <form @submit.prevent="submit">
                    <div>
                        <InputLabel for="title" value="Title" />
                        <TextInput
                            id="title"
                            v-model="form.title"
                            type="text"
                            placeholder="Your book title"
                            class="mt-1 block w-full"
                            autofocus
                            autocomplete="off"
                        />
                        <InputError class="mt-2" :message="form.errors.title" />
                    </div>
                    <div>
                        <InputLabel for="isbn" value="ISBN" />
                        <TextInput
                            id="isbn"
                            v-model="form.isbn"
                            type="text"
                            class="mt-1 block w-full"
                            autocomplete="off"
                        />
                        <InputError class="mt-2" :message="form.errors.isbn" />
                    </div>
                    <div>
                        <InputLabel for="owner_id" value="Owner ID" />
                        <TextInput
                            id="owner_id"
                            v-model="form.owner_id"
                            type="text"
                            class="mt-1 block w-full"
                            autocomplete="off"
                        />
                        <InputError class="mt-2" :message="form.errors.owner_id" />
                    </div>
                    <div>
                        <InputLabel for="cover_image" value="Cover Image" />

                        <input
                            type="file" class="file-input w-full max-w-xs" />
                        <InputError class="mt-2" :message="form.errors.cover_image" />
                    </div>


                    <div class="flex items-center justify-end mt-4">
                        <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                            Save
                        </PrimaryButton>
                    </div>
                </form>

            </div>
        </div>
    </AppLayout>

</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

import { useForm } from "@inertiajs/vue3";
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

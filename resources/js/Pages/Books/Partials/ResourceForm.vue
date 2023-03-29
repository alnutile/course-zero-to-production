<template>
    <div class="mb-4">
        <InputLabel for="title" value="Title" />
        <TextInput
            id="title"
            v-model="modelValue.title"
            type="text"
            placeholder="Your book title"
            class="mt-1 block w-full"
            autofocus
            autocomplete="off"
        />
        <InputError class="mt-2" :message="modelValue.errors.title" />
    </div>
    <div class="mb-4">
        <InputLabel for="isbn" value="ISBN" />
        <TextInput
            id="isbn"
            v-model="modelValue.isbn"
            type="text"
            class="mt-1 block w-full"
            autocomplete="off"
        />
        <InputError class="mt-2" :message="modelValue.errors.isbn" />
    </div>

    <div class="mb-4">
        <InputLabel for="completed_at" value="Completed At" />
        <TextInput
            id="completed_at"
            v-model="modelValue.completed_at"
            type="date"
            class="mt-1 block w-full"
            autocomplete="off"
        />
        <InputError class="mt-2" :message="modelValue.errors.completed_at" />
    </div>
    <div class="mb-4">
        <InputLabel for="cover_image" value="Cover Image" />

        <input
            type="file" class="file-input w-full max-w-xs" />
        <InputError class="mt-2" :message="modelValue.errors.cover_image" />
    </div>

</template>

<script setup>

import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';

defineProps({
    modelValue: {}
})
</script>

<style scoped>

</style>

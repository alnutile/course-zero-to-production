<template>
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
            <span v-if="book.completed_at">{{ book.completed_at_formatted }}</span><span v-else>not done</span>
        </li>
    </ul>
</template>

<script setup>

import Label from "@/Components/Label.vue";

const props = defineProps({
    book: Object
})
</script>

<style scoped>

</style>

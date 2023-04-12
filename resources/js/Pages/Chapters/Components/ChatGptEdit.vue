<template>
    <div class="border border-gray-200 p-4">
        <div class="mb-2">
            Send this chapter to ChatGpt for edits and suggestion.
        </div>
        <form @submit.prevent="submit">
            <PrimaryButton
                :disabled="form.content === '' || form.processing"
                type="submit">
                Get Edits
            </PrimaryButton>
        </form>
    </div>

</template>

<script setup>

import PrimaryButton from "@/Components/PrimaryButton.vue";
import {useToast} from "vue-toastification";
const toast = useToast();
import {useForm} from "@inertiajs/vue3";

const emit = defineEmits(['edits']);

const form = useForm({
    content: props.chapter.content
})

const props = defineProps({
    chapter: Object
})

const submit = () => {
    form.processing = true;
    toast("Getting edits back in a moment");
    axios.post(route('chapters.openai.suggestions', {
        chapter: props.chapter.id
    }), {
        content: form.content
    }).then(data => {
        console.log(data.data.edits);
        emit('edits', data.data.edits);
        form.processing = false;
    }).catch(error => {
        form.processing = false;
        console.log(error.message)
        toast.error("Sorry error with system")
    })
}
</script>

<style scoped>

</style>

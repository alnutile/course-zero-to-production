<template>
    <div class="border border-gray-200 p-4">
        <div class="mb-2">
            Passing on your content and get an image back.
        </div>
        <form @submit.prevent="submit">
            <PrimaryButton
                :disabled="form.content === '' || form.processing"
                type="submit">
                Get Image
            </PrimaryButton>
        </form>

        <div class="p-2">
            <img v-if="image_url" :src="image_url"/>
        </div>
    </div>
</template>

<script setup>
import PrimaryButton from "@/Components/PrimaryButton.vue";
import {useToast} from "vue-toastification";
const toast = useToast();
import {useForm} from "@inertiajs/vue3";
import {ref} from "vue";

const emit = defineEmits(['image_generated']);

const props = defineProps({
    content: String
})

const image_url = ref(null);

const form = useForm({
    content: props.content
})

const submit = () => {
    form.processing = true;
    toast("Getting and image back in a moment");
    axios.post(route('openai.images'), {
        content: form.content
    }).then(data => {
        console.log(data.data.image);
        image_url.value = data.data.image;
        emit('image_generated', data.data.image);
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

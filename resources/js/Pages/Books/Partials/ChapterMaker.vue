<template>
    <form @submit.prevent="submit">
        <div>
            <div>
                <label for="comment"
                       class="block text-sm font-medium leading-6
                       text-gray-200">Give OpenAI some context</label>
                <div class="mt-2">
                    <TextAreaInput
                        v-model="form.context"
                        placeholder="Include some context about the chapter like This is a Sci-fi book about Zen and the art of coding."
                        :rows="4"></TextAreaInput>
                </div>
            </div>
            <div class="flex mx-auto justify-end mt-4">
                <PrimaryButton
                    :disabled="form.context === '' || form.processing"
                    type="submit">
                    Get me a chapter idea
                </PrimaryButton>
            </div>
        </div>
    </form>


    <form @submit.prevent="saveChapter">
        <div>
            <div>
                <label for="comment"
                       class="block text-sm font-medium leading-6
                       text-gray-200">Here is the Generated chapter fix it up as needed and save</label>
                <div class="mt-2">
                    <InputError
                    :message="formChapter.errors.content"></InputError>

                    <TextAreaInput
                        placeholder="The results will show here 🤖"
                        v-model="formChapter.content"></TextAreaInput>
                </div>
            </div>
            <div class="flex mx-auto justify-end mt-4">
                <PrimaryButton
                    :disabled="formChapter.content === '' || formChapter.processing"
                    type="submit">
                    Save this chapter
                </PrimaryButton>
            </div>
        </div>
    </form>
</template>

<script setup>
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { useForm } from "@inertiajs/vue3";
import {useToast} from "vue-toastification";
import {onMounted, ref} from "vue";
import InputError from "@/Components/InputError.vue";
import TextAreaInput from "@/Components/TextAreaInput.vue";
const toast = useToast();

const props = defineProps({
    book: Object
})

const form = useForm({
    context: ""
})

const formChapter = useForm({
    content: null
})

onMounted(() => {
    Echo.private(`books.${props.book.id}`)
        .listen('ChapterDownGeneratingEvent', (event) => {
            toast("Suggestion ready see what you think")
            formChapter.content = event.suggestedChapter
            form.processing = false;
        });
})

const submit = () => {
    form.processing = true;
    toast("Getting chapter inspiration back in a moment")

    axios.post(route('chapter.maker.generate.idea', {
        book: props.book.id
    }), {
        "context": form.context
    }).then(data => {
        console.log(data.data)
        toast("Back in a moment with your results");
    }).catch(error => {
        console.log(error)
        toast.error("Sorry there was an error")
        form.processing = false;
    })

}


const saveChapter = () => {
    toast("Saving chapter")
    formChapter.post(route('chapters.create', {
        book: props.book.id
    }), {
        preserveState: true,
        onSuccess: params => {
            toast("Chapter saved")
        },
        onError: params => {
            console.log("errors")
            console.log(params)
            toast.error("Oops something went wrong")
        }
    });
}


</script>

<style scoped>

</style>

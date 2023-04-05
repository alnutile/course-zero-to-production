<template>
    <form @submit.prevent="submit">
        <div>
            <div>
                <label for="comment"
                       class="block text-sm font-medium leading-6
                       text-gray-200">Give OpenAI some context</label>
                <div class="mt-2">
                    <textarea
                        v-model="form.context"
                        placeholder="Include some context about the chapter like This is a Sci-fi book about Zen and the art of coding."
                        rows="4"
                          class="block w-full rounded-md border-0 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:py-1.5 sm:text-sm sm:leading-6"></textarea>
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
                    <textarea
                        v-model="formChapter.chapter"
                        rows="25"
                        class="block w-full rounded-md border-0 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:py-1.5 sm:text-sm sm:leading-6"></textarea>
                </div>
            </div>
            <div class="flex mx-auto justify-end mt-4">
                <PrimaryButton
                    :disabled="formChapter.chapter === '' || formChapter.processing"
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
import {ref} from "vue";
const toast = useToast();

const props = defineProps({
    book: Object
})

const form = useForm({
    context: ""
})

const formChapter = useForm({
    chapter: null
})

const saveChapter = () => {
    console.log("Save this chapter")
}

const submit = () => {
    form.processing = true;
    toast("Getting chapter inspiration back in a moment")

    axios.post(route('chapter.maker.generate.idea', {
            book: props.book.id
        }), {
        "context": form.context
    }).then(data => {
        console.log(data.data)
        formChapter.chapter = data.data.context
        toast("Please review the chapter")
        form.processing = false;
    }).catch(error => {
        console.log(error)
        toast.error("Sorry there was an error")
        form.processing = false;
    })

}

</script>

<style scoped>

</style>

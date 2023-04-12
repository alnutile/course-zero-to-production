<template>
    <AppLayout :title="chapter.book.title">

        <div class="flex min-h-full flex-col">
            <!-- 3 column wrapper -->
            <div class="mx-auto w-full max-w-7xl grow lg:flex xl:px-2">
                <!-- Left sidebar & main wrapper -->
                <div class="flex-1 xl:flex">

                    <div class="px-4 py-6 sm:px-6 lg:pl-8 xl:flex-1 xl:pl-6">

                        Chapter {{ chapter.book.tite }}
                        <form @submit.prevent="submit">
                            <div >
                                <label for="content"
                                       class="block text-sm font-medium leading-6
                           text-gray-200">Chapter content</label>
                                <div class="mt-2">
                                    <InputError
                                        :message="form.errors.content"></InputError>

                                    <textarea
                                        v-model="form.content"
                                        rows="25"
                                        class="block w-full rounded-md border-0 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:py-1.5 sm:text-sm sm:leading-6"></textarea>
                                </div>

                                <div class="flex mx-auto justify-end mt-4">
                                    <PrimaryButton
                                        :disabled="form.content === '' || form.processing"
                                        type="submit">
                                        Update
                                    </PrimaryButton>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="shrink-0 border-t border-gray-200 px-4 py-6 sm:px-6 lg:w-96 lg:border-l lg:border-t-0 lg:pr-8 xl:pr-6">
                   <h2 class="mb-4 text-2xl">Actions</h2>
                        <ChatGptEdit
                            @edits="showEdits"
                        :chapter="chapter"
                        />
                </div>
            </div>
        </div>
    </AppLayout>

</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Label from "@/Components/Label.vue";
import InputError from "@/Components/InputError.vue";
import {Link, useForm} from "@inertiajs/vue3";
import SectionTitle from "@/Components/SectionTitle.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import {useToast} from "vue-toastification";
const toast = useToast();
import ChatGptEdit from "./Components/ChatGptEdit.vue"

const props = defineProps({
    chapter: Object
})

const form = useForm({
    id: props.chapter.id,
    book_id: props.chapter.book_id,
    content: props.chapter.content,
    active: props.chapter.active,
})

const showEdits = (edits) => {
    toast("Your edits are in place")
    form.content = edits;
}

const submit = () => {
    toast("Saving chapter")
}


</script>

<style scoped>

</style>

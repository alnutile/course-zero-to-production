<script setup>

defineProps({
    modelValue: String,
    rows: {
        type: Number,
        default: 20
    },
    placeholder: {
        type: String,
        default: ""
    }
});

defineEmits(['update:modelValue']);



defineExpose({ focus: () => input.value.focus() });
</script>

<template>

    <textarea
        :placeholder="placeholder"
        :value="modelValue"
        @input="$emit('update:modelValue', $event.target.value)"
        :rows="rows"
        class="
                        dark:bg-gray-400
                        block w-full  border-0
                        text-gray-900 shadow-sm ring-1
                        ring-inset ring-gray-500
                        placeholder:text-gray-500 focus:ring-2
                        focus:ring-inset focus:ring-indigo-600
                        sm:py-1.5 sm:text-sm sm:leading-6"></textarea>
</template>

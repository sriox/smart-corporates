<template>
    <div class="border-0">
        <label for="" v-if="!!label">{{ label }}</label>
        <textarea class="border rounded border-gray-500 focus:border-blue-300 w-full" v-model="proxyValue" @change="emit('change:modelValue')"></textarea>
    </div>
</template>
<script setup>
import { computed, ref } from 'vue'

const props = defineProps({
    label: {
        type: String,
    },
    modelValue: {
        type: [String, Number],
        default: '',
    },
})

const emit = defineEmits(['update:modelValue', 'change:modelValue'])

const proxyValue = computed({
    get() {
        return props.modelValue
    },
    set(val) {
        emit('update:modelValue', val)
    },
})
</script>

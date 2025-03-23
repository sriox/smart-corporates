<template>
    <div class="form-select1">
        <label for="" v-if="!!label">{{ label }}</label>
        <select class="rounded w-full focused:border-blue-300 focused:border-2x" v-model="proxyValue">
            <slot>
                <option v-for="option in options" :value="option[valueField]" :key="option[valueField]">{{ option[textField] }}</option>
            </slot>
        </select>
    </div>
</template>
<script setup>
import { computed, ref } from 'vue'
const props = defineProps({
    label: {
        type: String,
    },
    options: {
        type: Array,
        default: () => [],
    },
    valueField: {
        type: String,
        default: 'id',
    },
    textField: {
        type: String,
        default: 'name',
    },
    modelValue: {
        type: [String, Number],
        default: '',
    },
})

const emit = defineEmits(['update:modelValue'])

const proxyValue = computed({
    get() {
        return props.modelValue
    },
    set(val) {
        emit('update:modelValue', val)
    },
})
</script>

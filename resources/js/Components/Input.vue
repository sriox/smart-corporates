<template>
    <div class="flex flex-col">
        <label for="" v-if="!!props.label">{{ props.label }}</label>
        <input :type="fieldType" v-model="valueProxy" :value="value" class="border border-gray-300 rounded focus:border-blue-300" />
        <small v-if="!!props.help">{{ props.help }}</small>
    </div>
</template>
<script>
// export default {
//     inheritAttrs: false,
// }
//
</script>
<script setup>
import { computed, ref } from 'vue'
const emit = defineEmits(['update:modelValue'])

const props = defineProps({
    label: {
        type: String,
    },
    type: {
        type: String,
        default: 'text',
    },
    help: {
        type: String,
    },
    modelValue: {
        type: [String, Number],
        default: '',
    },
})

const value = ref(props.modelValue)

const valueProxy = computed({
    get() {
        return props.modelValue
    },
    set(val) {
        value.value = val
        emit('update:modelValue', val)
    },
})

const fieldType = computed(() => {
    return props.type === 'words' ? 'text' : props.type
})

const validate = (e) => {
    const val = e.target.value
    const data = e.data

    if (props.type !== 'words') {
        value.value = val
        return emit('input', value.value)
    }

    const parts = val.split(' ')
    const cleanParts = parts.filter(Boolean)
    const newText = cleanParts.join(',')
    value.value = newText
    return emit('input', value.value)

    // if (data === ' ' && value.value.endsWith(',')) return false

    // value.value = val.trim().replaceAll(' ', ',')
    // return emit('input', value.value)
}

const onChange = (e) => emit('change', e.target.value)
</script>

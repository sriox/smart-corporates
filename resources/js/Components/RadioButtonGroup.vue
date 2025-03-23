<template>
    <div class="flex radio-button-group" :class="controlDirection">
        <div
            v-for="(option, index) in options"
            :key="`${props.id}-option-${index}`"
            class="mr-3 flex items-center mt-0 border border-gray-100 rounded py-2 px-1"
        >
            <input type="radio" :value="`${option[props.valueField]}`" :name="name" v-model="proxyValue" :checked="!!modelValue == option[props.valueField]" />
            <!-- <input
                type="radio"
                :value="`${option[props.valueField]}`"
                :name="name"
                @change="$emit('update:modelValue', $event.target.value)"
                :checked="modelValue == option[props.valueField]"
            /> -->
            <div class="ml-1 text-xl">
                {{ option[props.textField] }}
            </div>
        </div>
    </div>
</template>
<script setup>
import { computed, ref } from 'vue'

const emit = defineEmits(['update:checked'])

const proxyValue = computed({
    get() {
        return props.checked
    },
    set(val) {
        emit('update:checked', val)
    },
})

const directions = ref({ horizontal: 'flex-row', vertical: 'flex-col' })

const props = defineProps({
    options: {
        type: Array,
        default: () => [],
    },
    id: {
        type: String,
        default: () => `radio-group-${Date.now()}`,
    },
    name: {
        type: String,
        default: () => `radio-group-${Date.now()}`,
    },
    textField: {
        type: String,
        default: 'name',
    },
    valueField: {
        type: String,
        default: 'id',
    },
    direction: {
        type: String,
        default: 'vertical',
    },
    modelValue: {
        type: String,
        default: '',
    },
    checked: {
        type: [Array, Boolean],
        default: false,
    },
})

const controlDirection = computed(() => {
    return directions.value[props.direction] || 'flex-col'
})
</script>
<style scoped>
.radio-button-group {
    font-size: x-small;
}
@media screen and (min-width: 600px) {
    .radio-button-group {
        font-size: medium;
    }
}
</style>

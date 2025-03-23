<template>
    <button :class="classes" class="rounded-md py-1 px-3 font-bold" v-bind="$attrs" :disabled="disabled">
        <slot></slot>
    </button>
</template>
<script lang="ts">
// use normal <script> to declare options
export default {
    inheritAttrs: false,
}
</script>
<script setup lang="ts">
import { computed, ref } from 'vue'

interface Props {
    variant?: string
    block?: boolean
    disabled?: boolean
}

const props = withDefaults(defineProps<Props>(), {
    variant: 'primary',
    block: false,
    disabled: false,
})

const variant = computed(() => (Object.keys(variants).includes(props.variant) ? variants[props.variant] : variants['primary']))

const classes = computed(() => {
    let _classes
    if (!props.disabled) {
        _classes = [variant.value.bgColor, `hover:${variant.value.hoverBgColor}`]
    } else {
        _classes = [variant.value.bgColorDisabled]
    }
    !!props.block && _classes.push('w-full')

    return _classes.join(' ')
})

interface VariantConfig {
    bgColor: string
    bgColorDisabled: string
    hoverBgColor: string
}

const variants: Record<string, VariantConfig> = {
    primary: {
        bgColor: 'bg-indigo-500 text-white',
        bgColorDisabled: 'bg-indigo-300 text-white',
        hoverBgColor: 'bg-indigo-600',
    },
    secondary: {
        bgColor: 'bg-gray-600 text-white',
        bgColorDisabled: 'bg-gray-300 text-white',
        hoverBgColor: 'bg-gray-800',
    },
    danger: {
        bgColor: 'bg-red-500 text-white',
        bgColorDisabled: 'bg-red-300 text-white',
        hoverBgColor: 'bg-red-800',
    },
    info: {
        bgColor: 'bg-blue-600 text-white',
        bgColorDisabled: 'bg-blue-300 text-white',
        hoverBgColor: 'bg-blue-800',
    },
    warning: {
        bgColor: 'bg-orange-600',
        bgColorDisabled: 'bg-orange-300 text-white',
        hoverBgColor: 'bg-orange-800',
    },
    success: {
        bgColor: 'bg-green-600',
        bgColorDisabled: 'bg-green-300 text-white',
        hoverBgColor: 'bg-green-800',
    },
    link: {
        bgColor: 'underline text-indigo-500',
        bgColorDisabled: 'underline text-indigo-100',
        hoverBgColor: '',
    },
}
</script>

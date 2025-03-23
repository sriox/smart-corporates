<template>
    <div v-if="!!props.logoUrl">
        <img :src="props.logoUrl" style="max-width: 100%" :style="styles" alt="" />
    </div>
</template>
<script setup>
import { computed, ref } from 'vue'
const props = defineProps({
    logoUrl: {
        type: String,
    },
    size: {
        type: String,
        validator: (val) => ['sm', 'md', 'lg'].includes(val),
        default: 'md',
    },
})

const styles = computed(() => {
    return {
        sm: 'max-height: 45px',
        md: 'max-height: 100px',
        lg: 'max-height: 200px',
    }[props.size]
})
</script>

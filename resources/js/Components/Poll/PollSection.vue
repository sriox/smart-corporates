<template>
    <div class="poll-section jumbotron mt-2 w-100 border border-secondary rounded p-3" :class="statusColors[props.status]">
        <div class="title font-bold text-indigo-800">
            <slot name="title">{{ props.title }}</slot>
        </div>
        <slot></slot>
    </div>
</template>
<script setup lang="ts">
import { ref } from 'vue'
import { statusColors } from '../../Utils/StatusColors'

type Status = 'success' | 'error' | 'warning' | 'info' | ''
interface Props {
    title: string
    status: Status
}
const props = withDefaults(defineProps<Props>(), {
    status: '',
})
</script>

<!-- validator: (val: string) => ['success', 'error', 'warning', 'info', ''].includes(val), -->

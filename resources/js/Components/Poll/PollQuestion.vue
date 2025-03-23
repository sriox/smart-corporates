<template>
    <div class="poll-question rounded border border-gray-200 py-2 px-2 mt-1" :class="statusColors[props.status]">
        <slot></slot>
    </div>
</template>
<script setup lang="ts">
import { ref } from 'vue'
import { statusColors } from '../../Utils/StatusColors.js'
import { Status } from '../../Types'

interface Props {
    status: Status
}

const props = defineProps<Props>()
</script>

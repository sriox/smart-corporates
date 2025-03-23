<template>
    <div class="rounded border-indigo-300 py-4 px-1 mt-2 print:break-before-page" :class="{ border: !!border }">
        <div class="header mb-3">
            <slot name="header">
                <ReportTitle class="text-justify" v-if="!!title">{{ title }}</ReportTitle>
            </slot>
        </div>
        <div class="content">
            <slot></slot>
        </div>
    </div>
</template>
<script setup lang="ts">
import { ref, toRefs } from 'vue'
import ReportTitle from '../Report/ReportTitle.vue'

const props = defineProps<{
    title?: string
    border?: Boolean
}>()
const { title } = toRefs(props)
</script>

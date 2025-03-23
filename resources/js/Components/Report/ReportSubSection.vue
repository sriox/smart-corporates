<template>
    <div class="w-full my-2">
        <div v-if="!!title" class="text-xl text-blue-800 ml-8 font-bold">
            {{ title }}
        </div>
        <div class="mt-0">
            <slot></slot>
        </div>
    </div>
</template>
<script setup lang="ts">
import { Ref, ref } from 'vue'
const props = defineProps<{
    title?: string
}>()
</script>

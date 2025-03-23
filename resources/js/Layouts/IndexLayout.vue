<template>
    <div>
        <div class="header bg-indigo-700 text-white font-bold flex justify-center py-8 text-2xl">
            <slot name="header"></slot>
        </div>
        <div class="filters">
            <slot name="filters"></slot>
        </div>
        <div class="data">
            <slot></slot>
        </div>
    </div>
</template>
<script setup>
import { ref } from 'vue'
</script>

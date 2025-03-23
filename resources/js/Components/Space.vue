<template>
    <div class="whitespace-nowrap space">
        <slot></slot>
    </div>
</template>
<script setup>
import { ref } from 'vue'
</script>
<style>
div.space > * {
    margin-right: 4px;
}
</style>

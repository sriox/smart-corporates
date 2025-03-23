<template>
    <input type="radio" v-bind="$attrs" />
</template>
<script>
export default {
    inheritAttrs: false,
}
</script>
<script setup>
import { ref } from 'vue'
</script>

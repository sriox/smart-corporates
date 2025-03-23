<template>
    <Button variant="primary" title="Editar" v-bind="$attrs"><font-awesome-icon icon="fa-solid fa-pen-to-square" /></Button>
</template>
<script>
export default {
    inheritAttrs: false,
}
</script>
<script setup>
import { ref } from 'vue'
</script>

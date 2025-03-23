<template>
    <Button variant="danger" title="Eliminar" v-bind="$attrs"><font-awesome-icon icon="fa-solid fa-trash" /></Button>
</template>
<script>
export default {
    inheritAttrs: false,
}
</script>
<script setup>
import { ref } from 'vue'
</script>

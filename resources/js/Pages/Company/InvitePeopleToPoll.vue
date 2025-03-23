<template>
    <AppLayout>
        <IndexLayout>
            <DataTable :columns="columns" :items="people"></DataTable>
        </IndexLayout>
    </AppLayout>
</template>
<script setup>
import { ref } from 'vue'
</script>

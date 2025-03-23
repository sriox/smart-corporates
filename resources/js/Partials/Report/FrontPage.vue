<template>
    <div class="front-page">
        <div class="header">
            <div class="flex justify-center bg-white pt-10">
                <img src="/images/logo_team_building.png" class="max-h-80" alt="" />
            </div>
        </div>
        <div class="body bg-green-400">
            <div class="content bg-white h-44 mt-48 text-4xl text-[#5DC7D0] flex flex-col justify-center items-center">
                <div>Medición de Engagement</div>

                <div class="font-bold">{{ company.name }}</div>
            </div>
        </div>
    </div>
</template>
<script setup lang="ts">
import { Ref, ref } from 'vue'
const props = defineProps<{
    company: Company
}>()
</script>
<style scoped>
@media print {
    .front-page {
        height: 20.7cm;
    }
}

.front-page {
    background-image: url('/images/bg-1-light.jpg');
    background-position: center;
    background-size: cover;
    background-repeat: no-repeat;
}

.header {
    background-image: url('/images/bg-1-light.jpg');
    background-position: center;
    background-size: cover;
    background-repeat: no-repeat;
}
.body {
    background-image: url('/images/bg-2-light.jpg');
    background-position: center;
    background-size: cover;
    background-repeat: no-repeat;
}
</style>

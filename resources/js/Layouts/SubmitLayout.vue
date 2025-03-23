<template>
    <div class="submit-poll-container px-2 md:px-12">
        <div class="header py-5 bg-secondary">
            <div v-if="!!company && !!poll" class="flex flex-col items-center max-w-7xl mx-auto">
                <div class="flex items-center justify-between w-full">
                    <div v-if="!!company.logo_url" class="w-1/2">
                        <CompanyLogo :logo-url="company.logo_url" size="md"></CompanyLogo>
                    </div>
                    <div class="w-2/5 lg:w-full flex justify-end">
                        <CompanyLogo logo-url="https://teambuildingsas.com/wp-content/uploads/2022/11/engagement_logo_h_100.png" size="md"></CompanyLogo>
                    </div>
                </div>
                <!-- <h3 class="text-center">Bienvenido a la medición de engagement de la empresa {{ company?.name || '' }}</h3> -->
            </div>
            <div v-else>
                <slot name="header"></slot>
            </div>
        </div>
        <div class="submit-content max-w-7xl mx-auto">
            <slot></slot>
        </div>
    </div>
</template>
<script setup>
import { ref, toRefs } from 'vue'
import CompanyLogo from '../Components/Company/CompanyLogo.vue'
const props = defineProps({
    poll: Object,
    company: Object,
})

const { company, poll } = toRefs(props)
</script>

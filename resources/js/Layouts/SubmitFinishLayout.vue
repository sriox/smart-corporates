<template>
    <div class="submit-poll-container px-2 md:px-24">
        <div class="header py-5 bg-secondary">
            <div v-if="!!company && !!poll" class="flex flex-col items-center">
                <div v-if="!!company.logo_url">
                    <CompanyLogo :logo-url="company.logo_url" size="md"></CompanyLogo>
                </div>
            </div>
            <div v-else>
                <slot name="header"></slot>
            </div>
        </div>
        <div class="submit-content">
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

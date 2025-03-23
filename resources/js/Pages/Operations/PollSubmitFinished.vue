<template>
    <SubmitFinishLayout :company="company" :poll="poll">
        <div class="flex flex-col">
            <h3 class="text-center text-green-700 text-3xl">
                Gracias por participar en la medición de engagement de {{ company.name }}, con tu ayuda seguiremos mejorando.
            </h3>
            <div class="text-5xl mt-5 text-blue-700 text-center">
                <font-awesome-icon icon="fa-solid fa-thumbs-up" />
            </div>
        </div>
    </SubmitFinishLayout>
</template>
<script setup>
import { ref, toRefs } from 'vue'

const props = defineProps({
    code: {
        type: String,
        required: true,
    },
    company: {
        type: Object,
        required: true,
    },
    poll: {
        type: Object,
        required: true,
    },
})

const { code, company, poll } = toRefs(props)
</script>

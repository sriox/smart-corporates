<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue'
import { Inertia } from '@inertiajs/inertia'
import { Link } from '@inertiajs/inertia-vue3'
</script>

<template>
    <div>
        <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
            <div>
                <ApplicationLogo class="block h-12 w-auto" />
            </div>

            <div class="mt-8 text-2xl">Welcome to your Smart Companies Platform</div>

            <div class="mt-6 text-gray-500">Evaluaremos tu compañía de forma ágil y precisa para llevarla a un siguiente nivel</div>
        </div>
    </div>
</template>

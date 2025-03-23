<template>
    <div>
        <Space>
            <Button v-for="group in groups" @click="downloadDemographicResults(group)">
                {{ group.label }}
            </Button>
        </Space>
    </div>
</template>
<script setup lang="ts">
import { Inertia } from '@inertiajs/inertia'
import { propsToAttrMap } from '@vue/shared'
import { Ref, ref } from 'vue'

interface DemographicGroup {
    key: string
    label: string
}

const props = defineProps<{
    pollInstanceId: number
    groups: DemographicGroup[]
}>()

const downloadDemographicResults = (group: DemographicGroup) => {
    window.open(route('pollInstance.downloadDemographicGroup', { id: props.pollInstanceId, group: group.key }), '_blank')
}
</script>

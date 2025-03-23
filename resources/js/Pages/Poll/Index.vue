<template>
    <AppLayout>
        <IndexLayout>
            <template #filters> Aca van los filtros </template>
            <DataTable :columns="columns" :items="polls">
                <template #cell(actions)="{ item }">
                    <Button type="primary" size="sm" title="Preguntas" @click="goToQuestions(item.id)"><font-awesome-icon icon="fa-solid fa-list" /></Button>
                </template>
            </DataTable>
        </IndexLayout>
    </AppLayout>
</template>
<script setup>
import { Inertia } from '@inertiajs/inertia'
import { ref, toRefs } from 'vue'

const props = defineProps({
    polls: {
        type: Array,
        default: () => [],
    },
})

const { polls } = toRefs(props)

const goToQuestions = (pollId) => {
    Inertia.get(route('poll.questions', { id: pollId }))
}

const columns = ref([
    {
        key: 'name',
        text: 'Encuesta',
    },
    {
        key: 'poll_type.name',
        text: 'Tipo',
    },
    {
        key: 'actions',
        text: 'Acciones',
    },
])
</script>

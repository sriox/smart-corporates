<template>
    <AppLayout>
        <IndexLayout>
            <template #filters> Question Filters </template>
            <DataTable :columns="columns" :items="questions">
                <template #cell(actions)="{ item }">
                    <Space>
                        <EditButton title="Editar pregunta" @click="edit(item)" />
                        <DeleteButton title="Eliminar pregunta" @click="edit(item)" />
                    </Space>
                </template>
            </DataTable>
        </IndexLayout>
    </AppLayout>
</template>
<script setup>
import { ref, toRefs } from 'vue'

const props = defineProps({
    questions: {
        type: Array,
        default: () => [],
    },
})

const { questions } = toRefs(props)

const edit = (question) => {
    //
}

const columns = ref([
    {
        key: 'order',
        text: '#',
    },
    {
        key: 'question',
        text: 'Pregunta',
    },
    {
        key: 'attribute.name',
        text: 'Atributo',
    },
    {
        key: 'attribute.dimension.name',
        text: 'Dimensión',
    },
    {
        key: 'question_group.name',
        text: 'Grupo',
    },
    {
        key: 'attribute.dimension.poll.name',
        text: 'Encuesta',
    },
    {
        key: 'actions',
        text: 'Acciones',
    },
])
</script>

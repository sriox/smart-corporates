<template>
    <AppLayout>
        <IndexLayout>
            <template #header> Personas {{ company.name }} </template>
            <DataTable :columns="columns" :items="people">
                <template #cell(actions)="{ item }">
                    <Space>
                        <EditButton @click="edit(item)" title="Editar persona" />
                        <DeleteButton title="Eliminar persona" />
                    </Space>
                </template>
            </DataTable>
        </IndexLayout>
    </AppLayout>
</template>
<script setup>
import { ref, toRefs } from 'vue'

const props = defineProps({
    company: {
        type: Object,
        required: true,
    },
    people: {
        type: Object,
        required: true,
    },
})

const { people, company } = toRefs(props)

const edit = (person) => {
    //
}

const columns = ref([
    {
        key: 'first_name',
        text: 'Nombre',
    },
    {
        key: 'last_name',
        text: 'Apellido',
    },
    {
        key: 'document',
        text: 'Documento',
    },
    {
        key: 'email',
        text: 'E-mail',
    },
    {
        key: 'phone',
        text: 'Teléfono',
    },
    {
        key: 'actions',
        text: 'Acciones',
    },
])
</script>

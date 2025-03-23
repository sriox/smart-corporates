<template>
    <AppLayout>
        <IndexLayout>
            <template #header> Empresas </template>
            <DataTable :columns="columns" :items="companies">
                <template #cell(actions)="{ item }">
                    <Space>
                        <Button @click="edit(item)" title="Editar cliente"><font-awesome-icon icon="fa-solid fa-pen-to-square" /></Button>
                        <Button @click="goToPeople(item)" title="Personas"><font-awesome-icon icon="fa-solid fa-user" /></Button>
                        <Button @click="goToEvaluations(item)"><font-awesome-icon icon="fa-solid fa-ruler" /></Button>
                    </Space>
                </template>
            </DataTable>
        </IndexLayout>
    </AppLayout>
</template>
<script setup>
import { Inertia } from '@inertiajs/inertia'
import { ref, toRefs } from 'vue'
import IndexLayout from '../../Layouts/IndexLayout.vue'

const props = defineProps(['companies'])
const { companies } = toRefs(props)

const edit = (company) => {
    //
}

const goToEvaluations = (company) => {
    Inertia.get(route('company.polls', { company: company.id }))
}

const goToPeople = (company) => {
    Inertia.get(route('company.people', { company: company.id }))
}

const columns = [
    {
        key: 'name',
        text: 'Empresa',
    },
    {
        key: 'document',
        text: 'NIT',
    },
    {
        key: 'phone',
        text: 'Teléfono',
    },
    {
        key: 'email',
        text: 'E-Mail',
    },
    {
        key: 'address',
        text: 'Dirección',
    },
    {
        key: 'actions',
        text: 'Opciones',
    },
]
</script>

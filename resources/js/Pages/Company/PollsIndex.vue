<template>
    <AppLayout>
        <IndexLayout>
            <template #header>
                <div class="flex flex-col">
                    <div v-if="!!company.logo_url">
                        <img :src="company.logo_url" style="max-width: 100%; max-height: 100px" alt="" />
                    </div>
                    <div class="text-center">Evaluaciones - {{ company.name }}</div>
                </div>
            </template>
            <DataTable :columns="columns" :items="pollInstances">
                <template #buttons>
                    <Button variant="success" @click="showNewPollWindow = true"><font-awesome-icon icon="fa-solid fa-plus" /> Crear encuesta</Button>
                </template>
                <template #cell(eficiency)="{ item }">
                    {{ 0 === item.participants_count ? 0 : Math.round((item.completedCount / item.participantsCount) * 100) }}%
                </template>
                <template #cell(created_at)="{ item }">
                    {{ $filters.date(item.created_at) }}
                </template>
                <template #cell(start_at)="{ item }">
                    {{ $filters.date(item.start_at) }}
                </template>
                <template #cell(end_at)="{ item }">
                    {{ $filters.date(item.end_at) }}
                </template>
                <template #cell(actions)="{ item }">
                    <Space>
                        <EditButton title="Editar medición" @click="edit(item)" />
                        <UserButton title="Ver participantes" @click="goToParticipants(item)" />
                        <Button @click="goToReport(item)"><font-awesome-icon icon="fa-solid fa-chart-simple" /></Button>
                        <Button @click="goDemographicResults(item)"><font-awesome-icon icon="fa-solid fa-download" /></Button>
                    </Space>
                </template>
            </DataTable>
        </IndexLayout>
        <Modal :show="showInvitationWindow" :closeable="true" @close="showInvitationWindow = false">
            <div class="border rounded p-12 bg-white">Prueba del modal</div>
        </Modal>
        <Modal :show="showNewPollWindow" :closeable="true" @close="showNewPollWindow = false">
            <div class="border rounded p-12 bg-white">
                <div class="grid-rows-1">
                    <div class="mt-3">
                        <FormSelect label="Encuestas" :options="polls" v-model="newPollInstance.poll_id"></FormSelect>
                    </div>
                    <div class="mt-3">
                        <Input type="date" label="Disponible desde" v-model="newPollInstance.start_at"></Input>
                    </div>
                    <div class="mt-3">
                        <Input type="date" label="Disponible hasta" v-model="newPollInstance.end_at"></Input>
                    </div>
                    <div class="mt-3">
                        <FormTextArea type="date" label="Notas" v-model="newPollInstance.notes"></FormTextArea>
                    </div>
                </div>
                <div class="flex justify-end">
                    <Button @click="savePoll">Crear Encuesta</Button>
                </div>
            </div>
        </Modal>
    </AppLayout>
</template>
<script setup>
import { reactive, ref, toRefs } from 'vue'
import { Inertia } from '@inertiajs/inertia'

const props = defineProps({
    company: {
        type: Object,
        required: true,
    },
    polls: {
        type: Array,
        default: () => [],
    },
    pollInstances: {
        type: Array,
        default: () => [],
    },
})

const { company, polls } = toRefs(props)

const showInvitationWindow = ref(false)
const showNewPollWindow = ref(false)

const newPollInstance = reactive({
    poll_id: '',
    start_at: '',
    end_at: '',
    notes: '',
})

const edit = (pollInstance) => {
    //
}

const goToParticipants = (pollInstance) => {
    Inertia.visit(route('pollInstance.participants', { pollInstance: pollInstance.id }))
}

const goToReport = (pollInstance) => {
    Inertia.visit(route('pollInstance.report', { pollInstance }))
}

const savePoll = () => {
    Inertia.post(route('company.polls.store', { company: company.value.id }), newPollInstance)
    showNewPollWindow.value = false
}

const goDemographicResults = (item) => {
    return Inertia.visit(route('pollInstance.demographicsDownloads', { id: item.id }))
}

const columns = ref([
    {
        key: 'poll.name',
        text: 'Encuesta',
    },
    {
        key: 'code',
        text: 'Identificador',
    },
    {
        key: 'user.name',
        text: 'Creada Por',
    },
    {
        key: 'start_at',
        text: 'Fecha de inicio',
    },
    {
        key: 'end_at',
        text: 'Fecha de finalización',
    },
    {
        key: 'participants_count',
        text: 'Participantes',
    },
    {
        key: 'completedCount',
        text: 'Completados',
    },
    {
        key: 'eficiency',
        text: 'Alcance',
    },
    {
        key: 'created_at',
        text: 'Fecha creación',
    },
    {
        key: 'actions',
        text: 'Acciones',
    },
])
</script>

<template>
    <AppLayout>
        <IndexLayout>
            <template #header>
                <div class="flex flex-col items-center">
                    <div>Participantes de la encuesta seleccionados {{ selectedPeople.length }}</div>
                    <div>Personas invitadas: {{ invited }}</div>
                    <div>Encuestas finalizadas: {{ finished }}</div>
                </div>
            </template>
            <div v-if="!!$page.props.flash.message" class="alert py-4 px-5 bg-indigo-300 rounded-md border border-indigo-600 my-3 text-indigo-600 font-bold">
                {{ $page.props.flash.message }}
            </div>
            <DataTable :columns="columns" :items="people" :mutator="mutator" :sorter="sorter">
                <template #buttons>
                    <div class="gap-3 flex">
                        <div>
                            <Button :disabled="!invited" @click="showConfirm = true">Enviar recordatorio</Button>
                        </div>
                        <div class="">
                            <Button :disabled="selectedPeople.length === 0" @click="sendInvitations">{{
                                selectedPeople.length != people.length ? 'Enviar a los seleccionados' : 'Enviar a todos'
                            }}</Button>
                        </div>
                    </div>
                </template>
                <template #header(selector)>
                    <div class="flex">
                        <div>
                            <Button variant="link" @click="selectAll">Todos</Button>
                        </div>
                        |
                        <div>
                            <Button variant="link" @click="selectNone">Ninguno</Button>
                        </div>
                        |
                        <div>
                            <Button variant="link" href="#" @click="selectMissing">Faltantes</Button>
                        </div>
                    </div>
                </template>
                <template #cell(invited)="{ item }">
                    {{ !!item.participants_count ? 'Si' : 'No' }}
                </template>
                <template #cell(state)="{ item }">
                    <span v-if="!!item.participants[0] && !!item.participants[0].latest_state">
                        {{ item.participants[0].latest_state.event }} - {{ !!item.participants[0].latest_state.valid ? 'Válido' : 'Error' }}
                    </span>
                </template>
                <template #cell(selector)="{ item }">
                    <Checkbox @change="selectPerson" :value="`${item.id}`" :checked="selectedPeople.includes(item.id)"></Checkbox>
                </template>
                <template #cell(completed)="{ item }">
                    {{ !!item.completed_count ? 'Si' : 'No' }}
                </template>
                <template #cell(actions)="{ item }">
                    <SendButton @click="sendInvitation(item)"></SendButton>
                </template>
            </DataTable>
        </IndexLayout>
        <ConfirmationModal :show="showConfirm">
            <template #title> Envío de recordatorio </template>
            <template #content> ¿Esta seguro de enviar un recordatorio? </template>
            <template #footer>
                <div class="flex justify-end gap-3">
                    <Button variant="secondary" @click="showConfirm = false">Cancelar</Button>
                    <Button variant="primary" @click="sendReminder">Enviar</Button>
                </div>
            </template>
        </ConfirmationModal>
    </AppLayout>
</template>
<script setup lang="ts">
import { Inertia } from '@inertiajs/inertia'
import { ref, toRefs, Ref } from 'vue'
import axios from '../../Http'
import { Person, PollInstance } from '../../Types'
import toastr from 'toastr'
import { getErrorMessage } from '../../Utils/HandleError'
import { computed } from '@vue/reactivity'
import ConfirmationModal from '../../Components/ConfirmationModal.vue'

interface Props {
    people?: Person[]
    pollInstance: PollInstance
}

const props = withDefaults(defineProps<Props>(), {
    people: () => [],
})

const showConfirm = ref(false)

const { pollInstance, people } = toRefs(props)
const selectedPeople: Ref<number[]> = ref([])

const finished = computed(() => people.value.filter((person) => !!person.completed_count).length)
const invited = computed(() => people.value.filter((person) => !!person.participants_count).length)

const selectAll = () => (selectedPeople.value = people.value.map((item) => item.id))
const selectNone = () => (selectedPeople.value = [])

const selectPerson = ({ target }: { target: HTMLInputElement }, person: Person) => {
    const selected = selectedPeople.value.filter((item) => item !== Number(target.value))
    target.checked && selected.push(Number(target.value))
    selectedPeople.value = selected
}

const sendInvitation = (person: Person) => {
    selectedPeople.value = [person.id]
    sendInvitations()
}

const sendInvitations = async () => {
    try {
        const {
            data: { status, invitations },
        } = await axios.post(route('pollInstance.sendInvitations', { pollInstance: pollInstance.value.id }), {
            selectedPeople: selectedPeople.value,
        })
        toastr.success(`Invitación enviada a ${invitations} personas`)
        selectedPeople.value = []
        setTimeout(() => {
            Inertia.reload()
        }, 3000)
    } catch (error) {
        toastr.error(`Ha ocurrido un error enviando las invitaciones: ${getErrorMessage(error)}`)
    }
}

const mutator = (item: Person) => {
    const rowClasses = []
    !!item.completed_count && rowClasses.push('bg-green-300')
    !!item.participants_count && rowClasses.push('text-indigo-600 font-bold ')
    return { ...item, rowClasses }
}

const sorter = (items: Person[]) => items.sort((a, b) => ((a.completed_count ?? 0) < (b.completed_count ?? 0) ? 1 : -1))

const selectMissing = () => {
    selectedPeople.value = people.value.filter((person) => person.participants_count === 0).map((person) => person.id)
}

const sendReminder = () => {
    Inertia.post(route('pollInstance.sendReminder', { id: pollInstance.value.id }))
    showConfirm.value = false
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
        key: 'email',
        text: 'E-mail',
    },
    {
        key: 'invited',
        text: 'Invitado',
    },
    {
        key: 'completed',
        text: 'Completado',
    },
    {
        key: 'state',
        text: 'Estado envío',
    },
    {
        key: 'selector',
        text: 'Seleccionar',
        classes: 'flex justify-center',
    },
    {
        key: 'actions',
        text: 'Acciones',
    },
])
</script>

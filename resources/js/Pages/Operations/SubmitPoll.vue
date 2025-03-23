<template>
    <SubmitLayout :company="company" :poll="poll">
        <div class="intro">
            <div class="font-bold text-2xl lg:text-3xl text-center my-3 text-blue-800">Bienvenido a valorar tu entorno laboral Engagement</div>
            <!-- <div class="text-gray-600 text-xl lg:text-2xl text-center">
                Engagement es el nivel del vinculo emocional que junto con el entusiasmo y pasión por la compañía, se manifiesta en dar siempre lo mejor. Para
                <span class="uppercase">{{ company.name }}</span> es fundamental tu participación en la planificación y ejecución, de las oportunidades de
                desarrollo de los colaboradores.
            </div> -->
        </div>
        <div class="questions">
            <PollSection title="EDAD" v-if="ageRanges.length > 0" :status="!!pollAnswers.ageRangeId ? 'success' : ''">
                <div class="age">
                    <div class="grid-cols-1">
                        <RadioButtonGroup
                            :options="ageRanges"
                            v-model:checked="pollAnswers.ageRangeId"
                            name="age-range"
                            :model-value="pollAnswers.ageRangeId"
                        ></RadioButtonGroup>
                    </div>
                </div>
            </PollSection>
            <PollSection title="SELECCIONE" v-if="genders.length > 0" :status="!!pollAnswers.genderId ? 'success' : ''">
                <div class="age">
                    <div class="grid-cols-1">
                        <RadioButtonGroup
                            :options="genders"
                            v-model:checked="pollAnswers.genderId"
                            name="gender"
                            :model-value="pollAnswers.genderId"
                        ></RadioButtonGroup>
                    </div>
                </div>
            </PollSection>
            <PollSection title="ANTIGÜEDAD" v-if="serviceTimeRanges.length > 0" :status="!!pollAnswers.serviceTimeRangeId ? 'success' : ''">
                <div class="service-time-ranges">
                    <div class="grid-cols-1">
                        <RadioButtonGroup
                            :options="serviceTimeRanges"
                            v-model:checked="pollAnswers.serviceTimeRangeId"
                            name="service-time"
                            :model-value="pollAnswers.serviceTimeRangeId"
                        ></RadioButtonGroup>
                    </div>
                </div>
            </PollSection>
            <PollSection title="GRUPOS" v-if="companyLevels.length > 0" :status="!!pollAnswers.companyLevelId ? 'success' : ''">
                <div class="service-time-ranges">
                    <div class="grid-cols-1">
                        <RadioButtonGroup
                            :options="companyLevels"
                            v-model:checked="pollAnswers.companyLevelId"
                            name="company-level"
                            :model-value="pollAnswers.companyLevelId"
                        ></RadioButtonGroup>
                    </div>
                </div>
            </PollSection>
            <PollSection title="ÁREA A LA QUE PERTENECE" v-if="areas.length > 0" :status="!!pollAnswers.areaId ? 'success' : ''">
                <div class="service-time-ranges">
                    <div class="grid-cols-1">
                        <RadioButtonGroup
                            :options="areas"
                            v-model:checked="pollAnswers.areaId"
                            name="area"
                            :model-value="pollAnswers.areaId"
                        ></RadioButtonGroup>
                    </div>
                </div>
            </PollSection>
            <PollSection
                title="DIRECCIÓN, DIVISIÓN O DEPARTAMENTO AL QUE PERTENECE"
                v-if="divisions.length > 0"
                :status="!!pollAnswers.divisionId ? 'success' : ''"
            >
                <div class="service-time-ranges">
                    <div class="grid-cols-1">
                        <RadioButtonGroup
                            :options="divisions"
                            v-model:checked="pollAnswers.divisionId"
                            name="division"
                            :model-value="pollAnswers.divisionId"
                        ></RadioButtonGroup>
                    </div>
                </div>
            </PollSection>
            <div class="data-treatment-authorization border border-red-200 rounded p-3 mt-2">
                <Checkbox v-model="pollAnswers.dataPolicyAccept" value="1"></Checkbox>
                <small class="text-justify ml-2"
                    >Acepto el tratamiento de mis datos personales de acuerdo a la política de tratamiento de datos personales de Team Building SAS que se
                    encuentra en el sitio web <a href="https://teambuildingsas.com" target="_blank">www.teambuildingsas.com</a></small
                >
            </div>
            <div class="continue-button my-3">
                <Button block :disabled="!pollAnswers.dataPolicyAccept" class="py-5" @click="submit">Continuar</Button>
            </div>
        </div>
    </SubmitLayout>
</template>
<script setup>
import { Inertia } from '@inertiajs/inertia'
import { reactive, ref, toRefs, watch } from 'vue'
import CompanyLogo from '../../Components/Company/CompanyLogo.vue'

const props = defineProps({
    poll: {
        type: Object,
        required: true,
    },
    company: {
        type: Object,
        required: true,
    },
    participant: {
        type: Object,
        required: true,
    },
    areas: {
        type: Array,
        default: () => [],
    },
    serviceTimeRanges: {
        type: Array,
        default: () => [],
    },
    ageRanges: {
        type: Array,
        default: () => [],
    },
    divisions: {
        type: Array,
        default: () => [],
    },
    genders: {
        type: Array,
        default: () => [],
    },
    companyLevels: {
        type: Array,
        default: () => [],
    },
    code: {
        type: String,
        required: true,
    },
})

const { company, poll, areas, ageRanges, divisions, genders, serviceTimeRanges, companyLevels, participant } = toRefs(props)

const pollAnswers = reactive({
    ageRangeId: participant.value.age_range_id,
    genderId: participant.value.gender_id,
    serviceTimeRangeId: participant.value.service_time_range_id,
    companyLevelId: participant.value.company_level_id,
    areaId: participant.value.area_id,
    divisionId: participant.value.division_id,
})

const submit = () => {
    if (props.ageRanges.length > 0 && !pollAnswers.ageRangeId) return toastr.error('Debe diligenciar el rango de edad')
    if (props.genders.length > 0 && !pollAnswers.genderId) return toastr.error('Debe diligenciar todos los campos')
    if (props.serviceTimeRanges.length > 0 && !pollAnswers.serviceTimeRangeId) return toastr.error('Debe diligenciar el rango de antiguedad')
    if (props.companyLevels.length > 0 && !pollAnswers.companyLevelId) return toastr.error('Debe diligenciar el grupo al que pertenece')
    if (props.areas.length > 0 && !pollAnswers.areaId) return toastr.error('Debe diligenciar el área')
    if (props.divisions.length > 0 && !pollAnswers.divisionId) return toastr.error('Debe diligenciar la división a la que pertenece')
    Inertia.post(route('demographic.submit', { code: props.code }), pollAnswers)
}
</script>

<template>
    <div>
        <div v-if="!reportReady">Cargando datos...</div>
        <div v-else>
            <FrontPage :company="pollInstance.company"></FrontPage>
            <!-- <div class="text-xl"> -->
            <div class="max-w-7xl print:w-full mx-auto border px-2 my-0 pt-0">
                <ReportSection>
                    <ReportIndex></ReportIndex>
                </ReportSection>
                <ReportSection>
                    <Recommendations></Recommendations>
                </ReportSection>
                <ReportSection title="1. La importancia de medir el Engagement" id="engagement-importance">
                    <p class="text-justify text-lg">
                        Las personas crean valor al negocio, son activos intangibles, pero las personas también son emocionales y volubles, y requieren ser
                        conquistadas. Por ese motivo, el compromiso de los empleados puede ser un gran diferenciador para una organización en momentos de
                        estabilidad o en momentos de rápidos cambios. La palabra compromiso suena muy fuerte en el ámbito empresarial, varios estudios muestran
                        que tener los empleados comprometidos trae como consecuencia la mejora de muchos aspectos de la organización, tanto en el clima laboral
                        como en los resultados de forma directa o indirecta. Por esto es muy importante poder evaluar el Engagement, entendido como el nivel de
                        compromiso emocional, sentido de pertenencia combinado con entusiasmo y pasión por el trabajo y por la Organización, que se manifiesta
                        en un permanente deseo de dar siempre lo mejor. Las organizaciones con mayor nivel de Engagement atraen y mantienen el mejor talento,
                        logrando así resultados sobresalientes y sostenibles.
                    </p>
                    <div>
                        <div class="mt-5">
                            <ReportSubTitle class="mb-3">Engagement está relacionado con:</ReportSubTitle>
                            <ul class="list-disc list-outside text-lg pl-5">
                                <li class="text-justify">Dar lo mejor de sí todos los días y tener pasión por el trabajo.</li>
                                <li class="text-justify">Compromiso emocional con el propósito, los objetivos y valores de la organización.</li>
                                <li class="text-justify">
                                    Motivación para contribuir con el éxito de la organización con una mayor sensación de bienestar propio.
                                </li>
                                <li class="text-justify">
                                    Confianza, integridad, compromiso bidireccional y comunicación entre la organización y sus miembros.
                                </li>
                                <li class="text-justify">Alto nivel de entusiasmo y dedicación que una persona siente hacia su trabajo.</li>
                            </ul>
                        </div>
                        <div class="mt-5 print:break-before-page">
                            <ReportSubTitle class="mb-3">Engagement NO está relacionado con:</ReportSubTitle>
                            <ul class="list-disc list-outside text-lg pl-5">
                                <li class="text-justify">
                                    La felicidad en sí misma, como reírse con compañeros del trabajo o disfrutar de una fiesta de la empresa, no dice nada de
                                    qué tan involucrados o comprometidos están con la empresa o qué tan duro están trabajando para lograr la misión de la
                                    Organización. Es una medida a corto plazo que cambia rápidamente.
                                </li>
                                <li class="text-justify">
                                    La satisfacción puede ser suficiente para retener a los empleados, pero no garantiza la productividad. Esto solo indica qué
                                    tan feliz o contentos están los colaboradores, pero no aborda el nivel de motivación o compromiso emocional.
                                </li>
                            </ul>
                        </div>
                    </div>
                </ReportSection>

                <ReportSection title="2. Ejes fundamentales que explican la generación de compromiso" id="axis">
                    <div class="mb-3 text-xl text-justify">
                        Los ejes fundamentales que explican la generación de compromiso y sentido de pertenencia se agrupan en seis áreas, cada área a su vez
                        está definida por 3 variables y cada variable tiene 3 preguntas asociadas a indicadores de conducta, de la siguiente manera:
                    </div>
                    <div class="">
                        <div class="flex justify-center my-5">
                            <!-- <canvas id="variables-explain-chart" class="max-h-80"></canvas> -->
                            <VariablesTable></VariablesTable>
                        </div>
                    </div>
                    <div class="mt-10 print:break-before-page">
                        <div class="font-bold">Igualmente, el engagement se explica a través de:</div>
                        <div class="flex justify-center my-3">
                            <img src="/images/engagement.png" alt="Engagement" />
                        </div>
                    </div>
                </ReportSection>

                <ReportSection title="3. El método de medición" class="text-lg" id="method">
                    <div class="my-3 text-justify">
                        La encuesta contiene 60 afirmaciones que deben ser respondidas en una escala de 1 a 5 bajo las siguientes opciones:
                    </div>
                    <div class="my-3">
                        <ul class="list-decimal list-inside">
                            <li>Estoy totalmente en desacuerdo</li>
                            <li>Estoy parcialmente en desacuerdo</li>
                            <li>Ni en desacuerdo, ni de acuerdo</li>
                            <li>Estoy parcialmente de acuerdo</li>
                            <li>Estoy totalmente de acuerdo</li>
                        </ul>
                    </div>
                    <p class="my-3">
                        Adicionalmente en la parte final de la encuesta se hacen tres preguntas abiertas, las cuales se presentan en el reporte en forma
                        gráfica.
                    </p>
                    <p class="my-3 text-justify">
                        La medición del Employee Net Promoter Score ENPS (Puntaje del empleado promotor neto), se calcula con base a la pregunta “Le
                        recomendaría a amigo o familiar que trabaje en esta organización” (ítem 11), lo cual permite clasificar a los colaboradores en
                        promotores, neutros y detractores. El puntaje se obtiene de la resta de las respuestas que seleccionaron la opción Estoy totalmente de
                        acuerdo (promotores) menos la agrupación de las respuestas que seleccionaron Estoy totalmente en desacuerdo, Estoy parcialmente en
                        desacuerdo y Ni en desacuerdo, ni de acuerdo (detractores).
                    </p>
                    <p class="print:break-before-page">
                        El marco de interpretación para el ENPS: >0 es bueno, >20 es favorable, >50 es excelente, y >80 es de clase mundial
                    </p>
                    <div class="flex justify-center my-5">
                        <div class="w-full border rounded-md px-5 py-2 flex flex-col items-center">
                            <div class="font-bold text-2xl">Escala de medición de resultados para ENPS</div>
                            <div class="flex gap-0 w-full">
                                <div class="w-1/4 py-2 bg-[#F57C00] text-center flex flex-col justify-center items-center">
                                    <div class="font-bold">Bueno</div>
                                    <div class="font-bold">> 0</div>
                                </div>
                                <div class="w-1/4 py-2 bg-[#FCEB3C] text-center flex flex-col justify-center items-center">
                                    <div class="font-bold">Favorable</div>
                                    <div class="font-bold">> 20</div>
                                </div>
                                <div class="w-1/4 py-2 bg-[#ADFE30] text-center flex flex-col justify-center items-center">
                                    <div class="font-bold">Excelente</div>
                                    <div class="font-bold">> 50</div>
                                </div>
                                <div class="w-1/4 py-2 bg-[#3DFD01] text-center flex flex-col justify-center items-center">
                                    <div class="font-bold">Clase mundial</div>
                                    <div class="font-bold">> 80</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-8">
                        En la siguiente escala se pueden apreciar los colores, rangos de valor y significado para el mapa de calor que será utilizado en todas
                        las tablas del reporte
                    </div>
                    <div class="border rounded-md py-0 px-0 mx-0 flex flex-col items-center">
                        <div class="font-bold text-2xl">Escala de medición para resultados generales</div>
                        <div class="flex gap-0 w-full">
                            <div class="w-1/6 py-2 px-0 flex flex-col items-center bg-[#D51C00]">
                                <div class="font-bold print:text-sm text-center">Situación Crítica</div>
                                <div class="font-bold">0% - 30%</div>
                            </div>
                            <div class="w-1/6 py-2 px-0 flex flex-col items-center bg-[#F4511F]">
                                <div class="font-bold print:text-sm text-center">Atención urgente</div>
                                <div class="font-bold">31% - 50%</div>
                            </div>
                            <div class="w-1/6 py-2 px-0 flex flex-col items-center bg-[#F57C00]">
                                <div class="font-bold print:text-sm text-center">Insuficiente</div>
                                <div class="font-bold">51% - 70%</div>
                            </div>
                            <div class="w-1/6 py-2 px-0 flex flex-col items-center bg-[#FCEB3C]">
                                <div class="font-bold print:text-sm text-center">Aceptable</div>
                                <div class="font-bold">71% - 85%</div>
                            </div>
                            <div class="w-1/6 py-2 px-0 flex flex-col items-center bg-[#ADFE30]">
                                <div class="font-bold print:text-sm text-center">Muy bien</div>
                                <div class="font-bold">86% - 95%</div>
                            </div>
                            <div class="w-1/6 py-2 px-0 flex flex-col items-center bg-[#3DFD01]">
                                <div class="font-bold print:text-sm text-center">Sobresaliente</div>
                                <div class="font-bold">96% - 100%</div>
                            </div>
                        </div>
                    </div>
                </ReportSection>

                <div class="report-sections">
                    <ReportSection title="4. Descripción sociodemográfica">
                        <div class="py-5 flex justify-center">
                            <IndicatorWhite :text-light="true" name="Invitados">{{ pollInstance.participantsCount }}</IndicatorWhite>
                            <IndicatorWhite :text-light="true" name="Finalizados">{{ pollInstance.completedCount }}</IndicatorWhite>
                            <IndicatorWhite :text-light="true" name="Alcance">
                                {{
                                    pollInstance.participantsCount === 0
                                        ? 0
                                        : filters.decimal((pollInstance.completedCount / pollInstance.participantsCount) * 100, 1)
                                }}%
                            </IndicatorWhite>
                        </div>
                        <div class="flex flex-wrap">
                            <ReportSubSection title="4.1 Edad" class="col-span-2 lg:col-span-1" id="ages">
                                <PieChart
                                    resource="pollInstance.reachAgeRanges"
                                    label="Edad"
                                    :poll-instance-id="pollInstance.id"
                                    :show-equivalents="true"
                                ></PieChart>
                            </ReportSubSection>
                            <ReportSubSection title="4.2 Género" class="col-span-2 lg:col-span-1 print:break-before-page" id="genders">
                                <PieChart
                                    resource="pollInstance.reachGenders"
                                    label="Géneros"
                                    :poll-instance-id="pollInstance.id"
                                    :show-equivalents="true"
                                ></PieChart>
                            </ReportSubSection>
                            <ReportSubSection title="4.3 Antigüedad" class="col-span-2 lg:col-span-1" id="ancients">
                                <PieChart
                                    resource="pollInstance.reachServiceTime"
                                    label="Antiguedad"
                                    :poll-instance-id="pollInstance.id"
                                    :show-equivalents="true"
                                ></PieChart>
                            </ReportSubSection>
                            <ReportSubSection title="4.4 Niveles de la organización" class="col-span-2 print:break-before-page lg:col-span-1" id="levels">
                                <PieChart
                                    resource="pollInstance.reachCompanyLevels"
                                    label="Niveles de la organización"
                                    :poll-instance-id="pollInstance.id"
                                    :show-equivalents="true"
                                ></PieChart>
                            </ReportSubSection>
                            <ReportSubSection title="4.5 Área a la que pertenece" class="col-span-2 lg:col-span-1" id="areas">
                                <PieChart
                                    resource="pollInstance.reachAreas"
                                    label="Áreas"
                                    :poll-instance-id="pollInstance.id"
                                    :show-equivalents="true"
                                ></PieChart>
                            </ReportSubSection>
                            <ReportSubSection
                                title="4.6 Dirección, división, departamento, proyecto"
                                class="col-span-2 lg:col-span-1 print:break-before-page"
                                id="divisions"
                            >
                                <PieChart
                                    resource="pollInstance.reachDivisions"
                                    label="Dirección, división, departamtento, proyecto"
                                    :poll-instance-id="pollInstance.id"
                                    :show-chart="false"
                                    :show-equivalents="true"
                                ></PieChart>
                            </ReportSubSection>
                        </div>
                    </ReportSection>
                    <ReportSection title="5. Resultados" id="results">
                        <div class="py-5 flex justify-center">
                            <Indicator name="Puntaje Actual" :value="filters.decimal(generalResult, 2)"> </Indicator>
                            <Indicator name="Indice de engagement" :value="filters.decimal(engageResult, 2)"> </Indicator>
                            <Indicator name="Puntaje ponderado" :value="filters.decimal(ponderatedResult, 2)"> </Indicator>
                            <EnpIndicator name="ENPS" :value="filters.decimal(enpResult, 2)" symbol=""> </EnpIndicator>
                        </div>
                    </ReportSection>
                    <ReportSubSection title="5.1 Resultados por área" id="areas-result">
                        <div class="flex items-center w-full">
                            <div class="max-w-full">
                                <RadarChart
                                    resource="api.pollInstance.resultsByDimension"
                                    :poll-instance-id="pollInstance.id"
                                    label="Resultados por área"
                                    text-field="dimension"
                                    value-field="result"
                                    :show-table="true"
                                ></RadarChart>
                            </div>
                            <!-- <div class="col-span-1">
                                <table class="table1 max-w-full">
                                    <tr>
                                        <th class="border border-gray-800 text-center py-1">Área</th>
                                        <th class="border border-gray-800 text-center py-1">Resultado</th>
                                    </tr>
                                    <tr v-for="result in resultsByDimension" :key="result.dimension">
                                        <td class="border border-gray-800 text-center py-1">{{ result.dimension }}</td>
                                        <td class="border border-gray-800 text-center py-1" :style="`background-color: ${getRangeColor(result.result)}`">
                                            {{ filters.decimal(result.result, 2) }}%
                                        </td>
                                    </tr>
                                </table>
                            </div> -->
                        </div>
                    </ReportSubSection>
                    <ReportSubSection title="5.2 Resultados por área - variable" class="print:break-before-page" id="variables-result">
                        <table class="table1 min-w-full">
                            <tr>
                                <th class="border border-gray-800 text-center py-1" width="250px">Área</th>
                                <th class="border border-gray-800 text-center py-1">Variable</th>
                                <th class="border border-gray-800 text-center py-1" width="100px">Resultado</th>
                            </tr>
                            <tr v-for="(result, i) in resultsByDimensionAttribute" :key="result.attribute">
                                <td
                                    class="border border-gray-800 text-center py-1"
                                    :rowspan="getDimRows(result)"
                                    v-if="!i ? true : resultsByDimensionAttribute[i - 1].dimension !== result.dimension"
                                >
                                    {{ result.dimension }}
                                </td>
                                <td class="border border-gray-800 text-center py-1">{{ result.attribute }}</td>
                                <td class="border border-gray-800 text-center py-1" :style="`background-color: ${getRangeColor(result.result)}`">
                                    {{ filters.decimal(result.result, 2) }}
                                </td>
                            </tr>
                        </table>
                    </ReportSubSection>
                    <ReportSubSection title="5.3 Resultados por variable e indicador" class="print:break-before-page" id="indicators-result">
                        <div class="dimension-results mt-8" v-for="dimension in dimensions" :key="dimension.id">
                            <div class="text-blue-800 text-3xl flex justify-center">{{ dimension.name }}</div>
                            <div class="flex justify-center print:w-full mx-auto">
                                <table class="min-w-full table-fixed">
                                    <thead>
                                        <tr>
                                            <th class="border border-gray-800" width="250px">Variable</th>
                                            <th class="border border-gray-800">Indicador</th>
                                            <th class="border border-gray-800" width="100px">Puntaje Actual</th>
                                            <!-- <th>Puntaje Anterior</th>
                                <th>Tendencia</th>
                                <th>--</th> -->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(result, index) in dimensionResults(dimension.id)" :key="`dimension-${dimension.id}-${index}`">
                                            <td
                                                class="border text-center border-gray-800 py-1"
                                                rowspan="3"
                                                v-if="!index ? true : dimensionResults(dimension.id)[index - 1].attribute_name !== result.attribute_name"
                                            >
                                                {{ result.attribute_name }}
                                            </td>
                                            <td class="border text-center border-gray-800 py-1">{{ result.question_variable }}</td>
                                            <td
                                                class="border text-center border-gray-800 py-1 font-bold"
                                                :style="`background-color: ${getRangeColor(result.result)}`"
                                            >
                                                {{ filters.decimal(result.result, 2) }}%
                                            </td>
                                            <!-- <td></td>
                                <td></td>
                                <td></td> -->
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </ReportSubSection>
                    <ReportSection title="6. Rankings" id="rankings">
                        <ReportSubSection title="6.1 Variables con puntaje más alto" id="variables-top-ranking">
                            <table class="table1 min-w-full table-fixed">
                                <tr>
                                    <th class="border border-gray-800 text-center py-1">Variable</th>
                                    <th class="border border-gray-800 text-center py-1 w-72">Puntaje</th>
                                </tr>
                                <tr v-for="result in topHighAttributeResults">
                                    <td class="border border-gray-800 text-center py-1">{{ result.attribute }}</td>
                                    <td class="border border-gray-800 text-center py-1" :style="`background-color: ${getRangeColor(result.result)}`">
                                        {{ filters.decimal(result.result, 2) }}%
                                    </td>
                                </tr>
                            </table>
                        </ReportSubSection>
                        <ReportSubSection title="6.2 Variables con puntaje más bajo" id="variables-low-ranking">
                            <table class="table1 min-w-full table-fixed">
                                <tr>
                                    <th class="border border-gray-800 text-center py-1">Variable</th>
                                    <th class="border border-gray-800 text-center py-1 w-72">Puntaje</th>
                                </tr>
                                <tr v-for="result in topLowAttributeResults">
                                    <td class="border border-gray-800 text-center py-1">{{ result.attribute }}</td>
                                    <td class="border border-gray-800 text-center py-1" :style="`background-color: ${getRangeColor(result.result)}`">
                                        {{ filters.decimal(result.result, 2) }}%
                                    </td>
                                </tr>
                            </table>
                        </ReportSubSection>
                        <ReportSubSection title="6.3 Indicadores con puntaje más alto" class="print:break-before-page" id="indicators-top-ranking">
                            <table class="table1 min-w-full table-fixed">
                                <tr>
                                    <th class="border border-gray-800 text-center py-1">Indicador</th>
                                    <th class="border border-gray-800 text-center py-1 w-72">Puntaje</th>
                                </tr>
                                <tr v-for="result in topHighIndicatorResults">
                                    <td class="border border-gray-800 text-center py-1">{{ result.question_variable }}</td>
                                    <td class="border border-gray-800 text-center py-1" :style="`background-color: ${getRangeColor(result.result)}`">
                                        {{ filters.decimal(result.result, 2) }}%
                                    </td>
                                </tr>
                            </table>
                        </ReportSubSection>
                        <ReportSubSection title="6.4 Indicadores con puntaje más bajo" id="indicators-low-ranking">
                            <table class="table1 min-w-full table-fixed">
                                <tr>
                                    <th class="border border-gray-800 text-center py-1">Indicador</th>
                                    <th class="border border-gray-800 text-center py-1 w-72">Puntaje</th>
                                </tr>
                                <tr v-for="result in topLowIndicatorResults">
                                    <td class="border border-gray-800 text-center py-1">{{ result.question_variable }}</td>
                                    <td class="border border-gray-800 text-center py-1" :style="`background-color: ${getRangeColor(result.result)}`">
                                        {{ filters.decimal(result.result, 2) }}%
                                    </td>
                                </tr>
                            </table>
                        </ReportSubSection>
                    </ReportSection>
                    <ReportSection title="7. Dispersión" id="dispersion">
                        <ReportSubSection title="7.1 Dispersión por áreas" id="areas-dispersion">
                            <div class="flex justify-center max-w-lg mx-auto">
                                <DataTable
                                    class="w-full"
                                    :columns="[
                                        { key: 'dimension', text: 'Área' },
                                        { key: 'deviation', text: 'Desviación' },
                                    ]"
                                    :items="deviationByDimension"
                                >
                                    <template #cell(deviation)="{ item }">
                                        {{ filters.decimal(item.deviation, 3) }}
                                    </template>
                                </DataTable>
                            </div>
                        </ReportSubSection>
                        <ReportSubSection title="7.2 Dispersión por variables" id="variables-dispersion">
                            <div class="flex justify-center max-w-lg mx-auto">
                                <DataTable
                                    class="w-full"
                                    :columns="[
                                        { key: 'attribute', text: 'Variable' },
                                        { key: 'deviation', text: 'Desviación' },
                                    ]"
                                    :items="deviationByAttribute"
                                >
                                    <template #cell(deviation)="{ item }">
                                        {{ filters.decimal(item.deviation, 3) }}
                                    </template>
                                </DataTable>
                            </div>
                        </ReportSubSection>
                        <ReportSubSection title="7.3 Dispersión por indicadores (top 10)" id="indicators-dispersion">
                            <div class="flex justify-center max-w-lg mx-auto">
                                <DataTable
                                    class="w-full"
                                    :columns="[
                                        { key: 'variable', text: 'Indicador' },
                                        { key: 'deviation', text: 'Desviación' },
                                    ]"
                                    :items="deviationByVariable"
                                >
                                    <template #cell(deviation)="{ item }">
                                        {{ filters.decimal(item.deviation, 3) }}
                                    </template>
                                </DataTable>
                            </div>
                        </ReportSubSection>
                    </ReportSection>
                    <!-- <ReportSection title="8. Tendencias">
                        <ReportSubSection title="8.1. Tendencia por áreas"></ReportSubSection>
                        <ReportSubSection title="8.2. Tendencia por variables"></ReportSubSection>
                        <ReportSubSection title="8.3. Tendencia por indicadores"></ReportSubSection>
                    </ReportSection> -->
                    <ReportSection title="8. Resumen de preguntas abiertas" id="open-questions">
                        <div class="flex flex-col gap-10">
                            <div v-for="openQuestion in openQuestions" class="border rounded-md px-2 py-2">
                                <div class="text-blue-700 font-bold text-xl">{{ openQuestion.question }}</div>
                                <div class="flex flex-wrap gap-2 items-stretch">
                                    <div
                                        v-for="word in openQuestion.open_question_words"
                                        :style="`font-size: ${(parseFloat(word.weight.toString()) * 5) / getMaxWeight(openQuestion)}rem`"
                                        class="font-bold uppercase px-2 border rounded-md flex flex-col items-center justify-center align-middle"
                                    >
                                        <div class="align-middle">
                                            {{ word.word }}
                                        </div>
                                        <div class="text-sm text-blue-800">{{ word.frequency }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </ReportSection>
                </div>
            </div>
        </div>
    </div>
</template>
<script setup lang="ts">
import { nextTick, onMounted, Ref, ref, toRefs, watch } from 'vue'
import { rangeColors } from '../../Utils/StatusColors'
import ReportSection from '../../Components/Report/ReportSection.vue'
import ReportSubSection from '../../Components/Report/ReportSubSection.vue'
import Indicator from '../../Components/Dashboard/Indicator.vue'
import IndicatorWhite from '../../Components/Dashboard/IndicatorWhite.vue'
import EnpIndicator from '../../Components/Dashboard/EnpIndicator.vue'
import filters from '../../Filters'
import { useRepo } from '../../Repository'
import ReportIndex from '../../Partials/Report/ReportIndex.vue'
import Recommendations from '../../Partials/Report/Recommendations.vue'
import ReportTitle from '../../Components/Report/ReportTitle.vue'
import ReportSubTitle from '../../Components/Report/ReportSubTitle.vue'
import VariablesTable from '../../Partials/Report/VariablesTable.vue'
import FrontPage from '../../Partials/Report/FrontPage.vue'
import PieChart from '../../Components/Charts/PieChart.vue'
import RadarChart from '../../Components/Charts/RadarChart.vue'

import { renderDimensions, renderVariables } from '../../Partials/Report/charts'

interface VarianceResult {
    item: string
    value: number
    variance: number
}

const repo = useRepo()

const props = defineProps<{
    pollInstance: PollInstance
}>()
const { pollInstance } = toRefs(props)
const dimensions: Ref<Dimension[]> = ref([])
const engageResult: Ref<number> = ref(0)
const ponderatedResult: Ref<number> = ref(0)
const enpResult: Ref<number> = ref(0)
const generalResult: Ref<number> = ref(0)
const openQuestions: Ref<OpenQuestion[]> = ref([])
const pollResults: Ref<ParticipantPollAnswer[]> = ref([])
const resultsByDimension: Ref<DimensionResult[]> = ref([])
const resultsByDimensionAttribute: Ref<DimensionAttributeResult[]> = ref([])
const resultsByDimensionAttributeVariable: Ref<DimensionAttributeVariableResult[]> = ref([])
const topHighAttributeResults: Ref<TopHighAttributeResult[]> = ref([])
const topLowAttributeResults: Ref<TopLowAttributeResult[]> = ref([])
const topHighIndicatorResults: Ref<TopIndicatorResult[]> = ref([])
const topLowIndicatorResults: Ref<TopIndicatorResult[]> = ref([])
const deviationByAttribute: Ref<VarianceResult[]> = ref([])
const deviationByDimension: Ref<VarianceResult[]> = ref([])
const deviationByVariable: Ref<VarianceResult[]> = ref([])
const reportReady: Ref<boolean> = ref(false)

const getDimRows = (result: any) => {
    return resultsByDimensionAttribute.value.filter((item) => item.dimension === result.dimension).length
}

const dimensionResults = (dimensionId: number): DimensionAttributeVariableResult[] =>
    resultsByDimensionAttributeVariable.value.filter((item) => item.dimension_id === dimensionId)

const getRangeColor = (val: number) => {
    return rangeColors.find((item) => val > item.min && val <= item.max)?.color
}

const getMaxWeight = (openQuestion: any) => {
    return Math.max(...openQuestion.open_question_words.map((item: any) => item.weight))
}

const loadDimensions = async (): Promise<void> => {
    const { data } = await repo.get(route('api.poll.dimensions', { id: pollInstance.value.poll_id }))
    dimensions.value = data
}

const loadGeneralResult = async (): Promise<void> => {
    const { data } = await repo.get(route('api.pollInstance.generalResult', { id: pollInstance.value.id }))
    generalResult.value = data
}

const loadResultsByDimension = async (): Promise<void> => {
    const { data } = await repo.get(route('api.pollInstance.resultsByDimension', { id: pollInstance.value.id }))
    resultsByDimension.value = data
}

const loadPollResults = async (): Promise<void> => {
    const { data } = await repo.get(route('api.pollInstance.pollResults', { id: pollInstance.value.id }))
    pollResults.value = data
}

const loadEngageResult = async (): Promise<void> => {
    const { data } = await repo.get(route('api.pollInstance.engageResult', { id: pollInstance.value.id }))
    engageResult.value = data
}

const loadPonderatedResult = async (): Promise<void> => {
    const { data } = await repo.get(route('api.pollInstance.ponderatedResult', { id: pollInstance.value.id }))
    ponderatedResult.value = data
}

const loadEnpResult = async (): Promise<void> => {
    const { data } = await repo.get(route('api.pollInstance.enpResult', { id: pollInstance.value.id }))
    enpResult.value = data
}

const loadResultsByDimensionAttribute = async (): Promise<void> => {
    const { data } = await repo.get(route('api.pollInstance.resultsByDimensionAttribute', { id: pollInstance.value.id }))
    resultsByDimensionAttribute.value = data
}

const loadResultsByDimensionAttributeVariable = async (): Promise<void> => {
    const { data } = await repo.get(route('api.pollInstance.resultsByDimensionAttributeVariable', { id: pollInstance.value.id }))
    resultsByDimensionAttributeVariable.value = data
}

const loadTopHighAttributeResults = async (): Promise<void> => {
    const { data } = await repo.get(route('api.pollInstance.topHighAttributeResults', { id: pollInstance.value.id }))
    topHighAttributeResults.value = data
}

const loadTopLowAttributeResults = async (): Promise<void> => {
    const { data } = await repo.get(route('api.pollInstance.topLowAttributeResults', { id: pollInstance.value.id }))
    topLowAttributeResults.value = data
}

const loadTopHighIndicatorResults = async (): Promise<void> => {
    const { data } = await repo.get(route('api.pollInstance.topHighIndicatorResults', { id: pollInstance.value.id }))
    topHighIndicatorResults.value = data
}

const loadTopLowIndicatorResults = async (): Promise<void> => {
    const { data } = await repo.get(route('api.pollInstance.topLowIndicatorResults', { id: pollInstance.value.id }))
    topLowIndicatorResults.value = data
}

const loadOpenQuestions = async (): Promise<void> => {
    const { data } = await repo.get(route('api.pollInstance.words', { id: pollInstance.value.poll_id }))
    openQuestions.value = data
}

const loadDeviationByDimension = async (): Promise<void> => {
    const { data } = await repo.get(route('api.pollInstance.deviationByDimension', { id: pollInstance.value.id }))
    deviationByDimension.value = data
}
const loadDeviationByAttribute = async (): Promise<void> => {
    const { data } = await repo.get(route('api.pollInstance.deviationByAttribute', { id: pollInstance.value.id }))
    deviationByAttribute.value = data
}
const loadDeviationByVariable = async (): Promise<void> => {
    const { data } = await repo.get(route('api.pollInstance.deviationByVariable', { id: pollInstance.value.id }))
    deviationByVariable.value = data.slice(0, 10)
}

onMounted(() => {
    Promise.all([
        loadDimensions(),
        loadGeneralResult(),
        loadEngageResult(),
        loadPonderatedResult(),
        loadEnpResult(),
        loadResultsByDimension(),
        loadResultsByDimensionAttribute(),
        loadResultsByDimensionAttributeVariable(),
        loadTopHighAttributeResults(),
        loadTopLowAttributeResults(),
        loadTopHighIndicatorResults(),
        loadTopLowIndicatorResults(),
        loadOpenQuestions(),
        ,
        loadDeviationByDimension(),
        loadDeviationByAttribute(),
        loadDeviationByVariable(),
    ]).then(() => {
        reportReady.value = true
        nextTick(() => {
            renderDimensions('dimensions-explain-chart')
        })
    })
})
</script>
<style>
body {
    margin: 0;
    padding: 0;
}

@page {
    margin: 2cm 1.5cm;
    border: 1px solid lightgray;
}

@media print {
    body {
        margin: 0;
        padding: 0;
        -webkit-print-color-adjust: exact !important;
        print-color-adjust: exact !important;
    }
}

.table {
    border-collapse: collapse;
}

.table > tr {
    border: 1px solid darkgray;
}
.table > tr > td,
th {
    border: 1px solid darkgray;
    text-align: center;
    padding: 3px 8px;
}
</style>

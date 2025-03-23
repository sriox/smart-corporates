<template>
    <div class="grid my-8" :class="{ 'grid-cols-6': showChart, 'grid-cols-1': !showChart }">
        <div class="col-span-3 flex justify-center max-h-64 mr-1" v-if="showChart">
            <canvas :id="id"></canvas>
        </div>
        <div class="ml-2 flex items-center" :class="{ 'col-span-3': showChart, 'col-span-1': !showChart }">
            <DataTable :columns="theColumns" :items="results" compact class="w-full text-sm">
                <template #cell(equivalent)="{ item }: { item: ReachResult }"> {{ filters.decimal((item.cant / sumResults) * 100, 2) }} % </template>
            </DataTable>
        </div>
    </div>
</template>
<script setup lang="ts">
import { Ref, ref, onMounted, computed } from 'vue'
import Chart from 'chart.js/auto'
import ChartDataLabels from 'chartjs-plugin-datalabels'
import { useRepo } from '../../Repository'
import filters from '../../Filters'
Chart.register(ChartDataLabels)

interface ReachResult {
    name: string
    cant: number
}

const results: Ref<ReachResult[]> = ref([])

const repo = useRepo()
const props = withDefaults(
    defineProps<{
        pollInstanceId: number
        resource: string
        label: string
        id?: string
        showLabels?: boolean
        showChart?: boolean
        showEquivalents?: boolean
    }>(),
    {
        id: () => `canvas-${Math.random() * 100000000}`,
        showLabels: true,
        showChart: true,
        showEquivalents: false,
    }
)

const theColumns = computed(() => {
    if (!props.showEquivalents) return fields
    return [...fields, { key: 'equivalent', text: 'Equivalente' }]
})

const sumResults = computed(() => {
    return results.value.reduce((carry: number, item: ReachResult) => carry + item.cant, 0)
})

onMounted(async () => {
    const { data } = await repo.get(route(props.resource, { id: props.pollInstanceId }))
    results.value = data

    props.showChart &&
        new Chart(document.getElementById(props.id) as HTMLCanvasElement, {
            type: 'pie',
            data: {
                labels: data.map((item: ReachResult) => item.name),
                datasets: [
                    {
                        label: props.label,
                        data: data.map((item: ReachResult) => item.cant),
                    },
                ],
            },
            options: {
                font: {
                    weight: 'bold',
                },
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            boxWidth: 80,
                        },
                        display: false,
                    },
                    datalabels: {
                        display: props.showLabels,

                        font: {
                            weight: 'bolder',
                            size: 14,
                        },
                        color: 'black',

                        formatter: (value: number, ctx) => {
                            let dataArr = ctx.chart.data.datasets[0].data
                            const sum: any = dataArr.reduce((carry: any, item: any) => carry + item, 0)
                            // dataArr.map((data) => {
                            //     sum += data
                            // })
                            let percentage = ((value * 100) / sum).toFixed(2) + '%'
                            return percentage
                        },
                    },
                },
            },
        })
})

const fields = [
    {
        key: 'name',
        text: 'Item',
    },
    {
        key: 'cant',
        text: 'Resultado',
    },
]
</script>

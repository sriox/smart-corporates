<template>
    <div class="grid mt-1 mb-0 w-full" :class="{ 'grid-cols-12': showTable, 'grid-cols-1': !showTable }">
        <div class="flex justify-center mr-2" :class="showTable ? 'col-span-8' : 'col-span-1'">
            <canvas :id="id"></canvas>
        </div>
        <div class="ml-2 flex items-center max-w-full" :class="showTable ? 'col-span-4' : 'col-span-1'" v-if="showTable">
            <DataTable :columns="fields" :items="results" compact class="w-full"></DataTable>
        </div>
    </div>
</template>
<script setup lang="ts">
import { Ref, ref, onMounted } from 'vue'
import Chart from 'chart.js/auto'
import ChartDataLabels from 'chartjs-plugin-datalabels'
import { useRepo } from '../../Repository'
import filters from '../../Filters'
Chart.register(ChartDataLabels)

interface Result {
    text: string
    value: number
}

const results: Ref<Result[]> = ref([])

const repo = useRepo()
const props = withDefaults(
    defineProps<{
        pollInstanceId: number
        resource: string
        label: string
        id?: string
        valueField?: string
        textField?: string
        showTable?: boolean
    }>(),
    {
        id: () => `canvas-${Math.random() * 100000000}`,
        valueField: 'value',
        textField: 'text',
        showTable: true,
    }
)
onMounted(async () => {
    const { data } = await repo.get(route(props.resource, { id: props.pollInstanceId }))

    const _data: Result[] = data
        .sort((a: DimensionResult, b: DimensionResult) => (a.order < b.order ? -1 : 1))
        .map((item: Record<string, any>) => ({ text: item[props.textField], value: filters.decimal(item[props.valueField], 2) } as Result))
    // results.value = _data.sort((a: Result, b: Result) => (a.value < b.value ? 1 : -1))
    console.log({ data })

    results.value = _data

    const min = Math.min(..._data.map((item: Result) => item.value))
    const max = Math.max(..._data.map((item: Result) => item.value))

    new Chart(document.getElementById(props.id) as HTMLCanvasElement, {
        type: 'radar',
        data: {
            labels: _data.map((item: Result) => item.text),
            datasets: [
                {
                    label: props.label,
                    data: _data.map((item: Result) => item.value),
                },
            ],
        },
        options: {
            scales: {
                r: {
                    angleLines: {
                        display: false,
                    },
                    suggestedMin: min - 10,
                    suggestedMax: 100,
                    beginAtZero: false,
                    ticks: {
                        stepSize: 10,
                    },
                    grid: {
                        lineWidth: 2,
                        color: 'darkgray',
                    },
                },
            },

            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                    labels: {
                        boxWidth: 80,
                        font: {
                            size: 16,
                        },
                        color: 'black',
                    },
                    display: false,
                },
                // datalabels: {
                //     font: {
                //         size: 16,
                //     },
                //     color: 'black',
                // },
            },
        },
    })
})

const fields = [
    {
        key: 'text',
        text: 'Item',
    },
    {
        key: 'value',
        text: 'Resultado',
    },
]
</script>

import { Chart } from 'chart.js'
import ChartDataLabels from 'chartjs-plugin-datalabels'
Chart.register(ChartDataLabels)

export const renderDimensions = (id: string): void => {
    const ctx = document.getElementById(id) as HTMLCanvasElement
    const chart = new Chart(ctx, {
        type: 'polarArea',
        data: {
            labels: ['Compromiso', 'Ambiente laboral', 'Pertenencia', 'Equipo', 'Proyección', 'Liderazgo'],
            datasets: [
                {
                    label: 'Áreas',
                    data: [100, 100, 100, 100, 100, 100],
                },
            ],
        },
        options: {
            responsive: true,
            scales: {
                r: {
                    pointLabels: {
                        display: true,
                        centerPointLabels: true,
                        font: {
                            size: 16,
                        },
                    },
                },
            },
            plugins: {
                legend: {
                    display: false,
                    position: 'chartArea',
                },
                datalabels: {
                    display: false,
                },
            },
        },
    })
}

export const renderVariables = (id: string): void => {
    const ctx = document.getElementById(id) as HTMLCanvasElement
    const chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Compromiso', 'Pertenencia'],
            datasets: [
                {
                    type: 'bar',
                    label: 'Proposito',
                    data: [33, 33, 33],
                },
                {
                    type: 'bar',
                    label: 'Autonomía',
                    data: [33, 33, 33],
                },
                {
                    type: 'bar',
                    label: 'Realización',
                    data: [33, 33, 33],
                },
            ],
        },
        options: {
            scales: {
                x: {
                    stacked: true,
                },
                y: {
                    stacked: true,
                },
            },
        },
    })
}

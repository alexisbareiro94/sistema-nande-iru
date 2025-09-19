import Chart from 'chart.js/auto';
import { showToast } from './toast';

let PagosChart = null;
async function pagosChart() {
    try {

        const res = await fetch('http://localhost:8080/api/pagos');
        const data = await res.json();

        if (!res.ok) {
            throw data
        }

        const donut = document.getElementById('pagosChart');
        console.log(data)
        if (PagosChart) {
            PagosChart.destroy();
        }

        PagosChart = new Chart(donut, {
            type: 'doughnut',
            data: {
                labels: data.labels,
                datasets: [
                    {
                        label: 'Pagos',
                        data: [data.efectivo, data.transferencia, data.mixto],
                        backgroundColor: [
                            'rgba(8, 209, 49, 0.6)',
                            'rgba(35, 39, 235, 0.6)',
                            'rgba(255, 234, 0, 0.6)'
                        ],
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                }
            }
        });
    } catch (err) {
        showToast(`${err.error}`, 'error');
    }

}
document.addEventListener('DOMContentLoaded', async () => {
    if (window.location.pathname === '/reportes') {
        await pagosChart();
    }
});

let ventaChart = null;
async function ventasChart(periodo = 7) {
    const input = document.getElementById('periodo');
    const periodoPick = input ? parseInt(input.value) : periodo;
    try {
        const res = await fetch(`http://localhost:8080/api/ventas/${periodoPick}`)
        const data = await res.json();
        if (!res.ok) {
            throw data;
        }
        const bar = document.getElementById('ventasChart');

        const labels = data.labels;
        const valores = labels.map(fecha => data.ventas[fecha].total);

        if (ventaChart) {
            ventaChart.destroy();
        }

        ventaChart = new Chart(bar, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Ventas',
                        data: valores,
                        backgroundColor: 'rgba(54, 162, 235, 0.6)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    }
                },
                scales: {
                    x: {
                        ticks: {
                            autoSkip: false
                        },
                        grid: {
                            drawTicks: false
                        },
                        categoryPercentage: 1.0,
                        barPercentage: 0.8
                    },
                    y: {
                        beginAtZero: true
                    }
                }
            }

        });



    } catch (err) {
        showToast(`${err.error}`, 'error')
    }
}
ventasChart();

const btns = document.querySelectorAll('.periodo-btn');

btns.forEach(btn => {
    btn.addEventListener('click', () => {
        btns.forEach(b => {
            b.classList.remove('bg-gray-50', 'shadow-lg');
            b.classList.add('bg-gray-300');
        });
        ventasChart(btn.dataset.periodo);

        setTimeout(() => {
            btn.classList.remove('bg-gray-300');
            btn.classList.add('bg-gray-50', 'shadow-lg');
        }, 150)

        const periodo = btn.dataset.periodo;
        console.log(`Periodo seleccionado: ${periodo}`);
    });
});

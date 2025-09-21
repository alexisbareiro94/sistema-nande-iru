import Chart from 'chart.js/auto';
import { showToast } from './toast';

//------------------------------------grafico de pagos------------------------------------------
let PagosChart = null;
async function pagosChart(periodo = 7) {
    try {
        const res = await fetch(`http://localhost:8080/api/pagos/${periodo}`);
        const data = await res.json();

        if (!res.ok) {
            throw data
        }

        const donut = document.getElementById('pagosChart');
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
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                },

            }
        });
    } catch (err) {
        console.log(err)
        //showToast(`${err.error}`, 'error');
    }

}
document.addEventListener('DOMContentLoaded', async () => {
    if (window.location.pathname === '/reportes') {
        await pagosChart();
    }
});

const pagoBtns = document.querySelectorAll('.pago-btn');

pagoBtns.forEach(btn => {
    btn.addEventListener('click', () => {
        pagoBtns.forEach(b => {
            b.classList.remove('bg-gray-50', 'shadow-lg');
            b.classList.add('bg-gray-300');
        });
        pagosChart(btn.dataset.pago)
        setTimeout(() => {
            btn.classList.remove('bg-gray-300');
            btn.classList.add('bg-gray-50', 'shadow-lg');
        }, 150)
    });
});

// ----------------------------------------grafico de ventas ---------------------------------------------------
let ventaChart = null;
async function ventasChart(periodo = 7) {
    try {
        const res = await fetch(`http://localhost:8080/api/ventas/${periodo}`)
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
        console.log(err)
        //showToast(`${err.error}`, 'error')
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
    });
});


//-----------------------------------------grafico de tipo de venta-----------------------------------------------
let tipoVentaChart = null;
async function tipoVenta(periodo = 7) {
    try {
        const res = await fetch(`http://localhost:8080/api/tipo_venta/${periodo}`);
        const data = await res.json();

        if (!res.ok) {
            throw data
        }
        const donutVenta = document.getElementById('tipoVentaChart');
        if (tipoVentaChart) {
            tipoVentaChart.destroy();
        }

        tipoVentaChart = new Chart(donutVenta, {
            type: 'doughnut',
            data: {
                labels: data.labels,
                datasets: [
                    {
                        label: 'Cantidad',
                        data: [data.conteo.producto, data.conteo.servicio],
                        backgroundColor: [
                            'rgba(35, 39, 235, 0.6)',
                            'rgba(8, 209, 49, 0.6)',
                        ]
                    },
                    {
                        label: 'Ingresos',
                        data: [1500000, 1385000],
                        backgroundColor: [
                            'rgba(35, 39, 235, 0.3)',   // más transparente para diferenciar
                            'rgba(8, 209, 49, 0.3)',
                        ],
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                },

            }
        });
    } catch (err) {
        console.log(err)
        //showToast(`${err.error}`, 'error');
    }

}
document.addEventListener('DOMContentLoaded', async () => {
    if (window.location.pathname === '/reportes') {
        await tipoVenta();
    }
});


const tipoBtns = document.querySelectorAll('.tipo-btn');

tipoBtns.forEach(btn => {
    btn.addEventListener('click', () => {
        tipoBtns.forEach(b => {
            b.classList.remove('bg-gray-50', 'shadow-lg');
            b.classList.add('bg-gray-300');
        });
        tipoVenta(btn.dataset.tipo)
        setTimeout(() => {
            btn.classList.remove('bg-gray-300');
            btn.classList.add('bg-gray-50', 'shadow-lg');
        }, 150)
    });
});


//-------------------------parte de las ganancias----------------------------
const utiBtns = document.querySelectorAll('.utilidad-btn');

utiBtns.forEach(btn => {
    btn.addEventListener('click', async () => {
        utiBtns.forEach(b => {
            b.classList.remove('bg-gray-50', 'shadow-lg');
            b.classList.add('bg-gray-300');
        });
        const option = JSON.parse(sessionStorage.getItem('option'));
        console.log(option)
        if (option != null) {
            await gananacias(btn.dataset.utilidad, option);
        } else {
            await gananacias(btn.dataset.utilidad);
        }
        setTimeout(() => {
            btn.classList.remove('bg-gray-300');
            btn.classList.add('bg-gray-50', 'shadow-lg');
        }, 150)
    });
});


const optionsBtns = document.querySelectorAll('.option-btn');
optionsBtns.forEach(btn => {
    btn.addEventListener('click', async () => {
        optionsBtns.forEach(b => {
            b.classList.remove('bg-gray-50', 'shadow-lg');
            b.classList.add('bg-gray-300');
        });
        const periodo = JSON.parse(sessionStorage.getItem('periodo'))

        if (btn.dataset.option) {
            sessionStorage.setItem('option', JSON.stringify(btn.dataset.option))
            await gananacias(periodo, btn.dataset.option);
        } else {
            sessionStorage.removeItem('option');
            await gananacias(periodo);
        }
        setTimeout(() => {
            btn.classList.remove('bg-gray-300');
            btn.classList.add('bg-gray-50', 'shadow-lg');
        }, 150)
    });
});


async function gananacias(periodo, option = '') {
    sessionStorage.setItem('periodo', JSON.stringify(periodo));
    const gananciaActual = document.getElementById('ganancia-actual');
    const rangoActual = document.getElementById('rango-actual');
    const contDiff = document.getElementById('cont-diff');
    const porcentaje = document.getElementById('variacion-porcentaje');
    const diferencia = document.getElementById('variacion-valor');
    const rangoAnterior = document.getElementById('rango-anterior');
    try {
        const res = await fetch(`http://localhost:8080/api/utilidad/${periodo}/${option}`);
        const data = await res.json();
        if (!res.ok) {
            throw data;
        }

        const fecha = periodo == 'dia' ? `Hoy (${data.data.actual.fecha_apertura})` :
            (periodo == 'semana' ? `Semana Actual (${data.data.actual.fecha_apertura} al ${data.data.actual.fecha_cierre})` :
                `Mes Actual (${data.data.actual.fecha_apertura} al ${data.data.actual.fecha_cierre})`);

        const fechaPasada = periodo == 'dia' ? `Ayer (${data.data.pasado.fecha_apertura})` :
            (periodo == 'semana' ? `Semana Pasada (${data.data.pasado.fecha_apertura} al ${data.data.pasado.fecha_cierre})` :
                `Mes Pasado (${data.data.pasado.fecha_apertura} al ${data.data.pasado.fecha_cierre})`);
        //ganancia actual        
        gananciaActual.innerText = `Gs. ${data.data.actual.ganancia.toLocaleString('es-PY')}`
        rangoActual.innerText = `Rango: ${fecha}`

        //vs periodo anterior
        const tag = data.data.tag;
        let classContDiff = data.data.tag == '-' ? 'from-red-50 to-red-100 border-red-200' : 'from-green-50 to-green-100 border-green-200'
        let spanClass = data.data.tag == '-' ? 'text-red-700' : 'text-green-700';
        porcentaje.classList = `text-2xl font-bold ${spanClass}`;
        contDiff.classList = `bg-gradient-to-r p-4 rounded-lg border ${classContDiff}`;
        porcentaje.innerText = `${tag} ${data.data.porcentaje}%`;
        diferencia.innerText = `(Gs. ${data.data.diferencia.toLocaleString('es-PY')})`
        rangoAnterior.innerText = `Rango: ${fechaPasada}`

    } catch (err) {
        console.log(err)
        showToast(`${err.error ?? 'error'}`, 'error');
    }
}


//---------------grafico de tendencias-----------------------

async function tendenciasChart() {
    try {
        const res = await fetch('http://localhost:8080/api/tendencias');
        const data = await res.json();
        if (!res.ok) {
            throw data;
        }

        console.log(data)



        new Chart(document.getElementById('miniChart'), {
            type: 'line',
            data: {
                labels: data.labels,
                datasets: [{
                    label: 'Ganancia Diaria',
                    data: [data.datos[0]['ganancia'], data.datos[1]['ganancia'], data.datos[2]['ganancia'], data.datos[3]['ganancia'], data.datos[4]['ganancia'], data.datos[5]['ganancia'],data.datos[6]['ganancia'],data.datos[7]['ganancia']],
                    borderColor: '#6366f1',
                    tension: 0.3,
                    fill: true,
                    backgroundColor: 'rgba(99, 102, 241, 0.1)'
                }]
            },
            options: {
                plugins: { legend: { display: false } },
                maintainAspectRatio: false,
                scales: {
                    x: {
                        ticks: {
                            // fuerza la rotación vertical
                            // minRotation: 90,
                            // maxRotation: 90,
                        }
                    },
                    y: {
                        display: true
                    }
                },
                elements: {
                    point: { radius: 4 }
                }
            }
        });
    } catch (err) {
        console.log(err)
    }
}

tendenciasChart();
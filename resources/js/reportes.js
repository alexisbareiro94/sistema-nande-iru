import Chart from 'chart.js/auto';
import { showToast } from './toast';


function limpiarSessions() {
    sessionStorage.removeItem('regreso');
    sessionStorage.removeItem('periodo');
    sessionStorage.removeItem('option');
}

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
                    },
                    {
                        label: 'Ingresos',
                        data: [data.ingresos.efectivo, data.ingresos.transferencia, data.ingresos.mixto],
                        backgroundColor: [
                            'rgba(8, 209, 49, 0.4)',
                            'rgba(35, 39, 235, 0.4)',
                            'rgba(255, 234, 0, 0.4)'
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
})
limpiarSessions();


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

// ----------------------------------------grafico de Evolución de Ventas---------------------------------------------------
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
                        data: [data.conteo.ingresos.producto, data.conteo.ingresos.servicio],
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


//-------------------------comparativa de las ganancias----------------------------

//boton de periodo
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

//boton de opcion
const optionsBtns = document.querySelectorAll('.option-btn');
optionsBtns.forEach(btn => {
    btn.addEventListener('click', async () => {
        optionsBtns.forEach(b => {
            b.classList.remove('bg-gray-50', 'shadow-lg');
            b.classList.add('bg-gray-300');
        });
        const periodo = JSON.parse(sessionStorage.getItem('periodo'))
        const regreso = JSON.parse(sessionStorage.getItem('regreso'));

        if (btn.dataset.option) {
            if (regreso != null) {
                sessionStorage.setItem('option', JSON.stringify(btn.dataset.option))
                await gananacias(periodo, btn.dataset.option, regreso);
            } else {
                sessionStorage.setItem('option', JSON.stringify(btn.dataset.option))
                await gananacias(periodo, btn.dataset.option);
            }
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


const rEgresosBtns = document.querySelectorAll('.regreso-btn');

rEgresosBtns.forEach(btn => {
    btn.addEventListener('click', async () => {
        rEgresosBtns.forEach(b => {
            b.classList.remove('bg-gray-50', 'shadow-lg');
            b.classList.add('bg-gray-300');
        });
        const option = JSON.parse(sessionStorage.getItem('option'));
        const periodo = JSON.parse(sessionStorage.getItem('periodo')) || 'dia';
        console.log(periodo)
        if (btn.dataset.regreso) {
            sessionStorage.setItem('regreso', JSON.stringify(btn.dataset.regreso))
            await gananacias(periodo, option, btn.dataset.regreso);
            //TendenciasChart();
        } else {
            sessionStorage.removeItem('regreso');
            await gananacias(periodo, option, null);
        }
        setTimeout(() => {
            btn.classList.remove('bg-gray-300');
            btn.classList.add('bg-gray-50', 'shadow-lg');
        }, 150)
    });
});

async function gananacias(periodo = '7', option = '', egreso = '') {
    sessionStorage.setItem('periodo', JSON.stringify(periodo));
    const regreso = JSON.parse(sessionStorage.getItem('regreso'));
    const gananciaActual = document.getElementById('ganancia-actual');
    const rangoActual = document.getElementById('rango-actual');
    const contDiff = document.getElementById('cont-diff');
    const porcentaje = document.getElementById('variacion-porcentaje');
    const diferencia = document.getElementById('variacion-valor');
    const rangoAnterior = document.getElementById('rango-anterior');
    const gananciaAnterior = document.getElementById('ganancia-anterior');

    try {
        const res = await fetch(`http://localhost:8080/api/utilidad/${periodo}/${option}`);
        const data = await res.json();
        if (!res.ok) {
            throw data;
        }

        const fecha = periodo == 'dia'
            ? `Hoy (${data.data.actual.fecha_apertura})`
            : (periodo == 'semana'
                ? `Semana Actual (${data.data.actual.fecha_apertura} al ${data.data.actual.fecha_cierre})`
                : `Mes Actual (${data.data.actual.fecha_apertura} al ${data.data.actual.fecha_cierre})`);

        const fechaPasada = periodo == 'dia'
            ? `Ayer (${data.data.pasado.fecha_apertura})`
            : (periodo == 'semana'
                ? `Semana Pasada (${data.data.pasado.fecha_apertura} al ${data.data.pasado.fecha_cierre})`
                : `Mes Pasado (${data.data.pasado.fecha_apertura} al ${data.data.pasado.fecha_cierre})`);

        if (regreso == 'true') {        
            gananciaActual.innerText = `Gs. ${data.data.actual.ganancia_egreso.toLocaleString('es-PY')}`;
            rangoActual.innerText = `Rango: ${fecha}`;
            
            const tagE = data.data.tagE;
            const colorClass = tagE === '+' ? 'text-green-700 bg-green-200 rounded-xl px-1' : 'text-red-700 bg-red-200 rounded-xl px-1';
            
            porcentaje.className = `text-sm font-semibold ${colorClass}`;
            porcentaje.innerText = `${tagE} ${data.data.porcentaje_egreso}%`;

            gananciaAnterior.innerText = `Gs. ${data.data.pasado.ganancia_egreso.toLocaleString('es-PY')}`;
            diferencia.innerText = `Gs. ${data.data.diferencia_egreso.toLocaleString('es-PY')}`;
            rangoAnterior.innerText = `Rango: ${fechaPasada}`;

        } else {            
            gananciaActual.innerText = `Gs. ${data.data.actual.ganancia.toLocaleString('es-PY')}`;
            rangoActual.innerText = `Rango: ${fecha}`;
            
            const tag = data.data.tag;
            const colorClass = tag === '+' ? 'text-green-700 bg-green-200 rounded-xl px-1' : 'text-red-700 bg-red-200 rounded-xl px-1';

            porcentaje.className = `text-sm font-semibold ${colorClass}`;
            porcentaje.innerText = `${tag} ${data.data.porcentaje}%`;

            gananciaAnterior.innerText = `Gs. ${data.data.pasado.ganancia.toLocaleString('es-PY')}`;
            diferencia.innerText = `Gs. ${data.data.diferencia.toLocaleString('es-PY')}`;
            rangoAnterior.innerText = `Rango: ${fechaPasada}`;
        }

    } catch (err) {
        console.log(err)
        // showToast(`${err.error ?? 'error'}`, 'error');
    }
}

//gananacias('dia');
//---------------grafico de tendencias-----------------------
let TendenciasChart = null;
async function tendenciasChart(periodo = 7) {
    try {
        const res = await fetch(`http://localhost:8080/api/tendencias/${periodo}`);
        const data = await res.json();
        if (!res.ok) {
            throw data;
        }
        const ganancias = data.datos.map(item => item?.ganancia ?? 0);
        if (TendenciasChart) {
            TendenciasChart.destroy();
        }
        TendenciasChart = new Chart(document.getElementById('miniChart'), {
            type: 'line',
            data: {
                labels: data.labels,
                datasets: [{
                    label: 'Ganancia Diaria',
                    data: ganancias,
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

const tendenciaBtns = document.querySelectorAll('.tendencia-btn');
tendenciaBtns.forEach(btn => {
    btn.addEventListener('click', () => {
        tendenciaBtns.forEach(b => {
            b.classList.remove('bg-gray-50', 'shadow-lg');
            b.classList.add('bg-gray-300');
        });
        tendenciasChart(btn.dataset.tendencia);
        setTimeout(() => {
            btn.classList.remove('bg-gray-300');
            btn.classList.add('bg-gray-50', 'shadow-lg');
        }, 150)
    });
});


//-------------------------------grafico de egresos------------------------------------
let egresosChart = null;
async function egresoChart(periodo = 7) {
    try {
        const res = await fetch(`http://localhost:8080/api/egresos/${periodo}`)
        const data = await res.json();
        if (!res.ok) {
            throw data;
        }
        const bar = document.getElementById('egresosChart');

        const labels = data.labels;
        const egresos = labels.map(fecha => data.egresos[fecha].total);

        if (egresosChart) {
            egresosChart.destroy();
        }
        console.log(data)
        egresosChart = new Chart(bar, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Egresos',
                        data: egresos,
                        backgroundColor: 'rgba(245, 66, 66, 0.6)',
                        borderColor: 'rgba(245, 66, 66, 1)',
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
egresoChart();

const egesosBtns = document.querySelectorAll('.egreso-btn');
egesosBtns.forEach(btn => {
    btn.addEventListener('click', () => {
        egesosBtns.forEach(b => {
            b.classList.remove('bg-gray-50', 'shadow-lg');
            b.classList.add('bg-gray-300');
        });
        egresoChart(btn.dataset.egreso);
        setTimeout(() => {
            btn.classList.remove('bg-gray-300');
            btn.classList.add('bg-gray-50', 'shadow-lg');
        }, 150)
    });
});

//------------------------------grafico de conceptos de egresos------------------------
let ConceptoEgresos = null;
async function conceptoEgresosChart(periodo = 7) {
    try {
        const res = await fetch(`http://localhost:8080/api/egresos/concepto/${periodo}`);
        const data = await res.json();

        if (!res.ok) {
            throw data
        }

        const donut = document.getElementById('egresosConceptoChart');
        if (ConceptoEgresos) {
            ConceptoEgresos.destroy();
        }

        console.log(data)
        const labels = data.labels;
        const egresos = labels.map(fecha => data.egresos[fecha].total);
        ConceptoEgresos = new Chart(donut, {
            type: 'pie',
            data: {
                labels: data.labels,
                datasets: [
                    {
                        label: 'Pagos',
                        data: egresos,
                        backgroundColor: [
                            'rgba(8, 209, 49, 0.6)',
                            'rgba(35, 39, 235, 0.6)',
                            'rgba(255, 234, 0, 0.6)',
                            'rgba(255, 24, 0, 0.6)',
                            'rgba(180, 50, 10, 0.6)',
                            'rgba(25, 3, 10, 0.6)',
                            'rgba(85, 0, 150, 0.6)',
                        ],
                    },
                    // {
                    //     label: 'Ingresos',
                    //     data: [data.ingresos.efectivo, data.ingresos.transferencia, data.ingresos.mixto],
                    //     backgroundColor: [
                    //         'rgba(8, 209, 49, 0.4)',
                    //         'rgba(35, 39, 235, 0.4)',
                    //         'rgba(255, 234, 0, 0.4)'
                    //     ],
                    // }
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
conceptoEgresosChart();

const conceptoBtns = document.querySelectorAll('.concepto-btn');
conceptoBtns.forEach(btn => {
    btn.addEventListener('click', () => {
        conceptoBtns.forEach(b => {
            b.classList.remove('bg-gray-50', 'shadow-lg');
            b.classList.add('bg-gray-300');
        });
        console.log(btn.dataset.concepto)
        conceptoEgresosChart(btn.dataset.concepto);
        setTimeout(() => {
            btn.classList.remove('bg-gray-300');
            btn.classList.add('bg-gray-50', 'shadow-lg');
        }, 150)
    });
});
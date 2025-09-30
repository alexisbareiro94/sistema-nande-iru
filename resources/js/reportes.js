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
        const res = await fetch(`http://127.0.0.1:80/api/pagos/${periodo}`);
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
        const res = await fetch(`http://127.0.0.1:80/api/ventas/${periodo}`)
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
        if(!bar){
            return;
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
        const res = await fetch(`http://127.0.0.1:80/api/tipo_venta/${periodo}`);
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
        const tenPeriodo = JSON.parse(sessionStorage.getItem('tenPeriodo')) || '7';     
        if (btn.dataset.regreso) {
            sessionStorage.setItem('regreso', JSON.stringify(btn.dataset.regreso))
            await gananacias(periodo, option, btn.dataset.regreso);
            tendenciasChart(tenPeriodo);
        } else {
            sessionStorage.removeItem('regreso');
            await gananacias(periodo, option, null);
            tendenciasChart(tenPeriodo);
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
    const porcentaje = document.getElementById('variacion-porcentaje');
    const diferencia = document.getElementById('variacion-valor');
    const rangoAnterior = document.getElementById('rango-anterior');
    const gananciaAnterior = document.getElementById('ganancia-anterior');
    const svgCont = document.getElementById('svg-cont-card');

    try {
        const res = await fetch(`http://127.0.0.1:80/api/utilidad/${periodo}/${option}`);
        const data = await res.json();
        if (!res.ok) {
            throw data;
        }

        const svgUp = `  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2.25 18 9 11.25l4.306 4.306a11.95 11.95 0 0 1 5.814-5.518l2.74-1.22m0 0-5.94-2.281m5.94 2.28-2.28 5.941" />
                    </svg>`;

        const svgDown = ` <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2.25 6 9 12.75l4.286-4.286a11.948 11.948 0 0 1 4.306 6.43l.776 2.898m0 0 3.182-5.511m-3.182 5.51-5.511-3.181" />
                    </svg>`;

        svgCont.innerHTML = '';

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
            const svgContClass = tagE === '+' ? 'text-green-500' : 'text-red-500';
            svgCont.classList = svgContClass;
            svgCont.innerHTML = tagE == '+' ? svgUp : svgDown;

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
            const svgContClass = tag === '+' ? 'text-green-500' : 'text-red-500';
            svgCont.classList = svgContClass;
            svgCont.innerHTML = tag == '+' ? svgUp : svgDown;

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

//---------------grafico de tendencias-----------------------
let TendenciasChart = null;
async function tendenciasChart(periodo = 7) {
    const regreso = JSON.parse(sessionStorage.getItem('regreso')) || '';    
    try {
        sessionStorage.setItem('tenPeriodo', JSON.stringify(periodo));        
        const res = await fetch(`http://127.0.0.1:80/api/tendencias/${periodo}`);
        const data = await res.json();
        if (!res.ok) {
            throw data;
        }
        
        if (TendenciasChart) {
            TendenciasChart.destroy();
        }
        let ganancias;
        if(regreso){
            ganancias = data.datos.map(item => item?.egresos > 0 ? item.ganacia_egresos : item.ganancia);
        }else{
            ganancias = data.datos.map(item => item?.ganancia ?? 0);
            
        }        
        const miniChart = document.getElementById('miniChart');
        if(!miniChart){
            return;
        }
        TendenciasChart = new Chart(miniChart, {
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
        sessionStorage.removeItem('tenPeriodo');
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
        const res = await fetch(`http://127.0.0.1:80/api/egresos/${periodo}`)
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
        if(!bar){
            return;
        } 
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
        const res = await fetch(`http://127.0.0.1:80/api/egresos/concepto/${periodo}`);
        const data = await res.json();

        if (!res.ok) {
            throw data
        }

        const donut = document.getElementById('egresosConceptoChart');
        if (ConceptoEgresos) {
            ConceptoEgresos.destroy();
        }        
        const labels = data.labels;
        const egresos = labels.map(fecha => data.egresos[fecha].total);
        if(!donut){
            return;
        }
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
        conceptoEgresosChart(btn.dataset.concepto);
        setTimeout(() => {
            btn.classList.remove('bg-gray-300');
            btn.classList.add('bg-gray-50', 'shadow-lg');
        }, 150)
    });
});
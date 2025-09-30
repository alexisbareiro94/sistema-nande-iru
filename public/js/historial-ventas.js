const modal = document.getElementById('modal-detalle-venta');
function abrirModalDetalles() {
    const btnsdetalleVentas = document.querySelectorAll('.detalle-venta');
    btnsdetalleVentas.forEach(btn => {
        btn.addEventListener('click', async () => {
            const codigo = btn.dataset.ventaid ?? btn.dataset.ventam;
            await detalleVentas(codigo);
            modal.classList.remove('hidden');
            setTimeout(() => {
                modal.classList.remove('opacity-0');
                modal.classList.add('opacity-100', 'flex');
            }, 5);
        })
    })
}

abrirModalDetalles();

function cerrarModalDetalle() {
    modal.classList.remove('opacity-100');
    modal.classList.add('opacity-0');

    setTimeout(() => {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }, 150);

}

document.getElementById('modal-detalle-venta').addEventListener('click', function (e) {
    if (e.target === this) {
        cerrarModal();
    }
});

async function detalleVentas(codigo) {
    try {
        const res = await fetch(`http://127.0.0.1:80/venta/${decodeURIComponent(codigo)}`, {
            method: 'GET',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
            }
        });
        const data = await res.json();
        if (!res.ok) {
            throw data;
        }

        setDataDetalleVenta(data);
    } catch (err) {
        console.log(err)
        showToast(`${err.error}`, 'error')
    }
}



function setDataDetalleVenta(data) {
    const fecha = document.getElementById('d-v-fecha');
    const estado = document.getElementById('d-v-estado');
    const mPago = document.getElementById('d-v-pago');
    const codigo = document.getElementById('d-v-codigo');
    const total = document.getElementById('d-v-total');
    const dvCajero = document.getElementById('dv-cajero');    
    dvCajero.innerText = `${data.venta.vendedor.name}`

    let metodoDePago = '';
    let estadoClass = data.venta.estado === 'completado' ? 'px-2 py-1 bg-green-100 text-green-800 rounded-full text-sm font-medium' :
        (data.venta.estado === 'cancelado' ? 'px-2 py-1 bg-red-100 text-red-800 rounded-full text-sm font-medium' :
            'px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full text-sm font-medium');

    //detalles de la venta
    estado.classList = '';
    const datafecha = new Date(data.venta.created_at);
    fechaFormat = datafecha.toLocaleString('es-PY', {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit',
        hour12: false
    }).replace(',', ' -');

    codigo.innerText = `Detalle de Venta #${data.venta.codigo}`
    fecha.innerText = fechaFormat
    estado.classList = estadoClass;
    estado.innerText = data.venta.estado

    if (data.productos != '') {
        if (data.venta.pagos.length === 2) {
            metodoDePago = 'mixto'
            document.getElementById('svg-mixto').classList.remove('hidden');
            setMetodosPagosMixto(data);

        } else {
            if (!document.getElementById('svg-mixto').classList.contains('hidden')) {
                document.getElementById('svg-mixto').classList.add('hidden');
            }
            metodoDePago = data.venta.pagos[0].metodo;
        }
        mPago.innerText = metodoDePago;

        if (data.venta.con_descuento) {
            document.getElementById('dv-descuento').classList.remove('hidden');
            document.getElementById('dv-subtotal').innerText = 'Gs. -' + data.venta.monto_descuento.toLocaleString('es-PY');

        }
        if (!data.venta.con_descuento) {
            if (!document.getElementById('dv-descuento').classList.contains('hidden')) {
                document.getElementById('dv-descuento').classList.add('hidden');
            }
        }
    }

    //datos del cliente
    setCliente(data);
    //productos
    setProductos(data);
    //total gral
    if (data.productos == '') {
        total.innerText = 'Gs ' + data.venta.monto.toLocaleString('es-PY');
    } else {
        total.innerText = 'Gs ' + data.venta.total.toLocaleString('es-PY');
    }
}

document.getElementById('svg-mixto').addEventListener('click', (e) => {
    document.getElementById('d-v-if-mixto').classList.toggle('hidden');
});

let clicks = 0;
document.addEventListener('click', () => {
    if (!document.getElementById('d-v-if-mixto').classList.contains('hidden')) {
        clicks++;
        if (clicks >= 2) {
            document.getElementById('d-v-if-mixto').classList.add('hidden');
            clicks = 0;
        }
    } else {
        return;
    }
});

function setMetodosPagosMixto(data) {
    const transf = document.getElementById('d-v-mixto-transf');
    const efectivo = document.getElementById('d-v-mixto-efectivo');
    const total = document.getElementById('d-v-total-mixto');

    if (!transf && !efectivo && !total) {
        return;
    }

    transf.innerText = `Gs. ${data.venta.pagos[1].monto.toLocaleString('es-PY')}`;
    efectivo.innerText = `Gs. ${data.venta.pagos[0].monto.toLocaleString('es-PY')}`;
    total.innerText = `Gs. ${data.venta.total.toLocaleString('es-PY')}`
}

function setCliente(data) {
    if (data.productos != '') {
        const razon = document.getElementById('d-v-razon');
        const rucCi = document.getElementById('d-v-ruc');

        if (!razon && !rucCi) {
            return;
        }

        razon.innerText = data.venta.cliente.razon_social;
        rucCi.innerText = data.venta.cliente.ruc_ci;
    } else {
        return;
    }
}

function setProductos(data) {
    if (!document.getElementById('d-v-bodyTable')) {
        return;
    }
    const bodyTabla = document.getElementById('d-v-bodyTable');
    bodyTabla.innerHTML = '';
    if (data.productos != '') {
        data.productos.forEach(producto => {
            const tipoClass = producto.tipo === 'servicio'
                ? 'bg-green-100 text-green-800 border border-green-300'
                : 'bg-blue-100 text-blue-800 border border-blue-300';
            const tr = document.createElement('tr');
            tr.innerHTML = `
            <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900">
            <span class="rounded-full px-1 py-1 text-xs ${tipoClass}" > ${producto.tipo.substring(0, 3)}</span>
            ${producto.nombre}
            </td>
            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
            ${producto.codigo ?? 'sin codigo'}
            </td>
            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
            ${producto.detalles[0].cantidad}
            </td>
            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
            ${producto.detalles[0].producto_con_descuento ? producto.detalles[0].precio_descuento.toLocaleString('es-PY') : producto.precio_venta.toLocaleString('es-PY')}
            </td>
            <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900">
            Gs. ${producto.detalles[0].producto_con_descuento ? (producto.detalles[0].precio_descuento * producto.detalles[0].cantidad).toLocaleString('es-PY') : (producto.precio_venta * producto.detalles[0].cantidad).toLocaleString('es-PY')}
            </td>
            `
            bodyTabla.appendChild(tr);
        })
    } else {

    }
}


if (document.getElementById('dv-buscar')) {
    document.getElementById('dv-buscar').addEventListener('click', () => {
        const desde = document.getElementById('dv-desde').value;
        const hasta = document.getElementById('dv-hasta').value;
        const estado = document.getElementById('dv-i-estado').value;
        const formaPago = document.getElementById('dv-forma-pago').value;
        const tipo = document.getElementById('dv-tipo').value;

        if (desde == '' && hasta == '' && estado == '' && formaPago == '' && tipo == '') {
            window.location.href = '/movimientos'
            return;
        }

        let datos = JSON.parse(sessionStorage.getItem('datos')) ?? {};
        document.getElementById('dv-borrar-filtros').classList.remove('hidden')
        datos = {
            desde: desde,
            hasta: hasta,
            estado: estado,
            formaPago: formaPago,
            tipo: tipo,
        }
        sessionStorage.setItem('datos', JSON.stringify(datos))
        buscar();
    });
}

window.addEventListener('DOMContentLoaded', () => {
    let datos = JSON.parse(sessionStorage.getItem('datos'));
    if (datos != null) {
        document.getElementById('dv-borrar-filtros').classList.remove('hidden')
    }
    if (sessionStorage.getItem('datos')) {
        sessionStorage.removeItem('datos')
        if (!document.getElementById('dv-borrar-filtros').classList.contains('hidden')) {
            document.getElementById('dv-borrar-filtros').classList.add('hidden');
        }
    }
})

if (document.getElementById('dv-borrar-filtros')) {
    document.getElementById('dv-borrar-filtros').addEventListener('click', (e) => {
        e.target.classList.add('hidden');
        sessionStorage.removeItem('datos')
        window.location.href = '/movimientos'
    });
}

async function buscar(orderBy = '', direction = '') {
    const datos = JSON.parse(sessionStorage.getItem('datos')) || {};
    const ingresoFiltro = document.getElementById('ingresos-filtro');
    const egresosFiltro = document.getElementById('egresos-filtro');
    const desde = datos.desde ?? '';
    const hasta = datos.hasta ?? '';
    const estado = datos.estado ?? '';
    const formaPago = datos.formaPago ?? '';
    const tipo = datos.tipo ?? '';
    const q = document.getElementById('dv-input-s').value;
    let paginacion = false;

    if (q === '' && desde == "" && hasta == "" && estado == "" && formaPago == "" && tipo == "") {
        if (!ingresoFiltro.classList.contains('hidden') || !egresosFiltro.classList.contains('hidden')) {
            ingresoFiltro.classList.add('hidden');
            egresosFiltro.classList.add('hidden');
        }
        paginacion = true;
    }
    try {
        const res = await fetch(`http://127.0.0.1:80/venta?q=${encodeURIComponent(q)}&desde=${encodeURIComponent(desde)}&hasta=${encodeURIComponent(hasta)}&estado=${encodeURIComponent(estado)}&formaPago=${encodeURIComponent(formaPago)}&tipo=${encodeURIComponent(tipo)}&paginacion=${encodeURIComponent(paginacion)}&orderBy=${encodeURIComponent(orderBy)}&direction=${encodeURIComponent(direction)}`, {
            method: 'GET',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
            }
        });
        const data = await res.json();
        if (!res.ok) {
            throw data;
        }
        console.log(data)
        recargarTablaHistorialVentas(data, paginacion);
    } catch (err) {
        console.log(err)
        showToast(`${err.error}`, 'error')
    }

}
let timerDv;
document.getElementById('dv-input-s').addEventListener('input', () => {
    clearTimeout(timerDv);
    timerDv = setTimeout(async () => {
        buscar();
    }, 500);
})

function recargarTablaHistorialVentas(data, paginacion) {
    const bodyTabla = document.getElementById('dv-body-tabla');
    const ingresoFiltro = document.getElementById('ingresos-filtro');
    const egresosFiltro = document.getElementById('egresos-filtro');
    const montoIngreso = document.getElementById('monto-ingresos-filtro');
    const montoEgreso = document.getElementById('monto-egresos-filtro');
    const svg = `

                                    <span class="cursor-help" title="Venta con descuento">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="m8.99 14.993 6-6m6 3.001c0 1.268-.63 2.39-1.593 3.069a3.746 3.746 0 0 1-1.043 3.296 3.745 3.745 0 0 1-3.296 1.043 3.745 3.745 0 0 1-3.068 1.593c-1.268 0-2.39-.63-3.068-1.593a3.745 3.745 0 0 1-3.296-1.043 3.746 3.746 0 0 1-1.043-3.297 3.746 3.746 0 0 1-1.593-3.068c0-1.268.63-2.39 1.593-3.068a3.746 3.746 0 0 1 1.043-3.297 3.745 3.745 0 0 1 3.296-1.042 3.745 3.745 0 0 1 3.068-1.594c1.268 0 2.39.63 3.068 1.593a3.745 3.745 0 0 1 3.296 1.043 3.746 3.746 0 0 1 1.043 3.297 3.746 3.746 0 0 1 1.593 3.068ZM9.74 9.743h.008v.007H9.74v-.007Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm4.125 4.5h.008v.008h-.008v-.008Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                                        </svg>
                                    </span>
    `;
    bodyTabla.innerText = ''
    if (data.ingresos_filtro != null || data.ingresos_filtro != undefined) {
        ingresoFiltro.classList.remove('hidden');
        montoIngreso.innerText = `Ingresos: Gs. ${data.ingresos_filtro.toLocaleString('es-PY')}`
    }
    if ((data.egresos_filtro != null || data.egresos_filtro != undefined) && data.egresos_filtro != 0) {
        egresosFiltro.classList.remove('hidden');
        montoEgreso.innerText = `Egresos: Gs. ${data.egresos_filtro.toLocaleString('es-PY')}`
    }
    data.ventas.forEach(venta => {
        if (venta.venta_id != null) {
            let estadoClass = '';
            const tr = document.createElement('tr');
            tr.classList = 'hover:bg-gray-50 transition-colors';
            venta.venta.estado === 'completado' ? estadoClass = 'bg-green-100 text-green-800' :
                (venta.venta.estado == 'cancelado' ? estadoClass = 'bg-red-100 text-red-800' : estadoClass = 'bg-yellow-100 text-yellow-800');

            let fechaC = new Date(venta.venta.created_at)

            fecha = fechaC.toLocaleString('es-PY', {
                day: '2-digit',
                month: '2-digit',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit',
                hour12: false
            }).replace(',', ' -');

            tr.innerHTML = `
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="venta-id px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 items-center">
                                        <div class="flex items-center gap-2 mb-1">
                                            <span class="bg-blue-200 px-2 py-0.5 text-xs font-semibold text-blue-800 rounded-xl">
                                                Venta
                                            </span>
                                            ${venta.venta.con_descuento ? svg : ''}                                            
                                        </div>
                                        <span class="" title="Codigo de venta">
                                            #${venta.venta.codigo}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        ${fecha}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 font-semibold">
                                        ${venta.venta.cliente.razon_social ?? venta.venta.cliente.name}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        ${venta.venta.cantidad_productos} productos
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        Gs. ${venta.venta.total.toLocaleString('es-PY')}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full ${estadoClass}">
                                            ${venta.venta.estado}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex space-x-2">
                                            <button id="btn-detalle-venta" data-ventaId="${venta.venta.codigo}"
                                                class="detalle-venta cursor-pointer text-blue-600 hover:text-blue-900" title="Ver detalles">
                                                <i class="fas fa-eye">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5">
                                                        <path d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                                                        <path fill-rule="evenodd"
                                                            d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 0 1 0-1.113ZM17.25 12a5.25 5.25 0 1 1-10.5 0 5.25 5.25 0 0 1 10.5 0Z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                </i>
                                            </button>
                                            <button class="text-green-600 cursor-pointer hover:text-green-900" title="Imprimir">
                                                <i class="fas fa-print">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                                        <path fill-rule="evenodd"
                                                            d="M7.875 1.5C6.839 1.5 6 2.34 6 3.375v2.99c-.426.053-.851.11-1.274.174-1.454.218-2.476 1.483-2.476 2.917v6.294a3 3 0 0 0 3 3h.27l-.155 1.705A1.875 1.875 0 0 0 7.232 22.5h9.536a1.875 1.875 0 0 0 1.867-2.045l-.155-1.705h.27a3 3 0 0 0 3-3V9.456c0-1.434-1.022-2.7-2.476-2.917A48.716 48.716 0 0 0 18 6.366V3.375c0-1.036-.84-1.875-1.875-1.875h-8.25ZM16.5 6.205v-2.83A.375.375 0 0 0 16.125 3h-8.25a.375.375 0 0 0-.375.375v2.83a49.353 49.353 0 0 1 9 0Zm-.217 8.265c.178.018.317.16.333.337l.526 5.784a.375.375 0 0 1-.374.409H7.232a.375.375 0 0 1-.374-.409l.526-5.784a.373.373 0 0 1 .333-.337 41.741 41.741 0 0 1 8.566 0Zm.967-3.97a.75.75 0 0 1 .75-.75h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75H18a.75.75 0 0 1-.75-.75V10.5ZM15 9.75a.75.75 0 0 0-.75.75v.008c0 .414.336.75.75.75h.008a.75.75 0 0 0 .75-.75V10.5a.75.75 0 0 0-.75-.75H15Z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                </i>
                                            </button>
                                            <button class="text-red-600 hover:text-red-900 cursor-pointer" title="Eliminar">
                                                <i class="fas fa-trash">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5">
                                                        <path fill-rule="evenodd"
                                                            d="M16.5 4.478v.227a48.816 48.816 0 0 1 3.878.512.75.75 0 1 1-.256 1.478l-.209-.035-1.005 13.07a3 3 0 0 1-2.991 2.77H8.084a3 3 0 0 1-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 0 1-.256-1.478A48.567 48.567 0 0 1 7.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 0 1 3.369 0c1.603.051 2.815 1.387 2.815 2.951Zm-6.136-1.452a51.196 51.196 0 0 1 3.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 0 0-6 0v-.113c0-.794.609-1.428 1.364-1.452Zm-.355 5.945a.75.75 0 1 0-1.5.058l.347 9a.75.75 0 1 0 1.499-.058l-.346-9Zm5.48.058a.75.75 0 1 0-1.498-.058l-.347 9a.75.75 0 0 0 1.5.058l.345-9Z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                </i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>

        `;
            bodyTabla.appendChild(tr);
        } else {
            const tr = document.createElement('tr');
            tr.classList = 'hover:bg-gray-50 transition-colors';
            let fechaC = new Date(venta.created_at)

            const tipoClass = venta.tipo === 'egreso' ? 'bg-red-200 text-red-800' : 'bg-green-200 text-green-800';
            const montoClass = venta.tipo === 'egreso' ? 'text-red-500' : 'text-gray-900';
            const menos = venta.tipo === 'egreso' ? '-' : '';

            fecha = fechaC.toLocaleString('es-PY', {
                day: '2-digit',
                month: '2-digit',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit',
                hour12: false
            }).replace(',', ' -');

            tr.innerHTML = `
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="venta-id px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 items-center">
                                        <div class="flex items-center gap-2 mb-1">
                                            <span class="px-2 py-0.5 text-xs font-semibold rounded-xl ${tipoClass} ">
                                                ${venta.tipo}
                                            </span>
                                            
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        ${fecha}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        <span class="bg-gray-200 text-gray-500 font-semibold px-2 py-0.5 rounded-xl italic" > Sin Cliente </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        ${venta.concepto}
                                    </td>
                                    
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium ${montoClass}">        
                                        ${menos}  Gs. ${venta.monto.toLocaleString('es-PY')}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex space-x-2">
                                            <button id="btn-detalle-movimiento" data-ventaM="${venta.id}"
                                                class="detalle-movimiento cursor-pointer text-blue-600 hover:text-blue-900" title="Ver detalles">
                                                <i class="fas fa-eye">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5">
                                                        <path d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                                                        <path fill-rule="evenodd"
                                                            d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 0 1 0-1.113ZM17.25 12a5.25 5.25 0 1 1-10.5 0 5.25 5.25 0 0 1 10.5 0Z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                </i>
                                            </button>
                                            <button class="text-green-600 cursor-pointer hover:text-green-900" title="Imprimir">
                                                <i class="fas fa-print">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                                        <path fill-rule="evenodd"
                                                            d="M7.875 1.5C6.839 1.5 6 2.34 6 3.375v2.99c-.426.053-.851.11-1.274.174-1.454.218-2.476 1.483-2.476 2.917v6.294a3 3 0 0 0 3 3h.27l-.155 1.705A1.875 1.875 0 0 0 7.232 22.5h9.536a1.875 1.875 0 0 0 1.867-2.045l-.155-1.705h.27a3 3 0 0 0 3-3V9.456c0-1.434-1.022-2.7-2.476-2.917A48.716 48.716 0 0 0 18 6.366V3.375c0-1.036-.84-1.875-1.875-1.875h-8.25ZM16.5 6.205v-2.83A.375.375 0 0 0 16.125 3h-8.25a.375.375 0 0 0-.375.375v2.83a49.353 49.353 0 0 1 9 0Zm-.217 8.265c.178.018.317.16.333.337l.526 5.784a.375.375 0 0 1-.374.409H7.232a.375.375 0 0 1-.374-.409l.526-5.784a.373.373 0 0 1 .333-.337 41.741 41.741 0 0 1 8.566 0Zm.967-3.97a.75.75 0 0 1 .75-.75h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75H18a.75.75 0 0 1-.75-.75V10.5ZM15 9.75a.75.75 0 0 0-.75.75v.008c0 .414.336.75.75.75h.008a.75.75 0 0 0 .75-.75V10.5a.75.75 0 0 0-.75-.75H15Z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                </i>
                                            </button>
                                            <button class="text-red-600 hover:text-red-900 cursor-pointer" title="Eliminar">
                                                <i class="fas fa-trash">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5">
                                                        <path fill-rule="evenodd"
                                                            d="M16.5 4.478v.227a48.816 48.816 0 0 1 3.878.512.75.75 0 1 1-.256 1.478l-.209-.035-1.005 13.07a3 3 0 0 1-2.991 2.77H8.084a3 3 0 0 1-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 0 1-.256-1.478A48.567 48.567 0 0 1 7.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 0 1 3.369 0c1.603.051 2.815 1.387 2.815 2.951Zm-6.136-1.452a51.196 51.196 0 0 1 3.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 0 0-6 0v-.113c0-.794.609-1.428 1.364-1.452Zm-.355 5.945a.75.75 0 1 0-1.5.058l.347 9a.75.75 0 1 0 1.499-.058l-.346-9Zm5.48.058a.75.75 0 1 0-1.498-.058l-.347 9a.75.75 0 0 0 1.5.058l.345-9Z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                </i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
        `;
            bodyTabla.appendChild(tr);
        }
    });
    const paginate = document.getElementById('paginacion')
    if (paginacion == false) {
        paginate.classList.add('hidden');
    } else {
        if (paginate.classList.contains('hidden')) {
            paginate.classList.remove('hidden');
        }
    }
    abrirmodalDmDetalles();
    abrirModalDetalles();
}

const trigger = document.getElementById('dropdown');
const exportMenu = document.getElementById('export-menu');
const iconFlecha = document.getElementById('icon-flecha');

trigger.addEventListener('click', (e) => {
    //e.stopPropagation(); 
    iconFlecha.classList.toggle('rotate-180');

    if (exportMenu.classList.contains('hidden')) {
        exportMenu.classList.remove('hidden');
        setTimeout(() => {
            exportMenu.classList.remove('opacity-0');
            exportMenu.classList.add('opacity-100');
        }, 10);
    } else {
        exportMenu.classList.add('hidden');
        setTimeout(() => {
            exportMenu.classList.remove('opacity-100');
            exportMenu.classList.add('opacity-0');
        }, 10);
    }
});

document.addEventListener('click', (e) => {
    if (!exportMenu.classList.contains('hidden') && !trigger.contains(e.target) && !exportMenu.contains(e.target)) {
        exportMenu.classList.add('hidden');
        exportMenu.classList.remove('opacity-100');
        exportMenu.classList.add('opacity-0');

        iconFlecha.classList.remove('rotate-180');
    }
});


function toastLoading(message = "Cargando...") {
    const container = document.getElementById('loading-container');

    const spinner = `
        <svg class="animate-spin w-6 h-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>`;

    const toast = document.createElement('div');
    toast.className = `bg-red-500 font-semibold text-white px-5 py-3 rounded-lg shadow-lg flex items-center space-x-2 opacity-0 transition-opacity duration-300`;
    toast.innerHTML = `<span>${spinner}</span><span>${message}</span>`;

    container.appendChild(toast);

    setTimeout(() => toast.classList.remove('opacity-0'), 10);

    setTimeout(() => {
        toast.classList.add('opacity-0');
        setTimeout(() => toast.remove(), 500);
    }, 5000);
}


document.getElementById('export-pdf').addEventListener('click', () => {
    toastLoading('Generando PDF. Esto puede tomar algunos minutos. No cierre esta ventana.');
});
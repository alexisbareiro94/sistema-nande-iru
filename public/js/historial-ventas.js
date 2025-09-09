const modal = document.getElementById('modal-detalle-venta');
const btnsdetalleVentas = document.querySelectorAll('.detalle-venta');

btnsdetalleVentas.forEach(btn => {
    btn.addEventListener('click', async () => {
        const codigo = btn.dataset.ventaid;

        await detalleVentas(codigo);

        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.classList.remove('opacity-0');
            modal.classList.add('opacity-100', 'flex');
        }, 5);
    })
})

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
        const res = await fetch(`http://localhost:8080/venta/${decodeURIComponent(codigo)}`, {
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

    if(data.venta.con_descuento){
        document.getElementById('dv-descuento').classList.remove('hidden');
        document.getElementById('dv-subtotal').innerText = 'Gs. -' + data.venta.monto_descuento.toLocaleString('es-PY');

    }
    if(!data.venta.con_descuento){
        if(!document.getElementById('dv-descuento').classList.contains('hidden')) {
            document.getElementById('dv-descuento').classList.add('hidden');
        }
    }

    //datos del cliente
    setCliente(data);
    //productos
    setProductos(data);
    total.innerText = 'Gs ' + data.venta.total.toLocaleString('es-PY');
}

document.getElementById('svg-mixto').addEventListener('click', (e) => {
    document.getElementById('d-v-if-mixto').classList.toggle('hidden');

});


function setMetodosPagosMixto(data) {
    const transf = document.getElementById('d-v-mixto-transf');
    const efectivo = document.getElementById('d-v-mixto-efectivo');
    const total = document.getElementById('d-v-total-mixto');

    transf.innerText = `Gs. ${data.venta.pagos[1].monto.toLocaleString('es-PY')}`;
    efectivo.innerText = `Gs. ${data.venta.pagos[0].monto.toLocaleString('es-PY')}`;
    total.innerText = `Gs. ${data.venta.total.toLocaleString('es-PY')}`
}

function setCliente(data) {
    const razon = document.getElementById('d-v-razon');
    const rucCi = document.getElementById('d-v-ruc');

    razon.innerText = data.venta.cliente.razon_social;
    rucCi.innerText = data.venta.cliente.ruc_ci;
}

function setProductos(data) {
    const bodyTabla = document.getElementById('d-v-bodyTable');
    //const productos = {};
    bodyTabla.innerHTML = '';

    console.log(data.productos)

    data.productos.forEach(producto => {
        const tr = document.createElement('tr');
        tr.innerHTML = `
                                <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900">
                                    ${producto.nombre}
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                                    ${producto.codigo ?? 'sin codigo'}
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                                    ${producto.detalles[0].cantidad}
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                                    ${producto.detalles[0].producto_con_descuento ? producto.detalles[0].precio_descuento.toLocaleString('es-PY') : producto.precio_venta.toLocaleString('es-PY') }
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900">
                                    Gs. ${producto.detalles[0].producto_con_descuento ? (producto.detalles[0].precio_descuento * producto.detalles[0].cantidad).toLocaleString('es-PY') : (producto.precio_venta * producto.detalles[0].cantidad).toLocaleString('es-PY') }
                                </td>
        `
        bodyTabla.appendChild(tr);
    })
}

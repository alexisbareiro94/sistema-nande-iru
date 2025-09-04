document.getElementById('procesar-venta').addEventListener('click', () => {
    const carrito = JSON.parse(sessionStorage.getItem('carrito')) ?? {};
    const ruc = document.getElementById('i-ruc-ci');
    const razon = document.getElementById('i-nombre-razon');

    if (Object.entries(carrito).length === 0) {
        showToast('No hay productos en el carrito', 'error');
        return;
    }
    if (ruc.value.trim() == '') {
        ruc.classList.remove('border-gray-300', 'focus:ring-yellow-400', 'focus:border-yellow-400')
        ruc.classList.add('border-red-500', 'ring-2', 'ring-red-500', 'focus:border-red-500', 'bg-red-100');
        ruc.placeholder = 'Campo Obligatorio';
    }
    if (razon.value.trim() == '') {
        razon.classList.remove('border-gray-300', 'focus:ring-yellow-400', 'focus:border-yellow-400')
        razon.classList.add('border-red-500', 'ring-2', 'ring-red-500', 'focus:border-red-500', 'bg-red-100');
        razon.placeholder = 'Campo Obligatorio';
    }
    if (razon.value.trim() != '' && ruc.value.trim() != '') {
        document.getElementById('modal-confirmar-venta').classList.remove('hidden')
        document.getElementById('razon-venta').innerHTML = razon.value.trim();
        document.getElementById('ruc-venta').innerHTML = ruc.value.trim();
        resumenCarrito();
    }
});

document.getElementById('confirmar-venta').addEventListener('click', async () => {    
    const mixtoEfectivo = document.getElementById('mixto-efectivo') ?? '';
    const mixtoTransf = document.getElementById('mixto-transf') ?? '';
    const montoRecibido = document.getElementById('i-monto-recibido') ?? '';    
    let formaPago = {};

    if (efectivo.checked == false && transf.checked == false && mixto.checked == false) {
        document.getElementById('no-radio').classList.remove('hidden');
        return;
    }

    if (montoRecibido != '' && mixtoEfectivo == '' && mixtoTransf == '') {
        if (montoRecibido.value == '') {
            montoRecibido.classList.remove('border-gray-300')
            montoRecibido.classList.add('border-red-500', 'bg-red-100', 'ring-2', 'ring-red-500')
            montoRecibido.placeholder = 'Ingresa el monto recibido';
            return;
        }
    }
    if (montoRecibido == '' && mixtoTransf != '' && mixtoEfectivo != '') {
        if (mixtoEfectivo.value == '') {
            mixtoEfectivo.classList.remove('border-gray-300')
            mixtoEfectivo.classList.add('border-red-500', 'bg-red-100', 'ring-2', 'ring-red-500')
            mixtoEfectivo.placeholder = 'Ingresa el monto recibido';

            if (mixtoTransf.value == '') {
                mixtoTransf.classList.remove('border-gray-300')
                mixtoTransf.classList.add('border-red-500', 'bg-red-100', 'ring-2', 'ring-red-500')
                mixtoTransf.placeholder = 'Ingresa el monto recibido';
                return;
            } else {
                return;
            }
        }
        if (mixtoTransf.value == '') {
            mixtoTransf.classList.remove('border-gray-300')
            mixtoTransf.classList.add('border-red-500', 'bg-red-100', 'ring-2', 'ring-red-500')
            mixtoTransf.placeholder = 'Ingresa el monto recibido';
            return;
        }
    }
    if (efectivo.checked) {
        formaPago = {
            'efectivo': montoRecibido.value.trim(),
        }
    } else if (transf.checked) {
        formaPago = {
            'transferencia': montoRecibido.value.trim(),
        }
    } else {
        formaPago = {
            'mixto': {
                'efectivo': mixtoEfectivo.value.trim(),
                'transferencia': mixtoTransf.value.trim(),
            }
        }
    }
    await confirmarVenta(formaPago);
    limpiarUI();    
});


function resumenCarrito() {
    const carrito = JSON.parse(sessionStorage.getItem('carrito')) || {};
    const totalResumen = JSON.parse(sessionStorage.getItem('totalCarrito')) || {};
    const bodyTableVenta = document.getElementById('body-tabla-venta');
    const footerTableVenta = document.getElementById('footer-tabla-venta');

    bodyTableVenta.innerHTML = '';
    footerTableVenta.innerHTML = '';
    Object.entries(carrito).forEach(([id, producto]) => {
        const tr = document.createElement('tr');
        tr.innerHTML = `
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap ">
                                    ${producto.nombre}
                                </th>
                                <td class="px-6 py-4">
                                    ${producto.cantidad}
                                </td>
                                <td class="px-6 py-4">
                                    ${producto.descuento ? producto.precio_descuento : producto.precio}
                                </td>
        `;
        bodyTableVenta.appendChild(tr)
    });

    const trF = document.createElement('tr');
    trF.classList.add('font-semibold', 'text-gray-900', 'bg-gray-200');
    trF.innerHTML = `
                                <th scope="row" class="px-6 py-3 text-base">Total</th>
                                <td class="px-6 py-3">${totalResumen.cantidadTotal}</td>
                                <td class="px-6 py-3">Gs. ${totalResumen.total}</td>
    `;
    footerTableVenta.appendChild(trF);
}

const mixto = document.getElementById('mixto');
const efectivoTransf = document.querySelectorAll('#efectivo, #transf');
const contMontoRecibido = document.getElementById('monto-recibido');

mixto.addEventListener('change', () => {
    contMontoRecibido.innerHTML = `
                <div class="flex">
                    <label for="mixto-efectivo" class="text-gray-800 font-semibold mt-1 pr-14">Efectivo Recibido:</label>
                    <input class="border border-gray-300 px-3 py-1 rounded-md" type="number" name="mixto-efectivo" id="mixto-efectivo">
                </div>
                <div class="flex ">
                    <label for="mixto-transf" class="text-gray-800 font-semibold mt-1 pr-2">Monto en Transferencia:</label>
                    <input class="border border-gray-300 px-3 py-1 rounded-md" type="number" name="mixto-transf" id="mixto-transf">
                </div>
    `
});

efectivoTransf.forEach(btn => {
    btn.addEventListener('change', () => {
        contMontoRecibido.innerHTML = `
                <div class="flex">
                    <label for="monto-recibido" class="text-gray-800 font-semibold mt-1 pr-12">Monto Recibido:</label>
                    <input class="border border-gray-300 px-3 py-1 rounded-md" type="number" name="monto-recibido" id="i-monto-recibido">
                </div>                
    `;
    })
})

async function confirmarVenta(formaPago) {
    try {
        carrito = JSON.parse(sessionStorage.getItem('carrito')) || {};
        total = JSON.parse(sessionStorage.getItem('totalCarrito')) || {};

        ventaData = new FormData();
        ventaData.append('carrito', JSON.stringify(carrito));
        ventaData.append('total', JSON.stringify(total));
        ventaData.append('forma_pago', JSON.stringify(formaPago));
        ventaData.append('ruc', document.getElementById('i-ruc-ci').value.trim());
        ventaData.append('razon', document.getElementById('i-nombre-razon').value.trim());

        const res = await fetch(`http://localhost:8080/api/venta`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
            },
            body: ventaData,
        });
        const data = await res.json();
        if (!res.ok) {
            throw data;
        }
        showToast('Venta realizado con éxito');

    } catch (err) {
        showToast(`${err.error}`, 'error');
    }

}

function limpiarUI(){
    const ruc = document.getElementById('i-ruc-ci');
    const razon = document.getElementById('i-nombre-razon');
    sessionStorage.clear();
    renderCarrito();
    document.getElementById('totalCarrito').innerHTML = ''
    document.getElementById('subTotalCarrito').innerHTML = ''
    document.getElementById('form-cliente-venta').reset();
    document.getElementById('modal-ventas').classList.add('hidden');
    document.getElementById('form-monto-recibido').reset();
    ruc.classList.remove('border-red-500', 'ring-2', 'ring-red-500', 'focus:border-red-500', 'bg-red-100');
    ruc.classList.add('border-gray-300', 'focus:ring-yellow-400', 'focus:border-yellow-400')
    ruc.placeholder = 'Ingrese RUC O CI';
    razon.classList.remove('border-red-500', 'ring-2', 'ring-red-500', 'focus:border-red-500', 'bg-red-100');
    razon.classList.add('border-gray-300', 'focus:ring-yellow-400', 'focus:border-yellow-400')
    razon.placeholder = 'Ingrese nombre o razon social';
    document.getElementById('modal-confirmar-venta').classList.add('hidden')
}

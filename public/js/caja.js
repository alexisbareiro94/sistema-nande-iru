const btnAbrirCaja = document.getElementById('btn-abrir-caja');
const modalAbrirCaja = document.getElementById('modalAbrirCaja')
const cerrarModalCaja = document.querySelectorAll('#cancelarModal, #closeModal')
const abrirCajaForm = document.getElementById('abrir-caja-form')

const modalVentas = document.getElementById('modal-ventas');
const btnCerrarModalVentas = document.getElementById('cerrar-modal-ventas');

if (btnAbrirCaja) {
    btnAbrirCaja.addEventListener('click', () => {
        modalAbrirCaja.classList.remove('hidden')
        document.getElementById('monto_inicial').focus();
    });
}
cerrarModalCaja.forEach(btn => {
    btn.addEventListener('click', () => {
        modalAbrirCaja.classList.add('hidden');
    })
});

document.getElementById('ir-a-ventas').addEventListener('click', () => {
    modalVentas.classList.remove('hidden');
    const carrito = JSON.parse(sessionStorage.getItem('carrito'));
    if (carrito == null) {
        document.getElementById('input-b-producto-ventas').focus();
    } else if (carrito != null) {
        document.getElementById('i-ruc-ci').focus();
    }
});


btnCerrarModalVentas.addEventListener('click', () => {
    modalVentas.classList.add('hidden');
});

document.getElementById('form-b-productos-ventas').addEventListener('submit', (e) => {
    e.preventDefault();
})

let timerVentas;
document.getElementById('input-b-producto-ventas').addEventListener('input', (e) => {
    clearTimeout(timerVentas);
    timerVentas = setTimeout(async () => {
        let query = e.target.value.trim();
        if (query.length == 0) {
            const tablaVentaProductos = document.getElementById('tabla-venta-productos');
            tablaVentaProductos.innerHTML = '';
        } else {
            try {
                const res = await fetch(`http://127.0.0.1:80/api/productos?q=${encodeURIComponent(query)}`, {
                    method: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                    }
                });
                const data = await res.json();
                if (!res.ok) {
                    throw data;
                }
                if (data.productos && Object.keys(data.productos).length > 0) {
                    await recargarTablaVentas(data);
                } else {
                    const tablaVentaProductos = document.getElementById('tabla-venta-productos');
                    tablaVentaProductos.innerHTML = `
                        <tr>
                            <td colspan="4" class="text-center py-4 text-gray-500">
                                No hay resultados
                            </td>
                        </tr>
                    `;
                }

            } catch (err) {
                showToast(`${err.messages}`, 'error');
            }
        }
    }, 300);
});

async function recargarTablaVentas(data) {
    const tablaVentaProductos = document.getElementById('tabla-venta-productos');
    tablaVentaProductos.innerHTML = '';

    data.productos.forEach(producto => {
        const row = document.createElement('tr');
        const stockClass = producto.tipo == 'servicio' ? 'text-gray-300 font-semibold' : producto.stock < producto.stock_minimo ? 'text-red-500 font-semibold' : 'text-green-500 font-semibold'

        row.classList.add('hover:bg-gray-50', 'transition-colors');

        row.innerHTML = `
                                <td class="px-5 py-3">
                                    <div class="flex items-center gap-3">
                                        <div class="bg-gray-100 p-2 rounded-lg">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 5v2m0 4v2m0 4v2M5 8a2 2 0 012-2h10a2 2 0 012 2v14a2 2 0 01-2 2H7a2 2 0 01-2-2V8z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="font-medium">${producto.nombre}</p>
                                            <p class="text-xs text-gray-500">Código: ${producto.codigo ?? 'sin codigo'}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-5 py-3 font-medium">Gs. ${producto.precio_venta.toLocaleString('es-PY')}</td>
                                <td class="px-5 py-3 ${stockClass}">${producto.tipo == 'servicio' ? 'servicio' : producto.stock}</td>
                                <td class="px-5 py-3 text-center">
                                    <button data-producto='${JSON.stringify(producto)}'
                                        class="productos  cursor-pointer bg-gray-100 hover:bg-gray-300 border broder-gray-700 text-gray-800 px-2 py-1 rounded-md flex items-center justify-center transition-all shadow-md hover:shadow-lg">
                                        <span class="font-semibold text-xs">
                                            ADD     
                                        </span>
                            
                                        <span class="">
                                        <svg class="w-6 h-6 text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                 <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.2" d="M5 4h1.5L9 16m0 0h8m-8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm-8.5-3h9.25L19 7h-1M8 7h-.688M13 5v4m-2-2h4"/>
                                            </svg>
                                        </span>
                                    </button>
                                </td>
                    `
        tablaVentaProductos.appendChild(row);
    });
}

function addToCart() {
    const tablaVentaProductos = document.getElementById('tabla-venta-productos');
    tablaVentaProductos.addEventListener('click', function (e) {
        const btn = e.target.closest('.productos');
        if (btn) {
            const producto = JSON.parse(btn.dataset.producto);
            let carrito = JSON.parse(sessionStorage.getItem('carrito')) || {};

            if (carrito[producto.id]) {
                carrito[producto.id].cantidad += 1;

            } else {
                carrito[producto.id] = {
                    nombre: producto.nombre,
                    codigo: producto.codigo,
                    precio: producto.precio_venta,
                    stock: producto.stock,
                    imagen: producto.imagen,
                    descuento: false,
                    precio_descuento: 0,
                    cantidad: 1
                };
            }

            sessionStorage.setItem('carrito', JSON.stringify(carrito));
            renderCarrito();
        }
    });
}
addToCart();
renderCarrito();

function renderCarrito() {
    const carrito = JSON.parse(sessionStorage.getItem('carrito')) || {};
    const carritoForm = document.getElementById('carrito-form');
    carritoForm.innerHTML = '';

    Object.entries(carrito).forEach(([id, producto]) => {
        const div = document.createElement('div');
        div.classList.add('flex-1')
        div.innerHTML = `
            <div id="carrito-container" class="bg-gray-50 p-2 flex justify-between items-start border-b border-gray-300">
                <div class="flex-1">
                    <p class="text-xs font-semibold">${producto.nombre}</p>
                    <p class="text-xs text-gray-500">Código: ${producto.codigo}</p>
                </div>
                <div id="btn-cont" class="flex items-center gap-0 ml-1">
                    <button data-action="dec" data-id="${id}" class="decaum w-5 h-5 rounded-md cursor-pointer bg-gray-200 text-gray-700 flex items-center justify-center hover:bg-gray-200 transition-colors">
                        <span>-</span>
                    </button>
                    <span class="w-5 text-center font-medium">${producto.cantidad}</span>
                    <button data-action="aum" data-id="${id}" class="decaum w-5 h-5 rounded-md cursor-pointer bg-gray-400 text-white flex items-center justify-center hover:bg-gray-600 transition-colors">
                        <span>+</span>
                    </button>
                </div>
                <div class="ml-3 font-medium flex-col gap-1">
                    Gs. <input data-id="${id}" class="input-precio max-w-25 border border-white hover:border-gray-300 focus:border-gray-200 px-2" type="text"
                        value="${producto.descuento ? (producto.precio_descuento * producto.cantidad).toLocaleString('es-PY') : (producto.precio * producto.cantidad).toLocaleString('es-PY')}">
                        ${producto.descuento ?
                `<div class="text-xs ml-2 -mt-1.5 text-red-600 font-normal">Gs. ${producto.precio.toLocaleString('es-PY')}</div>`
                : ''
            }
                </div>
            </div>
        `;
        carritoForm.appendChild(div);
        descuento();
        totalCarrito();
    });
}

function descuento() {
    let timerInPrecio;
    document.querySelectorAll('.input-precio').forEach(input => {
        input.addEventListener('input', () => {
            const nuevoPrecio = input.value;
            const id = input.dataset.id;

            clearTimeout(timerInPrecio);
            timerInPrecio = setTimeout(() => {
                carrito = JSON.parse(sessionStorage.getItem('carrito')) || {};
                carrito[id].descuento = true;
                carrito[id].precio_descuento = nuevoPrecio;

                if (nuevoPrecio == carrito[id].precio) {
                    carrito[id].descuento = false;
                    carrito[id].precio_descuento = 0;
                }
                sessionStorage.setItem('carrito', JSON.stringify(carrito))
                totalCarrito();
                renderCarrito();
            }, 1000)

        })
    })
}

document.getElementById('carrito-form').addEventListener('click', (e) => {
    e.preventDefault();
    if (e.target.closest('.decaum')) {
        const carrito = JSON.parse(sessionStorage.getItem('carrito')) || {};
        const btn = e.target.closest('.decaum');
        const action = btn.dataset.action;
        const id = btn.dataset.id;

        if (action === 'aum') {
            carrito[id].cantidad++;
        } else {
            carrito[id].cantidad--;
            if (carrito[id].cantidad <= 0) {
                delete carrito[id];
                let totalVenta = document.getElementById('totalCarrito');
                totalVenta.innerHTML = '';
                document.getElementById('subTotalCarrito').innerHTML = '';
            }
        }

        sessionStorage.setItem('carrito', JSON.stringify(carrito));
        renderCarrito();
    }
});

function totalCarrito() {
    let totalP = 0;
    let subTotal = 0;
    let cantidadTotal = 0;
    let totalVenta = document.getElementById('totalCarrito');
    const subtotalVenta = document.getElementById('subTotalCarrito');
    const carrito = JSON.parse(sessionStorage.getItem('carrito')) || {};

    Object.entries(carrito).forEach(([id, producto]) => {
        if (carrito[id].descuento && carrito[id].precio_descuento > 0) {
            totalP += producto.cantidad * producto.precio_descuento;
        } else {
            totalP += producto.cantidad * producto.precio;
        }
        cantidadTotal += producto.cantidad;
        subTotal += producto.cantidad * producto.precio;
    })

    totalCarritoSession = JSON.parse(sessionStorage.getItem('totalCarrito')) || {};
    totalCarritoSession = {
        total: totalP,
        subtotal: subTotal,
        cantidadTotal: cantidadTotal,
    };
    sessionStorage.setItem('totalCarrito', JSON.stringify(totalCarritoSession));

    subtotalVenta.innerHTML = `Gs. ${subTotal.toLocaleString('es-PY')}`;
    totalVenta.innerHTML = `Gs. ${totalP.toLocaleString('es-PY')}`;
}

const form = document.getElementById('form-cliente-venta');
const modalUsuarios = document.getElementById('modalUsuarios');

form.addEventListener('submit', async (e) => {
    e.preventDefault();
    const inputRucCi = document.getElementById('i-ruc-ci').value;
    const inputNombreRazon = document.getElementById('i-nombre-razon').value;
    const listaUsers = document.getElementById('listaUsuarios');
    listaUsers.innerHTML = '';
    const q = inputRucCi ?? inputNombreRazon;
    if (q.length <= 0) {
        return;
    }
    try {
        const res = await fetch(`http://127.0.0.1:80/api/users?q=${encodeURIComponent(q)}`, {
            method: 'GET',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
            }
        });

        const data = await res.json();
        if (!res.ok) {
            throw data;
        }
        if (data.users && Object.keys(data.users).length > 0) {
            data.users.forEach(user => {
                const li = document.createElement('li');
                li.classList = 'clientes hover:bg-gray-100 px-2 py-2 cursor-pointer bg-gray-200 rounded-md';
                li.dataset.razon = user.razon_social;
                li.dataset.ruc = user.ruc_ci;
                li.innerHTML = `
                        <p> <strong> Nombre:</strong> ${user.razon_social}</p>
                        <p> <strong> RUC/CI:</strong> ${user.ruc_ci}</p>
                `;
                listaUsers.appendChild(li);
                selectUser();
            });
        } else {
            listaUsers.innerHTML = `
            <div class="items-center justify-center text-center">
                <p class="text-center text-gray-400">No hay registro</p>
                <br>
            </div>
            `;
        }

    } catch (err) {
        showToast(`${err.error}`, 'error');
    }
    modalUsuarios.classList.remove('hidden')
});

function selectUser() {
    const listaUsers = document.getElementById('listaUsuarios');

    const inputRazonSocial = document.getElementById('i-nombre-razon');
    const inputRucCi = document.getElementById('i-ruc-ci');

    listaUsers.addEventListener('click', (e) => {
        const btn = e.target.closest('.clientes');
        if (btn) {
            const razon = btn.dataset.razon;
            const ruc = btn.dataset.ruc;

            inputRazonSocial.value = razon;
            inputRucCi.value = ruc;

            document.getElementById('modalUsuarios').classList.add('hidden');
        }
    });
}

const formAddCliente = document.getElementById('form-add-cliente');

formAddCliente.addEventListener('submit', async (e) => {
    e.preventDefault();
    const listaUsers = document.getElementById('listaUsuarios');
    const addCliente = new FormData();
    addCliente.append('razon_social', document.getElementById('razon_social').value.trim());
    addCliente.append('ruc_ci', document.getElementById('ruc_ci').value.trim())
    addCliente.append('email', document.getElementById('correo-c').value.trim());
    addCliente.append('telefono', document.getElementById('telefono-c').value.trim());

    try {
        const res = await fetch(`http://127.0.0.1:80/api/users`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
            },
            body: addCliente,
        });

        const data = await res.json();

        if (!res.ok) {
            throw data;
        }
        console.log(data)
        const inputRazonSocial = document.getElementById('i-nombre-razon');
        const inputRucCi = document.getElementById('i-ruc-ci');
        const razon = data.cliente.razon_social;
        const ruc = data.cliente.ruc_ci;

        inputRazonSocial.value = razon;
        inputRucCi.value = ruc;

        document.getElementById('modalUsuarios').classList.add('hidden');
        document.getElementById('modal-add-cliente').classList.add('hidden');

        showToast('Cliente Agregado con éxito', 'success');
    } catch (err) {
        console.log(err)
        showToast(`${err.error}`, 'error');
    }
})

window.addEventListener('DOMContentLoaded', async () => {
    await recargarSaldo();
});

async function recargarSaldo(flag = true) {
    const saldo = document.getElementById('saldo-caja');
    if (!saldo) {
        return;
    }
    try {
        const res = await fetch(`http://127.0.0.1:80/api/movimiento/total`, {
            method: 'GET',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
            },
        });
        const data = await res.json();
        if (!res.ok) {
            throw data;
        }
        if (flag === true) {
            saldo.innerText = `${data.total.toLocaleString('es-PY')} GS.`;
        }
        return data;
    } catch (err) {
        showToast(`${err.error}`, 'error')
    }
}

if (document.getElementById('btn-movimiento')) {
    document.getElementById('btn-movimiento').addEventListener('click', () => {
        document.getElementById('modal-movimiento-caja').classList.remove('hidden');
    });
}

if (document.getElementsByName('tipo-movimiento')) {
    document.getElementsByName('tipo-movimiento').forEach(btn => {
        const salarioCont = document.getElementById('salario-cont');
        const conceptomm = document.getElementById('concepto-mm');
        btn.addEventListener('click', () => {
            if (btn.value == 'salario') {
                salarioCont.classList.remove('hidden');
                conceptomm.value = 'Pago de salario'
                conceptomm.disabled = true;
            } else {
                if (!salarioCont.classList.contains('hidden')) {
                    salarioCont.classList.add('hidden');
                }
                conceptomm.value = ''
                conceptomm.disabled = false;
            }
        });
    });
}

const select = document.getElementById('personales');
let personal = '';

select.addEventListener('change', () => {
    personal = select.value;
});

document.getElementById('confirmar-movimiento').addEventListener('click', async (e) => {
    e.preventDefault();
    let errores = '';
    let tipoSelcted;
    const form = document.getElementById('movimiento-form');
    const tipos = document.getElementsByName('tipo-movimiento');
    const concepto = document.getElementById('concepto-mm');
    const monto = document.getElementById('monto-mm');

    tipos.forEach(tipo => {
        if (tipo.checked) {
            tipoSelcted = tipo.value;
        }
    })
    tipoSelcted == 'salario' ? tipoSelcted = 'egreso' : '';


    if (tipoSelcted == undefined) {
        showToast('Debes Seleccionar un tipo de movimiento', 'error');
        errores = '1'
    }
    if (concepto.value == '') {
        showToast('Debes Ingresar un concepto', 'error');
        errores = '2';
    }
    if (monto.value == '') {
        showToast('Debes Ingresar un monto', 'error');
        errores = '3';
    }
    if (errores != '') {
        return;
    }
    try {
        const formData = new FormData();
        formData.append('tipo', tipoSelcted);
        formData.append('concepto', concepto.value);
        formData.append('monto', monto.value);
        formData.append('personal_id', personal);

        const res = await fetch('http://127.0.0.1:80/api/movimiento', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
            },
            body: formData,
        });
        const data = await res.json();
        if (!res.ok) {
            throw data
        }
        console.log(data)
        personal = '';
        form.reset();
        document.getElementById('modal-movimiento-caja').classList.add('hidden');
        document.getElementById('datos-personal').classList.add('hidden');
        limpiarUI();
        showToast('Movimiento registrado');
    } catch (err) {
        showToast(`${err.error}`, 'error')
    }
});

//cierre de caja
if (document.getElementById('btn-cerrar-caja')) {
    document.getElementById('btn-cerrar-caja').addEventListener('click', async () => {
        const modalCierreCaja = document.getElementById('modalCierreCaja');
        modalCierreCaja.classList.remove('hidden')
        await recargarCierreCaja();
    });
}

async function recargarCierreCaja() {
    const nombreCC = document.getElementById('nombre-cc');
    const fechaCC = document.getElementById('fecha-cc');
    const montoInicialCC = document.getElementById('monto-inicial-cc')
    const ingresos = document.getElementById('ingresos-cc');
    const egresos = document.getElementById('egresos-cc');
    const saldoEsperado = document.getElementById('saldo-esperado');

    try {
        const res = await fetch('http://127.0.0.1:80/api/movimiento/total', {
            method: 'GET',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
            }
        });
        const data = await res.json();
        if (!res.ok) {
            throw data;
        }

        fechaA = new Date(data.caja.created_at);
        fechaFormateadaA = fechaA.toLocaleString('es-PY', {
            day: '2-digit',
            month: '2-digit',
            year: 'numeric',
            hour: '2-digit',
            minute: '2-digit',
            hour12: false
        }).replace(',', ' -');

        nombreCC.innerText = `${data.caja.user.name}`
        fechaCC.innerText = `${fechaFormateadaA}`
        montoInicialCC.innerText = `${data.caja.monto_inicial.toLocaleString('es-PY')} Gs.`
        ingresos.innerText = `${data.ingreso.toLocaleString('es-PY')} GS.`
        egresos.innerText = `${data.egreso.toLocaleString('es-PY')} GS.`
        saldoEsperado.innerText = `${(data.ingreso - data.egreso).toLocaleString('es-PY')} Gs.`
    } catch (err) {
        showToast(`${err.error}`, 'error')
    }
}

let timerCC;
document.getElementById('montoContado').addEventListener('input', async (e) => {
    const data = await recargarSaldo(false);
    const montoContado = document.getElementById('montoContado').value
    const diferencia = document.getElementById('diferencia');
    const saldoEsperado = data.ingreso - data.egreso;

    e.preventDefault();
    clearTimeout(timerCC)
    if (montoContado == '') {
        diferencia.innerText = '0 GS.'
        return;
    }
    timerCC = setTimeout(() => {
        diferencia.innerText = (montoContado - saldoEsperado).toLocaleString('es-PY') + ' GS.';
    }, 800)
})


document.getElementById('confirmar-cierre').addEventListener('click', async () => {
    const data = await recargarSaldo(false);
    const montoContado = document.getElementById('montoContado').value
    const observaciones = document.getElementById('observaciones').value;
    const saldoEsperado = data.ingreso - data.egreso;
    const diferencia = montoContado - saldoEsperado
    const egreso = data.egreso;

    if (montoContado == '') {
        showToast('Debes ingresar el monto contado', 'error')
        return
    }

    const formData = new FormData();
    formData.append('monto_cierre', montoContado);
    formData.append('saldo_esperado', saldoEsperado);
    formData.append('diferencia', diferencia);
    formData.append('observaciones', observaciones);
    formData.append('egreso', egreso);

    try {
        const res = await fetch('http://127.0.0.1:80/caja', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
            },
            body: formData,
        });

        const data = await res.json();
        if (!res.ok) {
            throw data;
        }
        document.getElementById('modalCierreCaja').classList.add('hidden');
        showToast('Caja Cerrada Correctamente');
        limpiarUI();
        document.getElementById('modal-carga').classList.remove('hidden');
        setTimeout(() => {
            document.getElementById('modal-carga').classList.add('hidden');
            window.location.href = '/caja';
        }, 900);
    } catch (err) {
        console.log(err)
        showToast(`${err.error}`, 'error')
    }
});

const selectPersonal = document.getElementById('personales');

selectPersonal.addEventListener('change', async (e) => {
    const datosPersonal = document.getElementById('datos-personal');

    try {
        const res = await fetch(`http://127.0.0.1:80/api/user/${e.target.value}`);
        const data = await res.json();
        if (!res.ok) {
            throw data;
        }
        let fecha = '';
        let fechaFormateada = '';
        if (data.data.user) {
            fecha = new Date(data.data.created_at);
            fechaFormateada = fecha.toLocaleString('es-PY', {
                day: '2-digit',
                month: '2-digit',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit',
                hour12: false
            }).replace(',', ' -');
        }

        const nombre = data.data.name ?? data.data.user.name;
        const salario = data.data.salario ?? data.data.user.salario;
        const restante = data.data.restante ?? data.data.salario;
        datosPersonal.classList.remove('hidden');
        datosPersonal.innerHTML = `
                        <p class="font-medium">${nombre}</p>
                        <p class="text-sm"><span class="data-personal font-semibold">Salario:</span> Gs. ${salario.toLocaleString('es-PY')}</p>
                        <p class="text-sm"><span class="data-personal font-semibold">Restante:</span> Gs. ${restante.toLocaleString('es-PY')}</p>
                        <p class="text-sm"><span class="data-personal font-semibold">Adelanto:</span> ${fechaFormateada}</p>`;
    } catch (err) {
        console.log(err)
    }
});

if (document.getElementById('max-cajas-form')) {
    document.getElementById('max-cajas-form').addEventListener('submit', async (e) => {
        e.preventDefault();
        const valor = document.getElementById('valor').value;
        const id = document.getElementById('cong-id').value;

        try {
            const formData = new FormData();
            formData.append('valor', valor);
            const res = await fetch(`http://127.0.0.1:80/api/conf/${id}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: formData
            });
            const data = await res.json();
            if (!res.ok) {
                throw data
            }
            console.log(data)
            showToast('Cantidad máxima de cajas cambiado');
        } catch (err) {
            console.log(err)
        }
    })


}
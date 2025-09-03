const btnAbrirCaja = document.getElementById('btn-abrir-caja');
const modalAbrirCaja = document.getElementById('modalAbrirCaja')
const cerrarModalCaja = document.querySelectorAll('#cancelarModal, #closeModal')
const abrirCajaForm = document.getElementById('abrir-caja-form')

const modalVentas = document.getElementById('modal-ventas');
const btnCerrarModalVentas = document.getElementById('cerrar-modal-ventas');
//const btnAbrirModalVentas = document.getElementById('ir-a-ventas');

if (btnAbrirCaja) {
    btnAbrirCaja.addEventListener('click', () => {
        modalAbrirCaja.classList.remove('hidden')
    });
}
cerrarModalCaja.forEach(btn => {
    btn.addEventListener('click', () => {
        modalAbrirCaja.classList.add('hidden');
    })
});

document.getElementById('ir-a-ventas').addEventListener('click', () => {    
    modalVentas.classList.remove('hidden');
});


btnCerrarModalVentas.addEventListener('click', () => {
    modalVentas.classList.add('hidden');
});

let timerVentas;
document.getElementById('input-b-producto-ventas').addEventListener('input', function () {
    clearTimeout(timerVentas);
    timerVentas = setTimeout(async () => {
        let query = this.value.trim();
        if (query.length == 0) {
            const tablaVentaProductos = document.getElementById('tabla-venta-productos');
            tablaVentaProductos.innerHTML = '';
        } else {
            try {
                const res = await fetch(`http://localhost:8080/api/productos?q=${encodeURIComponent(query)}`, {
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
                showToast(`${err.messages}`,'error');
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

        row.classList.add('hover:bg-yellow-50', 'transition-colors');

        row.innerHTML = `
                                <td class="px-5 py-3">
                                    <div class="flex items-center gap-3">
                                        <div class="bg-yellow-100 p-2 rounded-lg">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-600"
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
                                <td class="px-5 py-3 font-medium">Gs. ${producto.precio_venta}</td>                                
                                <td class="px-5 py-3 ${stockClass}">${producto.tipo == 'servicio' ? 'servicio' : producto.stock}</td>
                                <td class="px-5 py-3 text-center">
                                    <button data-producto='${JSON.stringify(producto)}'
                                        class="productos cursor-pointer bg-yellow-500 hover:bg-yellow-600 text-white w-9 h-9 rounded-full flex items-center justify-center transition-all shadow-md hover:shadow-lg">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                        </svg>
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
                    <button data-action="dec" data-id="${id}" class="decaum w-5 h-5 rounded-md bg-yellow-100 text-yellow-700 flex items-center justify-center hover:bg-yellow-200 transition-colors">
                        <span>-</span>
                    </button>
                    <span class="w-5 text-center font-medium">${producto.cantidad}</span>
                    <button data-action="aum" data-id="${id}" class="decaum w-5 h-5 rounded-md bg-yellow-500 text-white flex items-center justify-center hover:bg-yellow-600 transition-colors">
                        <span>+</span>
                    </button>
                </div>  
                <div class="ml-3 font-medium flex-col gap-1">
                    Gs. <input data-id="${id}" class="input-precio max-w-24 border border-none hover:border-gray-300 focus:border-gray-200 px-2" type="number"
                        value="${(producto.descuento ? producto.precio_descuento * producto.cantidad : producto.precio * producto.cantidad ).toLocaleString('es-PY')}">                                                            
                        ${producto.descuento ? 
                            `<div class="text-xs ml-2 mt-1 text-red-600 font-normal">Gs. ${producto.precio}</div>`
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

function descuento(){
    let timerInPrecio;
    document.querySelectorAll('.input-precio').forEach(input => {
        input.addEventListener('input', ()=>{        
            const nuevoPrecio = input.value;            
            const id = input.dataset.id;

            clearTimeout(timerInPrecio);
            timerInPrecio = setTimeout(()=>{
                carrito = JSON.parse(sessionStorage.getItem('carrito')) || {};                
                carrito[id].descuento = true;
                carrito[id].precio_descuento = nuevoPrecio;

                if(nuevoPrecio == carrito[id].precio){
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
        
        if(action == 'aum'){            
            carrito[id].cantidad++;            
        }else{            
            carrito[id].cantidad--;
            if(carrito[id].cantidad <= 0){
                delete carrito[id];  
                let totalVenta = document.getElementById('totalCarrito');                          
                totalVenta.innerHTML = '';
            }
        }        

        sessionStorage.setItem('carrito', JSON.stringify(carrito));        
        renderCarrito();
    }
});

function totalCarrito(){    
    let totalP = 0;
    let subTotal = 0;
    let cantidadTotal = 0;
    let totalVenta = document.getElementById('totalCarrito');
    const subtotalVenta = document.getElementById('subTotalCarrito');
    const carrito = JSON.parse(sessionStorage.getItem('carrito')) || {};
        
    Object.entries(carrito).forEach(([id, producto]) => {
        if(carrito[id].descuento && carrito[id].precio_descuento > 0){
            totalP += producto.cantidad * producto.precio_descuento;
        }else{
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
    if(q.length <= 0){
        return;
    }
    try {
        const res = await fetch(`http://localhost:8080/api/users?q=${encodeURIComponent(q)}`, {
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
            data.users.forEach(async user => {
                const li = document.createElement('li');
                li.classList.add('clientes', 'hover:bg-amarillo/20', 'px-2', 'py-2', 'cursor-pointer');
                li.dataset.razon = user.razon_social;
                li.dataset.ruc = user.ruc_ci;
                li.innerHTML = `                    
                        <p> <strong> Nombre:</strong> ${user.razon_social}</p>                
                        <p> <strong> RUC/CI:</strong> ${user.ruc_ci}</p>                    
                `;
                listaUsers.appendChild(li);
                await selectUser();
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

async function selectUser() {
    const listaUsers = document.getElementById('listaUsuarios');

    const inputRazonSocial = document.getElementById('i-nombre-razon');
    const inputRucCi = document.getElementById('i-ruc-ci');

    listaUsers.addEventListener('click', async (e) => {
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
    //document.getElementById('modalUsuarios').classList.add('hidden');
    const addCliente = new FormData();
    addCliente.append('name', document.getElementById('name').value.trim());
    addCliente.append('surname', document.getElementById('surname').value.trim());
    addCliente.append('razon_social', document.getElementById('razon_social').value.trim());
    addCliente.append('ruc_ci', document.getElementById('ruc_ci').value.trim())

    try {
        const res = await fetch(`http://localhost:8080/api/users`, {
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

        const inputRazonSocial = document.getElementById('i-nombre-razon');
        const inputRucCi = document.getElementById('i-ruc-ci');
        const razon = data.cliente.razon_social;
        const ruc = data.cliente.ruc_ci;

        inputRazonSocial.value = razon;
        inputRucCi.value = ruc;

        document.getElementById('modalUsuarios').classList.add('hidden');        
        listaUsers.classList.add('hidden');
        document.getElementById('modal-add-cliente').classList.add('hidden');

        showToast('Cliente Agregado con éxito', 'success');
    } catch (err) {
        console.log(err)
        showToast(`${err.error}`, 'error');
    }
})
//form-add-cliente
//modal-add-cliente
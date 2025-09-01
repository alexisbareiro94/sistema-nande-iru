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
    console.log('message')
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
                showToast('error', `${err.messages}`);
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
                                    <button data-producto="${producto.id}"
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
            console.log(btn.dataset.producto);

        }
    });
}
addToCart();

const form = document.getElementById('form-cliente-venta');
const modalUsuarios = document.getElementById('modalUsuarios');

form.addEventListener('submit', async (e) => {
    e.preventDefault();
    const inputRucCi = document.getElementById('i-ruc-ci').value;
    const inputNombreRazon = document.getElementById('i-nombre-razon').value;
    const listaUsers = document.getElementById('listaUsuarios');
    listaUsers.innerHTML = '';
    const q = inputRucCi ?? inputNombreRazon;
    try{
        const res = await fetch(`http://localhost:8080/api/users?q=${encodeURIComponent(q)}`,{
            method: 'GET',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
            }            
        });

        const data = await res.json();
        if(!res.ok){
            throw data;
        }
        
        if(data.users && Object.keys(data.users).length > 0){
            console.log(data)
        }else{
            listaUsers.innerHTML = `
            <div class="items-center justify-center text-center">
                <p class="text-center text-gray-400">No hay registro</p>
                <br>
                <button id="registrar-cliente" class="border border-yellow-200 bg-amarillo px-4 py-2 rounded-md font-semibold">
                    Registrar Cliente
                </button>
            </div>
            `;
            document.getElementById('registrar-cliente').addEventListener('click', ()=>{
                document.getElementById('modal-add-cliente').classList.remove('hidden')      
            })
        }   

    }catch(err){
        console.log(err)
        showToast('error', `${err.error}`)
    }
    modalUsuarios.classList.remove('hidden')
});

const formAddCliente = document.getElementById('form-add-cliente');

formAddCliente.addEventListener('submit', async (e) => {
    e.preventDefault();
    const addCliente = new FormData();
    addCliente.append('name', document.getElementById('name').value.trim());
    addCliente.append('surname',document.getElementById('surname').value.trim());
    addCliente.append('razon_social', document.getElementById('razon_social').value.trim());
    addCliente.append('ruc_ci', document.getElementById('ruc_ci').value.trim())

    try{

    }catch(err){
        showToast('error', `${err.error}`);
    }
})
//form-add-cliente
//modal-add-cliente
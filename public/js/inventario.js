const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

let timer;
document.getElementById("i-s-inventario").addEventListener('input', (e) => {
    clearTimeout(timer);
    timer = setTimeout(() => {
        let query = document.getElementById("i-s-inventario").value.trim();
        let filtro = document.getElementById("filtro").value;
        let btnCerrarInv = document.getElementById('btn-cerrar-inv');
        if (query.length >= 1) {
            btnCerrarInv.classList.remove('hidden');
            btnCerrarInv.addEventListener('click', (e) => {
                e.preventDefault();
                document.getElementById("i-s-inventario").value = '';
                btnCerrarInv.classList.add('hidden');
                searchInventario(query = "", filtro = "");
            });
        }
        searchInventario(query, filtro, '');
    }, 300);
});

async function searchInventario(query, filtro, filter = '') {
    await fetch(`http://localhost:8080/api/productos?q=${encodeURIComponent(query)}&filtro=${encodeURIComponent(filtro)}&filter=${encodeURIComponent(filter)}`, {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
        },
    })
        .then(async res => await res.json())
        .then(data => {
            console.log(data);
            const bodytableInv = document.getElementById('body-table-inv');
            bodytableInv.innerHTML = '';

            data.productos.forEach(producto => {
                const row = document.createElement('tr');
                row.className = "hover:bg-gray-50 transition-colors";
                const marcaNombre = producto.marca?.nombre ?? '';

                const precioFormateado = new Intl.NumberFormat('es-PY', {
                    minimumFractionDigits: 0
                }).format(producto.precio_venta);

                let stockClass = '';
                let stockContent = '';
                let stockTag = '';

                if (producto.tipo === 'servicio') {
                    stockClass = 'text-gray-400 italic';
                    stockContent = 'Servicio';
                } else {
                    if (producto.stock === 0) {
                        stockClass = 'font-bold bg-red-200 text-red-700';
                        stockContent = producto.stock;
                        stockTag = `<span class="ml-2 text-xs text-red-700">sin stock</span>`;
                    } else if (producto.stock_minimo >= producto.stock && producto.stock >= 1) {
                        stockClass = 'text-orange-600 font-bold bg-orange-100';
                        stockContent = producto.stock;
                        stockTag = `<span class="ml-2 text-xs text-red-700">stock min.</span>`;
                    } else {
                        stockClass = '';
                        stockContent = producto.stock;
                    }
                }
                const distribuidorNombre = producto.tipo === 'servicio'
                    ? 'Servicio'
                    : (producto.distribuidor?.nombre ?? '');

                const distribuidorClass = producto.tipo === 'servicio'
                    ? 'text-gray-400 italic'
                    : '';

                row.innerHTML = `
                        <td class="pl-3 py-3 text-sm">
                            <p class="font-semibold">${producto.nombre}</p>
                            <p class="text-gray-500 text-xs">${marcaNombre}</p>
                        </td>
                        <td class="px-2 py-3 text-sm">${producto.codigo ?? ""}</td>
                        <td class="pl-3 py-3 text-sm font-medium">
                            GS. ${precioFormateado}
                        </td>
                        <td class="pl-3 py-3 text-sm ${stockClass}">
                            <span class="${producto.tipo === 'servicio' ? 'font-semibold rounded-full text-green-400 text-center bg-green-100 px-2 py-1' : ''}">
                                ${stockContent}
                            </span>
                            ${stockTag}
                        </td>
                        <td class="pl-3 py-3 text-sm ${distribuidorClass}">
                            ${distribuidorNombre}
                        </td>
                        <td class="pl-3 py-3 text-sm flex items-center space-x-3">
                            <a href="/edit/${producto.id}/producto"
                                class="edit-product text-blue-600 hover:text-blue-800 transition-colors"
                                title="Editar producto">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                </svg>
                            </a>
                            <button data-producto="${producto.id}"
                                class="delete-producto text-red-600 hover:text-red-800 transition-colors"
                                title="Eliminar producto">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                    </svg>
                            </button>
                        </td>
                    `;

                bodytableInv.appendChild(row);
            });

            // Re-inicializar eventos si es necesario
            deleteP();
        })
        .catch(err => console.error('error al cargar los datos', err));
}


//borrar producto
function deleteP() {
    const deleteCont = document.getElementById("delete-container");
    const cancelarModal = document.getElementById("cancelar-d");
    const bodyTableInv = document.getElementById("body-table-inv");

    // Solo agrega el listener una vez
    if (!cancelarModal.dataset.listener) {
        cancelarModal.addEventListener('click', () => {
            deleteCont.classList.add("hidden");
        });
        cancelarModal.dataset.listener = "true";
    }

    // Delegación de eventos para los botones de borrar
    bodyTableInv.addEventListener('click', async function (e) {
        if (e.target.closest('.delete-producto')) {
            const btn = e.target.closest('.delete-producto');
            const productoId = btn.dataset.producto;
            const product = await getProduct(productoId);
            console.log(product)
            document.getElementById('product-h3').innerHTML = `
                ¿Estás seguro de eliminar, <strong>${product.producto.nombre}</strong>?
            `;

            // Remueve listeners previos antes de agregar uno nuevo
            const confirmarBtn = document.getElementById("confirmar-d");
            confirmarBtn.replaceWith(confirmarBtn.cloneNode(true));
            const newConfirmarBtn = document.getElementById("confirmar-d");
            console.log(productoId)
            newConfirmarBtn.addEventListener('click', async () => {
                try {
                    const res = await fetch(`http://localhost:8080/api/delete/${productoId}/producto`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        },
                    });
                    const data = await res.json();
                    if (!res.ok) {                        
                        throw data;
                    }

                    recargarEstadisticas(data);
                    await recargarTablaInv();
                    deleteCont.classList.add('hidden');
                    showToast('Producto Eliminado', 'success');
                } catch (err) {
                    showToast(`${err.errors}`, "error");
                }
            });

            deleteCont.classList.remove("hidden");
        }
    });
}
deleteP();

async function recargarTablaInv() {
    const bodytableInv = document.getElementById('body-table-inv');
    bodytableInv.innerHTML = '';

    try {
        const res = await fetch(`http://localhost:8080/api/all-products`);
        const data = await res.json();

        if (!res.ok) {
            throw data;
        }
                
        data.productos.forEach(producto => {
            const row = document.createElement('tr');
            row.className = "hover:bg-gray-50 transition-colors";

            // Marca
            const marcaNombre = producto.marca?.nombre ?? '';

            // Precio formateado
            const precioFormateado = new Intl.NumberFormat('es-PY', {
                minimumFractionDigits: 0
            }).format(producto.precio_venta);

            // Stock y tipo
            let stockClass = '';
            let stockContent = '';
            let stockTag = '';

            if (producto.tipo === 'servicio') {
                stockClass = 'text-gray-400 italic';
                stockContent = 'Servicio';
            } else {
                if (producto.stock === 0) {
                    stockClass = 'font-bold bg-red-200 text-red-700';
                    stockContent = producto.stock;
                    stockTag = `<span class="ml-2 text-xs text-red-700">sin stock</span>`;
                } else if (producto.stock_minimo >= producto.stock && producto.stock >= 1) {
                    stockClass = 'text-orange-600 font-bold bg-orange-100';
                    stockContent = producto.stock;
                    stockTag = `<span class="ml-2 text-xs text-orange-600">stock min.</span>`;
                } else {
                    stockClass = '';
                    stockContent = producto.stock;
                }
            }
            const distribuidorNombre = producto.tipo === 'servicio'
                ? 'Servicio'
                : (producto.distribuidor?.nombre ?? '');


            const distribuidorClass = producto.tipo === 'servicio'
                ? 'text-gray-400 italic'
                : '';

            row.innerHTML = `
                        <td class="pl-3 py-3 text-sm">
                            <p class="font-semibold">${producto.nombre}</p>
                            <p class="text-gray-500 text-xs">${marcaNombre}</p>
                        </td>
                        <td class="px-2 py-3 text-sm">${producto.codigo ?? ""}</td>
                        <td class="pl-3 py-3 text-sm font-medium">
                            GS. ${precioFormateado}
                        </td>
                        <td class="pl-3 py-3 text-sm ${stockClass}">
                            <span class="${producto.tipo === 'servicio' ? 'font-semibold rounded-full text-green-400 text-center bg-green-100 px-2 py-1' : ''}">
                                ${stockContent}
                            </span>
                            ${stockTag}
                        </td>
                        <td class="pl-3 py-3 text-sm ${distribuidorClass}">
                            ${distribuidorNombre}
                        </td>
                        <td class="pl-3 py-3 text-sm flex items-center space-x-3">
                            <a href="/edit/${producto.id}/producto"
                                class="edit-product text-blue-600 hover:text-blue-800 transition-colors"
                                title="Editar producto">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                </svg>
                            </a>
                            <button data-producto="${producto.id}"
                                class="delete-producto text-red-600 hover:text-red-800 transition-colors"
                                title="Eliminar producto">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                    </svg>
                            </button>
                        </td>
                    `;

            bodytableInv.appendChild(row);
        });

        // Re-inicializar eventos si es necesario
        deleteP();        
    } catch (err) {
        console.error(err);
        showToast(`${err.message || 'Error al obtener productos'}`, 'error');
    }
}
async function getProduct(productoId) {
    try {
        const res = await fetch(`http://localhost:8080/api/producto/${productoId}`, {
            method: 'GET',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            }
        });

        const data = await res.json();
        if (!res.ok) {
            throw data;
        }

        return data;
    } catch (err) {
        showToast(`${err.message || 'Error al obtener productos'}`, 'error');
    }
}

const totalProductos = document.getElementById('total-productos');
const stockMinimo = document.getElementById('stock-minimo');
const sinStock = document.getElementById('sin-stock');
const servicios = document.getElementById('servicios');
const productos = document.getElementById('productos');
let filter;

sinStock.addEventListener('click', async () => {
    filter = 'sin_stock'
    await searchInventario('', '', filter);
})

stockMinimo.addEventListener('click', async () => {
    filter = 'stock_min',
        await searchInventario('', '', filter);
});

totalProductos.addEventListener('click', async () => {
    filter = 'total_productos';
    await searchInventario('', '', filter);
})

servicios.addEventListener('click', async () => {
    filter = 'servicios';
    await searchInventario('', '', filter);
});
productos.addEventListener('click', async () => {
    filter = 'productos';
    await searchInventario('', '', filter);
});


function recargarEstadisticas(data){
    console.log(data)
    const totalProductos = document.getElementById('total-productos-i');
    const stockMinimo = document.getElementById('stock-minimo-i');
    const sinStock = document.getElementById('sin-stock-i');
    const servicios = document.getElementById('servicios-i');
    const productos = document.getElementById('productos-i');

    totalProductos.innerText = `${data.total - 1}`;
    stockMinimo.innerText = `${data.stock}`;
    sinStock.innerText = `${data.sinStock}`;
    servicios.innerText = `${data.totalServicios}`
    productos.innerText = `${data.totalProductos}`
}
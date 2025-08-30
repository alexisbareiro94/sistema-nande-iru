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
            btnCerrarInv.addEventListener('click', (e)=> {
                e.preventDefault();
                document.getElementById("i-s-inventario").value = '';
                btnCerrarInv.classList.add('hidden');
                searchInventario(query = "", filtro ="");
            });
        }
        searchInventario(query, filtro);
    }, 300);
});

function searchInventario(query, filtro) {
    fetch(`http://localhost:8080/api/productos?q=${encodeURIComponent(query)}&filtro=${encodeURIComponent(filtro)}`, {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
        },
    })
        .then(res => res.json())
        .then(data => {
            const bodytableInv = document.getElementById('body-table-inv');
            bodytableInv.innerHTML = '';

            data.productos.forEach(producto => {
                const row = document.createElement('tr');

                const tipoStockClass = producto.tipo === 'servicio'
                    ? "text-gray-300 font-semibold" : "text-gray-500";

                row.innerHTML = `
                        <td class="pl-6 py-4 text-sm">
                            <p class="font-semibold">${producto.nombre}</p>
                            <p class="text-gray-500">${producto.marca?.nombre ?? ''}</p>
                        </td>
                        <td class="px-2 py-4 text-sm">${producto.codigo}</td>
                        <td class="px-6 py-4 text-sm">
                            GS. ${producto.precio_venta.toLocaleString('es-PY', { minimumFractionDigits: 0 })}
                        </td>
                        <td class="px-6 py-4 text-sm ${tipoStockClass}">
                            ${producto.tipo === 'servicio' ? 'Servicio' : producto.stock}
                        </td>
                        <td class="px-6 py-4 text-sm ${tipoStockClass}">
                            ${producto.tipo === 'servicio' ? 'Servicio' : producto.distribuidor?.nombre ?? ''}
                        </td>
                        <td class="px-6 py-4 text-sm flex">
                            <a href="http://localhost:8080/edit/${producto.id}/producto"
                                    class="edit-product text-blue-600 hover:underline text-sm cursor-pointer transition-all duration-150 hover:bg-blue-100 px-1 py-1 rounded-md">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                </svg>
                            </a>
                            <button data-producto="${producto.id}"
                                    class="delete-producto text-red-600 hover:underline ml-4 text-sm cursor-pointer transition-all duration-150 hover:bg-red-100 px-1 py-1 rounded-md">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                    </svg>
                            </button>
                        </td>
                    `;
                bodytableInv.appendChild(row);
                deleteP();
            });
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

            document.getElementById('product-h3').innerHTML = `
                ¿Estás seguro de eliminar, <strong>${product.producto.nombre}</strong>?
            `;

            // Remueve listeners previos antes de agregar uno nuevo
            const confirmarBtn = document.getElementById("confirmar-d");
            confirmarBtn.replaceWith(confirmarBtn.cloneNode(true));
            const newConfirmarBtn = document.getElementById("confirmar-d");

            newConfirmarBtn.addEventListener('click', async () => {
                try {
                    const res = await fetch(`http://localhost:8080/api/delete/${productoId}/producto`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        },
                    });

                    if (!res.ok) {
                        const errData = await res.json();
                        throw errData;
                    }
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
    const bodyTableInv = document.getElementById("body-table-inv");

    try {
        const res = await fetch(`http://localhost:8080/api/all-products`);
        const data = await res.json();

        if (!res.ok) {
            throw data;
        }

        bodyTableInv.innerHTML = "";

        data.productos.forEach(producto => {
            const row = document.createElement('tr');

            const tipoStockClass = producto.tipo === 'servicio'
                ? "text-gray-300 font-semibold" : "text-gray-500";

            row.innerHTML = `
                        <td class="pl-6 py-4 text-sm">
                            <p class="font-semibold">${producto.nombre}</p>
                            <p class="text-gray-500">${producto.marca?.nombre ?? ''}</p>
                        </td>
                        <td class="px-2 py-4 text-sm">${producto.codigo}</td>
                        <td class="px-6 py-4 text-sm">
                            GS. ${producto.precio_venta.toLocaleString('es-PY', { minimumFractionDigits: 0 })}
                        </td>
                        <td class="px-6 py-4 text-sm ${tipoStockClass}">
                            ${producto.tipo === 'servicio' ? 'Servicio' : producto.stock}
                        </td>
                        <td class="px-6 py-4 text-sm ${tipoStockClass}">
                            ${producto.tipo === 'servicio' ? 'Servicio' : producto.distribuidor?.nombre ?? ''}
                        </td>
                        <td class="px-6 py-4 text-sm flex">
                           <a href="http://localhost:8080/edit/${producto.id}/producto"
                                    class="edit-product text-blue-600 hover:underline text-sm cursor-pointer transition-all duration-150 hover:bg-blue-100 px-1 py-1 rounded-md">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                </svg>
                            </a>
                            <button data-producto="${producto.id}" class="delete-producto text-red-600 hover:underline ml-4 text-sm cursor-pointer transition-all duration-150 hover:bg-red-100 px-1 py-1 rounded-md">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                    </svg>
                            </button>
                        </td>
                    `;
            bodyTableInv.appendChild(row);
            deleteP();
        });

    } catch (err) {
        console.error(err);
        showToast(`${err.message || 'Error al obtener productos'}`, 'error');
    }
}
async function getProduct(productoId) {
    try{
        const res = await fetch(`http://localhost:8080/api/producto/${productoId}`, {
            method: 'GET',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            }
        });

        const data = await res.json();
        if(!res.ok){
            throw data;
        }

        return data;
    }catch(err){
       // console.log('error en getProduct');
        showToast(`${err.message || 'Error al obtener productos'}`, 'error');
    }
}

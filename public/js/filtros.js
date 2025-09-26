async function orderBy(column, direction) {
    try {
        const res = await fetch(`http://127.0.0.1:80/api/productos?orderBy=${column}&dir=${direction}`, {
            method: 'GET',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
            },
        });

        const data = await res.json();
        if (!res.ok) {
            throw data;
        }
        await recargarTableInvForOrder(data);

    } catch (err) {
        showToast(err.message, 'error');
    }
}
function formatearPrecio(numero) {
    return numero.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}


async function recargarTableInvForOrder(data) {
    const bodytableInv = document.getElementById('body-table-inv');
    bodytableInv.innerHTML = '';

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
                stockTag = `<span class="ml-2 text-xs text-red-700">stock min.</span>`;
            } else {
                stockClass = '';
                stockContent = producto.stock;
            }
        }

        // Distribuidor
        const distribuidorNombre = producto.tipo === 'servicio'
            ? 'Servicio'
            : (producto.distribuidor?.nombre ?? '');

        // Clase para distribuidor
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

}



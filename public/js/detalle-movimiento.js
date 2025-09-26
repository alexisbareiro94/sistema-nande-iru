const modalDm = document.getElementById('modal-detalle-movimiento');
function abrirmodalDmDetalles() {
    const btnsdetalleVentas = document.querySelectorAll('.detalle-movimiento');
    btnsdetalleVentas.forEach(btn => {
        btn.addEventListener('click', async () => {
            const id = btn.dataset.ventam;
            console.log(id)
            await detalleMov(id);
            modalDm.classList.remove('hidden');
            setTimeout(() => {
                modalDm.classList.remove('opacity-0');
                modalDm.classList.add('opacity-100', 'flex');
            }, 5);
        })
    })
}

abrirmodalDmDetalles();

function cerrarmodalDmDetalleMov() {
    modalDm.classList.remove('opacity-100');
    modalDm.classList.add('opacity-0');

    setTimeout(() => {
        modalDm.classList.add('hidden');
        modalDm.classList.remove('flex');
    }, 150);
}

async function detalleMov(id) {
    try {
        const res = await fetch(`http://127.0.0.1:80/venta/${decodeURIComponent(id)}`, {
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
        setDataDetalleMov(data);
    } catch (err) {
        console.log(err)
        showToast(`${err.error}`, 'error')
    }
}



function setDataDetalleMov(data) {
    const dmFecha = document.getElementById('dm-fecha');
    const dmTipo = document.getElementById('dm-tipo');
    const dmCajero = document.getElementById('dm-cajero');
    const dmConcepto = document.getElementById('dm-concepto');
    const dmTotal = document.getElementById('dm-total');

    //set fecha del movimiento
    const fecha = new Date(data.venta.created_at);
    const fechaFormateada = fecha.toLocaleString('es-PY', {
         day: '2-digit',
        month: '2-digit',
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit',
        hour12: false
    }).replace(',', ' -');

    dmFecha.innerText = fechaFormateada

    //set tipo de movimiento
    const dmTipoClass = data.venta.tipo == 'egreso' ? 'text-red-700 bg-red-200' : 'text-green-700 bg-green-200'
    dmTipo.classList = `px-2 py-1 rounded-full text-sm font-medium ${dmTipoClass}`
    dmTipo.innerText = `${data.venta.tipo}`

    //set cajero
    dmCajero.innerText = `${data.venta.caja.user.name}`

    //set concepto
    dmConcepto.innerText = `${data.venta.concepto}`

    //set total
    dmTotal.innerText = `Gs. ${data.venta.monto.toLocaleString('es-PY')}`

}

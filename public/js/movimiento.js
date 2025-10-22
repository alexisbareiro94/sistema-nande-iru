window.addEventListener('DOMContentLoaded', async () => {
    await recargarMovimientos();
});

async function getMovimientos() {
    try {
        const res = await fetch(`http://127.0.0.1:80/api/movimiento`, {
            method: 'GET',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
            }
        });

        const data = await res.json();
        if (!res.ok) {
            throw data;
        }                
        return data;
    } catch (err) {
        showToast(`${err.error}`);
    }
}

async function recargarMovimientos() {
    const movimientoCont = document.getElementById('movimiento-cont');
    const data = await getMovimientos();
    movimientoCont.innerHTML = '';    
    data.movimientos.forEach((movimiento) => {
        let fecha = new Date(movimiento.created_at);
        let fechaFormateada = fecha.toLocaleString('es-PY', {
            day: '2-digit',
            month: '2-digit',
            year: 'numeric',
            hour: '2-digit',
            minute: '2-digit',
            hour12: false
        }).replace(',', ' -');
        const div = document.createElement('div');
        let montoClass = movimiento.tipo == 'ingreso' ? 'text-green-400' : 'text-red-600';
        let simbolo = movimiento.tipo == 'ingreso' ? '+' : '-';
        div.classList.add('flex', 'items-center', 'justify-between', 'p-3', 'bg-gray-200', 'rounded-lg');
        div.innerHTML = `
                <div>
                    <p id="concepto-m" class="font-medium text-gray-800">${movimiento.concepto}</p>
                    <p id="fecha-m" class="text-gray-500 text-sm">${fechaFormateada}</p>
                </div>
                <span id="monto" class="${montoClass} font-bold">${simbolo} ${movimiento.monto.toLocaleString('es-PY')} Gs.</span>            
        `;
        movimientoCont.appendChild(div);
    })
}
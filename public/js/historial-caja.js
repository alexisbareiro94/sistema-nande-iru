function abrirModalCaja() {
    const modal = document.getElementById("modal-detalle-caja");
    modal.classList.remove("hidden", "opacity-0", "pointer-events-none");
    modal.classList.add("flex", "opacity-100");
    setTimeout(() => {
        modal.querySelector("div").classList.add("scale-100");
    }, 10);
}

function cerrarModalCaja() {
    const modal = document.getElementById("modal-detalle-caja");
    modal.querySelector("div").classList.remove("scale-100");
    modal.classList.remove("opacity-100");
    modal.classList.add("opacity-0");

    setTimeout(() => {
        modal.classList.add("hidden", "pointer-events-none");
        modal.classList.remove("flex");
    }, 300);
}

// Cerrar modal al hacer clic fuera
document
    .getElementById("modal-detalle-caja")
    .addEventListener("click", function (e) {
        if (e.target === this) {
            cerrarModalCaja();
        }
    });
document.querySelectorAll(".detalle-caja").forEach((btn) => {
    btn.addEventListener("click", async () => {
        const data = await getCaja(btn.dataset.cajaid);
        abrirModalCaja();
        mapearDetalleCaja(data);
    });
});

async function getCaja(id) {
    try {
        const res = await fetch(`http://127.0.0.1:80/api/caja/${id}`, {
            method: "GET",
            headers: {
                "X-CSRF-TOKEN": csrfToken,
            },
        });
        const data = await res.json();
        if (!res.ok) {
            throw data;
        }
        console.log(data);
        return data;
    } catch (err) {
        showToast(`${err.error}`, "error");
    }
}

function mapearDetalleCaja(data) {
    const dcDetalleVenta = document.getElementById("dc-detalle-caja");
    const dcCajeroFechas = document.getElementById("dc-cajero-fechas");
    const dcMontoEsperado = document.getElementById("dc-monto-esperado");
    const dcMontoEncontrado = document.getElementById("dc-monto-encontrado");
    const dcDiferencia = document.getElementById("dc-diferencia");
    const dcTransacciones = document.getElementById("dc-transacciones");
    const dcEfectivo = document.getElementById("dc-efectivo");
    const efecPor = document.getElementById("dc-ef-por");
    const dcTransferencia = document.getElementById("dc-transferencia");
    const transfPor = document.getElementById("dc-tr-por");
    const dcClientes = document.getElementById("dc-clientes");
    const dcTablaBody = document.getElementById("dc-tabla-body");
    const divOne = document.getElementById("dif-cont-one");
    const divDos = document.getElementById("dif-cont-dos");
    const meyorVenta = document.getElementById("dc-mayor-venta");
    const promedio = document.getElementById("dc-promedio");

    let simbolo = "";
    if (data.datos.caja.monto_cierre > data.datos.caja.saldo_esperado) {
        divOne.classList =
            "bg-gradient-to-br from-green-50 to-green-100 border border-green-200 rounded-xl p-4";
        divDos.classList = "p-2 bg-green-500 rounded-lg";
        dcDiferencia.classList = "text-xl font-bold text-green-600";
        simbolo = "+";
    } else {
        divOne.classList =
            "bg-gradient-to-br from-red-50 to-red-100 border border-red-200 rounded-xl p-4";
        divDos.classList = "bg-red-500 rounded-lg";
        dcDiferencia.classList = "text-xl font-bold text-red-600";
        simbolo = "-";
    }

    fechaAp = new Date(data.datos.caja.fecha_apertura);
    fechaApertura = fechaAp
        .toLocaleString("es-PY", {
            day: "2-digit",
            month: "2-digit",
            year: "numeric",
            hour: "2-digit",
            minute: "2-digit",
            hour12: false,
        })
        .replace(",", " ");

    fechaCie = new Date(data.datos.caja.fecha_cierre);
    fechaCierre = fechaCie
        .toLocaleString("es-PY", {
            day: "2-digit",
            month: "2-digit",
            year: "numeric",
            hour: "2-digit",
            minute: "2-digit",
            hour12: false,
        })
        .replace(",", " ");

    console.log(data);
    dcDetalleVenta.innerText = `Detalle de Caja #${data.datos.caja.id}`;
    dcCajeroFechas.innerHTML = `${data.datos.caja.user.name} - ${fechaApertura} - ${fechaCierre}`;
    dcMontoEsperado.innerText = `Gs. ${data.datos.caja.saldo_esperado.toLocaleString("es-PY")}`;
    dcMontoEncontrado.innerText = `Gs. ${data.datos.caja.monto_cierre.toLocaleString("es-PY")}`;
    dcDiferencia.innerText = `Gs. ${simbolo} ${data.datos.caja.diferencia.toLocaleString("es-PY")}`;
    dcTransacciones.innerText = `${data.datos.transacciones}`;
    dcClientes.innerText = `${data.datos.clientes}`;

    const efectivo = Number(data.datos.efectivo ?? 0);
    const transferencia = Number(data.datos.transferencia ?? 0);

    const efecPorcentaje =
        data.datos.efecPorcentaje ?? data.datos.efecProcentaje ?? 0;
    const transfPorcentaje =
        data.datos.transfPorcentaje ?? data.datos.transfProcentaje ?? 0;

    dcEfectivo.innerText = `Gs ${efectivo.toLocaleString("es-PY")} (${efecPorcentaje}%)`;
    dcTransferencia.innerText = `Gs ${transferencia.toLocaleString("es-PY")} (${transfPorcentaje}%)`;

    efecPor.className = "h-2 rounded-full bg-green-500";
    efecPor.style.width = `${efecPorcentaje}%`;
    efecPor.setAttribute("aria-valuenow", efecPorcentaje);

    transfPor.className = "h-2 rounded-full bg-blue-500";
    transfPor.style.width = `${transfPorcentaje}%`;
    transfPor.setAttribute("aria-valuenow", transfPorcentaje);

    dcTablaBody.innerHTML = "";
    data.datos.ventas.forEach((producto) => {
        const tr = document.createElement("tr");
        tr.innerHTML = `
                                    <td class="px-4 py-2 font-medium">${producto.producto}</td>
                                    <td class="px-4 py-2">${producto.cantidad}</td>
                                    <td class="px-4 py-2">Gs. ${producto.total.toLocaleString("es-PY")}</td>

        `;
        dcTablaBody.appendChild(tr);
    });

    meyorVenta.innerText = `Gs. ${data.datos.mayorVenta.toLocaleString("es-PY")}`;
    promedio.innerText = `Gs. ${data.datos.promedio.toLocaleString("es-PY")}`;
    //  <td class="px-4 py-2">
    //                                         <span
    //                                             class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">22%</span>
    //                                     </td>
}

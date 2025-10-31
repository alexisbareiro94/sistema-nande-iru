import { csrfToken } from './csrf-token';

function mostrarNotificacion(tipo = 'tipo', mensaje = 'No se pudo cargar el mensaje', color = 'orange') {
    const contenedor = document.getElementById('notificaciones');

    if (contenedor.classList.contains('hidden')) {
        contenedor.classList.remove('hidden');
    }

    const notificacion = document.createElement('div');
    notificacion.className = `p-3 bg-${color}-50 border border-${color}-200 rounded-lg mb-2 transition-opacity duration-500`;
    notificacion.innerHTML = `
        <div class="flex items-center">
            <div class="flex-shrink-0 text-${color}-700">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" 
                    stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" 
                        d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 
                           9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
                </svg>
            </div>
            <div class="ml-3">
                <h4 class="text-sm font-medium text-${color}-800">${tipo}</h4>
                <p class="text-sm text-${color}-700">${mensaje}</p>
            </div>
        </div>
    `;
    contenedor.appendChild(notificacion);

    setTimeout(() => {
        notificacion.classList.add('opacity-0');
        setTimeout(() => {
            notificacion.remove();
            if (contenedor.children.length === 0) {
                contenedor.classList.add('hidden');
            }
        }, 500);
    }, 5000);
}

function listenNotification() {
    if (window.tenantId) {
        window.Echo.private(`admin-notificaciones.${window.tenantId}`)
            .listen('NotificacionEvent', (e) => {
                console.log(e)
                mostrarNotificacion(e.tipo, e.mensaje, e.color);
                getDataNotificaciones(); //para las notificaciones dentro del modulo de reportes

            })
            .error((error) => {
                console.log('Error en el canal:', error);
            });
    }
}

listenNotification();

function listenCierreCaja() {
    if(window.tenantId){
        window.Echo.private(`cierre-caja.${window.tenantId}`)
        .listen('CierreCajaEvent', (e) => {
            if (window.location.pathname === "/caja") {
                alert('Cierre de Caja');
                window.location.reload();
            } else {
                mostrarNotificacion(e.tipo, e.mensaje, e.color);
                getDataNotificaciones();
            }
        })
        .error(error => {
            console.log('Error en el canal: ', error)
        })
    }
}

listenCierreCaja();

async function getDataNotificaciones(flag = false) {
    try {
        if (!document.getElementById('alert-cont')) {
            return;
        }
        const res = await fetch('http://127.0.0.1:80/api/notificaciones');
        const data = await res.json();

        if (!res.ok) {
            throw data;
        }

        if (flag == false) {
            renderNotifications(data);
        } else {
            return data;
        }
    } catch (err) {
        console.log(err)
    }
}

function renderNotifications(data) {
    const alertCont = document.getElementById('alert-cont');
    if (!alertCont) {
        return;
    }
    alertCont.innerHTML = '';

    data.notificaciones.forEach((item, index) => {
        const div = document.createElement('div');

        const fecha = new Date(item.created_at);
        const fechaFormateada = fecha.toLocaleString('es-PY', {
            day: '2-digit',
            month: '2-digit',
            year: 'numeric',
            hour: '2-digit',
            minute: '2-digit',
            hour12: false
        }).replace(',', ' -');

        const colors = {
            orange: {
                text: "text-orange-700",
                title: "text-orange-800",
                span: "text-orange-500",
                div: "border-orange-600"
            },
            red: {
                text: "text-red-700",
                title: "text-red-800",
                span: "text-red-500",
            },
        };


        const classDiv = item.is_read == false
            ? `border-l-8 border-${item.color}-600 bg-${item.color}-50`
            : `bg-${item.color}-50 rounded-md border border-${item.color}-400`;

        // arranca oculto para animar
        div.classList = `p-3 shadow-md ${classDiv} transition-all duration-300 transform opacity-0 -translate-y-2`;
        div.innerHTML = `          
            <div class="flex relative">               
                <div class="ml-3 ">
                    <h4 class="text-sm font-medium text-${item.color}-800">${item.titulo}</h4>
                    <p class="text-sm text-${item.color}-700">${item.mensaje}</p>
                    <span class="text-xs absolute top-0 text-${item.color}-500 right-0">${fechaFormateada}</span>
                </div>
            </div>`;

        alertCont.appendChild(div);

        setTimeout(() => {
            div.classList.remove("opacity-0", "-translate-y-2");
        }, 50);
    });
}

getDataNotificaciones();


async function isRead() {
    if (!document.getElementById('alert-cont')) {
        return;
    }
    const data = await getDataNotificaciones(true)
    const ids = data.notificaciones
        .filter(item => item?.is_read === false)
        .map(item => item.id);

    setTimeout(() => {
        try {
            ids.forEach(async (id) => {
                const res = await fetch(`http://127.0.0.1:80/api/notificaciones/update/${id}`, {
                    method: 'PUT',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                    }
                });
                const data = res.json();
                if (!res.ok) {
                    throw data
                }
            })
        } catch (err) {
            console.log(err)
        }
    }, 1000);
}

if (window.location.pathname === "/reportes") {
    isRead();
}

if (document.getElementById('todas-alertas')) {
    document.getElementById('todas-alertas').addEventListener('click', () => {
        document.getElementById('todas-notificaciones-modal').classList.remove('hidden');
        sessionStorage.setItem('pag', JSON.stringify(10));
        renderNotificaciones();
    });
}

if (document.getElementById('cerrar-notificaciones')) {
    document.getElementById('cerrar-notificaciones').addEventListener('click', () => {
        sessionStorage.removeItem('pag');
        const cargarMas = document.getElementById('cargar-mas');
        cargarMas.classList = 'px-3 py-2 rounded-lg font-semibold bg-gray-200 cursor-pointer transition-all duration-200 hover:bg-gray-300'
        cargarMas.innerText = 'Cargar mas'
        document.getElementById('todas-notificaciones-modal').classList.add('hidden');
    });
}

async function allNotifications() {
    const pag = JSON.parse(sessionStorage.getItem('pag'));
    try {
        const res = await fetch(`http://127.0.0.1:80/api/notificaciones?all=${pag}`);
        const data = await res.json();

        if (!res.ok) {
            throw data;
        }
        return data;
    } catch (err) {
        console.log(err)
    }
}


async function renderNotificaciones() {
    const allNotifCont = document.getElementById('all-notif-cont');
    const data = await allNotifications();
    const pag = JSON.parse(sessionStorage.getItem('pag'));
    allNotifCont.innerHTML = '';

    data.data.forEach(item => {
        const fecha = new Date(item.created_at);
        const fechaFormateada = fecha.toLocaleString('es-PY', {
            day: '2-digit',
            month: '2-digit',
            year: 'numeric',
            hour: '2-digit',
            minute: '2-digit',
            hour12: false
        }).replace(',', ' -');
        const div = document.createElement('div');
        div.classList = `col col-span-1 p-3 shadow-md transition-all duration-300 transform bg-${item.color}-50 rounded-md border border-${item.color}-400`
        div.innerHTML = `<div class="flex relative">
                            <div class="ml-3 ">
                                <h4 class="text-sm font-medium text-${item.color}-800">${item.titulo}</h4>
                                <p class="text-sm text-${item.color}-700">${item.mensaje}</p>
                                <span
                                    class="text-xs absolute top-0 text-${item.color}-500 right-0">${fechaFormateada}</span>
                            </div>
                        </div>`;
        allNotifCont.appendChild(div);
    });
    console.log(data.count, pag)
    if (pag > data.count) {
        const cargarMas = document.getElementById('cargar-mas');
        cargarMas.classList = 'px-3 py-2 rounded-lg font-semibold'
        cargarMas.innerText = 'Ya no hay notificaciones'
    }

}

if (document.getElementById('cargar-mas')) {
    document.getElementById('cargar-mas').addEventListener('click', () => {
        const pag = JSON.parse(sessionStorage.getItem('pag')) + 10;
        sessionStorage.setItem('pag', JSON.stringify(pag));
        renderNotificaciones();
    });
}

window.Echo.private(`auth-event.${window.tenantId}`)
    .listen('AuthEvent', (e) => {
        conexion(e.user, e.tipo, e.ultimaConexion);
    })
    .error((error) => {
        console.log('Error en el canal:', error);
    });

function conexion(userFromEvent, tipo, ultimaConexion = null) {
    const tds = document.querySelectorAll('.td-personal');

    tds.forEach(td => {
        const userIdTd = td.dataset.id;

        if (userFromEvent.id == userIdTd) {
            td.classList.remove('text-green-500');
            if (tipo === 'logout') {
                td.innerText = ultimaConexion;
            } else {
                td.classList.add('text-green-500');
                td.innerText = 'En línea';
            }
        }
    });
}

window.Echo.private(`pdf-ready.${window.userId}`)
    .listen('PdfGeneradoEvent', async (e) => {
        const container = document.getElementById('loading-container');
        const link = document.createElement('a');
        link.href = `${e.path}`;
        console.log(e.path)
        try {
            setTimeout(() => {
                container.classList.add('hidden');
                sessionStorage.removeItem('pdf-toast')
                alert('Su pdf esta listo')
                const url = 'http://127.0.0.1:80/download'
                const a = document.createElement('a');
                a.href = url;
                a.click();
            }, 500)
        } catch (err) {
            console.log(err)
        }
    })
    .error((error) => {
        console.log('Error en el canal:', error);
    });


window.Echo.private(`ultima-actividad.${window.tenantId}`)
    .listen('UltimaActividadEvent', (e) => {
        const tds = document.querySelectorAll('.td-total')
        tds.forEach(td => {
            const userIdTd = td.dataset.userid;
            if (e.userId == userIdTd) {
                td.innerText = `Gs. ${e.totalVenta}`;
            }
        })
    })
    .error(err => {
        console.log(err)
    })



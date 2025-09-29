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

// Escuchar canal privado de admins
function listenNotification() {
    window.Echo.private('admin-notificaciones')
        .listen('NotificacionEvent', (e) => {
            mostrarNotificacion(e.tipo, e.mensaje, e.color);
            getDataNotificaciones(); //para las notificaciones dentro del modulo de reportes

        })
        .error((error) => {
            console.error('Error en el canal:', error);
        });
}

listenNotification();



function listenCierreCaja() {
    window.Echo.private('cierre-caja')
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
            console.error('Error en el canal: ', error)
        })
}

listenCierreCaja();

async function getDataNotificaciones(flag = false) {
    try {
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
            // etc...
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
    const data = await getDataNotificaciones(true)
    const ids = data.notificaciones
        .filter(item => item?.is_read === false)
        .map(item => item.id);

    console.log(ids)
    console.log(ids.length)
    setTimeout(() => {
        console.log('message')
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



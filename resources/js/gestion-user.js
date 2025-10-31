import { csrfToken } from './csrf-token';
import { showToast } from './toast';
import { $ } from './utils';

let userId = '';
function selectUser() {
    if (!document.getElementById('edit-user')) {
        return;
    }
    document.getElementById('edit-user').addEventListener('change', async (e) => {
        const name = document.getElementById('name-selected');
        const email = document.getElementById('email-selected');
        const rol = document.getElementById('rol-selected');
        const salario = document.getElementById('salario-selected');
        userId = e.target.value;
        try {
            const res = await fetch(`http://127.0.0.1:80/api/gestion_user/${e.target.value}`);
            const data = await res.json();
            if (!res.ok) {
                throw data;
            }
            if (data.data.activo == false) {
                document.getElementById('btn-actualizar').innerText = 'Actualizar y activar'
            } else {
                document.getElementById('btn-actualizar').innerText = 'Actualizar'
            }
            name.value = data.data.name;
            email.value = data.data.email;
            salario.value = `${data.data.salario}`;
        } catch (err) {
            console.log(err.error)
        }
    });
}
selectUser();
if (document.getElementById('update-personal-form')) {
    document.getElementById('update-personal-form').addEventListener('submit', async (e) => {
        e.preventDefault();
        await updatePersonal(true);
        await renderSelects();
    });
}

if (document.getElementById('personal-activo')) {
    document.getElementById('personal-activo').addEventListener('change', (e) => {
        userId = e.target.value;
        console.log(userId);
    });
}

const btns = document.querySelectorAll('.delDes-personal');
btns.forEach(async (btn) => {
    btn.addEventListener('click', async () => {
        if (btn.id === 'desactivar') {
            await updatePersonal(false);
            await renderSelects();
        } else {
            await deletePersonal();
            await renderSelects();
        }
    });
})

async function updatePersonal(activo) {
    const name = document.getElementById('name-selected').value;
    const email = document.getElementById('email-selected').value;
    const rol = document.getElementById('rol-selected').value;
    const salario = document.getElementById('salario-selected').value;
    try {
        const formData = new FormData();
        name != '' ? formData.append('name', name) : '';
        email != '' ? formData.append('email', email) : '';
        rol != '' ? formData.append('rol', rol) : '';
        salario != '' ? formData.append('salario', salario) : '';
        formData.append('activo', activo);

        const res = await fetch(`http://127.0.0.1:80/api/gestion_user/${userId}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
            },
            body: formData,
        });
        const data = await res.json();
        console.log(data);
        if (!res.ok) {
            throw data
        }
        showToast('Usuario Actualizado');
    } catch (err) {
        console.log(err)
    }
}

async function deletePersonal() {
    try {
        const res = await fetch(`http://127.0.0.1/api/gestion_user/${userId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
            }
        });

        const data = await res.json();
        if (!res.ok) {
            throw data;
        }
        console.log(data)
        showToast('Usuario Eliminado')
    } catch (err) {
        showToast(`No se puede eliminar este usuario porque tiene cajas relacionadas, puedes desactivarlo`, 'error')
    }
}

async function renderSelects() {
    await rerenderEliDes();
    await rerenderForm();

}


async function rerenderEliDes() {
    const eliDesUser = document.getElementById('personal-activo');
    try {
        const res = await fetch('http://127.0.0.1:80/api/gestion_users');
        const data = await res.json();

        if (!res.ok) {
            throw data;
        }

        eliDesUser.innerHTML = '';
        const optionOne = document.createElement('option');
        optionOne.disabled = true;
        optionOne.selected = true;
        optionOne.textContent = 'Seleccionar usuario';
        eliDesUser.appendChild(optionOne);
        const users = data.data.filter(user => user.activo == true);
        console.log(users)
        users.forEach(user => {
            const option = document.createElement('option');
            option.value = user.id;
            option.textContent = user.name;

            eliDesUser.appendChild(option);
        });

    } catch (err) {
        console.log(err);
    }
}

async function rerenderForm() {
    const editUser = document.getElementById('edit-user');

    try {
        const res = await fetch('http://127.0.0.1:80/api/gestion_users');
        const data = await res.json();

        if (!res.ok) {
            throw data;
        }

        editUser.innerHTML = '';
        const optionOne = document.createElement('option');
        optionOne.disabled = true;
        optionOne.selected = true;
        optionOne.textContent = 'Seleccionar usuario';
        editUser.appendChild(optionOne);

        data.data.forEach(user => {
            const option = document.createElement('option');
            option.value = user.id;
            option.textContent = user.name + (user.activo == false ? ' - Inactivo' : '');

            if (user.activo == false) {
                option.className = 'text-gray-300 underline';
            }

            editUser.appendChild(option);
        });

    } catch (err) {
        console.log(err);
    }
}


window.Echo.private(`auditoria-creada.${window.tenantId}`)
    .listen('AuditoriaCreadaEvent', async e => {
        try {
            const res = await fetch('http://127.0.0.1:80/api/auditorias');
            const data = await res.json();
            if (!res.ok) {
                throw data;
            }
            renderTableBody(data.data);
        } catch (err) {
            console.log(err)
        }
    })
    .error(err => {
        console.log(err)
    })


function renderTableBody(data) {
    if(!$('#table-body-auditorias')){
        return;
    }
    const body = document.getElementById('table-body-auditorias');
    body.innerHTML = '';
    let count = 0;

    data.forEach(item => {
        console.log(item);
        const tr = document.createElement('tr');
        let key = '';
        let dato = '';

        if (item.datos && typeof item.datos === 'object') {
            console.log(item.datos);
            for (const [k, v] of Object.entries(item.datos)) {
                key = k;
                dato = v;
                console.log(key, dato);
            }
        }

        tr.className = count === 0 ? 'bg-blue-200' : '';

        const fecha = new Date(item.created_at);
        const fechaFormateada = fecha.toLocaleString('es-PY', {
            day: '2-digit',
            month: '2-digit',
            year: 'numeric',
            hour: '2-digit',
            minute: '2-digit',
            hour12: false
        }).replace(',', ' -');

        tr.innerHTML = `
            <td class="px-4 py-3">${item.user?.name ?? ''}</td>
            <td class="px-4 py-3">${item.accion}</td>
            <td class="px-4 py-3">
                ${key} : ${dato}
            </td>
            <td class="px-4 py-3">${fechaFormateada}</td>
        `;

        body.appendChild(tr);
        count++;
    });
}

import axios from "axios";
import { $$, $el, $eli, $ ,$i, url, formatFecha } from './utils'
import { showToast } from './toast'
edit();
function edit() {
    const btns = $$('.edit-cliente-gcd');
    btns.forEach(btn => {
        btn.addEventListener('click', async () => {
            const id = btn.dataset.id;
            const modal = $i('modal-edit-cliente')
            const ruc = $i('ruc-ci-gcd');
            const razon = $i('razon-gcd');
            const userId = $i('user-id');
            modal.classList.remove('hidden')
            try {
                const res = await axios.get(`${url}/cliente/${id}`)
                const data = res.data.data;

                userId.value = id;
                ruc.value = `${data.ruc_ci}`
                razon.value = `${data.razon_social}`
            } catch (err) {
                console.error(err)
            }
        })
    });
}


if ($i('modal-edit-cliente')) {
    $eli('modal-edit-cliente', 'click', e => {
        if (e.target == $i('modal-edit-cliente')) {
            $i('modal-edit-cliente').classList.add('hidden')
        }
    });
}

if ($i('cerrar-modal-edit-cliente')) {
    $eli('cerrar-modal-edit-cliente', 'click', () => {
        const modal = $i('modal-edit-cliente')
        modal.classList.add('hidden')
    })
}

if ($i('form-edit-cliente-gcd')) {
    $eli('form-edit-cliente-gcd', 'submit', async e => {
        e.preventDefault();
        const ruc = $i('ruc-ci-gcd').value;
        const razon = $i('razon-gcd').value;
        const id = $i('user-id').value;

        const data = new FormData();
        data.append('razon_social', razon);
        data.append('ruc_ci', ruc);

        try {
            await axios.post(`${url}/user/${id}`, data);            
            $i('modal-edit-cliente').classList.add('hidden')
            $i('form-edit-cliente-gcd').reset();
            showToast('Usuario Actualizado');
            renderUser();
            renderAllUser();
        } catch (err) {
            console.error(err)
        }
    })
}

async function renderUser() {    
    const tableBody = $i('clientes-table-body')
    tableBody.innerHTML = '';
    try {
        const res = await axios.get(`${url}/users`);        
        const users = res.data.users
        let count = 0;
        for (const user of users) {
            if (count == 5) break;
            const tr = document.createElement('tr')
            tr.className = 'bg-white border-b border-gray-200'
            tr.innerHTML = `
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                            ${user.razon_social}
                            </th>
                            <td class="px-6 py-4">
                                ${user.ruc_ci}
                            </td>
                            <td class="px-6 py-4">
                                ${user.compras.length}
                            </td>
                            <td class="px-6 py-4">
                                ${formatFecha(user.created_at)}
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex gap-5">
                                <button
                                    class="edit-cliente-gcd hover:text-blue-500 cursor-pointer transition-all active:scale-90"
                                    data-id="${user.id}">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                    </svg>
                                </button>

                                <button
                                    class="borrar-cliente-gcd hover:text-red-500 cursor-pointer transition-all active:scale-90"
                                    data-id="${user.id}">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                    </svg>
                                </button>
                            </div>
                        </td>`                                    
            tableBody.appendChild(tr)
            count++
            edit();
            deleteCliente();
        }
    } catch (err) {
        console.log(err)
    }
}


export async function renderAllUser(data = null) {          
    const todosTableBody = $i('todos-clientes-table-body');        
    todosTableBody.innerHTML = '';    
    try {  
        let users;
        if(data){
            users = data;
        }else{
            const res = await axios.get(`${url}/users`);
            console.log(res.data.users)
            users = res.data.users
        }
        
        for (const user of users) {            
            const tr = document.createElement('tr')
            tr.className = 'bg-white border-b border-gray-200'
            tr.innerHTML = `
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                            ${user.razon_social}
                            </th>
                            <td class="px-6 py-4">
                                ${user.ruc_ci}
                            </td>
                            <td class="px-6 py-4">
                                ${user.compras.length}
                            </td>
                            <td class="px-6 py-4">
                                ${formatFecha(user.created_at)}
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex gap-5">
                                <button
                                    class="edit-cliente-gcd hover:text-blue-500 cursor-pointer transition-all active:scale-90"
                                    data-id="${user.id}">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                    </svg>
                                </button>

                                <button
                                    class="borrar-cliente-gcd hover:text-red-500 cursor-pointer transition-all active:scale-90"
                                    data-id="${user.id}">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                    </svg>
                                </button>
                            </div>
                        </td>`                                    
            todosTableBody.appendChild(tr)            
            edit();
            deleteCliente();
        }
    } catch (err) {
        console.log(err)
    }
}

deleteCliente();
if ($i('add-cliente-gcd')) {
    $eli('add-cliente-gcd', 'click', () => {
        $i('modal-add-cliente').classList.remove('hidden')
    })


    $eli('form-add-cliente', 'submit', e => {
        e.preventDefault();

        const formAddCliente = document.getElementById('form-add-cliente');

        formAddCliente.addEventListener('submit', async (e) => {
            e.preventDefault();
            const addCliente = new FormData();
            addCliente.append('razon_social', document.getElementById('razon_social').value.trim());
            addCliente.append('ruc_ci', document.getElementById('ruc_ci').value.trim())
            addCliente.append('email', document.getElementById('correo-c').value.trim());
            addCliente.append('telefono', document.getElementById('telefono-c').value.trim());

            try {
                await axios.post(`${url}/users`, addCliente);
                document.getElementById('modal-add-cliente').classList.add('hidden');
                renderUser();
                renderAllUser();
                showToast('Cliente Agregado con éxito', 'success');
            } catch (err) {
                console.log(err)
                showToast(`${err.error}`, 'error');
            }
        })
    });
}

if($i('modal-eliminar-cliente-gcd')){

    $eli('modal-eliminar-cliente-gcd', 'click', e => {
        if (e.target == $i('modal-eliminar-cliente-gcd')) {
            $i('modal-eliminar-cliente-gcd').classList.add('hidden')
        }
    })
}

const btnsCerrraModal = $$('#modal-eliminar-cliente-gcd .cerrar-modal');

btnsCerrraModal.forEach(btn => {
    btn.addEventListener('click', () => {
        $i('modal-eliminar-cliente-gcd').classList.add('hidden')
    });
});
function deleteCliente() {
    const btns = $$('.borrar-cliente-gcd')    
    btns.forEach(btn => {
        btn.addEventListener('click', async () => {
            const id = btn.dataset.id;
            try {
                const res = await axios.get(`${url}/cliente/${id}`);
                const user = res.data.data;

                const modal = $i('modal-eliminar-cliente-gcd')
                const title = $i('h3-eliminar-cliente');

                title.innerText = `Estas seguro de eliminar al Cliente: ${user.name ?? user.razon_social}`

                if ($i('btn-eliminar-cliente')) {
                    $i('btn-eliminar-cliente').dataset.id = user.id
                }

                modal.classList.remove('hidden');
            } catch (err) {
                console.log(err)
            }

        })
    });
}


if ($i('btn-eliminar-cliente')) {
    $eli('btn-eliminar-cliente', 'click', async e => {
        e.preventDefault();
        const id = e.target.dataset.id
        try {
            await axios.post(`${url}/cliente/${id}`);
            const modal = $i('modal-eliminar-cliente-gcd')
            modal.classList.add('hidden');
            renderUser();
            renderAllUser();
            showToast('Cliente Eliminado');
        } catch (err) {
            console.log(err)
        }
    });
}


//distribuidores
if($('#add-distribuidor-gcd')){
    $el('#add-distribuidor-gcd', 'click', () => {
        $('#cont-add-dist').classList.remove('hidden');
    });
}


if($('#cerrar-dist')){
    $el('#cerrar-dist', 'click', () => {
        $('#cont-add-dist').classList.add('hidden');
    });
}

if($('#cont-add-dist')){
    $el('#cont-add-dist', 'click', e => {
        if(e.target == $('#cont-add-dist')){
            $('#cont-add-dist').classList.add('hidden');
        }
    });
}
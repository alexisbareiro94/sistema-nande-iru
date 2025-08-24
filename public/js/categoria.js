const btnVerCategorias = document.getElementById('all-categorias');
const contVerCategorias = document.getElementById('cont-ver-categorias') //contenedor de la tabla de marcas

btnVerCategorias.addEventListener('click', () => {
    contVerCategorias.classList.remove('hidden')
});

document.getElementById('cerrar-ver-categoria').addEventListener('click', () => {
    contVerCategorias.classList.add('hidden')
})

let timerCat;
document.getElementById('query-c').addEventListener('input',  function (){
    clearTimeout(timerCat);
    timerCat = setTimeout(() => {
        const query = this.value.trim();
        if(query.length >= 1){
            document.getElementById('cerrar-q-c').classList.toggle('hidden');
            document.getElementById('cerrar-q-c').addEventListener('click', () => {
                document.getElementById('query-c').value = '';
                document.getElementById('cerrar-q-c').classList.toggle('hidden');
                processQueryCat();
            });
        }
        processQueryCat(query);
    }, 300);
})

async function processQueryCat(query = '') {
    try{
        const res = await fetch(`http://localhost:8080/api/categorias?q=${encodeURIComponent(query)}`, {
            method: 'GET',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
            },
        });
        const data = await res.json();

        if(!res.ok){
            console.log(error)
            throw data;
        }

        const bodyTablaMarcas = document.getElementById('body-tabla-categorias');
        bodyTablaMarcas.innerHTML = '';
        data.categorias.forEach(categoria => {
            const row = document.createElement('tr');
            row.innerHTML = `
                        <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                            ${categoria.nombre}
                        </td>
                        <td class="px-6 py-4">
                            <button type="button"
                                    class="font-medium text-red-600 cursor-pointer hover:underline px-2 py-1 rounded-lg animation-all transition-all hover:scale-110 duration-150  hover:bg-red-100">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"
                                        />
                                    </svg>
                            </button>
                        </td>
                    `;
            bodyTablaMarcas.appendChild(row);
        });
    }catch(err){
        console.log(err);
        showToast(err.message, 'error')
    }
}

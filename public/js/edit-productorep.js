addCategoria = document.getElementById("add-categoria");
addMarca = document.getElementById("add-marca");
btnCerrarCategoria = document.getElementById("cerrar-categoria");
contAddCategoria = document.getElementById("cont-add-categoria");

addCategoria.addEventListener("click", () => {
    contAddCategoria.classList.remove('hidden');

});

btnCerrarCategoria.addEventListener("click", () => {
    contAddCategoria.classList.add('hidden');
});

document.getElementById("add-distribuidor").addEventListener("click", (e) => {
    document.getElementById("cont-add-dist").classList.remove('hidden');
});

document.getElementById("cerrar-dist").addEventListener("click", (e) => {
    document.getElementById("cont-add-dist").classList.add('hidden');
});


document.getElementById("ver-dists").addEventListener("click", (e) => {
    document.getElementById("cont-ver-dists").classList.remove('hidden');
    const q = document.getElementById('query');
});

document.getElementById("cerrar-ver-dists").addEventListener("click", (e) => {
    document.getElementById("cont-ver-dists").classList.add('hidden');
});

// Llamar la función al cargar la página o cuando se agregue un nuevo registro
function recargarTodo() {
    fetch('http://localhost:8080/api/all')
        .then(res => res.json())
        .then(data => {
            const marcasSelect = document.getElementById('marca_id');
            const categoriasSelect = document.getElementById('categoria_id');
            const distribuidoresSelect = document.getElementById('distribuidor_id');
            const bodyTablaDistribuidores = document.getElementById('body-tabla-distribuidores');

            // Limpiar los selects
            marcasSelect.innerHTML = '';
            categoriasSelect.innerHTML = '';
            distribuidoresSelect.innerHTML = '';
            bodyTablaDistribuidores.innerHTML = ''; // Limpiar la tabla de distribuidores

            // Llenar el select de marcas
            const opctionDefaultMarca = document.createElement('option');
            opctionDefaultMarca.value = "";
            opctionDefaultMarca.textContent = "Seleccionar Marca"
            marcasSelect.appendChild(opctionDefaultMarca);
            data.marcas.forEach(marca => {
                const option = document.createElement('option');
                option.value = marca.id;
                option.textContent = marca.nombre;
                marcasSelect.appendChild(option);
            });

            // Llenar el select de categorías
            const opctionDefaultCategoria = document.createElement('option');
            opctionDefaultCategoria.value = "";
            opctionDefaultCategoria.textContent = "Seleccionar Categoría"
            categoriasSelect.appendChild(opctionDefaultCategoria);
            data.categorias.forEach(categoria => {
                const option = document.createElement('option');
                option.value = categoria.id;
                option.textContent = categoria.nombre;
                categoriasSelect.appendChild(option);
            });

            // Llenar el select de distribuidores
            const opctionDefaultDist = document.createElement('option');
            opctionDefaultDist.value = "";
            opctionDefaultDist.textContent = "Seleccionar Categoría"
            distribuidoresSelect.appendChild(opctionDefaultDist);
            data.distribuidores.forEach(distribuidor => {
                const option = document.createElement('option');
                option.value = distribuidor.id;
                option.textContent = distribuidor.nombre;
                distribuidoresSelect.appendChild(option);

                // Agregar fila a la tabla de distribuidores
                const row = document.createElement('tr');
                row.innerHTML = `
                        <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                            ${distribuidor.nombre}
                        </td>
                        <td class="px-6 py-4">
                            ${distribuidor.ruc ?? 'No se registro RUC'}
                        </td>
                        <td class="px-6 py-4">
                            ${distribuidor.celular ?? 'No se registro Celular'}
                        </td>
                        <td class="px-6 py-4">
                            ${distribuidor.direccion ?? 'No se registro Direccion'}
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
                bodyTablaDistribuidores.appendChild(row);
            });
        })
        .catch(err => console.error("Error cargando datos:", err));
}

//agregar marcas
//const contAddMarca = document.getElementById("cont-add-marca");
//const cerrarMarca = document.getElementById("cerrar-marca");

document.getElementById("add-marca").addEventListener("click", (e) => {
    document.getElementById("cont-add-marca").classList.remove('hidden');
});
document.getElementById("cerrar-marca").addEventListener("click", (e) => {
    document.getElementById("cont-add-marca").classList.add('hidden');
});

document.addEventListener('DOMContentLoaded', () => {

    document.getElementById("form-marca").addEventListener("submit", (e) => {
        e.preventDefault();
        addMarca();
    });

    document.getElementById("btn-add-marca").addEventListener("click", (e) => {
        e.preventDefault();
        addMarca();
    });

    function addMarca() {
        const marcaNombre = document.getElementById("marca_nombre");
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        fetch('http://localhost:8080/agregar-marca', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({
                nombre: marcaNombre.value,
            }),
        })
            .then(res => {
                if (!res.ok) {
                    return res.json().then(err => { throw err; });
                }
                return res.json();
            })
            .then(data => {
                showToastRep("Marca agregada con éxito", "success");                
                recargarTodo();
                marcaNombre.value = '';
            })
            .catch(err => {
                if (err.errors) {
                    showToastRep("⚠ Error: " + Object.values(err.errors).join(', '), "error");                    
                } else {
                    showToastRep(`${err['nombre']}`, "error");                    
                }
            });
    }

    document.getElementById("btn-add-categoria").addEventListener("click", (e) => {
        e.preventDefault();
        addCategoria();
    });

    document.getElementById("form-categoria").addEventListener('submit', (e) => {
        e.preventDefault();
        addCategoria();
    });
    function addCategoria() {
        const categoriaNombre = document.getElementById("categoria_nombre");
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        fetch('http://localhost:8080/agregar-categoria', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({
                nombre: categoriaNombre.value,
                prueba: 'asdasd',
            }),
        })
            .then(res => {
                if (!res.ok) {
                    return res.json().then(err => { throw err; });
                }
                return res.json();
            })
            .then(data => {
                showToastRep("Categoría agregada con éxito", "success");                
                recargarTodo(); // recargar los selects
                categoriaNombre.value = ''; // limpiar input
            })
            .catch(err => {
                if (err.errors) {
                    showToastRep("⚠ Error: " + Object.values(err.errors).join(', '), "error");                    
                } else {
                    showToastRep(`${err['nombre']}`, "error");                    
                }
            });
    }

    document.getElementById("btn-add-dist").addEventListener("click", (e) => {
        e.preventDefault();
        addDistribuidor();
    });
    document.getElementById("form-dist").addEventListener("submit", (e) => {
        e.preventDefault();
        addDistribuidor();
    });

    function addDistribuidor() {        
        const distNombre = document.getElementById('dist-nombre');
        const distRuc = document.getElementById('dist-ruc');
        const distCelular = document.getElementById('dist-celular');
        const distDireccion = document.getElementById('dist-direccion');
        fetch('http://localhost:8080/agregar-distribuidor', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
            body: JSON.stringify({
                nombre: distNombre.value,
                ruc: distRuc.value,
                celular: distCelular.value,
                direccion: distDireccion.value,
            })
        })
            .then(res => {
                if (!res.ok) {
                    return res.json().then(err => { throw err; });
                }
                return res.json();
            })
            .then(data => {
                recargarTodo();
                showToastRep("Distribuidor agregado con éxito", "success");
                distNombre.value = '';
                distRuc.value = '';
                distCelular.value = '';
                distDireccion.value = '';
            })
            .catch(err => {
                if (err.errors) {
                    showToastRep("⚠ Error: " + Object.values(err.errors).join(', '), "error");
                } else {
                    var errores = ['nombre', 'ruc'];
                    if (err['messages']) {
                        errores.forEach(function (error) {
                            if (err['messages'][error]) {
                                showToastRep(err['messages'][error], "error");
                            }
                        })
                    }
                    console.error("Error:", err);
                }
            });
    }
    //});
});

//buscar distribuidores
let timerRep;
document.getElementById('query').addEventListener('input', function () {
    clearTimeout(timerRep);
    timerRep = setTimeout(() => {
        const query = this.value.trim();
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        if (query.length >= 1) {
            //const cerrarq = document.getElementById('cerrar-q');
            document.getElementById('cerrar-q').classList.remove('hidden');
        }
        fetch(`http://localhost:8080/api/distribuidores?q=${encodeURIComponent(query)}`, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
        })
            .then(res => res.json())
            .then(data => {
                const bodyTablaDistribuidores = document.getElementById('body-tabla-distribuidores');
                bodyTablaDistribuidores.innerHTML = '';

                data.data.forEach(distribuidor => {
                    const row = document.createElement('tr');

                    row.innerHTML = `
                        <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                            ${distribuidor.nombre}
                        </td>
                        <td class="px-6 py-4">
                            ${distribuidor.ruc ?? 'No se registro RUC'}
                        </td>
                        <td class="px-6 py-4">
                            ${distribuidor.celular ?? 'No se registro Celular'}
                        </td>
                        <td class="px-6 py-4">
                            ${distribuidor.direccion ?? 'No se registro Direccion'}
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
                    bodyTablaDistribuidores.appendChild(row);
                });
            })
            .catch(err => console.error("error al cargar los datos", err))
    }, 300);
});

//const cerrarq = document.getElementById('cerrar-q')
document.getElementById('cerrar-q').addEventListener('click', () => {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    document.getElementById('query').value = '';
    document.getElementById('cerrar-q').classList.add('hidden');
    fetch('http://localhost:8080/api/distribuidores?q=', {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
    })
        .then(res => res.json())
        .then(data => {
            const bodyTablaDistribuidores = document.getElementById('body-tabla-distribuidores');
            bodyTablaDistribuidores.innerHTML = '';

            data.data.forEach(distribuidor => {
                const row = document.createElement('tr');

                row.innerHTML = `
                        <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                            ${distribuidor.nombre}
                        </td>
                        <td class="px-6 py-4">
                            ${distribuidor.ruc ?? 'No se registro RUC'}
                        </td>
                        <td class="px-6 py-4">
                            ${distribuidor.celular ?? 'No se registro Celular'}
                        </td>
                        <td class="px-6 py-4">
                            ${distribuidor.direccion ?? 'No se registro Direccion'}
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
                bodyTablaDistribuidores.appendChild(row);
            });
        }).catch(err => console.error("error al cargar los datos", err))
}, 300);


function showToastRep(message, type = 'success') {
    const container = document.getElementById('toast-container');
    const bgColor = type === 'success' ? 'bg-green-500' : 'bg-red-500';
    const icon = type === 'success' ? '✅' : '❌';

    const toast = document.createElement('div');
    toast.className = `${bgColor} text-white px-4 py-2 rounded-lg shadow-lg flex items-center space-x-2 opacity-0 transition-opacity duration-300`;
    toast.innerHTML = `<span>${icon}</span><span>${message}</span>`;

    container.appendChild(toast);

    // Fade in
    setTimeout(() => toast.classList.remove('opacity-0'), 10);

    // Fade out
    setTimeout(() => {
        toast.classList.add('opacity-0');
        setTimeout(() => toast.remove(), 500);
    }, 3000);
}


imagen.addEventListener('change', (e) => {
    const file = e.target.files[0];
    const contImgOriginalu = document.getElementById("div-img-original-u");
    const previewu = document.getElementById("imagen-preview-u");
    const previewContu = document.getElementById("preview-cont-u");

    if (file) {
        const reader = new FileReader();
        reader.onload = (e) => {
            previewu.src = e.target.result;
            previewContu.classList.remove('hidden');
            contImgOriginalu.classList.add('hidden');
        }
        reader.readAsDataURL(file);
    } else {
        previewu.src = "";

    }
});

document.getElementById('cerrar-preview-up').addEventListener('click', ()=>{
    const contImgOriginalu = document.getElementById("div-img-original-u");
    const previewu = document.getElementById("imagen-preview-u");
    const previewContu = document.getElementById("preview-cont-u");

    previewu.src = "";
    previewContu.classList.add('hidden');
    contImgOriginalu.classList.remove('hidden');
})

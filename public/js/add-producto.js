const nombre = document.getElementById("nombre");
const codigo = document.getElementById("codigo");
const categoria_id = document.getElementById("categoria_id");
const marca_id = document.getElementById("marca_id");
const descripcion = document.getElementById("descripcion");
const precio_venta = document.getElementById("precio_venta");
const precio_compra = document.getElementById("precio_compra");
const stock = document.getElementById("stock");
const stock_minimo = document.getElementById("stock_minimo")
const imagen = document.getElementById("imagen");
const boton = document.getElementById("boton");
const distribuidor_id = document.getElementById("distribuidor_id");
const tipoProductoRadios = document.getElementsByName("tipo-producto");
let codigoAuto = false;
document.getElementById('codigo-auto').addEventListener('click', function(){
    if (this.value === 'false'){
        codigoAuto = true;
        this.value = true;
    }else{
        codigoAuto = false;
        this.value = false;
    }
});

const labelServicio = document.getElementById("l-servicio");
const labelProducto = document.getElementById("l-producto");
let tipoSeleccionado = "producto";
tipoProductoRadios.forEach(radio => {
    radio.addEventListener('change', (e) => {
        if (e.target.value === 'servicio') {
            labelServicio.classList.add('bg-amarillo');
            labelProducto.classList.remove('bg-amarillo');
            tipoSeleccionado = "servicio";
        } else {
            labelServicio.classList.remove('bg-amarillo');
            labelProducto.classList.add('bg-amarillo');
            tipoSeleccionado = "producto";
        }
    });
});

boton.addEventListener("click", (e) => {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const formData = new FormData();
    formData.append('nombre', nombre.value);
    formData.append('codigo', codigo.value);
    formData.append('codigo_auto', codigoAuto);
    formData.append('categoria_id', categoria_id.value ?? "");
    formData.append('marca_id', marca_id.value ?? "");
    formData.append('descripcion', descripcion.value ?? "");
    formData.append('precio_venta', precio_venta.value ?? "");
    formData.append('precio_compra', precio_compra.value ?? "");
    formData.append('stock', stock.value ?? "");
    formData.append('stock_minimo', stock_minimo.value ?? "");
    formData.append('distribuidor_id', distribuidor_id.value ?? "");
    formData.append('tipo', tipoSeleccionado ?? "");
    formData.append('imagen', imagen.files[0] ?? "");
    console.log(formData.get('codigo_auto'));
    fetch('http://localhost:8080/agregar-producto', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': csrfToken
        },
        body: formData
    })
        .then(res => {
            if (!res.ok) {
                return res.json().then(errData => { throw errData });
            }
            return res.json();
        })
        .then(data => {
            console.log(data);
            document.getElementById('form-add-producto').reset();
            document.getElementById('imagen-preview').src = "";
            document.getElementById("preview-cont").classList.add('hidden');
            document.getElementById("div-img-original").classList.remove('hidden');
            showToast("Producto agregado con éxito", "success");
            console.log("Producto agregado:", data);
        })
        .catch(err => {
            console.log(err)
            const errores = ['nombre', 'codigo', 'tipo', 'descripcion', 'precio_compra', 'precio_venta', 'stock', 'stock_minimo',
                'categoria_id', 'marca_id', 'distribuidor_id', 'ventas', 'imagen',]
            errores.forEach(errori => {
                if (err.errors[errori]) {
                    showToast(`${err.errors[errori]}`, "error");
                }
            });
        });
});

// document.getElementById('codigo-auto').addEventListener('change', (e) => {
//     console.log('toggle')
//     const toggle = e.target;
//     if (toggle.checked) {
//         toggle.parentNode.querySelector('.block').classList.remove('bg-gray-300');
//         toggle.parentNode.querySelector('.block').classList.add('bg-amarillo');
//         toggle.parentNode.querySelector('.dot').classList.remove('left-1');
//         toggle.parentNode.querySelector('.dot').classList.add('left-7');
//     } else {
//         toggle.parentNode.querySelector('.block').classList.add('bg-gray-300');
//         toggle.parentNode.querySelector('.block').classList.remove('bg-amarillo');
//         toggle.parentNode.querySelector('.dot').classList.add('left-1');
//         toggle.parentNode.querySelector('.dot').classList.remove('left-7');
//     }
// });


//mostar preview de la imagen
imagen.addEventListener('change', (e) => { //evento del input de la imagen
    const file = e.target.files[0];
    const contImgOriginal = document.getElementById("div-img-original"); //div contenedor de la imagen que se va a enviar
    const preview = document.getElementById("imagen-preview"); //input para el preview de la imagen
    const previewCont = document.getElementById("preview-cont"); //<div/> contenedor donde se va a mostrar el preview

    if (file) {
        const reader = new FileReader();

        reader.onload = (e) => {
            preview.src = e.target.result;
            previewCont.classList.remove('hidden');
            contImgOriginal.classList.add('hidden');
        }
        reader.readAsDataURL(file);
    } else {
        preview.src = "";
        //previewCont.classList.remove('hidden');
    }
});

//elimiar el preview
document.getElementById("cerrar-preview").addEventListener("click", () => {
    const contImgOriginal = document.getElementById("div-img-original"); //div contenedor de la imagen que se va a enviar
    const preview = document.getElementById("imagen-preview"); //input para el preview de la imagen
    const previewCont = document.getElementById("preview-cont"); //<div/> contenedor donde se va a mostrar el preview

    contImgOriginal.classList.remove('hidden');
    preview.src = ""
    previewCont.classList.add('hidden');
});

//agregar categorias y marcas
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


//notificacion solo para agregar categorias
function showToast(message, type = 'success') {
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


//add distribuidores
const addDistribuidor = document.getElementById("add-distribuidor");
const contAddDistribuidor = document.getElementById("cont-add-dist");
const cerrarDist = document.getElementById("cerrar-dist");

addDistribuidor.addEventListener("click", (e) => {
    contAddDistribuidor.classList.remove('hidden');
});

cerrarDist.addEventListener("click", (e) => {
    contAddDistribuidor.classList.add('hidden');
});


//ver tabla de  distribuidores
const verDistribuidores = document.getElementById("ver-dists");
const contVerDistribuidores = document.getElementById("cont-ver-dists");

verDistribuidores.addEventListener("click", (e) => {
    contVerDistribuidores.classList.remove('hidden');
    const q = document.getElementById('query');
    const cerrarq = document.getElementById('cerrar-q');
    console.log(q.length);
});
cerrarVerDist = document.getElementById("cerrar-ver-dists");
cerrarVerDist.addEventListener("click", (e) => {
    contVerDistribuidores.classList.add('hidden');
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
                processQueryCat();
                processQueryMarca()
            });
        })
        .catch(err => console.error("Error cargando datos:", err));
}

//agregar marcas
const contAddMarca = document.getElementById("cont-add-marca");
const cerrarMarca = document.getElementById("cerrar-marca");

document.getElementById("add-marca").addEventListener("click", (e) => {
    contAddMarca.classList.remove('hidden');
});
cerrarMarca.addEventListener("click", (e) => {
    contAddMarca.classList.add('hidden');
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
                showToast("Marca agregada con éxito", "success");
                console.log("Marca agregada:", data);
                recargarTodo();
                marcaNombre.value = '';
            })
            .catch(err => {
                if (err.errors) {
                    showToast("⚠ Error: " + Object.values(err.errors).join(', '), "error");
                    console.log("Errores de validación:", err.errors);
                } else {
                    showToast(`${err['nombre']}`, "error");
                    console.error("Error:", err);
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
                showToast("Categoría agregada con éxito", "success");
                console.log("Producto agregado:", data);
                recargarTodo(); // recargar los selects
                categoriaNombre.value = ''; // limpiar input
            })
            .catch(err => {
                if (err.errors) {
                    showToast("⚠ Error: " + Object.values(err.errors).join(', '), "error");
                    console.log("Errores de validación:", err.errors);
                } else {
                    showToast(`${err['nombre']}`, "error");
                    console.error("Error:", err);
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
        console.log('add distr')
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
                showToast("Distribuidor agregado con éxito", "success");
                distNombre.value = '';
                distRuc.value = '';
                distCelular.value = '';
                distDireccion.value = '';
            })
            .catch(err => {
                if (err.errors) {
                    showToast("⚠ Error: " + Object.values(err.errors).join(', '), "error");
                } else {
                    var errores = ['nombre', 'ruc'];
                    if (err['messages']) {
                        errores.forEach(function (error) {
                            if (err['messages'][error]) {
                                showToast(err['messages'][error], "error");
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
let debounceTimer;
document.getElementById('query').addEventListener('input', function () {
    clearTimeout(debounceTimer);
    debounceTimer = setTimeout(() => {
        const query = this.value.trim();
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        if (query.length >= 1) {
            const cerrarq = document.getElementById('cerrar-q');
            cerrarq.classList.remove('hidden');
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

const cerrarq = document.getElementById('cerrar-q')
cerrarq.addEventListener('click', () => {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    document.getElementById('query').value = '';
    cerrarq.classList.add('hidden');
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

const producto_id = document.getElementById('producto_id').value;

document.getElementById('boton-u').addEventListener('click', (e) => {
    e.preventDefault();
    updateProduct(flag = false);
});

document.addEventListener('DOMContentLoaded', ()=>{
    const message = localStorage.getItem('toastMessage');
    const type = localStorage.getItem('toastType');

    if(message != null){
        showToast(message, type);
    }
    localStorage.clear();
});

let eliminarImagen = false;
const btnCerrarPreviewUp = document.getElementById('cerrar-preview-u');
const alerta = document.getElementById('alerta-borrado');
btnCerrarPreviewUp.addEventListener('click', () => {
    alerta.classList.remove('hidden');
    btnCerrarPreviewUp.classList.add('hidden');
    eliminarImagen = true;
});

const btnCancelarBorrado = document.getElementById('cancelar-borrado');
btnCancelarBorrado.addEventListener('click', () => {
    alerta.classList.add('hidden');
    btnCerrarPreviewUp.classList.remove('hidden');
    eliminarImagen = false;
});

document.getElementById('confirmar-borrado').addEventListener('click', async (e) => {
    e.preventDefault();
    eliminarImagen = true;
    await updateProduct(true);
});

async function updateProduct(flag = false) {
    const tipoE = document.getElementById('tipo-e').value;

    const formDataEdit = new FormData();
    nombre.value ? formDataEdit.append('nombre', nombre.value) : '';
    codigo.value ? formDataEdit.append('codigo', codigo.value) : '';
    categoria_id.value ? formDataEdit.append('categoria_id', categoria_id.value) : '';
    marca_id.value ? formDataEdit.append('marca_id', marca_id.value) : '';
    descripcion.value ? formDataEdit.append('descripcion', descripcion.value) : '';
    precio_venta.value ? formDataEdit.append('precio_venta', precio_venta.value) : '';
    precio_compra.value ? formDataEdit.append('precio_compra', precio_compra.value) : '';
    stock.value ? formDataEdit.append('stock', stock.value) : '';
    stock_minimo.value ? formDataEdit.append('stock_minimo', stock_minimo.value) : '';
    distribuidor_id.value ? formDataEdit.append('distribuidor_id', distribuidor_id.value) : '';
    tipoE ? formDataEdit.append('tipo', tipoE) : '';
    imagen.files[0] ? formDataEdit.append('imagen', imagen.files[0]) : '';
    eliminarImagen ? formDataEdit.append('eliminar_imagen', eliminarImagen) : '';
    producto_id ? formDataEdit.append('producto_id', producto_id) : '';    
    try {
        const res = await fetch(`http://127.0.0.1:80/edit/${encodeURIComponent(producto_id)}/producto`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
            },
            body: formDataEdit,
        });

        if (!res.ok) {
            const errData = await res.json();            
            throw errData;
        }

        const data = await res.json();
        document.getElementById('form-add-producto-u').reset();
        // guardo el mensaje en localStorage
        if (flag == true) {
            localStorage.setItem("toastMessage", "Producto Actualizado Correctamente");
            localStorage.setItem("toastType", "success");
            localStorage.setItem("scrollToBottom", "true");
            window.location.href = `/edit/${producto_id}/producto`;
        } else {
            localStorage.setItem("toastMessage", "Producto Actualizado Correctamente");
            localStorage.setItem("toastType", "success");
            window.location.href = `/edit/${producto_id}/producto`;
        }

    } catch (err) {        
        const errores = [
            'nombre', 'codigo', 'tipo', 'descripcion', 'precio_compra', 'precio_venta',
            'stock', 'stock_minimo', 'categoria_id', 'marca_id', 'distribuidor_id',
            'ventas', 'imagen'
        ];

        errores.forEach(errori => {
            if (err.errors && err.errors[errori]) {
                showToast(`${err.errors[errori]}`, "error");
            }
        });

        if (err.message) {            
            showToast(err.message, "error");
        }
    }
}

if (localStorage.getItem("scrollToBottom") === "true") {
    const observer = new MutationObserver(() => {
        const formElement = document.getElementById('form-add-producto-u');
        if (formElement) {
            formElement.scrollIntoView({ behavior: "smooth", block: "end" });
            localStorage.removeItem("scrollToBottom");
            observer.disconnect();
        }
    });

    observer.observe(document.body, { childList: true, subtree: true });
}

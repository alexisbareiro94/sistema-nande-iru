const procesarVenta = document.getElementById('procesar-venta');

procesarVenta.addEventListener('click', () => {
    const ruc = document.getElementById('i-ruc-ci');    
    const razon = document.getElementById('i-nombre-razon');
    if(ruc.value.trim() == ''){
        ruc.classList.remove('border-gray-300', 'focus:ring-yellow-400', 'focus:border-yellow-400')
        ruc.classList.add('border-red-500', 'ring-2','ring-red-500', 'focus:border-red-500', 'bg-red-100');
        ruc.placeholder = 'Campo Obligatorio';
    }
    if(razon.value.trim() == ''){
        razon.classList.remove('border-gray-300', 'focus:ring-yellow-400', 'focus:border-yellow-400')
        razon.classList.add('border-red-500', 'ring-2','ring-red-500', 'focus:border-red-500', 'bg-red-100');
        razon.placeholder = 'Campo Obligatorio';
    }
    //w-full pl-10 pr-4 py-2.5 rounded-lg focus:ring-2 
});
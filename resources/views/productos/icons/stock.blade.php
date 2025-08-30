<div id="stock-i-c" class="flex relative">
    <span id="doble-s" class="cursor-pointer absolute z-50">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5">
            <path fill-rule="evenodd"
                  d="M10.53 3.47a.75.75 0 0 0-1.06 0L6.22 6.72a.75.75 0 0 0 1.06 1.06L10 5.06l2.72 2.72a.75.75 0 1 0 1.06-1.06l-3.25-3.25Zm-4.31 9.81 3.25 3.25a.75.75 0 0 0 1.06 0l3.25-3.25a.75.75 0 1 0-1.06-1.06L10 14.94l-2.72-2.72a.75.75 0 0 0-1.06 1.06Z"
                  clip-rule="evenodd" />
        </svg>
    </span>

    <span id="up-s" class="cursor-pointer absolute z-20 hidden">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="size-4">
            <path fill-rule="evenodd"
                  d="M11.78 9.78a.75.75 0 0 1-1.06 0L8 7.06 5.28 9.78a.75.75 0 0 1-1.06-1.06l3.25-3.25a.75.75 0 0 1 1.06 0l3.25 3.25a.75.75 0 0 1 0 1.06Z"
                  clip-rule="evenodd" />
        </svg>
    </span>

    <span id="down-s" class="cursor-pointer absolute z-10 hidden">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="size-4">
            <path fill-rule="evenodd"
                  d="M4.22 6.22a.75.75 0 0 1 1.06 0L8 8.94l2.72-2.72a.75.75 0 1 1 1.06 1.06l-3.25 3.25a.75.75 0 0 1-1.06 0L4.22 7.28a.75.75 0 0 1 0-1.06Z"
                  clip-rule="evenodd" />
        </svg>
    </span>
</div>

<script>
    const dobleS = document.getElementById('doble-s');
    const upS = document.getElementById('up-s');
    const downS = document.getElementById('down-s');

    dobleS.addEventListener('click', async () => { //column = nombre / asc
        dobleS.classList.remove('z-50')
        dobleS.classList.add('z-10');
        dobleS.classList.add('hidden');

        upS.classList.remove('hidden');
        upS.classList.remove('z-20');
        upS.classList.add('z-50');

        await orderBy('stock', 'asc');
        document.getElementById('links').innerHTML = '';
    });


    upS.addEventListener('click', async () => { //column = nombre /desc
        upS.classList.remove('z-50');
        upS.classList.add('z-10');
        upS.classList.add('hidden');

        downS.classList.remove('hidden');
        downS.classList.remove('z-10');
        downS.classList.add('z-50');

        await orderBy('stock', 'desc');
        document.getElementById('links').innerHTML = '';
    });

    downS.addEventListener('click', async () => { //column = null / ""
        downS.classList.remove('z-50');
        downS.classList.add('z-10');
        downS.classList.add('hidden');

        dobleS.classList.remove('hidden');
        dobleS.classList.remove('z-10');
        downS.classList.add('z-50');
        await recargarTablaInv();
    });
</script>

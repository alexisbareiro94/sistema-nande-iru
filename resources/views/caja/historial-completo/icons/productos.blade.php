<div id="precio-i-c" class="flex relative">
    <span id="doble-p" class="cursor-pointer absolute z-50">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5">
            <path fill-rule="evenodd"
                  d="M10.53 3.47a.75.75 0 0 0-1.06 0L6.22 6.72a.75.75 0 0 0 1.06 1.06L10 5.06l2.72 2.72a.75.75 0 1 0 1.06-1.06l-3.25-3.25Zm-4.31 9.81 3.25 3.25a.75.75 0 0 0 1.06 0l3.25-3.25a.75.75 0 1 0-1.06-1.06L10 14.94l-2.72-2.72a.75.75 0 0 0-1.06 1.06Z"
                  clip-rule="evenodd" />
        </svg>
    </span>

    <span id="up-p" class="cursor-pointer absolute z-20 hidden">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="size-4">
            <path fill-rule="evenodd"
                  d="M11.78 9.78a.75.75 0 0 1-1.06 0L8 7.06 5.28 9.78a.75.75 0 0 1-1.06-1.06l3.25-3.25a.75.75 0 0 1 1.06 0l3.25 3.25a.75.75 0 0 1 0 1.06Z"
                  clip-rule="evenodd" />
        </svg>
    </span>

    <span id="down-p" class="cursor-pointer absolute z-10 hidden">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="size-4">
            <path fill-rule="evenodd"
                  d="M4.22 6.22a.75.75 0 0 1 1.06 0L8 8.94l2.72-2.72a.75.75 0 1 1 1.06 1.06l-3.25 3.25a.75.75 0 0 1-1.06 0L4.22 7.28a.75.75 0 0 1 0-1.06Z"
                  clip-rule="evenodd" />
        </svg>
    </span>
</div>

<script>
    const dobleP = document.getElementById('doble-p');
    const upP = document.getElementById('up-p');
    const downP = document.getElementById('down-p');

    dobleP.addEventListener('click', async () => { //column = nombre / asc
        dobleP.classList.remove('z-50')
        dobleP.classList.add('z-10');
        dobleP.classList.add('hidden');

        upP.classList.remove('hidden');
        upP.classList.remove('z-20');
        upP.classList.add('z-50');

        await orderBy('precio_venta', 'asc');
        document.getElementById('links').innerHTML = '';
    });


    upP.addEventListener('click', async () => { //column = nombre /desc
        upP.classList.remove('z-50');
        upP.classList.add('z-10');
        upP.classList.add('hidden');

        downP.classList.remove('hidden');
        downP.classList.remove('z-10');
        downP.classList.add('z-50');

        await orderBy('precio_venta', 'desc');
        document.getElementById('links').innerHTML = '';
    });

    downP.addEventListener('click', async () => { //column = null / ""
        downP.classList.remove('z-50');
        downP.classList.add('z-10');
        downP.classList.add('hidden');

        dobleP.classList.remove('hidden');
        dobleP.classList.remove('z-10');
        downP.classList.add('z-50');
        await recargarTablaInv();
    });
</script>


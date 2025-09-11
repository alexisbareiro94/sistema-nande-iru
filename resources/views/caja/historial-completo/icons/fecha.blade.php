<div id="nombre-i-c" class="flex relative">
    <span id="doble-n" class="cursor-pointer absolute z-50">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-4">
            <path fill-rule="evenodd"
                d="M10.53 3.47a.75.75 0 0 0-1.06 0L6.22 6.72a.75.75 0 0 0 1.06 1.06L10 5.06l2.72 2.72a.75.75 0 1 0 1.06-1.06l-3.25-3.25Zm-4.31 9.81 3.25 3.25a.75.75 0 0 0 1.06 0l3.25-3.25a.75.75 0 1 0-1.06-1.06L10 14.94l-2.72-2.72a.75.75 0 0 0-1.06 1.06Z"
                clip-rule="evenodd" />
        </svg>
    </span>

    <span id="up-n" class="cursor-pointer absolute z-20 hidden">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="size-4">
            <path fill-rule="evenodd"
                d="M11.78 9.78a.75.75 0 0 1-1.06 0L8 7.06 5.28 9.78a.75.75 0 0 1-1.06-1.06l3.25-3.25a.75.75 0 0 1 1.06 0l3.25 3.25a.75.75 0 0 1 0 1.06Z"
                clip-rule="evenodd" />
        </svg>
    </span>

    <span id="down-n" class="cursor-pointer absolute z-10 hidden">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="size-4">
            <path fill-rule="evenodd"
                d="M4.22 6.22a.75.75 0 0 1 1.06 0L8 8.94l2.72-2.72a.75.75 0 1 1 1.06 1.06l-3.25 3.25a.75.75 0 0 1-1.06 0L4.22 7.28a.75.75 0 0 1 0-1.06Z"
                clip-rule="evenodd" />
        </svg>
    </span>
</div>

<script>
    const dobleN = document.getElementById('doble-n');
    const upN = document.getElementById('up-n');
    const downN = document.getElementById('down-n');

    dobleN.addEventListener('click', async () => { //column = nombre / asc
        dobleN.classList.remove('z-50')
        dobleN.classList.add('z-10');
        dobleN.classList.add('hidden');

        upN.classList.remove('hidden');
        upN.classList.remove('z-20');
        upN.classList.add('z-50');

        await orderBy('nombre', 'asc');
        document.getElementById('links').innerHTML = '';
    });


    upN.addEventListener('click', async () => { //column = nombre /desc
        upN.classList.remove('z-50');
        upN.classList.add('z-10');
        upN.classList.add('hidden');

        downN.classList.remove('hidden');
        downN.classList.remove('z-10');
        downN.classList.add('z-50');

        await orderBy('nombre', 'desc');
        document.getElementById('links').innerHTML = '';
    });

    downN.addEventListener('click', async () => { //column = null / ""
        downN.classList.remove('z-50');
        downN.classList.add('z-10');
        downN.classList.add('hidden');

        dobleN.classList.remove('hidden');
        dobleN.classList.remove('z-10');
        downN.classList.add('z-50');
        await recargarTablaInv();
    });
</script>

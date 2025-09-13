<div id="dv-total-order" class="flex relative text-black">
    <span id="dv-fecha-doble" class="cursor-pointer absolute z-50">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-4">
            <path fill-rule="evenod"
                d="M10.53 3.47a.75.75 0 0 0-1.06 0L6.22 6.72a.75.75 0 0 0 1.06 1.06L10 5.06l2.72 2.72a.75.75 0 1 0 1.06-1.06l-3.25-3.25Zm-4.31 9.81 3.25 3.25a.75.75 0 0 0 1.06 0l3.25-3.25a.75.75 0 1 0-1.06-1.06L10 14.94l-2.72-2.72a.75.75 0 0 0-1.06 1.06Z"
                clip-rule="evenod" />
        </svg>
    </span>

    <span id="dv-fecha-up" class="cursor-pointer absolute z-20 hidden">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="size-4">
            <path fill-rule="evenod"
                d="M11.78 9.78a.75.75 0 0 1-1.06 0L8 7.06 5.28 9.78a.75.75 0 0 1-1.06-1.06l3.25-3.25a.75.75 0 0 1 1.06 0l3.25 3.25a.75.75 0 0 1 0 1.06Z"
                clip-rule="evenod" />
        </svg>
    </span>

    <span id="dv-fecha-down" class="cursor-pointer absolute z-10 hidden">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="size-4">
            <path fill-rule="evenod"
                d="M4.22 6.22a.75.75 0 0 1 1.06 0L8 8.94l2.72-2.72a.75.75 0 1 1 1.06 1.06l-3.25 3.25a.75.75 0 0 1-1.06 0L4.22 7.28a.75.75 0 0 1 0-1.06Z"
                clip-rule="evenod" />
        </svg>
    </span>
</div>

<script>
    const dvFechaDoble = document.getElementById('dv-fecha-doble');
    const dvFechaUp = document.getElementById('dv-fecha-up');
    const dvFechaDown = document.getElementById('dv-fecha-down');

    dvFechaDoble.addEventListener('click', async () => { //column = nombre / asc
        dvFechaDoble.classList.remove('z-50')
        dvFechaDoble.classList.add('z-10');
        dvFechaDoble.classList.add('hidden');

        dvFechaUp.classList.remove('hidden');
        dvFechaUp.classList.remove('z-20');
        dvFechaUp.classList.add('z-50');
        await buscar('created_at', 'asc')        
    });


    dvFechaUp.addEventListener('click', async () => { //column = nombre /desc
        dvFechaUp.classList.remove('z-50');
        dvFechaUp.classList.add('z-10');
        dvFechaUp.classList.add('hidden');

        dvFechaDown.classList.remove('hidden');
        dvFechaDown.classList.remove('z-10');
        dvFechaDown.classList.add('z-50');
        await buscar('created_at', 'desc')        
    });

    dvFechaDown.addEventListener('click', async () => { //column = null / ""
        dvFechaDown.classList.remove('z-50');
        dvFechaDown.classList.add('z-10');
        dvFechaDown.classList.add('hidden');

        dvFechaDoble.classList.remove('hidden');
        dvFechaDoble.classList.remove('z-10');
        dvFechaDown.classList.add('z-50');        
        await buscar()        
    });
</script>

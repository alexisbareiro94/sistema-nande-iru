<div id="dv-total-order" class="flex relative text-black">
    <span id="dv-total-doble" class="cursor-pointer absolute z-50">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-4">
            <path fill-rule="evenodd"
                  d="M10.53 3.47a.75.75 0 0 0-1.06 0L6.22 6.72a.75.75 0 0 0 1.06 1.06L10 5.06l2.72 2.72a.75.75 0 1 0 1.06-1.06l-3.25-3.25Zm-4.31 9.81 3.25 3.25a.75.75 0 0 0 1.06 0l3.25-3.25a.75.75 0 1 0-1.06-1.06L10 14.94l-2.72-2.72a.75.75 0 0 0-1.06 1.06Z"
                  clip-rule="evenodd" />
        </svg>
    </span>

    <span id="dv-total-up" class="cursor-pointer absolute z-20 hidden">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="size-4">
            <path fill-rule="evenodd"
                  d="M11.78 9.78a.75.75 0 0 1-1.06 0L8 7.06 5.28 9.78a.75.75 0 0 1-1.06-1.06l3.25-3.25a.75.75 0 0 1 1.06 0l3.25 3.25a.75.75 0 0 1 0 1.06Z"
                  clip-rule="evenodd" />
        </svg>
    </span>

    <span id="dv-total-down" class="cursor-pointer absolute z-10 hidden">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="size-4">
            <path fill-rule="evenodd"
                  d="M4.22 6.22a.75.75 0 0 1 1.06 0L8 8.94l2.72-2.72a.75.75 0 1 1 1.06 1.06l-3.25 3.25a.75.75 0 0 1-1.06 0L4.22 7.28a.75.75 0 0 1 0-1.06Z"
                  clip-rule="evenodd" />
        </svg>
    </span>
</div>

<script>
    const dvTotalDoble = document.getElementById('dv-total-doble');
    const dvTotalUp = document.getElementById('dv-total-up');
    const dvTotalDown = document.getElementById('dv-total-down');

    dvTotalDoble.addEventListener('click', async () => { //column = nombre / asc
        dvTotalDoble.classList.remove('z-50')
        dvTotalDoble.classList.add('z-10');
        dvTotalDoble.classList.add('hidden');

        dvTotalUp.classList.remove('hidden');
        dvTotalUp.classList.remove('z-20');
        dvTotalUp.classList.add('z-50');

        await buscar('monto', 'asc');
        //document.getElementById('links').innerHTML = '';
    });


    dvTotalUp.addEventListener('click', async () => { //column = nombre /desc
        dvTotalUp.classList.remove('z-50');
        dvTotalUp.classList.add('z-10');
        dvTotalUp.classList.add('hidden');

        dvTotalDown.classList.remove('hidden');
        dvTotalDown.classList.remove('z-10');
        dvTotalDown.classList.add('z-50');

        await buscar('monto', 'desc');
        //document.getElementById('links').innerHTML = '';
    });

    dvTotalDown.addEventListener('click', async () => { //column = null / ""
        dvTotalDown.classList.remove('z-50');
        dvTotalDown.classList.add('z-10');
        dvTotalDown.classList.add('hidden');

        dvTotalDoble.classList.remove('hidden');
        dvTotalDoble.classList.remove('z-10');
        dvTotalDown.classList.add('z-50');
        await buscar();
    });
</script>

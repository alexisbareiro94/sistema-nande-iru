<div class="relative">
    @if (session('error'))
        <div id="error-alert"
            class="fixed top-4 right-4 z-50 max-w-lg flex items-center p-4 text-sm text-red-100 border border-red-600 rounded-lg bg-red-500 shadow-lg"
            role="alert">
            <span class="sr-only">Info</span>
            <span class="font-bold flex gap-4 items-center text-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
                <p class="">
                    {{ session('error') }}
                </p>
            </span>
        </div>

        <script>
            setTimeout(() => {
                document.getElementById('error-alert').classList.add('hidden');
            }, 5000);
        </script>
    @endif


    @if (session('success'))
        <div id="success-alert"
            class="fixed top-4 right-4 z-50 max-w-lg flex items-center p-4 text-sm text-green-100 border border-green-600 rounded-lg bg-green-500 shadow-lg"
            role="alert">
            <span class="sr-only">Info</span>

            <span class="font-bold flex gap-4 items-center text-center">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                    <path fill-rule="evenodd"
                        d="M19.916 4.626a.75.75 0 0 1 .208 1.04l-9 13.5a.75.75 0 0 1-1.154.114l-6-6a.75.75 0 0 1 1.06-1.06l5.353 5.353 8.493-12.74a.75.75 0 0 1 1.04-.207Z"
                        clip-rule="evenodd" />
                </svg>
                <p>
                    {{ session('success') }}
                </p>
            </span>
        </div>

        <script>
            setTimeout(() => {
                document.getElementById('success-alert').classList.add('hidden');
            }, 5000)
        </script>
    @endif


    @if (session('pdf'))
        <div class="fixed items-center top-4 right-4 z-50 max-w-lg flex p-4 text-sm text-gray-800 border border-gray-200 rounded-lg bg-white shadow-lg"
            role="alert">
            <span class="sr-only">Info</span>

            <span class="font-bold flex gap-4 items-center text-center">
                <svg class="animate-spin h-10 w-10 text-gray-700 mb-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                        stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor"
                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                    </path>
                </svg>
                <p>
                    {{ session('pdf') }}
                </p>
            </span>
        </div>
    @endif

</div>

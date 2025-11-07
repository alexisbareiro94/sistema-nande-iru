// import { $, $$, $el } from './utils'

// const trigger = document.getElementById('dropdown');
// const exportMenu = document.getElementById('export-menu');
// const iconFlecha = document.getElementById('icon-flecha');

// if(trigger){
//     trigger.addEventListener('click', (e) => {
//         //e.stopPropagation(); 
//         iconFlecha.classList.toggle('rotate-180');
        
//         if (exportMenu.classList.contains('hidden')) {
//             exportMenu.classList.remove('hidden');
//             setTimeout(() => {
//                 exportMenu.classList.remove('opacity-0');
//                 exportMenu.classList.add('opacity-100');
//             }, 10);
//         } else {
//             exportMenu.classList.add('hidden');
//             setTimeout(() => {
//                 exportMenu.classList.remove('opacity-100');
//                 exportMenu.classList.add('opacity-0');
//             }, 10);
//     }
// });
// }

// document.addEventListener('click', (e) => {
//     if (!exportMenu.classList.contains('hidden') && !trigger.contains(e.target) && !exportMenu.contains(e.target)) {
//         exportMenu.classList.add('hidden');
//         exportMenu.classList.remove('opacity-100');
//         exportMenu.classList.add('opacity-0');

//         iconFlecha.classList.remove('rotate-180');
//     }
// });


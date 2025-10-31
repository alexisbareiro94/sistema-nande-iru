import { $, $el } from '../utils'
import { renderAllUser } from '../clients-dist'
import axios from 'axios';

const modal = $('#modal-todos-clientes');
if($('#btn-ver-todos-clientes')){
    $el('#btn-ver-todos-clientes', 'click', () => {
        modal.classList.remove('hidden');    
    });
}

if($('#cerrar-modal-todos-cliente')){
    $el('#cerrar-modal-todos-cliente', 'click', () => {
        modal.classList.add('hidden');
    });
}

if(modal){
    modal.addEventListener('click', e => {
        if(e.target == modal){
            modal.classList.add('hidden');
        }
    })   
}

let timer;
if($('#todos-clientes-input')){
    $el('#todos-clientes-input', 'input', e => {
        e.preventDefault();
        const q = e.target.value.trim();
        console.log(q)
        clearTimeout(timer);
        timer = setTimeout(async () => {
            try{
                const res = await axios.get(`api/users?q=${q}`);                
                console.log(res)
                renderAllUser(res.data.users);
            }catch(err){
                console.error(err)
            }
        },300);
    });
}
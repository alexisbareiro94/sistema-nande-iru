import { csrfToken } from './csrf-token';
import {showToast} from './toast';

let userId = '';
function selectUser(){
    document.getElementById('edit-user').addEventListener('change', async (e)=>{
        const name = document.getElementById('name-selected');
        const email = document.getElementById('email-selected');
        const rol = document.getElementById('rol-selected');
        const salario = document.getElementById('salario-selected');
        userId = e.target.value;        
        try{    
            const res = await fetch(`http://127.0.0.1:80/api/gestion_user/${e.target.value}`);
            const data = await res.json();
            if(!res.ok){
                throw data;
            }
            name.value = data.data.name;
            email.value = data.data.email;
            salario.value = `${data.data.salario}`;  
        }catch(err){
            console.log(err.error)
        }
    }); 
}
selectUser();

document.getElementById('update-personal-form').addEventListener('submit', async (e)=>{
    e.preventDefault();        
    const name = document.getElementById('name-selected').value;
    const email = document.getElementById('email-selected').value;
    const rol = document.getElementById('rol-selected').value;
    const salario = document.getElementById('salario-selected').value;

    try{
        const formData = new FormData();
        formData.append('name', name);
        formData.append('email', email);
        formData.append('rol', rol);
        formData.append('salario', salario);

        const res = await fetch(`http://127.0.0.1:80/api/gestion_user/${userId}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
            },
            body: formData,
        });
        const data = await res.json();
        if(!res.ok){
            throw data
        }
        showToast('Usuario Actualizado');
    }catch(err){
        console.log(err)
    }
});
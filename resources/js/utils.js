export const $ = el => document.querySelector(el);
export const $$ = el => document.querySelectorAll(el);
export const $i = el => document.getElementById(el);

export const $el = (el, event, callback) => {
    return document.querySelector(el).addEventListener(event, callback)
}

export const $eli = (el, event, callback) => {
    return document.getElementById(el).addEventListener(event, callback)
}

export const url = 'http://127.0.0.1:80/api'

export const formatFecha = value => {
    const fecha = new Date(value);
    return fecha.toLocaleString('es-PY', {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit',
        hour12: false
    }).replace(',', ' -');
}
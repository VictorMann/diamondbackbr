// Url Base
const BASE_URL = 'http://localhost/diamondback-laravel/public/';

// valida envio do formulário
document.querySelector('#search').addEventListener('submit', function(event) {
    let valueBusca = this.elements.s.value.trim();
    if (!valueBusca) event.preventDefault();
});

// newsletter
document.querySelector('#form-newsletter').addEventListener('submit', function(event) {
    
    event.preventDefault();

    let dado = _queryStringURL({email: this.elements.email.value});

    this.elements.email.value = '';

    fetch(`${BASE_URL}cadastro/newsletter?${dado}`)
    .then(res => res.ok ? res.text() : Promise.reject(res.statusText))
    .then(res => {
        console.log(res);
        alert("Diamondback » newsletter\n====================================\n\nEmail Cadastrado com sucesso!");
    })
    .catch(console.log);
});

function _queryStringURL(obj) {
    if (typeof(obj) != 'object') throw TypeError();
    let query = [], typeValid = ['string', 'number'];
    for (let prop in obj) 
        typeValid.includes(typeof(obj[prop])) 
        && query.push(`${prop}=${encodeURIComponent(obj[prop])}`);
    return query.join('&');
}

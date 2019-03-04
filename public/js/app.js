// Url Base
const BASE_URL = 'http://192.168.0.4/dl/public/';

// valida envio do formulário
document.querySelector('.search').addEventListener('submit', function(event) {
    let valueBusca = this.elements.s.value.trim();
    if (!valueBusca) event.preventDefault();
});

document.querySelector('.menu-mobile')
.addEventListener('click', function(event) {
    document.documentElement.classList.toggle('menu-ativo');
});

function fechaMenuMobile() {
    document.documentElement.classList.remove('menu-ativo');
}

// fecha menu mobile ao clicar em shadow
document.documentElement
.addEventListener('click', event =>
    event.target == document.documentElement 
    && fechaMenuMobile()
);

// fecha ao clicar no x
document.querySelector('.nav-main .close')
.addEventListener('click', event =>
    fechaMenuMobile()
);

document.querySelectorAll('.nav-main a[href="#"]').forEach(a => {
    a.addEventListener('click', function(event) {

        let sub = this.parentNode.querySelector('.nav-sub');

        document.querySelectorAll('.nav-main .nav-sub').forEach(el =>
            sub != el && el.classList.remove('show')
        );
        
        sub.classList.toggle('show');
    });
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

/**
 * Cria query-string através de um objeto
 * @param {Object} obj 
 * @return {String}
 */
function _queryStringURL(obj) {
    if (typeof(obj) != 'object') throw TypeError();
    let query = [], typeValid = ['string', 'number'];
    for (let prop in obj) 
        typeValid.includes(typeof(obj[prop])) 
        && query.push(`${prop}=${encodeURIComponent(obj[prop])}`);
    return query.join('&');
}

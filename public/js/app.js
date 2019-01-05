// Url Base
const BASE_URL = 'http://localhost/diamondback-laravel/public/';

// valida envio do formulário
$('#search').on('submit', function(e) {
    let valueBusca = this.elements.s.value.trim();
    if (!valueBusca) e.preventDefault();
});


// newsletter
$('#form-newsletter').submit(function(e) {
    
    e.preventDefault();

    let dado = $.param({email: this.elements.email.value});

    this.elements.email.value = '';

    fetch(`${BASE_URL}cadastro/newsletter?${dado}`)
    .then(res => res.ok ? res.text() : Promise.reject(res.statusText))
    .then(res => {
        console.log(res);
        alert("Diamondback » newsletter\n====================================\n\nEmail Cadastrado com sucesso!");
    })
    .catch(console.log);
});
// valida envio do formulário
$('#search').on('submit', function(e) {
    let valueBusca = this.elements.s.value.trim();
    if (!valueBusca) e.preventDefault();
});

// newsletter
$('#form-newsletter').submit(function(e) {
    
    e.preventDefault();

    let dado = {email: this.elements.email.value};

    this.elements.email.value = '';

    $.get('http://localhost/laravel/public/cadastro/newsletter', dado, (data, status) => {
        if (status == 'success') {
            console.log(data);
            alert("Diamondback » newsletter\n====================================\n\nEmail Cadastrado com sucesso!");
        }
    });
});
// valida envio do formulário
$('#search').on('submit', function(e) {
    let valueBusca = this.elements.s.value.trim();
    if (!valueBusca) e.preventDefault();
});
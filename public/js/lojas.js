const $elEstMap = $('.mapa-img-estado-hover');
var revendas = {};

$('area').on({
    'mouseover': function(e) {
        let est = this.dataset.e;
        $elEstMap.css('background-image', () =>
            revendas[est] && revendas[est].qtd
            ? `url(imgs/mapa/${est}_ativo.gif)`
            : `url(imgs/mapa/${est}_.gif)`
        );
    },
    'mouseout': function(e) {
        $elEstMap.css('background-image', '');
    },
    'click': function(e) {
        let est = this.dataset.e;
        if (!(revendas[est] && revendas[est].qtd)) {
            e.preventDefault();
        }
    }
});

$.get('api/revendas-per-estado', (data, status) => {
    if (status == 'success') {
        data.forEach(est => 
            revendas[est.abbr] = {
                'nome': est.nome,
                'qtd': est.qtd
            }
        );
    }
});

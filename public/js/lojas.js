const $elEstMap = $('.mapa-img-estado-hover');
const $elMinEst = $('.ctn-mini-estado');
var revendas = {};

$('area').on({
    'mouseover': function(e) {
        let est = this.dataset.e;
        $elEstMap.css('background-image', () =>
            revendas[est] && revendas[est].qtd
            ? `url(imgs/mapa/${est}_ativo.gif)`
            : `url(imgs/mapa/${est}_.gif)`
        );

        $elMinEst.find('.ctn-image').append($('<img>', {'src': `imgs/mapa/${est}.gif`}));
        $elMinEst.find('.dados').html(() => {
            let message = revendas[est].qtd 
            ? revendas[est].qtd + ' revenda(s)'
            : 'não há revendas';
            return `${revendas[est].nome}<span class="rev">${message}</span>`;
        });
    },
    'mouseout': function(e) {
        $elEstMap.css('background-image', '');
        $elMinEst.find('div').empty();
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

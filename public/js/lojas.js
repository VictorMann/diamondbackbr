const $elEstMap = $('.mapa-img-estado-hover');
const $elMinEst = $('.ctn-mini-estado');
var revendas = {};

$('area').on({
    'mouseover': function(e) {
        let est = this.dataset.e;
        $elEstMap.css('background-image', () =>
            revendas[est] && revendas[est].qtd > 0
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
        !revendas[est].qtd && e.preventDefault();
    }
});

fetch('api/revendas-per-estado')
.then(res => res.ok ? res.json() : Promise.reject(res.statusText))
.then(estados => estados.forEach(est => 
    revendas[est.abbr] = {
        'nome': est.nome,
        'qtd': parseInt(est.qtd)
    }
))
.catch(console.error);
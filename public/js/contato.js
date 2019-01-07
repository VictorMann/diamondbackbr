$('.form-contato').submit(function(e) {

    console.log('interceptado!');

    $(this)
    .find(':submit')
    .replaceWith($('<img>', {
        src: 'imgs/loading.gif',
        width: '30px'
    }));
});

document.querySelector('#name').focus();


if (location.hash == '#rev') {

    $('#comment')
    .text("Desejo fazer parte do time Diamondback!\n\nAguardo o retorno.\n\nAtt")
    .attr('disabled', 'disabled')
    .siblings('.inf')
    .addClass('active');

    setTimeout(() => document.querySelector('#comment').removeAttribute('disabled'), 3000);
    

    $('html, body').animate({scrollTop: $('#contato-title').offset().top - 20}, 700);
}






$('.form-contato').submit(function(e) {

    console.log('interceptado!');

    $(this)
    .find(':submit')
    .replaceWith($('<img>', {
        src: 'imgs/loading2.gif',
        width: '30px'
    }));
});
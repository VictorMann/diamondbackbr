$('.sel').slick({
    autoplay: true,
    dots: true
});
$('.slick-arrow').each(function(i) {
    this.innerHTML = i == 0
    ? '<span class="glyphicon glyphicon-chevron-left"></span>'
    : '<span class="glyphicon glyphicon-chevron-right"></span>';
});


let c = carrosselResponsive();
$(window).resize(c);
c();

function carrosselResponsive() {
    let w = $(':root')
    , sel = $('.sel')
    , li  = sel.find('li.wb');
    return event => {

        if (w.innerWidth() <= 425)
        {
            if (sel.attr('data-w') != 'mobile')
            {
                sel.attr('data-w', 'mobile');
                li.empty().removeClass('wb').each(function() {
                    let img = new Image();
                    img.src = `imgs/carrossel/m/${this.dataset.p2}`;
                    $(this).append(img);
                });
            }
        }
        else
        {
            if (sel.attr('data-w') != 'desk')
            {
                sel.attr('data-w', 'desk');
                li.empty().removeClass('wb').each(function() {
                    let img = new Image();
                    img.src = `imgs/carrossel/${this.dataset.p1}`;
                    $(this).append(img);
                });
            }
        }
    };
}
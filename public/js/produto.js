// imagem principal
const img_primary = $('.pr-img').find('img');

// altera as imagens de miniatura pela principal
$('.pr-thumbnail li').click(function(e) {
    const src_img_mini = $(this).find('img').attr('src');
    img_primary.attr('src', src_img_mini);
});
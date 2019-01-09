

// altera as imagens de miniatura pela principal
$('.pr-thumbnail li:first').click(function(e) {
    e.preventDefault();
    $('.pr-img a').trigger('click');
});

$(".fancybox-gallery").fancybox();

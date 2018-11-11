$('.sel').slick({
    autoplay: true,
    dots: true
});
$('.slick-arrow').each(function(i) {
    this.innerHTML = i == 0
    ? '<span class="glyphicon glyphicon-chevron-left"></span>'
    : '<span class="glyphicon glyphicon-chevron-right"></span>';
});
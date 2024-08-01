$(document).ready(function(){
    $('.slider').slick({
        dots: true,
        infinite: true,
        speed: 500,
        slidesToShow: 1,
        adaptiveHeight: true,
        prevArrow: '<button type="button" class="slick-prev">Previous</button>',
        nextArrow: '<button type="button" class="slick-next">Next</button>'
    });
});

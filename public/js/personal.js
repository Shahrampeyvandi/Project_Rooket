$(document).ready(function () {









    $('.owl-carousel').owlCarousel({
        loop:false,
        margin:10,
        nav:true,
        rtl:true,
        responsive:{
            0:{
                items:1
            },
            600:{
                items:2
            },
            1000:{
                items:2
            }
        }
    });
});

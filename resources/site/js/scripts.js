$(document).ready(function () {
    $('#mainPageSlider').carousel({
        interval: 5000
    });

    // if ($(window).width() > 991) {
    //     $('.fotorama').on('fotorama:load', function (e, fotorama, extra) {
    //         $('.fotorama__stage__shaft .fotorama__active > img').attr('id', 'zoomit');
    //         $('#zoomit').elevateZoom({
    //             zoomWindowPosition: "preview-container",
    //             zoomWindowHeight: 400,
    //             zoomWindowWidth: 400,
    //             borderSize: 0,
    //             easing: true,
    //             scrollZoom: true
    //         });
    //     });
    //     $('.fotorama').on('fotorama:showend', function (e, fotorama, extra) {
    //         $('.fotorama__stage__shaft .fotorama__stage__frame > img').attr('id', '');
    //         $('.zoomContainer').remove();
    //         $('.fotorama__stage__shaft .fotorama__active > img').attr('id', 'zoomit');
    //         $('#zoomit').elevateZoom({
    //             zoomWindowPosition: "preview-container",
    //             zoomWindowHeight: 400,
    //             zoomWindowWidth: 400,
    //             borderSize: 0,
    //             easing: true,
    //             scrollZoom: true
    //         });
    //     });
    // }


    $(".quantity-input").each(function(){
        $(this).find("input").on('change',function () {
        let value = $(this).val();
        if (value < 1) {
            $(this).val(1);
        }
    })});

    if ($(window).width() < 768) {
        $('#openMobileSearch').on('click', function () {
            $('#searchForm').toggleClass('d-block');
            $('.block-page').toggleClass('d-block');
        });
        $('.block-page').on('click', function () {
            $('#searchForm').removeClass('d-block');
            $('.block-page').removeClass('d-block');
            $('#filters').removeClass('d-block');
            $('#mobileShowFilters').find('.fas').removeClass('rotate-180');

        })
        $('#mobileShowFilters').on('click', function () {
            $('.block-page').toggleClass('d-block');
            $('#filters').toggleClass('d-block');
            $(this).find('.fas').toggleClass('rotate-180');
        })
        $('#dashboardMenuBtn').on('click', function(){
            $('#dashboardMenu').toggleClass('d-block');
            $(this).find('.fas').toggleClass('rotate-180');
        });
    }
    $("#recommendations-list").owlCarousel({
        items: 6,
        loop: false,
        rewind: true,
        margin: 10,
        nav: true,
        rtl: true,
        navText: ['<i class="fa fa-angle-left" aria-hidden="true"></i>', '<i class="fa fa-angle-right" aria-hidden="true"></i>'],
        responsiveClass: true,
        responsive: {
            0: {
                items: 2,
                margin: 1
            },
            480: {
                items: 3,
            },
            992: {
                items: 6,
            }
        }
    });

    $("#patterns-list").owlCarousel({
        items: 4,
        loop: false,
        rewind: true,
        margin: 15,
        nav: true,
        autoHeight: false,
        rtl: true,
        navText: ['<i class="fa fa-angle-left" aria-hidden="true"></i>', '<i class="fa fa-angle-right" aria-hidden="true"></i>'],
        responsiveClass: true,
        responsive: {
            0: {
                items: 1,
            },
            480: {
                items: 2,
            },
            992: {
                items: 4,
            }
        }
    });

    $("#related-list").owlCarousel({
        items: 4,
        loop: false,
        rewind: true,
        margin: 10,
        nav: true,
        rtl: true,
        navText: ['<i class="fa fa-angle-left" aria-hidden="true"></i>', '<i class="fa fa-angle-right" aria-hidden="true"></i>'],
        responsiveClass: true,
        responsive: {
            0: {
                items: 2,
                margin: 1,
            },
            480: {
                items: 3,
            },
            992: {
                items: 4,
            }
        }
    });

    $('#openNav').on('click', function () {
        if ($('#mobileNav').hasClass('w-100')) {
            $('#mobileNav').removeClass('w-100');
            $('body').removeClass('no-scroll');
            $('nav').removeClass('fixed');
        } else {
            let scroll = $(window).scrollTop();
            if (scroll > 48) {
                $('nav').addClass('fixed');
            }
            let offset = scroll > 48 ? $('#openNav').outerHeight() + 1 : $('#openNav').outerHeight() + 49 - scroll;
            $('body').addClass('no-scroll');
            $('#mobileNav').css('top', offset).addClass('w-100');
        }
    });
    $(".product-quantity-minus").each(function(){
        $(this).on('click',function () {
            let quantitInput = $(this).siblings('input');
            let currentVal = parseInt(quantitInput.val(), 10) > 1 ? parseInt(quantitInput.val(), 10) - 1 : 1;
            quantitInput.val(currentVal);
        })});

    $(".product-quantity-plus").each(function(){
        $(this).on('click',function () {
            let quantitInput = $(this).siblings('input');
            let currentVal = parseInt(quantitInput.val(), 10) + 1;
            quantitInput.val(currentVal);
        })});
    if ($(window).width() < 769) {
        $('.navbar__item__btn').each(function(){
            $(this).on('click', function () {
                $(this).toggleClass('rotate-180');
                $(this).parent().siblings('.mega-menu__content').toggleClass('d-block');
            });
        })
    }
});

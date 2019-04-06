import '../sass/main.scss'
$('document').ready(function () {
    $('video, audio').mediaelementplayer({
        audioWidth: '100%'
    });

    $('.btn-hamburguer-menu').on('click', function () {
        $('.navigation').find('.menu').slideToggle();
        $(this).toggleClass('active');

        if ($(window).width() <= 991) {
            $('.navigation').find('.dropdown').on('click', function () {
                $(this).find('.droplist').slideToggle()
            })
        }

        return false
    });

    $('.gallery-zoom').magnificPopup({
        type: 'image',

        gallery: {
            enabled: true
        },

        image: {
            titleSrc: 'title'
        },

        zoom: {
            enabled: true,
            duration: 300,
            easing: 'ease-in-out',
            opener: function (openerElement) {
                return openerElement.is('img') ? openerElement : openerElement.find('img')
            }
        }
    });

    $('.form-validate').validate();
    $('.form-newsletter').validate({
        errorPlacement: (error, element) => {
            console.log(error, element)
        }
    });

    $('input, textarea').placeholder();

    if ($('.header.sticky').length) {
        let stickyOffset = $('.header.sticky').attr('data-offset');
        if (typeof stickyOffset !== typeof undefined && stickyOffset !== false) {
            stickyOffset = parseInt(stickyOffset)
        } else {
            stickyOffset = 60
        }

        $(window).on('scroll', function () {
            let top = $('.header.sticky').offset().top;
            if (top >= stickyOffset) {
                $('.header.sticky').addClass('scrolling')
            } else {
                $('.header.sticky').removeClass('scrolling')
            }
        });

        $(window).trigger('scroll')
    }

    $('#map').one('click', function () {
        $(this).addClass('touch')
    });

    $('.goto').on('click', function () {
        let to = $(this).attr('href');
        $('html, body').animate({
            scrollTop: ($(to).offset().top)
        }, 1000);
        return false
    })
});

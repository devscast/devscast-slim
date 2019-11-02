(function ($) {
    "use strict";
    jQuery(document).on('ready', function () {
        $('.navbar-light .navbar-nav li a').on('click', function (e) {
            let anchor = $(this);
            $('html, body').stop().animate({
                scrollTop: $(anchor.attr('href')).offset().top - 50
            }, 1500);
            e.preventDefault();
        });
        $('.navbar .navbar-nav li a').on('click', function () {
            $('.navbar-collapse').collapse('hide');
        });

        $(window).on('scroll', function () {
            if ($(this).scrollTop() > 120) {
                $('.navbar').addClass("is-sticky");
            } else {
                $('.navbar').removeClass("is-sticky");
            }
        });

        $('.projects-slides').owlCarousel({
            loop: true,
            nav: true,
            dots: false,
            autoplayHoverPause: true,
            autoplay: true,
            mouseDrag: true,
            margin: 30,
            navText: [
            "<i class='flaticon-left-arrow'></i>",
            "<i class='flaticon-right-arrow'></i>"
            ],
            responsive: {
                0: {
                    items: 1,
                },
                576: {
                    items: 2,
                },
                768: {
                    items: 2,
                },
                1024: {
                    items: 3,
                },
                1200: {
                    items: 4,
                }
            }
        });

        $('.testimonials-slides').owlCarousel({
            loop: true,
            nav: true,
            dots: false,
            items: 1,
            autoplayHoverPause: true,
            autoplay: true,
            animateOut: 'fadeOut',
            navText: [
            "<i class='flaticon-left-arrow'></i>",
            "<i class='flaticon-right-arrow'></i>"
            ],
        });

        $('.team-slides').owlCarousel({
            loop: true,
            nav: true,
            dots: false,
            autoplayHoverPause: true,
            autoplay: true,
            mouseDrag: true,
            margin: 30,
            navText: [
            "<i class='flaticon-left-arrow'></i>",
            "<i class='flaticon-right-arrow'></i>"
            ],
            responsive: {
                0: {
                    items: 1,
                },
                576: {
                    items: 2,
                },
                768: {
                    items: 3,
                },
                1024: {
                    items: 4,
                },
                1200: {
                    items: 4,
                }
            }
        });

        $('.projects-image-slides').owlCarousel({
            loop: true,
            nav: true,
            dots: false,
            autoplayHoverPause: true,
            autoplay: true,
            mouseDrag: true,
            margin: 30,
            navText: [
            "<i class='flaticon-left-arrow'></i>",
            "<i class='flaticon-right-arrow'></i>"
            ],
            responsive: {
                0: {
                    items: 1,
                },
                768: {
                    items: 2,
                },
                1200: {
                    items: 2,
                },
            }
        });

        if ($('.progress-line').length) {
            $('.progress-line').appear(function () {
                let el = $(this);
                let percent = el.data('width');
                $(el).css('width', percent + '%');
            }, {accY: 0});
        }
        if ($('.count-box').length) {
            $('.count-box').appear(function () {
                let $t = $(this),
                n = $t.find(".count-text").attr("data-stop"),
                r = parseInt($t.find(".count-text").attr("data-speed"), 10);

                if (!$t.hasClass("counted")) {
                    $t.addClass("counted");
                    $({
                        countNum: $t.find(".count-text").text()
                    }).animate({
                        countNum: n
                    }, {
                        duration: r,
                        easing: "linear",
                        step: function () {
                            $t.find(".count-text").text(Math.floor(this.countNum));
                        },
                        complete: function () {
                            $t.find(".count-text").text(this.countNum);
                        }
                    });
                }

            }, {accY: 0});
        }

      // Partner Slides
        $('.partner-slides').owlCarousel({
            loop: true,
            nav: false,
            dots: false,
            autoplayHoverPause: true,
            autoplay: true,
            mouseDrag: true,
            margin: 30,
            navText: [
            "<i class='flaticon-left-arrow'></i>",
            "<i class='flaticon-right-arrow'></i>"
            ],
            responsive: {
                0: {
                    items: 2,
                },
                576: {
                    items: 3,
                },
                768: {
                    items: 4,
                },
                1200: {
                    items: 6
                }
            }
        });
    });

    $(window).on('load', function () {
        $('.preloader').addClass('preloader-deactivate');
    });
}(jQuery));

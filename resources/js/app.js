/*
 * This file is part of the devcast.
 *
 * (c) Bernard Ng <ngandubernard@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

$('document').ready(function() {
    Array.from(document.querySelectorAll('video, audio')).forEach(function(node) {
        if (!node.hasAttribute('data-devscast-initialized')) {
            node.setAttribute('data-devscast-initialized', 'true')
            $(node).mediaelementplayer({
                audioWidth: '100%'
            })
        }
    })

    let menu = document.querySelector('.btn-hamburguer-menu');
    if (menu) {
        menu.addEventListener('click', function(e) {
            e.preventDefault()
            $('.navigation').find('.menu').slideToggle()
            this.classList.toggle('active')

            if ($(window).width() <= 991) {
                $('.navigation').find('.dropdown').on('click', function() {
                    $(this).find('.droplist').slideToggle()
                })
            }
        })
    }

    Array.from(document.querySelectorAll('.gallery-zoom')).forEach(function(node) {
        if (!node.hasAttribute('data-devscast-initialized')) {
            node.setAttribute('data-devscast-initialized', 'true')

            let settings = {
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
                    opener(openerElement) {
                        return openerElement.is('img') ? openerElement : openerElement.find('img')
                    }
                }
            }

            $(node).magnificPopup(settings)
        }
    })

    if ($('.header.sticky').length) {
        let stickyOffset = $('.header.sticky').attr('data-offset')
        if (typeof stickyOffset !== typeof undefined && stickyOffset !== false) {
            stickyOffset = parseInt(stickyOffset)
        } else {
            stickyOffset = 60
        }

        $(window).on('scroll', function() {
            let top = $('.header.sticky').offset().top
            if (top >= stickyOffset) {
                $('.header.sticky').addClass('scrolling')
            } else {
                $('.header.sticky').removeClass('scrolling')
            }
        })

        $(window).trigger('scroll')
    }


    let map = document.querySelector('#map')
    if (map) {
        map.addEventListener('click', function(e) {
            e.preventDefault()
            if (!this.hasAttribute('data-devscast-initialized')) {
                this.setAttribute('data-devscast-initialized', 'true')
                this.classList.add('touch')
            }
        })
    }
})
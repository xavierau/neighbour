/*=============================================================
 Authour URL: www.designbootstrap.com

 http://www.designbootstrap.com/

 License: MIT

 http://opensource.org/licenses/MIT

 100% Free To use For Personal And Commercial Use.

 IN EXCHANGE JUST TELL PEOPLE ABOUT THIS WEBSITE

 ========================================================  */

$(document).ready(function () {

    /*====================================
     SCROLLING SCRIPTS
     ======================================*/

    $('.scroll-me a').bind('click', function (event) { //just pass scroll-me in design and start scrolling
        var $anchor = $(this);
        $('html, body').stop().animate({
            scrollTop: $($anchor.attr('href')).offset().top
        }, 1200, 'easeInOutExpo');
        event.preventDefault();
    });


    /*====================================
     SLIDER SCRIPTS
     ======================================*/


    $('#carousel-slider').carousel({
        interval: 2000 //TIME IN MILLI SECONDS
    });


    /*====================================
     VAGAS SLIDESHOW SCRIPTS
     ======================================*/
    $.vegas('slideshow', {
        delay:15000,
        backgrounds:[
            {src: '/img/DSC00368_new.jpg', fade:1000},
            {src: '/img/1_new.jpg', fade:1000},
            {src: '/img/2_new.jpg', fade:1000},
            {src: '/img/3_new.jpg', fade:1000},
            {src: '/img/4_new.jpg', fade:1000},
            {src: '/img/5_new.jpg', fade:1000}
        ]
    })('overlay', {
        src:'/assets/js/vegas/overlays/06.png'
    });


    /*====================================
     POPUP IMAGE SCRIPTS
     ======================================*/
    $('.fancybox-media').fancybox({
        openEffect: 'elastic',
        closeEffect: 'elastic',
        helpers: {
            title: {
                type: 'inside'
            }
        }
    });


    /*====================================
     FILTER FUNCTIONALITY SCRIPTS
     ======================================*/
    $(window).load(function () {
        var $container = $('#work-div');
        $container.isotope({
            filter: '*',
            animationOptions: {
                duration: 750,
                easing: 'linear',
                queue: false
            }
        });
        $('.caegories a').click(function () {
            $('.caegories .active').removeClass('active');
            $(this).addClass('active');
            var selector = $(this).attr('data-filter');
            $container.isotope({
                filter: selector,
                animationOptions: {
                    duration: 750,
                    easing: 'linear',
                    queue: false
                }
            });
            return false;
        });

    });


    /*====================================
     WRITE YOUR CUSTOM SCRIPTS BELOW
     ======================================*/

    $(document).click(function (event) {
        var clickover = $(event.target);
        var _opened = $(".navbar-collapse").hasClass("navbar-collapse collapse in");
        if (_opened === true && !clickover.hasClass("navbar-toggle")) {
            $("button.navbar-toggle").click();
        }
    });

});

jQuery(document).ready(function($) {
    
    // Mobile menu toggle - Updated với prefix slp-
    $('.slp-mobile-menu-toggle').on('click', function() {
        $('.slp-mobile-menu').toggleClass('active');
        $(this).toggleClass('active');
        
        // Animate hamburger
        if ($(this).hasClass('active')) {
            $(this).find('span:nth-child(1)').css('transform', 'rotate(45deg) translateY(8px)');
            $(this).find('span:nth-child(2)').css('opacity', '0');
            $(this).find('span:nth-child(3)').css('transform', 'rotate(-45deg) translateY(-8px)');
        } else {
            $(this).find('span').css({
                'transform': 'none',
                'opacity': '1'
            });
        }
    });
    
    // Close mobile menu when clicking outside
    $(document).on('click', function(e) {
        if (!$(e.target).closest('.slp-header-container').length) {
            $('.slp-mobile-menu').removeClass('active');
            $('.slp-mobile-menu-toggle').removeClass('active');
            $('.slp-mobile-menu-toggle span').css({
                'transform': 'none',
                'opacity': '1'
            });
        }
    });
    
    // Smooth scroll
    $('a[href^="#"]').on('click', function(e) {
        var target = $(this.getAttribute('href'));
        if(target.length) {
            e.preventDefault();
            $('html, body').stop().animate({
                scrollTop: target.offset().top - 80
            }, 1000);
        }
    });
    
    // Sticky header on scroll
    var header = $('.slp-header');
    var headerHeight = header.outerHeight();
    
    $(window).scroll(function() {
        if ($(this).scrollTop() > 100) {
            header.addClass('scrolled');
        } else {
            header.removeClass('scrolled');
        }
    });
    
    // Slider logic (shared cho Phim đang chiếu & Phim sắp chiếu)
    function initSlpSlider($slider) {
        var $track = $slider.find('.slp-slider-track');
        var $cards = $track.find('.slp-slider-card');
        var $prev  = $slider.find('.slp-slider-prev');
        var $next  = $slider.find('.slp-slider-next');

        if (!$cards.length) {
            $prev.addClass('is-disabled');
            $next.addClass('is-disabled');
            return;
        }

        if ($cards.length <= 3) {
            $track.addClass('is-compact');
            if ($cards.length <= 1) {
                $slider.addClass('slp-slider-static');
            }
        }

        function getStep() {
            var step = $cards.first().outerWidth(true);
            if (!step) {
                step = $track.width() * 0.8;
            }
            return step;
        }

        function updateNavState() {
            var scrollLeft = $track.scrollLeft();
            var maxScroll  = $track[0].scrollWidth - $track.outerWidth();

            if (scrollLeft <= 5) {
                $prev.addClass('is-disabled');
            } else {
                $prev.removeClass('is-disabled');
            }

            if (scrollLeft >= maxScroll - 5) {
                $next.addClass('is-disabled');
            } else {
                $next.removeClass('is-disabled');
            }
        }

        function scrollByStep(direction) {
            var step = getStep();
            var current = $track.scrollLeft();
            var target  = direction === 'next' ? current + step : current - step;

            $track.stop().animate({ scrollLeft: target }, 380, 'swing', updateNavState);
        }

        $prev.on('click', function() {
            if (!$(this).hasClass('is-disabled')) {
                scrollByStep('prev');
            }
        });

        $next.on('click', function() {
            if (!$(this).hasClass('is-disabled')) {
                scrollByStep('next');
            }
        });

        $track.on('scroll', function() {
            window.requestAnimationFrame(updateNavState);
        });

        $(window).on('resize', function() {
            window.requestAnimationFrame(updateNavState);
        });

        updateNavState();
    }

    $('[data-slp-slider]').each(function() {
        initSlpSlider($(this));
    });
});

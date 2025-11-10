jQuery(document).ready(function($) {
    
    // Mobile menu toggle
    $('.mobile-menu-toggle').on('click', function() {
        $('.mobile-menu').toggleClass('active');
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
        if (!$(e.target).closest('.header-container').length) {
            $('.mobile-menu').removeClass('active');
            $('.mobile-menu-toggle').removeClass('active');
            $('.mobile-menu-toggle span').css({
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
    var header = $('.site-header');
    var headerHeight = header.outerHeight();
    
    $(window).scroll(function() {
        if ($(this).scrollTop() > 100) {
            header.addClass('scrolled');
        } else {
            header.removeClass('scrolled');
        }
    });
    
});


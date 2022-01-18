jQuery(document).ready(function($) {

    //chic js start

    var slider_auto, slider_loop, rtl;

    if (chic_lite_data.auto == '1') {
        slider_auto = true;
    } else {
        slider_auto = false;
    }

    if (chic_lite_data.loop == '1') {
        slider_loop = true;
    } else {
        slider_loop = false;
    }

    if (chic_lite_data.rtl == '1') {
        rtl = true;
    } else {
        rtl = false;
    }

    //header search toggle js
    //  $('.header-search .search-toggle').click(function() {
    //      ('.search-modal').addClass('active');
    //  });

    $('.header-search .search-modal').click(function(e) {
        e.stopPropagation();
    });

    $(window).click(function() {
        $('.header-search .search-modal').removeClass('active');
    });

    $(window).on('load resize', function() {
        if ($(window).width() < 1025) {
            $('.style-two .secondary-menu .toggle-btn').click(function(e) {
                $('.secondary-menu .mobile-menu').slideDown();
            });

            $('.style-two .secondary-menu .close').click(function(e) {
                $('.secondary-menu .mobile-menu').slideUp();
            });

            $(window).on('keyup', function(event) {
                if (event.key == 'Escape') {
                    $('.secondary-menu .mobile-menu').slideUp();
                }
            });
        }
    });

    $('.site-header .secondary-menu .toggle-btn').click(function() {
        $('body').addClass('menu-active');
        $(this).siblings('div').animate({
            width: 'toggle',
        });
    });

    $('.site-header .secondary-menu .close').click(function() {
        $('body').removeClass('menu-active');
        $(this).parent('div').animate({
            width: 'toggle',
        });
    });

    $('.main-navigation .toggle-btn').click(function() {
        $('body').addClass('menu-active');
        $(this).siblings('div').animate({
            width: 'toggle',
        });
    });

    $('.main-navigation .close').click(function() {
        $('body').removeClass('menu-active');
        $(this).parent('div').animate({
            width: 'toggle',
        });
    });

    $(window).on('keyup', function(event) {
        if (event.key == 'Escape') {
            $('.header-search .search-modal').removeClass('active');
        }
    });

    if ($('.secondary-menu').length) {
        var ps = new PerfectScrollbar('.secondary-menu .nav-menu', {
            wheelSpeed: 0.5,
            wheelPropagation: true,
            minScrollbarLength: 20
        });
    }

    //for accessibility 
    $('.header-search-wrap .search-form .search-submit').attr('tabindex', -1);
    $('.main-navigation ul li a, .secondary-menu ul li a, .submenu-toggle').focus(function() {
        $(this).parents('li').addClass('focused');
    }).blur(function() {
        $(this).parents('li').removeClass('focused');
    });

    //Banner slider js
    $('.site-banner.style-eight .item-wrap').owlCarousel({
        items: 1,
        autoplay: slider_auto,
        loop: slider_loop,
        nav: true,
        dots: false,
        autoplaySpeed: 800,
        autoplayTimeout: 3000,
        rtl: rtl,
    });

    //promo section js
    $('.promo-section .raratheme-itw-holder').addClass('owl-carousel');

    if ($('.promo-section .raratheme-itw-holder li').length > 3) {
        owlLoop = true;
    } else {
        owlLoop = false;
    }

    $('.promo-section .raratheme-itw-holder').owlCarousel({
        items: 3,
        margin: 30,
        autoplay: false,
        loop: owlLoop,
        nav: true,
        dots: false,
        autoplaySpeed: 800,
        autoplayTimeout: 3000,
        rtl: rtl,
        responsive: {
            0: {
                items: 1,
            },
            768: {
                items: 2,
            },
            1025: {
                items: 3,
            }
        }
    });

    //add span in widget title
    $('.site-footer .widget .widget-title').wrapInner('<span></span>');

    //scroll to top js
    $(window).scroll(function() {
        if ($(window).scrollTop() > 200) {
            $('.back-to-top').addClass('active');
        } else {
            $('.back-to-top').removeClass('active');
        }
    });

    $('.back-to-top').click(function() {
        $('body,html').animate({
            scrollTop: 0,
        }, 600);
    });

    //toggle social share
    $('body[class*="post-layout-"] .site-main article .social-share .share-icon').click(function(e) {
        $('.social-share').removeClass('active');
        $(this).parent('.social-share').addClass('active');
        e.stopPropagation();
    });

    $(window).click(function() {
        $('.social-share').removeClass('active');
    });

    $('.widget_raratheme_image_text_widget .raratheme-itw-holder li .btn-readmore').wrap('<div class="btn-holder"></div>');

    //single post layout article meta js
    if ($('.single-post .site-main .article-meta').length) {
        $('.single-post .site-main article').addClass('has-article-meta');
    }

    //alignfull js
    $(window).on('load resize', function() {
        var metaWidth;
        if ($(window).width() > 1024) {
            metaWidth = $('.single .site-main .article-meta').outerWidth() + 50;
        } else {
            metaWidth = $('.single .site-main .article-meta').outerWidth() + 30;
        }
        var gbWindowWidth = $(window).width();
        var gbContainerWidth = $('.chic-lite-has-blocks .site-content > .container').width();
        var gbContentWidth;
        if ($('.single-post .site-main .article-meta').length) {
            if ($(window).width() > 767) {
                gbContentWidth = $('.chic-lite-has-blocks .site-main .entry-content').width() - metaWidth;
            } else {
                gbContentWidth = $('.chic-lite-has-blocks .site-main .entry-content').width();
            }
            $('.chic-lite-has-blocks.full-width .wp-block-cover-image .wp-block-cover__inner-container, .chic-lite-has-blocks.full-width .wp-block-cover .wp-block-cover__inner-container, .chic-lite-has-blocks.full-width-centered .wp-block-cover-image .wp-block-cover__inner-container, .chic-lite-has-blocks.full-width-centered .wp-block-cover .wp-block-cover__inner-container').css('padding-left', metaWidth);
        } else {
            gbContentWidth = $('.chic-lite-has-blocks .site-main .entry-content').width();
        }
        var gbMarginFull = (parseInt(gbContentWidth) - parseInt(gbWindowWidth)) / 2;
        var gbMarginFull2 = (parseInt(gbContentWidth) - parseInt(gbContainerWidth)) / 2;
        var gbMarginCenter = (parseInt(gbContentWidth) - parseInt(gbWindowWidth)) / 2;
        $(".chic-lite-has-blocks.full-width .site-main .entry-content .alignfull").css({ "max-width": gbWindowWidth, "width": gbWindowWidth, "margin-left": gbMarginFull });
        $(".chic-lite-has-blocks.full-width-centered .site-main .entry-content .alignfull").css({ "max-width": gbWindowWidth, "width": gbWindowWidth, "margin-left": gbMarginCenter });
        $(".chic-lite-has-blocks.full-width-centered .site-main .entry-content .alignwide").css({ "max-width": gbContainerWidth, "width": gbContainerWidth, "margin-left": gbMarginFull2 });
    });

    //Ajax for Add to Cart
    $('.btn-simple').click(function() {
        $(this).addClass('adding-cart');
        var product_id = $(this).attr('id');

        $.ajax({
            url: chic_lite_data.ajax_url,
            type: 'POST',
            data: 'action=chic_lite_add_cart_single&product_id=' + product_id,
            success: function(results) {
                $('#' + product_id).replaceWith(results);
            }
        }).done(function() {
            var cart = $('#cart-' + product_id).val();
            $('.cart .number').html(cart);
        });
    });

    // menubutton 
    $('<button class="submenu-toggle"><i class="fas fa-chevron-down"></i> </button>').insertAfter($('.main-menu-modal ul .menu-item-has-children > a'));
    $('.main-menu-modal  ul li .submenu-toggle').click(function () {
        $(this).toggleClass('active');
        $(this).siblings('.sub-menu').slideToggle();
    });

});
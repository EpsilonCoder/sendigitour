$ = jQuery;

jQuery(document).ready(function( $ ) {
	"use strict";

/*
** Main Navigation =====
*/
	// Navigation Hover
	$('#top-menu, #main-menu').find('li').on('mouseenter', function() {
		$(this).children('.sub-menu').stop().fadeIn( 200 );
	}).on('mouseleave', function() {
		$(this).children('.sub-menu').stop().fadeOut( 200 );
	});

	// Mobile Menu
	$('.mobile-menu-btn').on( 'click', function() {
		$('.mobile-menu-container').slideToggle();
	});

	// Responsive Menu 
	$( '#mobile-menu .menu-item-has-children' ).prepend( '<div class="sub-menu-btn"></div>' );
	$( '#mobile-menu .sub-menu' ).before( '<span class="sub-menu-btn-icon"><i class="fa fa-angle-down"></i></span>' );

	// Responsive sub-menu btn
	$('.sub-menu-btn').click(function(){
		$(this).closest('li').children('.sub-menu').slideToggle();
		$(this).closest('li').children('.sub-menu-btn-icon').children('i').toggleClass( 'fa-rotate-270' );
	});

	// Search Form
	$('.main-nav-icons').after($('.main-nav-search #searchform').remove());
	var mainNavSearch = $('#main-nav #searchform');
	
	mainNavSearch.find('#s').attr( 'placeholder', mainNavSearch.find('#s').data('placeholder') );

	$('.main-nav-search').click(function() {
		if ( mainNavSearch.css('display') === 'none' ) {
			mainNavSearch.show();
			$('.main-nav-search i:last-of-type').show();
			$('.main-nav-search i:first-of-type').hide();
			$('.dark-mode-switcher').css('visibility', 'hidden');
		} else {
			mainNavSearch.hide();
			$('.main-nav-search i:last-of-type').hide();
			$('.main-nav-search i:first-of-type').show();
			$('.dark-mode-switcher').css('visibility', 'visible');
		}
	});


/*
** Featured Slider =====
*/
	var RTL = false;
	if( $('html').attr('dir') == 'rtl' ) {
	RTL = true;
	}

	$('#featured-slider').slick({
		prevArrow: '<span class="prev-arrow icon-left-open-big"></span>',
		nextArrow: '<span class="next-arrow icon-right-open-big"></span>',
		dotsClass: 'slider-dots',
		adaptiveHeight: true,
		rtl: RTL,
		speed: 750,
  		customPaging: function(slider, i) {
            return '';
        }
	});


/*
** Single Navigation =====
*/

	var singleNav 	 = $('.single-navigation'),
		headerHeight = $('#page-header').outerHeight();

	$(window).scroll(function() {
		if ( $(this).scrollTop() > headerHeight ) {
			singleNav.fadeIn();
		} else {
			singleNav.fadeOut();
		}
	});


/*
** Sidebars =====
*/

	// Sidebar Alt Scroll
	$('.sidebar-alt').perfectScrollbar({
		suppressScrollX : true,
		includePadding : true,
		wheelSpeed: 3.5
	});

	// Sidebar Alt
	$('.main-nav-sidebar').on('click', function () {
		$('.sidebar-alt').css( 'left','0' );
		$('.sidebar-alt-close').fadeIn( 500 );
	});

	// Sidebar Alt Close
	function asheAltSidebarClose() {
		var leftPosition = parseInt( $( ".sidebar-alt" ).outerWidth(), 10 ) + 30;
		$('.sidebar-alt').css( 'left','-'+ leftPosition +'px' );
		$('.sidebar-alt-close').fadeOut( 500 );
	}
	
	$('.sidebar-alt-close, .sidebar-alt-close-btn').on('click', function () {
		asheAltSidebarClose();
	});


/*
** Scroll Top Button =====
*/

	$('.scrolltop').on( 'click', function() {
		$('html, body').animate( { scrollTop : 0 }, 800 );
		return false;
	});

	$( window ).on( 'scroll', function() {
		if ($(this).scrollTop() >= 800 ) {
			$('.scrolltop').fadeIn(350);
		} else {
			$('.scrolltop').fadeOut(350);
		}
	});


/*
** Dark Mode
*/
	var darkModeSwitcher = $('.dark-mode-switcher');

	if ( darkModeSwitcher.length === 1 ) {
		var boxedBackground = '';

		if ( $('body').hasClass('ashe-boxed-style') ) {
			boxedBackground = '.featured-slider-area #featured-slider,#featured-links,.category-description,.author-description,.comments-area,article.post,article.blog-post,.single .related-posts,.page-content article.page,.sidebar-left .ashe-widget,.sidebar-right .ashe-widget,.page-footer-inner,.blog-pagination,main#main{background:#333!important}';
		}

		var darkModeCSS = '<style id="ashe_dark_mode">.cssload-cube { background: #fff; !important}body{background: #222222 !important;}.mc4wp-form-fields,.widget_wysija_cont{background-color:#272727!important}#top-bar{background-color:#111}#top-bar a{color:#fff}#top-menu .sub-menu,#top-menu .sub-menu a{background-color:#111;border-color:rgba(0,0,0,0.35)}#main-nav{background-color:#111;box-shadow:0 1px 5px rgba(0,0,0,0.3)}#featured-links h6{background-color:rgba(34,34,34,0.85);color:#c4c4c4}#main-nav a,#main-nav i,#main-nav #s{color:#fff}.main-nav-sidebar span,.sidebar-alt-close-btn span{background-color:#fff}#main-menu .sub-menu,#main-menu .sub-menu a{background-color:#111;border-color:rgba(0,0,0,0.35)}#main-nav #s{background-color:#111}#main-nav #s::-webkit-input-placeholder{color:rgba(0,0,0,0.3)}#main-nav #s::-moz-placeholder{color:rgba(0,0,0,0.3)}#main-nav #s:-ms-input-placeholder{color:rgba(0,0,0,0.3)}#main-nav #s:-moz-placeholder{color:rgba(0,0,0,0.3)}.sidebar-alt,#featured-links,.main-content,.featured-slider-area,.page-content select,.page-content input,.page-content textarea{background-color:#222}.page-content,.page-content select,.page-content input,.page-content textarea,.page-content .post-author a,.page-content .ashe-widget a,.page-content .comment-author{color:#c4c4c4}.page-content h1,.page-content h2,.page-content h3,.page-content h4,.page-content h5,.page-content h6,.page-content .post-title a,.page-content .author-description h4 a,.page-content .related-posts h4 a,.page-content .blog-pagination .previous-page a,.page-content .blog-pagination .next-page a,blockquote,.page-content .post-share a{color:#fff}.page-content .post-title a:hover{color:rgba(255,255,255,0.75)}.page-content .post-date,.page-content .post-comments,.page-content .post-author,.page-content [data-layout*="list"] .post-author a,.page-content .related-post-date,.page-content .comment-meta a,.page-content .author-share a,.page-content .post-tags a,.page-content .tagcloud a,.widget_categories li,.widget_archive li,.ahse-subscribe-box p,.rpwwt-post-author,.rpwwt-post-categories,.rpwwt-post-date,.rpwwt-post-comments-number{color:#9e9e9e}.page-content input::-webkit-input-placeholder{color:#9e9e9e}.page-content input::-moz-placeholder{color:#9e9e9e}.page-content input:-ms-input-placeholder{color:#9e9e9e}.page-content input:-moz-placeholder{color:#9e9e9e}.ashe-boxed-style #searchform i{background:#ccc;color:#222}.widget_search i,.widget_search #searchsubmit,.single-navigation i,.page-content .submit,.page-content .blog-pagination.numeric a,.page-content .blog-pagination.load-more a,.page-content .ashe-subscribe-box input[type="submit"],.page-content .widget_wysija input[type="submit"],.page-content .post-password-form input[type="submit"],.page-content .wpcf7 [type="submit"]{color:#c4c4c4;background-color:#333}.ashe-boxed-style .page-content .blog-pagination.numeric a,.ashe-boxed-style.woocommerce .page-content .woocommerce-pagination ul li a { background: #272727; }.image-overlay,#infscr-loading,.page-content h4.image-overlay{background-color:rgba(0,0,0,0.3)}#page-footer,#page-footer select,#page-footer input,#page-footer textarea,.select2-container--default .select2-selection--single{background-color:#222}#page-footer,#page-footer a,#page-footer select,#page-footer input,#page-footer textarea{color:#c4c4c4}#page-footer #s::-webkit-input-placeholder{color:#c4c4c4}#page-footer #s::-moz-placeholder{color:#c4c4c4}#page-footer #s:-ms-input-placeholder{color:#c4c4c4}#page-footer #s:-moz-placeholder{color:#c4c4c4}#page-footer h1,#page-footer h2,#page-footer h3,#page-footer h4,#page-footer h5,#page-footer h6{color:#fff}.ashe-preloader-wrap{background-color:#333}.woocommerce div.product .stock,.woocommerce div.product p.price,.woocommerce div.product span.price,.woocommerce ul.products li.product .price,.woocommerce-Reviews .woocommerce-review__author,.woocommerce form .form-row .required,.woocommerce form .form-row.woocommerce-invalid label,.woocommerce .page-content div.product .woocommerce-tabs ul.tabs li a{color:#c4c4c4}.woocommerce a.remove:hover{color:#c4c4c4!important}.woocommerce a.remove,.woocommerce .product_meta,.page-content .woocommerce-breadcrumb,.page-content .woocommerce-review-link,.page-content .woocommerce-breadcrumb a,.page-content .woocommerce-MyAccount-navigation-link a,.woocommerce .woocommerce-info:before,.woocommerce .page-content .woocommerce-result-count,.woocommerce-page .page-content .woocommerce-result-count,.woocommerce-Reviews .woocommerce-review__published-date,.woocommerce .product_list_widget .quantity,.woocommerce .widget_products .amount,.woocommerce .widget_price_filter .price_slider_amount,.woocommerce .widget_recently_viewed_products .amount,.woocommerce .widget_top_rated_products .amount,.woocommerce .widget_recent_reviews .reviewer{color:#9e9e9e}.woocommerce a.remove{color:#9e9e9e!important}.woocommerce-cart #payment,#add_payment_method #payment,.woocommerce-checkout #payment,.woocommerce .woocommerce-info,.woocommerce .woocommerce-error,.woocommerce .woocommerce-message,.woocommerce div.product .woocommerce-tabs ul.tabs li{background-color:rgba(56,56,56,0.3)!important}.woocommerce-cart #payment div.payment_box::before,#add_payment_method #payment div.payment_box::before,.woocommerce-checkout #payment div.payment_box::before{border-color:rgba(56,56,56,0.5)}.woocommerce-cart #payment div.payment_box,#add_payment_method #payment div.payment_box,.woocommerce-checkout #payment div.payment_box{background-color:rgba(56,56,56,0.5)}.page-content .woocommerce input.button,.page-content .woocommerce a.button,.page-content .woocommerce a.button.alt,.page-content .woocommerce button.button.alt,.page-content .woocommerce input.button.alt,.page-content .woocommerce #respond input#submit.alt,.woocommerce .page-content .widget_product_search input[type="submit"],.woocommerce .page-content .woocommerce-message .button,.woocommerce .page-content a.button.alt,.woocommerce .page-content button.button.alt,.woocommerce .page-content #respond input#submit,.woocommerce .page-content .widget_price_filter .button,.woocommerce .page-content .woocommerce-message .button,.woocommerce-page .page-content .woocommerce-message .button,.woocommerce .page-content nav.woocommerce-pagination ul li a,.woocommerce .page-content nav.woocommerce-pagination ul li span{color:#c4c4c4;background-color:#333}.woocommerce .page-content nav.woocommerce-pagination ul li a.prev,.woocommerce .page-content nav.woocommerce-pagination ul li a.next{color:#333}.woocommerce .page-content nav.woocommerce-pagination ul li a.prev:after,.woocommerce .page-content nav.woocommerce-pagination ul li a.next:after{color:#fff}.woocommerce .page-content nav.woocommerce-pagination ul li a.prev:hover:after,.woocommerce .page-content nav.woocommerce-pagination ul li a.next:hover:after{color:#fff}.ashe-dropcaps .post-content>p:first-of-type:first-letter{color:#fff!important}.sticky{background:#2f2f2f}body.ashe-dark-mode img{filter:brightness(.8) contrast(1.2)}.widget-title h2:before,.widget-title h2:after{border-color:#969696!important}::-webkit-input-placeholder{color:#c4c4c4!important}:-ms-input-placeholder{color:#c4c4c4!important}::placeholder{color:#c4c4c4!important}#page-footer{background:#333}.woocommerce form.login,.woocommerce form.register,.woocommerce-account fieldset,.woocommerce form.checkout_coupon,.woocommerce .woocommerce-info,.woocommerce .woocommerce-error,.woocommerce .woocommerce-message,.woocommerce .widget_shopping_cart .total,.woocommerce.widget_shopping_cart .total,.woocommerce-Reviews .comment_container,.woocommerce-cart #payment ul.payment_methods,#add_payment_method #payment ul.payment_methods,.woocommerce-checkout #payment ul.payment_methods,.woocommerce div.product .woocommerce-tabs ul.tabs::before,.woocommerce div.product .woocommerce-tabs ul.tabs::after,.woocommerce div.product .woocommerce-tabs ul.tabs li,.woocommerce .woocommerce-MyAccount-navigation-link,.select2-container--default .select2-selection--single,.page-content .post-footer,[data-layout*="list"] .blog-grid>li,.page-content .author-description,.page-content .related-posts,.page-content .entry-comments,.page-content .ashe-widget li,.page-content #wp-calendar,.page-content #wp-calendar caption,.page-content #wp-calendar tbody td,.page-content .widget_nav_menu li a,.page-content .tagcloud a,.page-content select,.page-content input,.page-content textarea,.widget-title h2:before,.widget-title h2:after,.post-tags a,.gallery-caption,.wp-caption-text,table tr,table th,table td,pre,.category-description,#page-footer a,#page-footer .ashe-widget li,#page-footer #wp-calendar,#page-footer #wp-calendar caption,#page-footer #wp-calendar tbody td,#page-footer .widget_nav_menu li a,#page-footer select,#page-footer input,#page-footer textarea,#page-footer .widget-title h2:before,#page-footer .widget-title h2:after,.footer-widgets{border-color:#6d6d6d}hr,#page-footer hr{background-color:#6d6d6d}.ashe-boxed-style .page-content .woocommerce .wc-proceed-to-checkout a.button,.ashe-boxed-style.woocommerce .page-content button.button.alt,.page-content .woocommerce button.button.alt,.ashe-boxed-style .page-content .submit{background:#222}.ashe-boxed-style.woocommerce .woocommerce-message,.ashe-boxed-style .woocommerce .woocommerce-notice,.ashe-boxed-style .woocommerce-form-coupon-toggle .woocommerce-info,.ashe-boxed-style.woocommerce .woocommerce-error,.ashe-boxed-style.woocommerce .page-content #respond input#submit{color:#ccc;background:#222!important}.woocommerce table.shop_table{border-color:#6d6d6d}.woocommerce table.shop_table td,#add_payment_method .cart-collaterals .cart_totals tr td,#add_payment_method .cart-collaterals .cart_totals tr th,.woocommerce-cart .cart-collaterals .cart_totals tr td,.woocommerce-cart .cart-collaterals .cart_totals tr th,.woocommerce-checkout .cart-collaterals .cart_totals tr td,.woocommerce-checkout .cart-collaterals .cart_totals tr th,.woocommerce table.shop_table tfoot th{border-color:#6d6d6d!important}.ashe-boxed-style .related-posts,.ashe-boxed-style .author-description { border-bottom: 0;}.post-content > p:first-of-type:first-letter { color: #c4c4c4 !important;}#main-menu .sub-menu a,#top-menu .sub-menu a{border-color:rgba(255,255,255,0.15)}.ashe-dropcaps .post-content>p:first-of-type:first-letter{color:#fff!important}.woocommerce .woocommerce-message,.woocommerce .woocommerce-notice,.woocommerce-form-coupon-toggle .woocommerce-info,.woocommerce .woocommerce-error,.woocommerce .page-content #respond input#submit{color:#c4c4c4;border-color:#848383}'+ boxedBackground +'</style>';

		darkModeSwitcher.on( 'click', function() {
			var body = $( 'body' );

			if ( body.hasClass( 'ashe-dark-mode' ) ) {
				body.removeClass( 'ashe-dark-mode' );
				localStorage.setItem( 'asheDarkMode', 'off' );

				// Remove
				darkModeSwitcher.find('i').removeAttr('class').addClass('fa fa-moon-o');
				$('style#ashe_dark_mode').remove();
			} else {
				body.addClass( 'ashe-dark-mode' );
				localStorage.setItem( 'asheDarkMode', 'on' );

				// Apply
				darkModeSwitcher.find('i').removeAttr('class').addClass('fa fa-sun-o');
				$('head').append( darkModeCSS );
			}
		});

		// Apply on Load
		if ( 'on' === localStorage.getItem('asheDarkMode') ) {
			$( 'body' ).addClass( 'ashe-dark-mode' );
			darkModeSwitcher.find('i').removeAttr('class').addClass('fa fa-sun-o');
			$('head').append( darkModeCSS );
		}

	} else {
		if ( 'on' === localStorage.getItem('asheDarkMode') ) {
			localStorage.setItem( 'asheDarkMode', 'off' );
		}
	}
	


/*
** Window Resize =====
*/

	$( window ).on( 'resize', function() {

		if ( $('.mobile-menu-btn').css('display') === 'none' ) {
			$( '.mobile-menu-container' ).css({ 'display' : 'none' });
		}
		
		asheStickySidebar();

		asheAltSidebarClose();
	});


/*
** Run Functions =====
*/
	// FitVids
	$('.slider-item, .post-media').fitVids();



}); // end dom ready


/*
** Window Load =====
*/
jQuery( window ).on( 'load', function() {
	asheStickySidebar();
	ashePreloader();
});


/*
** Global Functions =====
*/
	// Preloader
	function ashePreloader() {

		if ( $('.ashe-preloader-wrap').length ) {
			setTimeout(function(){
				$('.ashe-preloader-wrap > div').fadeOut( 600 );
				$('.ashe-preloader-wrap').fadeOut( 1500 );
			}, 300);

			if ( $('body').hasClass('elementor-editor-active') ) {
				setTimeout(function(){
					$('.ashe-preloader-wrap > div').fadeOut( 600 );
					$('.ashe-preloader-wrap').fadeOut( 1500 );
				}, 300);
			}
		}

	}

	// Sticky Sidebar
	function asheStickySidebar() {
		if ( $( '.main-content' ).data('sidebar-sticky') === 1 ) {		
			var SidebarOffset = 0;

			if ( $("#main-nav").attr( 'data-fixed' ) === '1' ) {
				SidebarOffset = 40;
			}

			$('.sidebar-left,.sidebar-right').stick_in_parent({
				parent: ".main-content",
				offset_top: SidebarOffset,
				spacer: '.sidebar-left-wrap,.sidebar-right-wrap'
			});

			if ( $('.mobile-menu-btn').css('display') !== 'none' ) {
				$('.sidebar-left,.sidebar-right').trigger("sticky_kit:detach");
			}
		}
	}
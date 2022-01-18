/*
** Instantly live-update customizer settings in the preview for improved user experience.
*/

(function( $ ) {

/*
** Colors
*/

	// Header
	wp.customize( 'header_textcolor', function( value ) {
		value.bind( function( val ) {
			if ( 'blank' === val ) {
				$( '.header-logo a, .site-description' ).css( 'color', $('.site-description').css('color') );
				$( 'body' ).removeClass( 'title-tagline-shown' );
				$( 'body' ).addClass( 'title-tagline-hidden' );
			} else {
				$( '.header-logo a, .site-description' ).css( 'color', val );
				$( 'body' ).removeClass( 'title-tagline-hidden' );
				$( 'body' ).addClass( 'title-tagline-shown' );
			}
		});
	});

	asheLivePreview( 'colors_header_bg', function( val ) {
		$('.entry-header').css( 'background-color', val );
	});

	// Accent Color
	asheLivePreview( 'colors_content_accent', function( val ) {
		var selectors = '\
			.page-content .post-title a,\
			.page-content .post-comments,\
			.page-content .post-author a,\
			.page-content .post-share a,\
		 	.page-content .ashe-widget a,\
			.page-content .related-posts h4 a,\
			.page-content .author-description h4 a,\
			.page-content .blog-pagination a,\
			.page-content .post-date,\
			.page-content .post-author,\
			.page-content .related-post-date,\
			.page-content .comment-meta a,\
			.page-content .author-share a,\
			.page-content .slider-title a,\
			.page-content .slider-categories a,\
			.page-content .slider-read-more a\
		';

		$( '.page-content a' ).not( selectors ).css( 'color', val );

		/* Disable TMP
		$( '.page-content .elementor a' ).css( 'color', 'inherit' );
		*/

		var css = '\
		.post-categories,\
		#top-bar a:hover,\
		#top-bar li.current-menu-item > a,\
		#top-bar li.current-menu-ancestor > a,\
		#top-bar .sub-menu li.current-menu-item > a,\
		#top-bar .sub-menu li.current-menu-ancestor> a,\
		#main-nav a:hover,\
		#main-nav i:hover,\
		#main-nav li.current-menu-item > a,\
		#main-nav li.current-menu-ancestor > a,\
		#main-nav .sub-menu li.current-menu-item > a,\
		#main-nav .sub-menu li.current-menu-ancestor> a,\
		.page-content .ashe-widget.widget_text a,\
		#page-footer a:hover,\
		.woocommerce .star-rating::before,\
		.woocommerce .star-rating span::before,\
		.woocommerce .page-content ul.products li.product .button,\
		.page-content .woocommerce ul.products li.product .button,\
		.page-content .woocommerce-MyAccount-navigation-link.is-active a,\
		.page-content .woocommerce-MyAccount-navigation-link a:hover,\
		.woocommerce .page-content nav.woocommerce-pagination ul li a.prev:hover,\
		.woocommerce .page-content nav.woocommerce-pagination ul li a.next:hover {\
		color: '+ val +' ;\
		}';


		css += '\
		.main-nav-sidebar:hover span,\
		.ps-container > .ps-scrollbar-y-rail > .ps-scrollbar-y,\
		.single-navigation i:hover,\
		.page-content .submit:hover,\
		.page-content .blog-pagination.numeric a:hover,\
		.page-content .blog-pagination.numeric span,\
		.page-content .blog-pagination.load-more a:hover,\
		.page-content .ashe-subscribe-box input[type="submit"]:hover,\
		.page-content .widget_wysija input[type="submit"]:hover,\
		.page-content .post-password-form input[type="submit"]:hover,\
		.page-content .wpcf7 [type="submit"]:hover,\
		p.demo_store,\
		.woocommerce-store-notice,\
		.woocommerce span.onsale,\
		.page-content .woocommerce input.button:hover,\
		.page-content .woocommerce a.button:hover,\
		.page-content .woocommerce a.button.alt:hover,\
		.page-content .woocommerce button.button.alt:hover,\
		.page-content .woocommerce input.button.alt:hover,\
		.page-content .woocommerce #respond input#submit.alt:hover,\
		.woocommerce .page-content .woocommerce-message .button:hover,\
		.woocommerce .page-content a.button.alt:hover,\
		.woocommerce .page-content button.button.alt:hover,\
		.woocommerce .page-content #respond input#submit:hover,\
		.woocommerce .page-content .widget_price_filter .button:hover,\
		.woocommerce .page-content .woocommerce-message .button:hover,\
		.woocommerce-page .page-content .woocommerce-message .button:hover,\
		.woocommerce .page-content nav.woocommerce-pagination ul li a:hover,\
		.woocommerce .page-content nav.woocommerce-pagination ul li span.current {\
			background-color: '+ val +';\
		}';

		css += '\
		blockquote {\
			border-color: '+ val +';\
		}';

		css += '\
		::-moz-selection {\
			background: '+ val +';\
		}\
		::selection {\
			background: '+ val +';\
		}';

		css += '\
		.page-content a:hover {\
			color: '+ asheHex2Rgba( val, 0.8 ) +';\
		}';	

		asheStyle( 'colors_content_accent', css );
	});


/*
** Page Header
*/

	asheLivePreview( 'title_tagline_logo_width', function( val ) {
		$( '.logo-img' ).css( 'max-width', val +'px' );
	});

	asheLivePreview( 'main_nav_mini_logo_width', function( val ) {
		$('.mini-logo a').css( 'max-width', val +'px' );
	});


/*
** Typography
*/

	// Menu Italic
	asheLivePreview( 'typography_nav_italic', function( val ) {
		if ( val === true ) {
			$( '#top-menu li a,	#main-menu li a, #mobile-menu li' ).css( 'font-style', 'italic' );
		} else {
			$( '#top-menu li a,	#main-menu li a, #mobile-menu li' ).css( 'font-style', 'normal' );
		}
	});

	// Menu Uppercase
	asheLivePreview( 'typography_nav_uppercase', function( val ) {
		if ( val === true ) {
			$( '#top-menu li a,	#main-menu li a, #mobile-menu li' ).css( 'text-transform', 'uppercase' );
		} else {
			$( '#top-menu li a,	#main-menu li a, #mobile-menu li' ).css( 'text-transform', 'none' );
		}
	});


/*
** Custom Functions
*/
	// Previewer
	function asheLivePreview( control, func ) {
		wp.customize( 'ashe_options['+ control +']', function( value ) {
			value.bind( function( val ) {
				func( val );
			} );
		} );
	}

	// convert hex color to rgba
	function asheHex2Rgba( hex, opacity ) {
		if ( typeof(hex) === 'undefined' ) {
			return;
		}

		var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec( hex ),
			rgba = 'rgba( '+ parseInt( result[1], 16 ) +', '+ parseInt( result[2], 16 ) +', '+ parseInt( result[3], 16 ) +', '+ opacity +')';

		// return converted RGB
		return rgba;
	}

	// Style Tag
	function asheStyle( id, css ) {
		if ( $( '#'+ id ).length === 0 ) {
			$('head').append('<style id="'+ id +'"></style>')
		}

		$( '#'+ id ).text( css );
	}

} )( jQuery );

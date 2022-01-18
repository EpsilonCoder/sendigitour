<?php

function ashe_dynamic_css() {

// begin style block
$css = '<style id="ashe_dynamic_css">';

/*
** Reusable Functions =====
*/

// true/false validaiton
function ashe_true_false( $option ) {
	if ( $option === true ) {
		return true;
	} else {
		return false;
	}
}


/*
** Colors =====
*/

	// Body
	if ( ! get_theme_mod('background_color') ) {
		$css .= '
			body {
				background-color: #ffffff;
			}
		';
	}

	// Top Bar
	$css .= '
		#top-bar {
		  background-color: #ffffff;
		}

		#top-bar a {
		  color: #000000;
		}

		#top-bar a:hover,
		#top-bar li.current-menu-item > a,
		#top-bar li.current-menu-ancestor > a,
		#top-bar .sub-menu li.current-menu-item > a,
		#top-bar .sub-menu li.current-menu-ancestor> a {
		  color: '. esc_html(ashe_options( 'colors_content_accent' )) .';
		}
		
		#top-menu .sub-menu,
		#top-menu .sub-menu a {
		  	background-color: #ffffff;
			border-color: '. esc_html(ashe_hex2rgba( '#000000', 0.05 )) .';
		}
	';

	if ( ashe_options( 'main_nav_label' ) === true || ! has_nav_menu('top') ) {
		$css .= "
		@media screen and ( max-width: 979px ) {
			.top-bar-socials {
				float: none !important;
			}

			.top-bar-socials a {
				line-height: 40px !important;
			}
		}";
	}

	// Page Header
	$header_text_color = get_header_textcolor();

	if ( $header_text_color === 'blank' ) {
		$css .= '
			.header-logo a,
			.site-description {
				color: #111111;
			}
		';	
	} else {
		$css .= '
			.header-logo a,
			.site-description {
				color: #'. esc_attr ( $header_text_color ) .';
			}
		';			
	}

	$css .= '
		.entry-header {
			background-color: '. ashe_options( 'colors_header_bg' ) .';
		}
	';
	
	// Main Navigation
	$css .= '
		#main-nav {
			background-color: #ffffff;
			box-shadow: 0px 1px 5px '. esc_html(ashe_hex2rgba( '#000000', 0.1 )) .';
		}

		#featured-links h6 {
			background-color: '. esc_html(ashe_hex2rgba( '#ffffff', 0.85 )) .';
			color: #000000;
		}

		#main-nav a,
		#main-nav i,
		#main-nav #s {
			color: #000000;
		}

		.main-nav-sidebar span,
		.sidebar-alt-close-btn span {
			background-color: #000000;
		}

		#main-nav a:hover,
		#main-nav i:hover,
		#main-nav li.current-menu-item > a,
		#main-nav li.current-menu-ancestor > a,
		#main-nav .sub-menu li.current-menu-item > a,
		#main-nav .sub-menu li.current-menu-ancestor> a {
			color: '. esc_html(ashe_options( 'colors_content_accent' )) .';
		}

		.main-nav-sidebar:hover span {
			background-color: '. esc_html(ashe_options( 'colors_content_accent' )) .';
		}

		#main-menu .sub-menu,
		#main-menu .sub-menu a {
			background-color: #ffffff;
			border-color: '. esc_html(ashe_hex2rgba( '#000000', 0.05 )) .';
		}

		#main-nav #s {
			background-color: #ffffff;
		}

		#main-nav #s::-webkit-input-placeholder { /* Chrome/Opera/Safari */
			color: '. esc_html(ashe_hex2rgba( '#000000', 0.7 )) .';
		}
		#main-nav #s::-moz-placeholder { /* Firefox 19+ */
			color: '. esc_html(ashe_hex2rgba( '#000000', 0.7 )) .';
		}
		#main-nav #s:-ms-input-placeholder { /* IE 10+ */
			color: '. esc_html(ashe_hex2rgba( '#000000', 0.7 )) .';
		}
		#main-nav #s:-moz-placeholder { /* Firefox 18- */
			color: '. esc_html(ashe_hex2rgba( '#000000', 0.7 )) .';
		}
	';

	if ( '' !== ashe_options( 'main_nav_mini_logo' ) && true !== ashe_options( 'main_nav_show_search' ) && true !== ashe_options( 'skins_dark_mode' ) ) {
		$css .= '
			.mobile-menu-btn {
				float: right;
				padding-right: 0;
			}
		';
	}

	// Content
	$css .= '
		/* Background */
		.sidebar-alt,
		#featured-links,
		.main-content,
		.featured-slider-area,
		.page-content select,
		.page-content input,
		.page-content textarea {
			background-color: '. esc_html(ashe_options( 'colors_content_bg' )) .';
		}

		/* Text */
		.page-content,
		.page-content select,
		.page-content input,
		.page-content textarea,
		.page-content .post-author a,
		.page-content .ashe-widget a,
		.page-content .comment-author {
			color: #464646;
		}

		/* Title */
		.page-content h1,
		.page-content h2,
		.page-content h3,
		.page-content h4,
		.page-content h5,
		.page-content h6,
		.page-content .post-title a,
		.page-content .author-description h4 a,
		.page-content .related-posts h4 a,
		.page-content .blog-pagination .previous-page a,
      	.page-content .blog-pagination .next-page a,
      	blockquote,
		.page-content .post-share a {
			color: #030303;
		}

		.page-content .post-title a:hover {
			color: '. esc_html(ashe_hex2rgba( '#030303', 0.75 )) .';
		}
	
		/* Meta */
		.page-content .post-date,
		.page-content .post-comments,
		.page-content .post-author,
		.page-content [data-layout*="list"] .post-author a,
		.page-content .related-post-date,
		.page-content .comment-meta a,
		.page-content .author-share a,
		.page-content .post-tags a,
		.page-content .tagcloud a,
		.widget_categories li,
		.widget_archive li,
		.ahse-subscribe-box p,
		.rpwwt-post-author,
		.rpwwt-post-categories,
		.rpwwt-post-date,
		.rpwwt-post-comments-number {
			color: #a1a1a1;
		}

		.page-content input::-webkit-input-placeholder { /* Chrome/Opera/Safari */
		  color: #a1a1a1;
		}
		.page-content input::-moz-placeholder { /* Firefox 19+ */
		  color: #a1a1a1;
		}
		.page-content input:-ms-input-placeholder { /* IE 10+ */
		  color: #a1a1a1;
		}
		.page-content input:-moz-placeholder { /* Firefox 18- */
		  color: #a1a1a1;
		}
		
	
		/* Accent */
		a,
		.post-categories,
		.page-content .ashe-widget.widget_text a {
			color: '. esc_html(ashe_options( 'colors_content_accent' )) .';
		}

		/* Disable TMP
		.page-content .elementor a,
		.page-content .elementor a:hover {
			color: inherit;
		}
		*/
		
		.ps-container > .ps-scrollbar-y-rail > .ps-scrollbar-y {
			background: '. esc_html(ashe_options( 'colors_content_accent' )) .';
		}

		a:not(.header-logo-a):hover {
			color: '. esc_html(ashe_hex2rgba( ashe_options( 'colors_content_accent' ), 0.8 )) .';
		}

		blockquote {
			border-color: '. esc_html(ashe_options( 'colors_content_accent' )) .';
		}


		/* Selection */
		::-moz-selection {
			color: #ffffff;
			background: '. esc_html(ashe_options( 'colors_content_accent' )) .';
		}
		::selection {
			color: #ffffff;
			background: '. esc_html(ashe_options( 'colors_content_accent' )) .';
		}

		/* Border */
		.page-content .post-footer,
		[data-layout*="list"] .blog-grid > li,
		.page-content .author-description,
		.page-content .related-posts,
		.page-content .entry-comments,
		.page-content .ashe-widget li,
		.page-content #wp-calendar,
		.page-content #wp-calendar caption,
		.page-content #wp-calendar tbody td,
		.page-content .widget_nav_menu li a,
		.page-content .tagcloud a,
		.page-content select,
		.page-content input,
		.page-content textarea,
		.widget-title h2:before,
		.widget-title h2:after,
		.post-tags a,
		.gallery-caption,
		.wp-caption-text,
		table tr,
		table th,
		table td,
		pre,
		.category-description {
			border-color: #e8e8e8;
		}

		hr {
			background-color: #e8e8e8;
		}

		/* Buttons */
		.widget_search i,
		.widget_search #searchsubmit,
		.wp-block-search button,
		.single-navigation i,
		.page-content .submit,
		.page-content .blog-pagination.numeric a,
		.page-content .blog-pagination.load-more a,
		.page-content .ashe-subscribe-box input[type="submit"],
		.page-content .widget_wysija input[type="submit"],
		.page-content .post-password-form input[type="submit"],
		.page-content .wpcf7 [type="submit"] {
			color: #ffffff;
			background-color: #333333;
		}
		.single-navigation i:hover,
		.page-content .submit:hover,
		.ashe-boxed-style .page-content .submit:hover,
		.page-content .blog-pagination.numeric a:hover,
		.ashe-boxed-style .page-content .blog-pagination.numeric a:hover,
		.page-content .blog-pagination.numeric span,
		.page-content .blog-pagination.load-more a:hover,
		.page-content .ashe-subscribe-box input[type="submit"]:hover,
		.page-content .widget_wysija input[type="submit"]:hover,
		.page-content .post-password-form input[type="submit"]:hover,
		.page-content .wpcf7 [type="submit"]:hover {
			color: #ffffff;
			background-color: '. esc_html(ashe_options( 'colors_content_accent' )) .';
		}


		/* Image Overlay */
		.image-overlay,
		#infscr-loading,
		.page-content h4.image-overlay {
			color: #ffffff;
			background-color: '. esc_html(ashe_hex2rgba( '#494949', 0.3 )) .';
		}

		.image-overlay a,
		.post-slider .prev-arrow,
		.post-slider .next-arrow,
		.page-content .image-overlay a,
		#featured-slider .slick-arrow,
		#featured-slider .slider-dots {
			color: #ffffff;
		}

		.slide-caption {
			background: '. esc_html(ashe_hex2rgba( '#ffffff', 0.95 )) .';
		}

		#featured-slider .slick-active {
			background: #ffffff;
		}
	';

	// Footer
	$css .= '
		#page-footer,
		#page-footer select,
		#page-footer input,
		#page-footer textarea {
			background-color: #f6f6f6;
			color: #333333;
		}

		#page-footer,
		#page-footer a,
		#page-footer select,
		#page-footer input,
		#page-footer textarea {
			color: #333333;
		}

		#page-footer #s::-webkit-input-placeholder { /* Chrome/Opera/Safari */
		  color: #333333;
		}
		#page-footer #s::-moz-placeholder { /* Firefox 19+ */
		  color: #333333;
		}
		#page-footer #s:-ms-input-placeholder { /* IE 10+ */
		  color: #333333;
		}
		#page-footer #s:-moz-placeholder { /* Firefox 18- */
		  color: #333333;
		}

		/* Title */
		#page-footer h1,
		#page-footer h2,
		#page-footer h3,
		#page-footer h4,
		#page-footer h5,
		#page-footer h6 {
			color: #111111;
		}

		#page-footer a:hover {
			color: '. esc_html(ashe_options( 'colors_content_accent' )) .';
		}

		/* Border */
		#page-footer a,
		#page-footer .ashe-widget li,
		#page-footer #wp-calendar,
		#page-footer #wp-calendar caption,
		#page-footer #wp-calendar tbody td,
		#page-footer .widget_nav_menu li a,
		#page-footer select,
		#page-footer input,
		#page-footer textarea,
		#page-footer .widget-title h2:before,
		#page-footer .widget-title h2:after,
		.footer-widgets {
			border-color: #e0dbdb;
		}

		#page-footer hr {
			background-color: #e0dbdb;
		}
	';

	// Preloader
	$css .= '
		.ashe-preloader-wrap {
			background-color: #ffffff;
		}
	';


/*
** Responsive =====
*/
	// Featured Slider
	if ( ashe_options( 'responsive_featured_slider' ) !== true ) {
		$css .= '
		@media screen and ( max-width: 768px ) {
			.featured-slider-area {
				display: none;
			}
		}
		';
	}

	// Featured Links
	if ( ashe_options( 'responsive_featured_links' ) !== true ) {
		$css .= '
		@media screen and ( max-width: 768px ) {
			#featured-links {
				display: none;
			}
		}
		';
	}

	// Related Posts
	if ( ashe_options( 'responsive_related_posts' ) !== true ) {
		$css .= '
		@media screen and ( max-width: 640px ) {
			.related-posts {
				display: none;
			}
		}
		';
	}


/*
** Typography =====
*/
	// Logo & Tagline
	$css .= "
		.header-logo a {
			font-family: '". str_replace( '+', ' ', ashe_options( 'typography_logo_family' ) ) ."';
		}
	";

	// Top Bar
	$css .= "
		#top-menu li a {
			font-family: '". str_replace( '+', ' ', ashe_options( 'typography_nav_family' ) ) ."';
		}
	";

	// Main Navigation
	$css .= "	
		#main-menu li a {
			font-family: '". str_replace( '+', ' ', ashe_options( 'typography_nav_family' ) ) ."';
		}

		#mobile-menu li,
		.mobile-menu-btn a {
			font-family: '". str_replace( '+', ' ', ashe_options( 'typography_nav_family' ) ) ."';
		}
	";

	// Italic
	if ( ashe_options( 'typography_nav_italic' ) === true ) {
		$css .= "
			#top-menu li a,
			#main-menu li a,
			#mobile-menu li {
				font-style: italic;
			}
		";
	}

	// Uppercase
	if ( ashe_options( 'typography_nav_uppercase' ) === true ) {
		$css .= "
			#top-menu li a,
			#main-menu li a,
			#mobile-menu li,
			.mobile-menu-btn a {
				text-transform: uppercase;
			}
		";
	}
	

/*
** General Layouts =====
*/

	// Blog Gutter
	$blog_page_gutter_horz = 37;
	$blog_page_gutter_vert = 30;

	// Site Width
	$css .= '
		.boxed-wrapper {
			max-width: 1160px;
		}
	';
	
	// Sidebar Width
	$css .= '
		.sidebar-alt {
			max-width: '. ( (int)ashe_options( 'general_sidebar_width' ) + 70 ) .'px;
			left: -'. ( (int)ashe_options( 'general_sidebar_width' ) + 70 ) .'px; 
			padding: 85px 35px 0px;
		}

		.sidebar-left,
		.sidebar-right {
			width: '. ( (int)ashe_options( 'general_sidebar_width' ) + $blog_page_gutter_horz ) .'px;
		}
	';

	// Both Sidebars
	if ( is_active_sidebar( 'sidebar-left' ) && is_active_sidebar( 'sidebar-right' ) ) {
		$css .= '
			.main-container {
				width: calc(100% - '. ( ( (int)ashe_options( 'general_sidebar_width' ) + $blog_page_gutter_horz ) * 2 ) .'px);
				width: -webkit-calc(100% - '. ( ( (int)ashe_options( 'general_sidebar_width' ) + $blog_page_gutter_horz ) * 2 ) .'px);
			}
		';

	// Left or Right
	} else if ( is_active_sidebar( 'sidebar-left' ) || is_active_sidebar( 'sidebar-right' ) || ashe_is_preview() ) {
		$css .= '
			.main-container {
				width: calc(100% - '. ( (int)ashe_options( 'general_sidebar_width' ) + $blog_page_gutter_horz ) .'px);
				width: -webkit-calc(100% - '. ( (int)ashe_options( 'general_sidebar_width' ) + $blog_page_gutter_horz ) .'px);
			}
		';

	// No Sidebars
	} else {
		$css .= '
			.main-container {
				width: 100%;
			}
		';
	}

	// Padding
	$css .= '
	#top-bar > div,
	#main-nav > div,
	#featured-links,
	.main-content,
	.page-footer-inner,
	.featured-slider-area.boxed-wrapper {
		padding-left: 40px;
		padding-right: 40px;
	}
	';

	// List Layout
	if ( strpos( ashe_options( 'general_home_layout' ), 'list' ) !== false ) {
		$css .= '
			[data-layout*="list"] .blog-grid .has-post-thumbnail .post-media {
				float: left;
				max-width: 300px;
				width: 100%;
			}

			[data-layout*="list"] .blog-grid .has-post-thumbnail .post-content-wrap {
				width: calc(100% - 300px);
				width: -webkit-calc(100% - 300px);
				float: left;
				padding-left: 37px;
			}

			[data-layout*="list"] .blog-grid > li {
				padding-bottom: 39px;
			}

			[data-layout*="list"] .blog-grid > li {
				margin-bottom: 39px;
			}

			[data-layout*="list"] .blog-grid .post-header, 
			[data-layout*="list"] .blog-grid .read-more {
				text-align: left;
			}
		';

		if ( is_rtl() ) {
			$css .= '
				[data-layout*="list"] .blog-grid .post-media {
					float: right;
				}

				[data-layout*="list"] .blog-grid .post-content-wrap {
					float: right;
					padding-left: 0;
					padding-right: 37px;

				}

				[data-layout*="list"] .blog-grid .post-header, 
				[data-layout*="list"] .blog-grid .read-more {
					text-align: right;
				}
			';

		}
	}



/*
** Top Bar =====
*/

	$css .= '
		#top-menu {
			float: left;
		}
		.top-bar-socials {
			float: right;
		}
	'; 


/*
** Header Image =====
*/
	// Height / Background
	$css .= '
		.entry-header {
			height: 500px;
			background-image:url('. esc_url( get_header_image() ) .');
			background-size: '. esc_html(ashe_options( 'header_image_bg_image_size' )) .';

		}
	';

	// Center if cover
	if ( esc_html(ashe_options( 'header_image_bg_image_size' )) === 'cover' ) {
		$css .= '
			.entry-header {
				background-position: center center;
			}
		';		
	}

	// Header Logo
	$css .= '
		.logo-img {
			max-width: '. (int)ashe_options( 'title_tagline_logo_width' ) .'px;
		}

		.mini-logo a {
			max-width: '. ashe_options( 'main_nav_mini_logo_width' ) .'px;
		}
	';


/*
** Site Identity =====
*/

	// Logo &  Tagline
	if ( ! display_header_text() ) {
		$css .= '
			.header-logo a:not(.logo-img),
			.site-description {
				display: none;
			}
		';		
	}


/*
** Main Navigation =====
*/
	
	// Align
	$css .= '
		#main-nav {
			text-align: '. esc_html(ashe_options( 'main_nav_align' )) .';
		}
	';

	if ( ashe_options( 'main_nav_align' ) === 'center' ) {
		$css .= '
			.main-nav-sidebar {
			  position: absolute;
			  top: 0px;
			  left: 40px;
			  z-index: 1;
			}
						
			.main-nav-icons {
			  position: absolute;
			  top: 0px;
			  right: 40px;
			  z-index: 2;
			}

			.mini-logo {
			  position: absolute;
			  left: auto;
			  top: 0;
			}

			.main-nav-sidebar ~ .mini-logo {
			  margin-left: 30px;
			}
		';
	} else {
		$css .= '
			.main-nav-sidebar,
			.mini-logo {
			  float: left;
			  margin-right: 15px;
			}
						
			.main-nav-icons {
			 float: right;
			 margin-left: 15px;
			}
		';
	}



/*
** Featured Links =====
*/
	// Layout
	$featured_links = array(
		esc_url(ashe_options( 'featured_links_image_1' )),
		esc_url(ashe_options( 'featured_links_image_2' )),
		esc_url(ashe_options( 'featured_links_image_3' ))
	);

	$featured_links = count( array_filter( $featured_links ) );
	$featured_links_gutter = 0;

	// Gutter	
	$featured_links_gutter = 20;
	$css .= '
		#featured-links .featured-link {
			margin-right: '. $featured_links_gutter .'px;
		}
		#featured-links .featured-link:last-of-type {
			margin-right: 0;
		}
	';

	// Columns
	$css .= '
		#featured-links .featured-link {
			width: calc( (100% - '. ( ($featured_links - 1) * $featured_links_gutter ) .'px) / '. $featured_links .' - 1px);
			width: -webkit-calc( (100% - '. ( ($featured_links - 1) * $featured_links_gutter ) .'px) / '. $featured_links .'- 1px);
		}
	';

	if ( ashe_options( 'featured_links_title_1' ) === '' ) {
		$css .= '
			.featured-link:nth-child(1) .cv-inner {
			    display: none;
			}
		';
	}

	if ( ashe_options( 'featured_links_title_2' ) === '' ) {
		$css .= '
			.featured-link:nth-child(2) .cv-inner {
			    display: none;
			}
		';
	}
	
	if ( ashe_options( 'featured_links_title_3' ) === '' ) {
		$css .= '
			.featured-link:nth-child(3) .cv-inner {
			    display: none;
			}
		';
	}



/*
** Blog Page =====
*/

	// Gutter
	$css .= '
		.blog-grid > li {
			width: 100%;
			margin-bottom: ' . $blog_page_gutter_vert . 'px;
		}
	';

	if ( is_active_sidebar( 'sidebar-left' ) && is_active_sidebar( 'sidebar-right' ) ) {
		$css .= '
			.sidebar-right {
				padding-left: ' . $blog_page_gutter_horz . 'px;
			}
			.sidebar-left {
				padding-right: ' . $blog_page_gutter_horz . 'px;
			}
		';
	} else if ( is_active_sidebar( 'sidebar-left' ) ) {
		$css .= '
			.sidebar-left {
				padding-right: ' . $blog_page_gutter_horz . 'px;
			}
		';
	} else if ( is_active_sidebar( 'sidebar-right' ) || ashe_is_preview() ) {
		$css .= '
			.sidebar-right {
				padding-left: ' . $blog_page_gutter_horz . 'px;
			}
		';
	}

	// Blog Page Dropcups
	if ( ashe_true_false(ashe_options( 'blog_page_show_dropcaps' )) === true ) {
		$css .= '
			.post-content > p:not(.wp-block-tag-cloud):first-of-type:first-letter {	
			  font-family: "Playfair Display";
			  font-weight: 400;
			  float: left;
			  margin: 0px 12px 0 0;
			  font-size: 80px;
			  line-height: 65px;
			  text-align: center;
			}

			.blog-post .post-content > p:not(.wp-block-tag-cloud):first-of-type:first-letter {
			  color: #030303;
			}

			@-moz-document url-prefix() {
				.post-content > p:not(.wp-block-tag-cloud):first-of-type:first-letter {
				    margin-top: 10px !important;
				}
			}
		';
	}



/*
** Page Footer =====
*/

	// Widget Columns
	$css .= '
		.footer-widgets > .ashe-widget {
			width: 30%;
			margin-right: 5%;
		}

		.footer-widgets > .ashe-widget:nth-child(3n+3) {
			margin-right: 0;
		}

		.footer-widgets > .ashe-widget:nth-child(3n+4) {
			clear: both;
		}
	';

	// Align
	$css .= '
		.copyright-info {
			float: right;
		}
		.footer-socials {
			float: left;
		}
	'; 


/*
** Woocommerce =====
*/

	/* Text */
	$css .= '
		.woocommerce div.product .stock,
		.woocommerce div.product p.price,
		.woocommerce div.product span.price,
		.woocommerce ul.products li.product .price,
		.woocommerce-Reviews .woocommerce-review__author,
		.woocommerce form .form-row .required,
		.woocommerce form .form-row.woocommerce-invalid label,
		.woocommerce .page-content div.product .woocommerce-tabs ul.tabs li a {
		    color: #464646;
		}

		.woocommerce a.remove:hover {
		    color: #464646 !important;
		}
	';

	/* Meta */
	$css .= '
		.woocommerce a.remove,
		.woocommerce .product_meta,
		.page-content .woocommerce-breadcrumb,
		.page-content .woocommerce-review-link,
		.page-content .woocommerce-breadcrumb a,
		.page-content .woocommerce-MyAccount-navigation-link a,
		.woocommerce .woocommerce-info:before,
		.woocommerce .page-content .woocommerce-result-count,
		.woocommerce-page .page-content .woocommerce-result-count,
		.woocommerce-Reviews .woocommerce-review__published-date,
		.woocommerce .product_list_widget .quantity,
		.woocommerce .widget_products .amount,
		.woocommerce .widget_price_filter .price_slider_amount,
		.woocommerce .widget_recently_viewed_products .amount,
		.woocommerce .widget_top_rated_products .amount,
		.woocommerce .widget_recent_reviews .reviewer {
		    color: #a1a1a1;
		}

		.woocommerce a.remove {
		    color: #a1a1a1 !important;
		}
	';

	/* Accent */
	$css .= '
		p.demo_store,
		.woocommerce-store-notice,
		.woocommerce span.onsale {
		   background-color: '. esc_html(ashe_options( 'colors_content_accent' )) .';
		}

		.woocommerce .star-rating::before,
		.woocommerce .star-rating span::before,
		.woocommerce .page-content ul.products li.product .button,
		.page-content .woocommerce ul.products li.product .button,
		.page-content .woocommerce-MyAccount-navigation-link.is-active a,
		.page-content .woocommerce-MyAccount-navigation-link a:hover {
		   color: '. esc_html(ashe_options( 'colors_content_accent' )) .';
		}
	';

	/* Border Color */
	$css .= '
		.woocommerce form.login,
		.woocommerce form.register,
		.woocommerce-account fieldset,
		.woocommerce form.checkout_coupon,
		.woocommerce .woocommerce-info,
		.woocommerce .woocommerce-error,
		.woocommerce .woocommerce-message,
		.woocommerce .widget_shopping_cart .total,
		.woocommerce.widget_shopping_cart .total,
		.woocommerce-Reviews .comment_container,
		.woocommerce-cart #payment ul.payment_methods,
		#add_payment_method #payment ul.payment_methods,
		.woocommerce-checkout #payment ul.payment_methods,
		.woocommerce div.product .woocommerce-tabs ul.tabs::before,
		.woocommerce div.product .woocommerce-tabs ul.tabs::after,
		.woocommerce div.product .woocommerce-tabs ul.tabs li,
		.woocommerce .woocommerce-MyAccount-navigation-link,
		.select2-container--default .select2-selection--single {
			border-color: #e8e8e8;
		}

		.woocommerce-cart #payment,
		#add_payment_method #payment,
		.woocommerce-checkout #payment,
		.woocommerce .woocommerce-info,
		.woocommerce .woocommerce-error,
		.woocommerce .woocommerce-message,
		.woocommerce div.product .woocommerce-tabs ul.tabs li {
			background-color: '. esc_html(ashe_hex2rgba( '#e8e8e8', 0.3 )) .';
		}

		.woocommerce-cart #payment div.payment_box::before,
		#add_payment_method #payment div.payment_box::before,
		.woocommerce-checkout #payment div.payment_box::before {
			border-color: '. esc_html(ashe_hex2rgba( '#e8e8e8', 0.5 )) .';
		}

		.woocommerce-cart #payment div.payment_box,
		#add_payment_method #payment div.payment_box,
		.woocommerce-checkout #payment div.payment_box {
			background-color: '. esc_html(ashe_hex2rgba( '#e8e8e8', 0.5 )) .';
		}
	';

	/* Buttons */
	$css .= '
		.page-content .woocommerce input.button,
		.page-content .woocommerce a.button,
		.page-content .woocommerce a.button.alt,
		.page-content .woocommerce button.button.alt,
		.page-content .woocommerce input.button.alt,
		.page-content .woocommerce #respond input#submit.alt,
		.woocommerce .page-content .widget_product_search input[type="submit"],
		.woocommerce .page-content .woocommerce-message .button,
		.woocommerce .page-content a.button.alt,
		.woocommerce .page-content button.button.alt,
		.woocommerce .page-content #respond input#submit,
		.woocommerce .page-content .widget_price_filter .button,
		.woocommerce .page-content .woocommerce-message .button,
		.woocommerce-page .page-content .woocommerce-message .button,
		.woocommerce .page-content nav.woocommerce-pagination ul li a,
		.woocommerce .page-content nav.woocommerce-pagination ul li span {
			color: #ffffff;
			background-color: #333333;
		}

		.page-content .woocommerce input.button:hover,
		.page-content .woocommerce a.button:hover,
		.page-content .woocommerce a.button.alt:hover,
		.ashe-boxed-style .page-content .woocommerce a.button.alt:hover,
		.page-content .woocommerce button.button.alt:hover,
		.page-content .woocommerce input.button.alt:hover,
		.page-content .woocommerce #respond input#submit.alt:hover,
		.woocommerce .page-content .woocommerce-message .button:hover,
		.woocommerce .page-content a.button.alt:hover,
		.woocommerce .page-content button.button.alt:hover,
		.ashe-boxed-style.woocommerce .page-content button.button.alt:hover,
		.ashe-boxed-style.woocommerce .page-content #respond input#submit:hover,
		.woocommerce .page-content #respond input#submit:hover,
		.woocommerce .page-content .widget_price_filter .button:hover,
		.woocommerce .page-content .woocommerce-message .button:hover,
		.woocommerce-page .page-content .woocommerce-message .button:hover,
		.woocommerce .page-content nav.woocommerce-pagination ul li a:hover,
		.woocommerce .page-content nav.woocommerce-pagination ul li span.current {
			color: #ffffff;
			background-color: '. esc_html(ashe_options( 'colors_content_accent' )) .';
		}

		.woocommerce .page-content nav.woocommerce-pagination ul li a.prev,
		.woocommerce .page-content nav.woocommerce-pagination ul li a.next {
			color: #333333;
		}

		.woocommerce .page-content nav.woocommerce-pagination ul li a.prev:hover,
		.woocommerce .page-content nav.woocommerce-pagination ul li a.next:hover {
			color: '. esc_html(ashe_options( 'colors_content_accent' )) .';
		}

		.woocommerce .page-content nav.woocommerce-pagination ul li a.prev:after,
		.woocommerce .page-content nav.woocommerce-pagination ul li a.next:after {
			color: #ffffff;
		}

		.woocommerce .page-content nav.woocommerce-pagination ul li a.prev:hover:after,
		.woocommerce .page-content nav.woocommerce-pagination ul li a.next:hover:after {
			color: #ffffff;
		}
	';


/*
** Preloader =====
*/

	$css .= '.cssload-cube{background-color:#333333;width:9px;height:9px;position:absolute;margin:auto;animation:cssload-cubemove 2s infinite ease-in-out;-o-animation:cssload-cubemove 2s infinite ease-in-out;-ms-animation:cssload-cubemove 2s infinite ease-in-out;-webkit-animation:cssload-cubemove 2s infinite ease-in-out;-moz-animation:cssload-cubemove 2s infinite ease-in-out}.cssload-cube1{left:13px;top:0;animation-delay:.1s;-o-animation-delay:.1s;-ms-animation-delay:.1s;-webkit-animation-delay:.1s;-moz-animation-delay:.1s}.cssload-cube2{left:25px;top:0;animation-delay:.2s;-o-animation-delay:.2s;-ms-animation-delay:.2s;-webkit-animation-delay:.2s;-moz-animation-delay:.2s}.cssload-cube3{left:38px;top:0;animation-delay:.3s;-o-animation-delay:.3s;-ms-animation-delay:.3s;-webkit-animation-delay:.3s;-moz-animation-delay:.3s}.cssload-cube4{left:0;top:13px;animation-delay:.1s;-o-animation-delay:.1s;-ms-animation-delay:.1s;-webkit-animation-delay:.1s;-moz-animation-delay:.1s}.cssload-cube5{left:13px;top:13px;animation-delay:.2s;-o-animation-delay:.2s;-ms-animation-delay:.2s;-webkit-animation-delay:.2s;-moz-animation-delay:.2s}.cssload-cube6{left:25px;top:13px;animation-delay:.3s;-o-animation-delay:.3s;-ms-animation-delay:.3s;-webkit-animation-delay:.3s;-moz-animation-delay:.3s}.cssload-cube7{left:38px;top:13px;animation-delay:.4s;-o-animation-delay:.4s;-ms-animation-delay:.4s;-webkit-animation-delay:.4s;-moz-animation-delay:.4s}.cssload-cube8{left:0;top:25px;animation-delay:.2s;-o-animation-delay:.2s;-ms-animation-delay:.2s;-webkit-animation-delay:.2s;-moz-animation-delay:.2s}.cssload-cube9{left:13px;top:25px;animation-delay:.3s;-o-animation-delay:.3s;-ms-animation-delay:.3s;-webkit-animation-delay:.3s;-moz-animation-delay:.3s}.cssload-cube10{left:25px;top:25px;animation-delay:.4s;-o-animation-delay:.4s;-ms-animation-delay:.4s;-webkit-animation-delay:.4s;-moz-animation-delay:.4s}.cssload-cube11{left:38px;top:25px;animation-delay:.5s;-o-animation-delay:.5s;-ms-animation-delay:.5s;-webkit-animation-delay:.5s;-moz-animation-delay:.5s}.cssload-cube12{left:0;top:38px;animation-delay:.3s;-o-animation-delay:.3s;-ms-animation-delay:.3s;-webkit-animation-delay:.3s;-moz-animation-delay:.3s}.cssload-cube13{left:13px;top:38px;animation-delay:.4s;-o-animation-delay:.4s;-ms-animation-delay:.4s;-webkit-animation-delay:.4s;-moz-animation-delay:.4s}.cssload-cube14{left:25px;top:38px;animation-delay:.5s;-o-animation-delay:.5s;-ms-animation-delay:.5s;-webkit-animation-delay:.5s;-moz-animation-delay:.5s}.cssload-cube15{left:38px;top:38px;animation-delay:.6s;-o-animation-delay:.6s;-ms-animation-delay:.6s;-webkit-animation-delay:.6s;-moz-animation-delay:.6s}.cssload-spinner{margin:auto;width:49px;height:49px;position:relative}@keyframes cssload-cubemove{35%{transform:scale(0.005)}50%{transform:scale(1.7)}65%{transform:scale(0.005)}}@-o-keyframes cssload-cubemove{35%{-o-transform:scale(0.005)}50%{-o-transform:scale(1.7)}65%{-o-transform:scale(0.005)}}@-ms-keyframes cssload-cubemove{35%{-ms-transform:scale(0.005)}50%{-ms-transform:scale(1.7)}65%{-ms-transform:scale(0.005)}}@-webkit-keyframes cssload-cubemove{35%{-webkit-transform:scale(0.005)}50%{-webkit-transform:scale(1.7)}65%{-webkit-transform:scale(0.005)}}@-moz-keyframes cssload-cubemove{35%{-moz-transform:scale(0.005)}50%{-moz-transform:scale(1.7)}65%{-moz-transform:scale(0.005)}}';

/*
** Simple Header Option =====
*/

	if ( true === ashe_options( 'main_nav_simple_header' ) ) {
		$css .= '
			.main-nav-sidebar div {
			  max-height: 70px;
			}

			#main-nav {
			  min-height: 70px;
			}

			#main-menu li a,
			.mobile-menu-btn,
			.dark-mode-switcher,
			.main-nav-socials a,
			.main-nav-search,
			#main-nav #s {
			  line-height: 70px;
			}

			.main-nav-sidebar,
			.mini-logo {
			  height: 70px;
			}
		';
	}


// end style block
$css .= '</style>';

// return generated & compressed CSS
echo str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $css); 


} // end ashe_dynamic_css()
add_action( 'wp_head', 'ashe_dynamic_css' );
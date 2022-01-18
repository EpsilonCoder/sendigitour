<?php

/* 
** Sets up theme defaults and registers support for various WordPress features
*/
function ashe_setup() {
	// Make theme available for translation
	load_theme_textdomain( 'ashe', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head
	add_theme_support( 'automatic-feed-links' );

	// Let WordPress manage the document title for us
	add_theme_support( 'title-tag' );

	// Enable support for Post Thumbnails on posts and pages
	add_theme_support( 'post-thumbnails' );

	// Add theme support for Custom Logo.
	$custom_logo_defaults = array(
		'width'       => 450,
		'height'      => 200,
		'flex-width'  => true,
		'flex-height' => true,
	);
	add_theme_support( 'custom-logo', $custom_logo_defaults );

	// Add theme support for Custom Header.
	$custom_header_defaults = array(
		'width'       			=> 1300,
		'height'      			=> 500,
		'flex-width'  			=> true,
		'flex-height' 			=> true,
		'default-image' 		=> esc_url( get_template_directory_uri() ) .'/assets/images/ashe_bg.jpg',
		'default-text-color'	=> '111',
	);
	add_theme_support( 'custom-header', $custom_header_defaults );

	// Add theme support for Custom Background.
	$custom_background_defaults = array(
		'default-color'	=> '',
	);
	add_theme_support( 'custom-background', $custom_background_defaults );

	// Set the default content width.
	$GLOBALS['content_width'] = 960;

	// This theme uses wp_nav_menu() in two locations
	register_nav_menus( array(
		'top'		=> __( 'Top Menu', 'ashe' ),
		'main' 		=> __( 'Main Menu', 'ashe' ),
		'footer' 	=> __( 'Footer Menu', 'ashe' ),
	) );

	// Switch default core markup for search form, comment form, and comments to output valid HTML5
	add_theme_support( 'html5', array(
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	// Gutenberg Embeds
	add_theme_support( 'responsive-embeds' ); 

	// WooCommerce
	add_theme_support( 'woocommerce' );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );

	// Theme Activation Notice
	// add_action( 'admin_notices', 'ashe_activation_notice' );
	add_action( 'admin_notices', 'ashe_classic_widgets_notice' );

	// Add Image Sizes
	ashe_add_image_sizes();
	
}
add_action( 'after_setup_theme', 'ashe_setup' );


/*
** Notice after Theme Activation and Update.
*/
function ashe_activation_notice() {
	if ( isset($_GET['page']) ) {
		return;
	}

	global $pagenow;
	global $current_user;

	$user_id	 = $current_user->ID;
	$theme_data	 = wp_get_theme();
	$theme_vers	 = str_replace( '.', '_', $theme_data->get( 'Version' ) );

	if ( ! get_user_meta( $user_id, esc_html( $theme_data->get( 'TextDomain' ) ) . $theme_vers .'_notice_ignore' ) ) {

		echo '<div class="notice notice-success ashe-activation-notice">';

			printf( '<a href="%1$s" class="notice-dismiss dashicons dashicons-dismiss dashicons-dismiss-icon"></a>', '?' . esc_html( $theme_data->get( 'TextDomain' ) ) . $theme_vers .'_notice_ignore=0' );
		
			echo '<p>';
				/* translators: %1$s: theme name, %2$s link */
				printf( __( 'Thank you for choosing %1$s! To fully take advantage of the best our theme can offer please make sure you visit our <a href="%2$s">Welcome page</a>', 'ashe' ), esc_html( $theme_data->Name ), esc_url( admin_url( 'themes.php?page=about-ashe' ) ) );
			echo '</p>';

			echo '<p><a href="'. esc_url( admin_url( 'themes.php?page=about-ashe' ) ) .'" class="button button-primary">';
				/* translators: %s theme name */
				printf( esc_html__( 'Get started with %s', 'ashe' ), esc_html( $theme_data->Name ) );
			echo '</a></p>';

		echo '</div>';

	}
}

function ashe_notice_ignore() {
	global $current_user;
	$theme_data	 = wp_get_theme();
	$user_id	 = $current_user->ID;
	$theme_vers	 = str_replace( '.', '_', $theme_data->get( 'Version' ) );

	/* If user clicks to ignore the notice, add that to their user meta */
	if ( isset( $_GET[ esc_html( $theme_data->get( 'TextDomain' ) ) . $theme_vers .'_notice_ignore' ] ) && '0' == $_GET[ esc_html( $theme_data->get( 'TextDomain' ) ) . $theme_vers .'_notice_ignore' ] ) {
		add_user_meta( $user_id, esc_html( $theme_data->get( 'TextDomain' ) ) . $theme_vers .'_notice_ignore', 'true', true );
	}
}
add_action( 'admin_init', 'ashe_notice_ignore' );

function ashe_erase_ignored_notice() {
	global $current_user;
	$theme_data	 = wp_get_theme();
	$user_id	 = $current_user->ID;
	$theme_vers	 = str_replace( '.', '_', $theme_data->get( 'Version' ) );
	
	delete_user_meta( $user_id, esc_html( $theme_data->get( 'TextDomain' ) ) . $theme_vers .'_notice_ignore' );
}
add_action('after_switch_theme', 'ashe_erase_ignored_notice');

function ashe_admin_scripts() {
	
	// Theme Activation Notice
	wp_enqueue_style( 'ashe-admin', get_theme_file_uri( '/assets/css/admin.css' ) );

}
add_action( 'admin_enqueue_scripts', 'ashe_admin_scripts' );


/*
** Notice for Classic Widgets Editor.
*/
function ashe_classic_widgets_notice() {
	$screen = get_current_screen();

	if ( ! $screen || 'widgets' !== $screen->base || file_exists(ABSPATH . 'wp-content/plugins/classic-widgets/classic-widgets.php') ) {
		return;
	}

    ?>

    <div class="notice is-dismissible ashe-widgets-notice-wrap">
    	<div>
        	<p><?php esc_html_e( 'Want to switch back to the Classic Widgets?', 'ashe' ); ?></p>

			<a class="button-primary" href="<?php echo esc_url( wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin=classic-widgets' ), 'install-plugin_classic-widgets' ) ); ?>" >
				<?php esc_html_e( 'Install Now', 'ashe' ); ?>
			</a>
        </div>
    </div>

	<style>.widgets-php .ashe-widgets-notice-wrap{display:-webkit-box!important;display:-ms-flexbox!important;display:flex!important;max-width:360px;margin:0 auto;z-index:999;background:0 0;border:none;-webkit-box-shadow:none;box-shadow:none;-webkit-box-align:center;-ms-flex-align:center;align-items:center;-webkit-box-pack:center;-ms-flex-pack:center;justify-content:center;margin-top:10px}.widgets-php .ashe-widgets-notice-wrap>div{display:-webkit-box;display:-ms-flexbox;display:flex}.widgets-php .ashe-widgets-notice-wrap .button-primary{height:20px;line-height:26px;font-size:12px;letter-spacing:.5px;margin-left:10px;margin-top:5px}.widgets-php .ashe-widgets-notice-wrap .notice-dismiss{display:none}.widgets-php .ashe-widgets-notice{text-align:center} </style>

    <?php
}


/**
** Add a pingback url auto-discovery header for singularly identifiable articles.
*/
function ashe_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">' . "\n", get_bloginfo( 'pingback_url' ) );
	}
}
add_action( 'wp_head', 'ashe_pingback_header' );


/*
** Enqueue scripts and styles
*/
function ashe_scripts() {

	// Theme Stylesheet
	wp_enqueue_style( 'ashe-style', get_stylesheet_uri(), array(), '1.9.7' );

	// FontAwesome Icons
	wp_enqueue_style( 'fontawesome', get_theme_file_uri( '/assets/css/font-awesome.css' ) );

	// Fontello Icons
	wp_enqueue_style( 'fontello', get_theme_file_uri( '/assets/css/fontello.css' ) );

	// Slick Slider
	wp_enqueue_style( 'slick', get_theme_file_uri( '/assets/css/slick.css' ) );

	// Scrollbar
	wp_enqueue_style( 'scrollbar', get_theme_file_uri( '/assets/css/perfect-scrollbar.css' ) );

	// WooCommerce
	if ( class_exists( 'WooCommerce' ) ) {
		wp_enqueue_style( 'ashe-woocommerce', get_theme_file_uri( '/assets/css/woocommerce.css' ) );
	}
	
	// Theme Responsive CSS
	wp_enqueue_style( 'ashe-responsive', get_theme_file_uri( '/assets/css/responsive.css' ), array(), '1.9.7'  );

	// Enqueue Custom Scripts
	wp_enqueue_script( 'ashe-plugins', get_theme_file_uri( '/assets/js/custom-plugins.js' ), array( 'jquery' ), '1.8.2', true );
	wp_enqueue_script( 'ashe-custom-scripts', get_theme_file_uri( '/assets/js/custom-scripts.js' ), array( 'jquery' ), '1.9.7', true );

	// Comment reply link
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
	
}
add_action( 'wp_enqueue_scripts', 'ashe_scripts' );


/*
** Enqueue Google Fonts
*/
function ashe_playfair_font_url() {
    $font_url = '';
    if ( 'off' !== _x( 'on', 'Google font: on or off', 'ashe' ) ) {
        $font_url = add_query_arg( 'family', urlencode( 'Playfair Display:400,700' ), "//fonts.googleapis.com/css" );
    }
    return $font_url;
}

function ashe_opensans_font_url() {
    $font_url = '';
    if ( 'off' !== _x( 'on', 'Google font: on or off', 'ashe' ) ) {
        $font_url = add_query_arg( 'family', urlencode( 'Open Sans:400italic,400,600italic,600,700italic,700' ), "//fonts.googleapis.com/css" );
    }
    return $font_url;
}

function ashe_kalam_font_url() {
    $font_url = '';
    if ( 'off' !== _x( 'on', 'Google font: on or off', 'ashe' ) ) {
        $font_url = add_query_arg( 'family', urlencode( 'Kalam' ), "//fonts.googleapis.com/css" );
    }
    return $font_url;
}

function ashe_rokkitt_font_url() {
    $font_url = '';
    if ( 'off' !== _x( 'on', 'Google font: on or off', 'ashe' ) ) {
        $font_url = add_query_arg( 'family', urlencode( 'Rokkitt' ), "//fonts.googleapis.com/css" );
    }
    return $font_url;
}



function ashe_gfonts_scripts() {
    wp_enqueue_style( 'ashe-playfair-font', ashe_playfair_font_url(), array(), '1.0.0' );
    wp_enqueue_style( 'ashe-opensans-font', ashe_opensans_font_url(), array(), '1.0.0' );

    // Load Kalam if selected
    if ( ashe_options( 'typography_logo_family' ) == 'Kalam' || ashe_options( 'typography_nav_family' ) == 'Kalam' ) {
    	wp_enqueue_style( 'ashe-kalam-font', ashe_kalam_font_url(), array(), '1.0.0' );
    }

    // Load Rokkitt if selected
    if ( ashe_options( 'typography_logo_family' ) == 'Rokkitt' || ashe_options( 'typography_nav_family' ) == 'Rokkitt' ) {
    	wp_enqueue_style( 'ashe-rokkitt-font', ashe_rokkitt_font_url(), array(), '1.0.0' );
    }
}
add_action( 'wp_enqueue_scripts', 'ashe_gfonts_scripts' );


/*
** Register widget areas.
*/
function ashe_widgets_init() {
	
	register_sidebar( array(
		'name'          => __( 'Right Sidebar', 'ashe' ),
		'id'            => 'sidebar-right',
		'description'   => __( 'Add widgets here to appear in your sidebar.', 'ashe' ),
		'before_widget' => '<div id="%1$s" class="ashe-widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<div class="widget-title"><h2>',
		'after_title'   => '</h2></div>',
	) );

	register_sidebar( array(
		'name'          => __( 'Left Sidebar', 'ashe' ),
		'id'            => 'sidebar-left',
		'description'   => __( 'Add widgets here to appear in your sidebar.', 'ashe' ),
		'before_widget' => '<div id="%1$s" class="ashe-widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<div class="widget-title"><h2>',
		'after_title'   => '</h2></div>',
	) );

	register_sidebar( array(
		'name'          => __( 'Sidebar Alt', 'ashe' ),
		'id'            => 'sidebar-alt',
		'description'   => __( 'Add widgets here to appear in your alternative/fixed sidebar.', 'ashe' ),
		'before_widget' => '<div id="%1$s" class="ashe-widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<div class="widget-title"><h2>',
		'after_title'   => '</h2></div>',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer Widgets', 'ashe' ),
		'id'            => 'footer-widgets',
		'description'   => __( 'Add widgets here to appear in your footer.', 'ashe' ),
		'before_widget' => '<div id="%1$s" class="ashe-widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<div class="widget-title"><h2>',
		'after_title'   => '</h2></div>',
	) );

}
add_action( 'widgets_init', 'ashe_widgets_init' );

/*
** Custom Image Sizes
*/
if ( ! function_exists( 'ashe_add_image_sizes' ) ) {
	function ashe_add_image_sizes() {
		add_image_size( 'ashe-slider-full-thumbnail', 1080, 540, true );
		add_image_size( 'ashe-full-thumbnail', 1140, 0, true );
		add_image_size( 'ashe-list-thumbnail', 300, 300, true );
		add_image_size( 'ashe-grid-thumbnail', 500, 330, true );
		add_image_size( 'ashe-single-navigation', 75, 75, true );	
	}
}


/*
**  Top Menu Fallback
*/

function ashe_top_menu_fallback() {
	if ( current_user_can( 'edit_theme_options' ) ) {
		echo '<ul id="top-menu">';
			echo '<li>';
				echo '<a href="'. esc_url( admin_url('nav-menus.php') ) .'">'. esc_html__( 'Setup Menu', 'ashe' ) .'</a>';
			echo '</li>';
		echo '</ul>';
	}
}

/*
**  Main Menu Fallback
*/

function ashe_main_menu_fallback() {
	if ( ashe_is_preview() ) {
		echo '<ul id="main-menu">';
			ashe_preview_navigation();
		echo '</ul>';
	} else {
		if ( current_user_can( 'edit_theme_options' ) ) {
			echo '<ul id="main-menu">';
				echo '<li>';
					echo '<a href="'. esc_url( admin_url('nav-menus.php') ) .'">'. esc_html__( 'Setup Menu', 'ashe' ) .'</a>';
				echo '</li>';
			echo '</ul>';
		}
	}
}

/*
**  Custom Excerpt Length
*/

function ashe_excerpt_length( $link ) {

	if ( is_admin() ) {
		return $link;
	}

	$link = sprintf( '<p class="link-more"><a href="%1$s" class="more-link">%2$s</a></p>',
		esc_url( get_permalink( get_the_ID() ) ),
		/* translators: %s: Name of current post */
		sprintf( __( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'ashe' ), get_the_title( get_the_ID() ) )
	);

	return 2000;
}
add_filter( 'excerpt_length', 'ashe_excerpt_length', 999 );

function ashe_new_excerpt( $link ) {

	if ( is_admin() ) {
		return $link;
	}

	$link = sprintf( '<p class="link-more"><a href="%1$s" class="more-link">%2$s</a></p>',
		esc_url( get_permalink( get_the_ID() ) ),
		/* translators: %s: Name of current post */
		sprintf( __( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'ashe' ), get_the_title( get_the_ID() ) )
	);

	return '...';
}
add_filter( 'excerpt_more', 'ashe_new_excerpt' );

if ( ! function_exists( 'ashe_excerpt' ) ) {

	function ashe_excerpt( $limit = 50 ) {
	    echo '<p>'. wp_trim_words(get_the_excerpt(), $limit) .'</p>';
	}

}

/*
** Custom Functions
*/

// HEX to RGBA Converter
function ashe_hex2rgba( $color, $opacity = 1 ) {

	// remove '#' from string
	$color = substr( $color, 1 );

	// get values from string
	$hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );

    // convert HEX to RGB
    $rgb = array_map( 'hexdec', $hex );

    // convert HEX to RGBA
	$output = 'rgba('. implode( ",", $rgb ) .', '. $opacity .')';

    return $output;
}

// Retrieves the attachment src from the file URL
function ashe_get_image_src_by_url( $image_url, $image_size ) {
	if ( ! isset($image_url) || '' === $image_url ) {
		return [ 0 => null ];
	} else {
		return wp_get_attachment_image_src( attachment_url_to_postid($image_url), $image_size );
	}
}

// Social Media
if ( ! function_exists( 'ashe_social_media' ) ) {

	function ashe_social_media( $social_class='' ) {

	?>

		<div class="<?php echo esc_attr( $social_class ); ?>">

			<?php
			$social_window = ( ashe_options( 'social_media_window' ) === true )?'_blank':'_self';
			if ( ashe_options( 'social_media_url_1' ) !== '' ) :
			?>

			<a href="<?php echo esc_url( ashe_options( 'social_media_url_1' ) ); ?>" target="<?php echo esc_attr($social_window); ?>">
				<i class="fa fa-<?php echo esc_attr(ashe_options( 'social_media_icon_1' )); ?>"></i>
			</a>
			<?php endif; ?>

			<?php if ( ashe_options( 'social_media_url_2' ) !== '' ) : ?>
				<a href="<?php echo esc_url( ashe_options( 'social_media_url_2' ) ); ?>" target="<?php echo esc_attr($social_window); ?>">
					<i class="fa fa-<?php echo esc_attr(ashe_options( 'social_media_icon_2' )); ?>"></i>
				</a>
			<?php endif; ?>

			<?php if ( ashe_options( 'social_media_url_3' ) !== '' ) : ?>
				<a href="<?php echo esc_url( ashe_options( 'social_media_url_3' ) ); ?>" target="<?php echo esc_attr($social_window); ?>">
					<i class="fa fa-<?php echo esc_attr(ashe_options( 'social_media_icon_3' )); ?>"></i>
				</a>
			<?php endif; ?>

			<?php if ( ashe_options( 'social_media_url_4' ) !== '' ) : ?>
				<a href="<?php echo esc_url( ashe_options( 'social_media_url_4' ) ); ?>" target="<?php echo esc_attr($social_window); ?>">
					<i class="fa fa-<?php echo esc_attr(ashe_options( 'social_media_icon_4' )); ?>"></i>
				</a>
			<?php endif; ?>

		</div>

	<?php

	} // ashe_social_media()

} // function_exists( 'ashe_social_media' )


// Related Posts
if ( ! function_exists( 'ashe_related_posts' ) ) {
	
	function ashe_related_posts( $title, $orderby ) {

		if ( $orderby === 'none' ) {
			return;
		}

		global $post;
		$current_categories	= get_the_category();

		if ( $current_categories ) {

			$first_category	= $current_categories[0]->term_id;

			$args = array(
				'post_type'				=> 'post',
				'category__in'			=> array( $first_category ),
				'post__not_in'			=> array( $post->ID ),
				'orderby'				=> 'rand',
				'posts_per_page'		=> 3,
				'ignore_sticky_posts'	=> 1,
			    'meta_query' => array(
			        array(
			         'key' => '_thumbnail_id',
			         'compare' => 'EXISTS'
			        ),
			    )
			);

			if ( ashe_is_preview() ) {
				array_pop($args);
			}

			$similar_posts = new WP_Query( $args );	

			if ( $similar_posts->have_posts() ) {

			?>

			<div class="related-posts">
				<h3><?php echo esc_html( $title ); ?></h3>

				<?php  while ( $similar_posts->have_posts() ) : $similar_posts->the_post(); ?>

					<section>
						<a href="<?php echo esc_url( get_permalink() ); ?>"><?php the_post_thumbnail('ashe-grid-thumbnail'); ?></a>
						<h4><a href="<?php echo esc_url( get_permalink() ); ?>"><?php the_title(); ?></a></h4>
						<span class="related-post-date"><?php echo get_the_time( get_option('date_format') ); ?></span>
					</section>

				<?php endwhile; ?>

				<div class="clear-fix"></div>
			</div>

			<?php

			} // end have_posts()

		} // if ( $current_categories )

		wp_reset_postdata();

	} // ashe_related_posts()
} // function_exists( 'ashe_related_posts' )


/*
** Custom Search Form
*/
function ashe_custom_search_form( $html ) {

	$html  = '<form role="search" method="get" id="searchform" class="clear-fix" action="'. esc_url( home_url( '/' ) ) .'">';
	$html .= '<input type="search" name="s" id="s" placeholder="'. esc_attr__( 'Search...', 'ashe' ) .'" data-placeholder="'. esc_attr__( 'Type then hit Enter...', 'ashe' ) .'" value="'. get_search_query() .'" />';
	$html .= '<i class="fa fa-search"></i>';
	$html .= '<input type="submit" id="searchsubmit" value="st" />';
	$html .= '</form>';

	return $html;
}
add_filter( 'get_search_form', 'ashe_custom_search_form' );


/*
**  Post Share
*/

function ashe_post_sharing_check() {
	if ( ashe_options( 'blog_page_show_facebook' ) || ashe_options( 'blog_page_show_twitter' ) || ashe_options( 'blog_page_show_pinterest' ) || ashe_options( 'blog_page_show_google' ) || ashe_options( 'blog_page_show_linkedin' ) || ashe_options( 'blog_page_show_tumblr' ) || ashe_options( 'blog_page_show_reddit' ) ) {
	return true;
	}
	return false;
}


if ( ! function_exists( 'ashe_post_sharing' ) ) { 
	function ashe_post_sharing() {	
	
	global $post; ?>	
	<div class="post-share">

		<?php if ( ashe_options( 'blog_page_show_facebook' ) ) : 
		$facebook_src = 'https://www.facebook.com/sharer/sharer.php?u='.esc_url( get_the_permalink() ); ?>
		<a class="facebook-share" target="_blank" href="<?php echo esc_url ( $facebook_src ); ?>">
			<i class="fa fa-facebook"></i>
		</a>
		<?php endif; ?>

		<?php if ( ashe_options( 'blog_page_show_twitter' ) ) : 
		$twitter_src = 'https://twitter.com/intent/tweet?url='. esc_url( get_the_permalink() ); ?>
		<a class="twitter-share" target="_blank" href="<?php echo esc_url ( $twitter_src ); ?>">
			<i class="fa fa-twitter"></i>
		</a>
		<?php endif; ?>

		<?php if ( ashe_options( 'blog_page_show_pinterest' ) ) : 
		$pinterest_src = 'https://pinterest.com/pin/create/button/?url='.esc_url( get_the_permalink() ).'&amp;media='.esc_url( wp_get_attachment_url( get_post_thumbnail_id($post->ID)) ).'&amp;description='.get_the_title(); ?>
		<a class="pinterest-share" target="_blank" href="<?php echo esc_url ( $pinterest_src ); ?>">
			<i class="fa fa-pinterest"></i>
		</a>
		<?php endif; ?>

		<?php if ( ashe_options( 'blog_page_show_google' ) ) : 
		$google_src = 'https://plus.google.com/share?url='. esc_url( get_the_permalink() ); ?>
		<a class="googleplus-share" target="_blank" href="<?php echo esc_url ( $google_src ); ?>">
			<i class="fa fa-google-plus"></i>
		</a>										
		<?php endif; ?>

		<?php if ( ashe_options( 'blog_page_show_linkedin' ) ) :
		$linkedin_src = 'http://www.linkedin.com/shareArticle?url='.esc_url( get_the_permalink() ).'&amp;title='.get_the_title(); ?>
		<a class="linkedin-share" target="_blank" href="<?php echo esc_url( $linkedin_src ); ?>">
			<i class="fa fa-linkedin"></i>
		</a>
		<?php endif; ?>

		<?php if ( ashe_options( 'blog_page_show_tumblr' ) ) : 
		$tumblr_src = 'http://www.tumblr.com/share/link?url='. urlencode( esc_url(get_permalink()) ) .'&amp;name='.urlencode( get_the_title() ).'&amp;description='.urlencode( wp_trim_words( get_the_excerpt(), 50 ) ); ?>
		<a class="tumblr-share" target="_blank" href="<?php echo esc_url( $tumblr_src ); ?>">
			<i class="fa fa-tumblr"></i>
		</a>
		<?php endif; ?>

		<?php if ( ashe_options( 'blog_page_show_reddit' ) ) : 
		$reddit_src = 'http://reddit.com/submit?url='. esc_url( get_the_permalink() ) .'&amp;title='.get_the_title(); ?>
		<a class="reddit-share" target="_blank" href="<?php echo esc_url( $reddit_src ); ?>">
			<i class="fa fa-reddit"></i>
		</a>
		<?php endif; ?>

	</div>
	<?php
	}
}


/*
** Comments Form Section
*/

if ( ! function_exists( 'ashe_comments' ) ) {

	function ashe_comments ( $comment, $args, $depth ) {
		$_GLOBAL['comment'] = $comment;

		if (get_comment_type() == 'pingback' || get_comment_type() == 'trackback' ) : ?>
			
		<li class="pingback" id="comment-<?php comment_ID(); ?>">
			<article <?php comment_class('entry-comments'); ?> >
				<div class="comment-content">
					<h3 class="comment-author"><?php esc_html_e( 'Pingback:', 'ashe' ); ?></h3>	
					<div class="comment-meta">		
						<a class="comment-date" href=" <?php echo esc_url( get_comment_link() ); ?> "><?php comment_date( get_option('date_format') ); esc_html_e( '&nbsp;at&nbsp;', 'ashe' ); comment_time( get_option('time_format') ); ?></a>
						<?php echo edit_comment_link( esc_html__('[Edit]', 'ashe' ) ); ?>
						<div class="clear-fix"></div>
					</div>
					<div class="comment-text">			
					<?php comment_author_link(); ?>
					</div>
				</div>
			</article>

		<?php elseif ( get_comment_type() == 'comment' ) : ?>

		<li id="comment-<?php comment_ID(); ?>">
			
			<article <?php comment_class( 'entry-comments' ); ?> >					
				<div class="comment-avatar">
					<?php echo get_avatar( $comment, 75 ); ?>
				</div>
				<div class="comment-content">
					<h3 class="comment-author"><?php comment_author_link(); ?></h3>
					<div class="comment-meta">		
						<a class="comment-date" href=" <?php echo esc_url( get_comment_link() ); ?> "><?php comment_date( get_option('date_format') ); esc_html_e( '&nbsp;at&nbsp;', 'ashe' ); comment_time( get_option('time_format') ); ?></a>
			
						<?php 
						echo edit_comment_link( esc_html__('[Edit]', 'ashe' ) );
						comment_reply_link(array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth']) ) );
						?>
						
						<div class="clear-fix"></div>
					</div>

					<div class="comment-text">
						<?php if ( $comment->comment_approved == '0' ) : ?>
						<p class="awaiting-moderation"><?php esc_html_e( 'Your comment is awaiting moderation.', 'ashe' ); ?></p>
						<?php endif; ?>
						<?php comment_text(); ?>
					</div>
				</div>
				
			</article>

		<?php endif;
	}
}

// Move Comments Textarea
function ashe_move_comments_field( $fields ) {

	// unset/set
	$comment_field = $fields['comment'];
	unset( $fields['comment'] );
	$fields['comment'] = $comment_field;

	return $fields;
}

add_filter( 'comment_form_fields', 'ashe_move_comments_field' );


/*
** WooCommerce
*/

// wrap woocommerce content - start
function ashe_woocommerce_output_content_wrapper() {

	$layout = ashe_options( 'general_content_width' ) === 'boxed' ? ' boxed-wrapper': '';

	echo '<div class="main-content clear-fix'. $layout .'">';
		echo '<div class="main-container">';

}
add_action( 'woocommerce_before_main_content', 'ashe_woocommerce_output_content_wrapper', 5 );

// wrap woocommerce content - end
function ashe_woocommerce_output_content_wrapper_end() {

		echo '</div><!-- .main-container -->';
	echo '</div><!-- .main-content -->';

}
add_action( 'woocommerce_after_main_content', 'ashe_woocommerce_output_content_wrapper_end', 50 );

// Remove Default Sidebar
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );

// Change product grid columns
if ( ! function_exists('ashe_woocommerce_grid_columns') ) {
	function ashe_woocommerce_grid_columns() {
		return 3;
	}
}
add_filter('loop_shop_columns', 'ashe_woocommerce_grid_columns');

// Change related products grid columns
add_filter( 'woocommerce_output_related_products_args', 'ashe_related_products_args' );
  function ashe_related_products_args( $args ) {
  	$args['posts_per_page'] = 3;
	$args['columns'] = 3;
	return $args;
}

// Remove Breadcrumbs
if ( ! function_exists('ashe_remove_wc_breadcrumbs') ) {
	function ashe_remove_wc_breadcrumbs() {
	    remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );
	}
}
add_action( 'init', 'ashe_remove_wc_breadcrumbs' );



// Shop Per Page
function ashe_set_shop_post_per_page() {
	return 9;
}
add_filter( 'loop_shop_per_page', 'ashe_set_shop_post_per_page', 20 );



// Pagination
remove_action( 'woocommerce_pagination', 'woocommerce_pagination', 10 );

function ashe_woocommerce_pagination() {
	get_template_part( 'templates/grid/blog', 'pagination' );
}
add_action( 'woocommerce_pagination', 'ashe_woocommerce_pagination', 10 );


/*
** Incs: Theme Customizer
*/

// Customizer
require get_parent_theme_file_path( '/inc/customizer/customizer-repeater/inc/customizer.php' );
require get_parent_theme_file_path( '/inc/customizer/customizer.php' );
require get_parent_theme_file_path( '/inc/customizer/customizer-defaults.php' );
require get_parent_theme_file_path( '/inc/customizer/dynamic-css.php' );
require get_parent_theme_file_path( '/inc/customizer/css/theme-skins.php' );
require get_parent_theme_file_path( '/inc/preview/demo-preview.php' );

// About Ashe
require get_parent_theme_file_path( '/inc/about/about-ashe.php' );

require get_parent_theme_file_path('/inc/rating/rating.php');

add_action( 'after_switch_theme', 'ashe_activation_time');
add_action('after_setup_theme', 'ashe_activation_time');
    
function ashe_activation_time() {
	if ( false === get_option( 'ashe_activation_time' ) ) {
		add_option( 'ashe_activation_time', strtotime('now') );
	}
	if ( false === get_option( 'ashe_random_number' ) ) {
		add_option('ashe_random_number', rand(10, 20));
	}
}

// Welcome Notice
require_once get_parent_theme_file_path( '/inc/activation/class-welcome-notice.php' );


/*
** TGM Plugin Activation Class
*/

require_once get_parent_theme_file_path( '/inc/tgm/class-tgm-plugin-activation.php' );

function ashe_register_recommended_plugins() {
	$plugins = array(
        array(
			'name'      => 'Elementor',
			'slug'      => 'elementor',
			'required'  => false,
		),
        array(
			'name'      => 'Royal Elementor Addons',
			'slug'      => 'royal-elementor-addons',
			'required'  => false,
		),
	);
	$config = array(
		'id'           => 'ashe',
		'default_path' => '',
		'menu'         => 'tgmpa-install-plugins',
		'has_notices'  => true,
		'dismissable'  => true,
		'dismiss_msg'  => '',
		'is_automatic' => false,
		'message'      => '',
	);
	tgmpa( $plugins, $config );
}

// add_action( 'tgmpa_register', 'ashe_register_recommended_plugins' );
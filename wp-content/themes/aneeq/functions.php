<?php
/**
 * Aneeq Theme Functions
 */

//Aneeq Text Domain
define("aneeq", "aneeq");

//Aneeq Theme URL
define("ANEEQ_THEME_URL", get_template_directory_uri());
define("ANEEQ_THEME_DIR", get_template_directory());

//Aneeq Theme Option Panel CSS and JS Backend
add_action('wp_enqueue_scripts','aneeq_resources');

// On theme activation add defaults theme settings and data
add_action( 'after_setup_theme', 'aneeq_default_theme_options_setup', 'theme_prefix_setup' );



function aneeq_default_theme_options_setup() {
	// Load text domain for translation-ready
	load_theme_textdomain( 'aneeq', ANEEQ_THEME_DIR . '/languages' );

	// Add Theme support Title Tag
	add_theme_support( 'title-tag' );

	// Logo
	add_theme_support( 'custom-logo', array(
		'width'       => 250,
		'height'      => 250,
		'flex-width'  => true,
		'flex-height'  => true,
	));

	// Set the content_width with 900
	if ( ! isset( $content_width ) ) $content_width = 900;
	
	
	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'aneeq_custom_background_args', 
		array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) 
	) );

	add_editor_style('css/editor-style.css');
	
	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );
	
	//Add Theme Support Like - featured image, image crop, post format, rss feed
	add_theme_support('post-thumbnails');	// featured image
	//Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	//woo-commerce theme support
	add_theme_support( 'woocommerce' );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
	
}


//modify page / post title using title filter
/* add_filter('wp_title', 'aneeq_filter_pagetitle');
function aneeq_filter_pagetitle($title) {
    //check if its a blog post
    return $title = $title . ' | ';  bloginfo( 'name' );
} */


/**
 * Aneeq - Load Theme Option Panel CSS and JS Start
 */
function aneeq_resources(){
	//aneeq theme css
	wp_enqueue_style( 'style', get_stylesheet_uri());
	wp_enqueue_style( 'aneeq-bootstrap-min-css', trailingslashit ( get_template_directory_uri()) . '/css/bootstrap/bootstrap.min.css');

	//JS & CSS
	wp_enqueue_style( 'font-awesome-css', trailingslashit ( get_template_directory_uri()) . '/css/font-awesome.css');
	//wp_enqueue_style( 'aneeq-style', get_stylesheet_uri());
	add_action('wp_enqueue_scripts', 'example_enqueue_styles');	
	wp_enqueue_script('jquery');
	wp_enqueue_script('aneeq-main-js', trailingslashit ( get_template_directory_uri()) . '/js/main.js', array('jquery'), 1.0, true);
	wp_enqueue_script('bootstrap', trailingslashit ( get_template_directory_uri()) . '/js/bootstrap.js', array('jquery'));
	
	wp_enqueue_style( 'aneeq-google-fonts', 'https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i', false ); 
	
	//dropdown menus js
	wp_enqueue_script('aneeq-smartmenus-js', trailingslashit ( get_template_directory_uri()) . '/js/jquery.smartmenus.js');
	wp_enqueue_script('aneeq-smartmenus-bootstrap-js', trailingslashit ( get_template_directory_uri()) . '/js/jquery.smartmenus.bootstrap.js');

	//Slider
	wp_enqueue_script('jquery-owl-carousel-js', trailingslashit ( get_template_directory_uri()) . '/js/owl.carousel.js');
	wp_enqueue_style( 'owl-carousel-css', trailingslashit ( get_template_directory_uri()) . '/css/owl.carousel.css');
}
//Aneeq - Load Theme Option Panel CSS and JS End


/**
 * Aneeq Widgets Start
 */
function aneeq_theme_widgets() {

	// Blog / Page Sidebar Widget
	register_sidebar( array(
		'name' 			=> esc_html__( 'Sidebar Widget', 'aneeq'),
		'id' 			=> 'sidebar-widget',
		'before_widget' => '<aside id="%1$s" class="widget sidebar-widget widget-color %2$s">',
		'after_widget' 	=> '</aside>',
		'before_title' 	=> '<h3 class="widget-title">',
		'after_title' 	=> '</h3>'
	));

	//Get Footer Layout Settings
	$aneeq_footer_column_layout = get_theme_mod('aneeq_footer_column_layout', 3);
	if($aneeq_footer_column_layout == 1) $aneeq_footer_class_name = "col-md-12 col-sm-12 col-xs-12";	// one column
	if($aneeq_footer_column_layout == 2) $aneeq_footer_class_name = "col-md-6 col-sm-6 col-xs-12";		// two column
	if($aneeq_footer_column_layout == 3) $aneeq_footer_class_name = "col-md-4 col-sm-6 col-xs-12";		// three column
	if($aneeq_footer_column_layout == 4) $aneeq_footer_class_name = "col-md-3 col-sm-6 col-xs-12";		// four column
	// Footer Widget 1
	register_sidebar( array(
		'name'			=> esc_html__( 'Footer Widget', 'aneeq'),
		'id'			=> 'footer-widget',
		'description'	=> esc_html__( 'Note: Select & Publish Settings And Reload Page', 'aneeq'),
		'before_widget' => '<aside id="%1$s" class="widget footer-widget %2$s '.$aneeq_footer_class_name.'">',
		'after_widget'	=> '</aside>',
		'before_title'	=> '<h3 class="widget-title">',
		'after_title'	=> '</h3>',
	));

	// WooCommerce Sidebar Widget
	register_sidebar( array(
		'name'			=> esc_html__( 'WooCommerce Sidebar Widget Area', 'aneeq'),
		'id'			=> 'woocommerce',
		'description'	=> esc_html__( 'WooCommerce Sidebar Widget Area', 'aneeq'),
		'before_widget' => '<aside id="%1$s" class="widget sidebar-widget widget-color %2$s">',
		'after_widget'	=> '</aside>',
		'before_title'	=> '<h3 class="widget-title">',
		'after_title'	=> '</h3>',
	));
}
add_action('widgets_init', 'aneeq_theme_widgets');
// Aneeq Widgets End

//Plugin Recommend
add_action('tgmpa_register','aneeq_plugin_recommend');
function aneeq_plugin_recommend(){
	$plugins = array(
		array(
				'name'      => 'Portfolio Filter Gallery',
				'slug'      => 'portfolio-filter-gallery',
				'required'  => false,
			),
		array(
				'name'      => 'Blog Filter & Post Portfolio',
				'slug'      => 'blog-filter',
				'required'  => false,
			),
		array(
				'name'      => 'Pricing Table',
				'slug'      => 'abc-pricing-table',
				'required'  => false,
			),
		array(
				'name'      => 'Customizer Login Page',
				'slug'      => 'customizer-login-page',
				'required'  => false,
		),
		array(
				'name'      => 'Photo + Video Gallery',
				'slug'      => 'new-photo-gallery',
				'required'  => false,
		)
	);
    tgmpa( $plugins );
}

//Register area for custom menu
add_action( 'init', 'aneeq_menu' );
function aneeq_menu() {
	register_nav_menu( 'primary-menu', __( 'Primary Menu','aneeq' ) );
	require get_template_directory() . '/include/walker.php';
}// Include Walker file

// custom excerpt for read more button
function aneeq_excerpt_more( $more ) {
	if ( ! is_single() ) {
		$more = sprintf( '...<p><a class="more-link" href="%1$s">%2$s</a></p>',
			get_permalink( get_the_ID() ),
			__( 'Read More', 'aneeq' )
		);
	}
	return $more;
}
add_filter( 'excerpt_more', 'aneeq_excerpt_more' );

// custom excerpt length
function aneeq_custom_excerpt_length( $length ) {
    return 50;
}
add_filter( 'excerpt_length', 'aneeq_custom_excerpt_length', 999 );


/**
 * Include default theme options.
 */
require get_template_directory() . '/include/customizer/default.php';


/**
 * Load hooks.
 */
require get_template_directory() . '/include/hook/basic.php';

/**
 * Implement the Theme Custom Header feature.
 */
require get_template_directory() . '/include/custom-header.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/include/extras.php';

//Customizer File
require get_template_directory() . '/include/customizer.php';

/**
 * Upsell 
 */
require get_template_directory() . '/include/custom-edition/upgrade/class-customize.php';

/**
 * TGM Plugin  
 */
require( get_template_directory() . '/class-tgm-plugin-activation.php');

//wordpress header customizer
require get_template_directory() . '/include/header_image_customizer.php';


/**
 * Skip Link
 *
 */
add_action('wp_head', 'aneeq_skip_to_content');
function aneeq_skip_to_content(){
	echo '<a class="skip-link screen-reader-text" href="#main-content">'. esc_html__( 'Skip to content', 'aneeq' ) .'</a>';
}

/**
 * Fix skip link focus in IE11.
 *
 * This does not enqueue the script because it is tiny and because it is only for IE11,
 * thus it does not warrant having an entire dedicated blocking script being loaded.
 *
 * @link https://git.io/vWdr2
 */
function aneeq_skip_link_focus_fix() {
	// The following is minified via `terser --compress --mangle -- js/skip-link-focus-fix.js`.
	?>
	<script>
	/(trident|msie)/i.test(navigator.userAgent)&&document.getElementById&&window.addEventListener&&window.addEventListener("hashchange",function(){var t,e=location.hash.substring(1);/^[A-z0-9_-]+$/.test(e)&&(t=document.getElementById(e))&&(/^(?:a|select|input|button|textarea)$/i.test(t.tagName)||(t.tabIndex=-1),t.focus())},!1);
	</script>
	<?php
}
add_action( 'wp_print_footer_scripts', 'aneeq_skip_link_focus_fix' );
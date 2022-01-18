<?php
/**
 * Chic Lite Custom functions and definitions
 *
 * @package Chic_Lite
 */

if ( ! function_exists( 'chic_lite_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function chic_lite_setup() {
	// Use minified libraries if SCRIPT_DEBUG is false
    $build  = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '/build' : '';
    $suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
    
    /*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Chic Lite, use a find and replace
	 * to change 'chic-lite' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'chic-lite', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary'   => esc_html__( 'Primary', 'chic-lite' ),
        'secondary' => esc_html__( 'Secondary', 'chic-lite' ),
        'footer'    => esc_html__( 'Footer', 'chic-lite' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-list',
		'gallery',
		'caption',
	) );
    
    // Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'chic_lite_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
    
	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support( 
        'custom-logo', 
        apply_filters( 
            'chic_lite_custom_logo_args', 
            array( 
                'height'      => 70, 
                'width'       => 70, 
                'flex-height' => true,
                'flex-width'  => true,
                'header-text' => array( 'site-title', 'site-description' ) 
            )
        ) 
    );
    
    /**
     * Add support for custom header.
    */
    add_theme_support( 
        'custom-header', 
        apply_filters( 
            'chic_lite_custom_header_args', 
            array(
                'default-image' => '',
                'video'         => true,
                'width'         => 1920, 
                'height'        => 600, 
                'header-text'   => false
            ) 
        ) 
    );

    /**
     * Add support for Delicious Recipes Plugin.
    */
    add_theme_support('delicious-recipes');
 
    /**
     * Add Custom Images sizes.
    */    
    add_image_size( 'chic-lite-schema', 600, 60 );    
    add_image_size( 'chic-lite-slider', 1920, 760, true );
    add_image_size( 'chic-lite-slider-one', 1220, 600, true );
    add_image_size( 'chic-lite-featured-four', 800, 530, true );
    add_image_size( 'chic-lite-blog', 420, 280, true );
    add_image_size( 'chic-lite-blog-one', 900, 500, true );
    add_image_size( 'chic-lite-sidebar', 840, 473, true );

    // Add theme support for Responsive Videos.
    add_theme_support( 'jetpack-responsive-videos' );

    // Add excerpt support for pages
    add_post_type_support( 'page', 'excerpt' );

    // Add support for full and wide align images.
    add_theme_support( 'align-wide' );

    // Add support for editor styles.
    add_theme_support( 'editor-styles' );

    // Add support for responsive embeds.
    add_theme_support( 'responsive-embeds' );
        
    /*
     * This theme styles the visual editor to resemble the theme style,
     * specifically font, colors, and column width.
     *
     */
    add_editor_style( array(
            'css' . $build . '/editor-style' . $suffix . '.css',
            chic_lite_fonts_url()
        )
    );

    // Add support for block editor styles.
    add_theme_support( 'wp-block-styles' );

    //removed block widgets
    remove_theme_support( 'widgets-block-editor' );
}
endif;
add_action( 'after_setup_theme', 'chic_lite_setup' );

if( ! function_exists( 'chic_lite_content_width' ) ) :
/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function chic_lite_content_width() {
	/** 
     * content width.
    */
    $GLOBALS['content_width'] = apply_filters( 'chic_lite_content_width', 840 );
}
endif;
add_action( 'after_setup_theme', 'chic_lite_content_width', 0 );

if( ! function_exists( 'chic_lite_template_redirect_content_width' ) ) :
/**
* Adjust content_width value according to template.
*
* @return void
*/
function chic_lite_template_redirect_content_width(){
	$sidebar = chic_lite_sidebar();
    if( $sidebar ){	 
        $GLOBALS['content_width'] = 840;    
	}else{
        if( is_singular() ){
            if( chic_lite_sidebar( true ) === 'full-width centered' ){
                $GLOBALS['content_width'] = 840;
            }else{
                $GLOBALS['content_width'] = 1220;              
            }                
        }else{
            $GLOBALS['content_width'] = 1220;
        }
	}
}
endif;
add_action( 'template_redirect', 'chic_lite_template_redirect_content_width' );

if( ! function_exists( 'chic_lite_scripts' ) ) :
/**
 * Enqueue scripts and styles.
 */
function chic_lite_scripts() {
	// Use minified libraries if SCRIPT_DEBUG is false
    $build  = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '/build' : '';
    $suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

    if( chic_lite_is_woocommerce_activated() )
    wp_enqueue_style( 'chic-lite-woocommerce', get_template_directory_uri(). '/css' . $build . '/woocommerce' . $suffix . '.css', array(), CHIC_LITE_THEME_VERSION );
    
    wp_enqueue_style( 'owl-carousel', get_template_directory_uri(). '/css' . $build . '/owl.carousel' . $suffix . '.css', array(), '2.3.4' );

    wp_enqueue_style( 'animate', get_template_directory_uri(). '/css' . $build . '/animate' . $suffix . '.css', array(), '3.5.2' );

    wp_enqueue_style( 'perfect-scrollbar', get_template_directory_uri(). '/css' . $build . '/perfect-scrollbar' . $suffix . '.css', array(), '1.3.0' );

    wp_enqueue_style( 'chic-lite-google-fonts', chic_lite_fonts_url(), array(), null );
    
    wp_enqueue_style( 'chic-lite', get_stylesheet_uri(), array(), CHIC_LITE_THEME_VERSION );

    wp_enqueue_style( 'chic-lite-gutenberg', get_template_directory_uri(). '/css' . $build . '/gutenberg' . $suffix . '.css', array(), CHIC_LITE_THEME_VERSION );
    
    wp_enqueue_script( 'all', get_template_directory_uri() . '/js' . $build . '/all' . $suffix . '.js', array( 'jquery' ), '5.6.3', true );
    wp_enqueue_script( 'v4-shims', get_template_directory_uri() . '/js' . $build . '/v4-shims' . $suffix . '.js', array( 'jquery', 'all' ), '5.6.3', true );
	wp_enqueue_script( 'owl-carousel', get_template_directory_uri() . '/js' . $build . '/owl.carousel' . $suffix . '.js', array( 'jquery' ), '2.3.4', true );

    wp_enqueue_script( 'owlcarousel2-a11ylayer', get_template_directory_uri() . '/js' . $build . '/owlcarousel2-a11ylayer' . $suffix . '.js', array( 'jquery', 'owl-carousel' ), '0.2.1', true );

    wp_enqueue_script( 'perfect-scrollbar-js', get_template_directory_uri() . '/js' . $build . '/perfect-scrollbar' . $suffix . '.js', array( 'jquery' ), '1.3.0', true );
    
	wp_enqueue_script( 'chic-lite', get_template_directory_uri() . '/js' . $build . '/custom' . $suffix . '.js', array( 'jquery', 'masonry' ), CHIC_LITE_THEME_VERSION, true );
    
    wp_enqueue_script( 'chic-lite-modal', get_template_directory_uri() . '/js' . $build . '/modal-accessibility' . $suffix . '.js', array( 'jquery' ), CHIC_LITE_THEME_VERSION, true );
    
    $array = array( 
        'rtl'           => is_rtl(),
        'auto'          => esc_attr( get_theme_mod( 'slider_auto', true ) ),
		'loop'          => esc_attr( get_theme_mod( 'slider_loop', true ) ),
        'ajax_url'      => admin_url( 'admin-ajax.php' ),
    );
    
    wp_localize_script( 'chic-lite', 'chic_lite_data', $array );
    
    if ( chic_lite_is_jetpack_activated( true ) ) {
        wp_enqueue_style( 'tiled-gallery', plugins_url() . '/jetpack/modules/tiled-gallery/tiled-gallery/tiled-gallery.css' );            
    }
    
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
endif;
add_action( 'wp_enqueue_scripts', 'chic_lite_scripts' );

if( ! function_exists( 'chic_lite_admin_scripts' ) ) :
/**
 * Enqueue admin scripts and styles.
*/
function chic_lite_admin_scripts( $hook ){
    
    wp_enqueue_style( 'chic-lite-admin', get_template_directory_uri() . '/inc/css/admin.css', '', CHIC_LITE_THEME_VERSION );
}
endif; 
add_action( 'admin_enqueue_scripts', 'chic_lite_admin_scripts' );

if( ! function_exists( 'chic_lite_block_editor_styles' ) ) :
/**
 * Enqueue editor styles for Gutenberg
 */
function chic_lite_block_editor_styles() {
    // Use minified libraries if SCRIPT_DEBUG is false
    $build  = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '/build' : '';
    $suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
    
    // Block styles.
    wp_enqueue_style( 'chic-lite-block-editor-style', get_template_directory_uri() . '/css' . $build . '/editor-block' . $suffix . '.css' );

    wp_add_inline_style( 'chic-lite-block-editor-style', chic_lite_gutenberg_inline_style() );

    // Add custom fonts.
    wp_enqueue_style( 'chic-lite-google-fonts', chic_lite_fonts_url(), array(), null );
}
endif;
add_action( 'enqueue_block_editor_assets', 'chic_lite_block_editor_styles' );

if( ! function_exists( 'chic_lite_body_classes' ) ) :
/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function chic_lite_body_classes( $classes ) {
    $editor_options = get_option( 'classic-editor-replace' );
    $allow_users_options = get_option( 'classic-editor-allow-users' );
    
    // Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}
    
    // Adds a class of custom-background-image to sites with a custom background image.
    if ( get_background_image() ) {
        $classes[] = 'custom-background-image';
    }
    
    // Adds a class of custom-background-color to sites with a custom background color.
    if ( get_background_color() != 'ffffff' ) {
        $classes[] = 'custom-background-color';
    }

    if ( is_home() || ( is_archive() && !( chic_lite_is_woocommerce_activated() && ( is_shop() || is_product_category() || is_product_tag() ) ) && !( chic_lite_is_delicious_recipe_activated() && ( is_post_type_archive( 'recipe' ) || is_tax( 'recipe-course' ) || is_tax( 'recipe-cuisine' ) || is_tax( 'recipe-cooking-method' ) || is_tax( 'recipe-key' ) || is_tax( 'recipe-tag' ) ) ) ) || is_search() ) {
        $classes[] = 'post-layout-one';
    }

    if ( !chic_lite_is_classic_editor_activated() || ( chic_lite_is_classic_editor_activated() && $editor_options == 'block' ) || ( chic_lite_is_classic_editor_activated() && $allow_users_options == 'allow' && has_blocks() ) ) {
        $classes[] = 'chic-lite-has-blocks';
    }

    if( is_singular( 'post' ) ){        
        $classes[] = 'single-style-four';
    }

    $classes[] = chic_lite_sidebar( true );
    
	return $classes;
}
endif;
add_filter( 'body_class', 'chic_lite_body_classes' );

if( ! function_exists( 'chic_lite_post_classes' ) ) :
/**
 * Add custom classes to the array of post classes.
*/
function chic_lite_post_classes( $classes ){    

    global $wp_query;

    if( ( is_home() || is_archive() || is_search() ) && $wp_query->current_post == 0 ){
        $classes[] = 'large-post';
    }else {
        $classes[] = 'latest_post';
    }

    if( is_single() ){
        $classes[] = 'sticky-meta';
    }

    return $classes;
}
endif;
add_filter( 'post_class', 'chic_lite_post_classes' );

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function chic_lite_pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
	}
}
add_action( 'wp_head', 'chic_lite_pingback_header' );

if( ! function_exists( 'chic_lite_change_comment_form_default_fields' ) ) :
/**
 * Change Comment form default fields i.e. author, email & url.
 * https://blog.josemcastaneda.com/2016/08/08/copy-paste-hurting-theme/
*/
function chic_lite_change_comment_form_default_fields( $fields ){    
    // get the current commenter if available
    $commenter = wp_get_current_commenter();
 
    // core functionality
    $req = get_option( 'require_name_email' );
    $aria_req = ( $req ? " aria-required='true'" : '' );    
 
    // Change just the author field
    $fields['author'] = '<p class="comment-form-author"><label for="author">' . esc_html__( 'Name', 'chic-lite' ) . '<span class="required">*</span></label><input id="author" name="author" placeholder="' . esc_attr__( 'Name*', 'chic-lite' ) . '" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' /></p>';
    
    $fields['email'] = '<p class="comment-form-email"><label for="email">' . esc_html__( 'Email', 'chic-lite' ) . '<span class="required">*</span></label><input id="email" name="email" placeholder="' . esc_attr__( 'Email*', 'chic-lite' ) . '" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . ' /></p>';
    
    $fields['url'] = '<p class="comment-form-url"><label for="url">' . esc_html__( 'Website', 'chic-lite' ) . '</label><input id="url" name="url" placeholder="' . esc_attr__( 'Website', 'chic-lite' ) . '" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" /></p>'; 
    
    return $fields;    
}
endif;
add_filter( 'comment_form_default_fields', 'chic_lite_change_comment_form_default_fields' );

if( ! function_exists( 'chic_lite_change_comment_form_defaults' ) ) :
/**
 * Change Comment Form defaults
 * https://blog.josemcastaneda.com/2016/08/08/copy-paste-hurting-theme/
*/
function chic_lite_change_comment_form_defaults( $defaults ){    
    $defaults['comment_field'] = '<p class="comment-form-comment"><label for="comment">' . esc_html__( 'Comment', 'chic-lite' ) . '</label><textarea id="comment" name="comment" placeholder="' . esc_attr__( 'Comment', 'chic-lite' ) . '" cols="45" rows="8" aria-required="true"></textarea></p>';
    
    return $defaults;    
}
endif;
add_filter( 'comment_form_defaults', 'chic_lite_change_comment_form_defaults' );

if ( ! function_exists( 'chic_lite_excerpt_more' ) ) :
/**
 * Replaces "[...]" (appended to automatically generated excerpts) with ... * 
 */
function chic_lite_excerpt_more( $more ) {
	return is_admin() ? $more : ' &hellip; ';
}

endif;
add_filter( 'excerpt_more', 'chic_lite_excerpt_more' );

if ( ! function_exists( 'chic_lite_excerpt_length' ) ) :
/**
 * Changes the default 55 character in excerpt 
*/
function chic_lite_excerpt_length( $length ) {
	$excerpt_length = get_theme_mod( 'excerpt_length', 25 );
    return is_admin() ? $length : absint( $excerpt_length );    
}
endif;
add_filter( 'excerpt_length', 'chic_lite_excerpt_length', 999 );

if( ! function_exists( 'chic_lite_search_form' ) ) :
/**
 * Search Form
*/
function chic_lite_search_form(){ 

    if( ! is_search() ){
        $placeholder = is_404() ? _x( 'Try searching for what you were looking for&hellip;', 'placeholder', 'chic-lite' ) : _x( 'Type & Hit Enter&hellip;', 'placeholder', 'chic-lite' );
        $form = '<form role="search" method="get" class="search-form" action="' . esc_url( home_url( '/' ) ) . '">
                    <label>
                        <span class="screen-reader-text">' . esc_html__( 'Looking for Something?', 'chic-lite' ) . '
                        </span>
                        <input type="search" class="search-field" placeholder="' . esc_attr( $placeholder ) . '" value="' . esc_attr( get_search_query() ) . '" name="s" />
                    </label>                
                    <input type="submit" id="submit-field" class="search-submit" value="'. esc_attr_x( 'Search', 'submit button', 'chic-lite' ) .'" />
                </form>';
     
        return $form;
    }
}
endif;
add_filter( 'get_search_form', 'chic_lite_search_form' );


if( ! function_exists( 'chic_lite_get_the_archive_title' ) ) :
/**
 * Filter Archive Title
*/
function chic_lite_get_the_archive_title( $title ){
    
    $ed_prefix = get_theme_mod( 'ed_prefix_archive', true );

    if( is_post_type_archive( 'product' ) ){
        $title = '<h1 class="page-title">' . get_the_title( get_option( 'woocommerce_shop_page_id' ) ) . '</h1>';
    }else{
        if( is_category() ){
            if( $ed_prefix ){
                $title = '<h1 class="page-title">' .single_cat_title( '', false ). '</h1>';                                   
            }else{
                $title = sprintf( __( '%1$s Category: %2$s %3$s', 'chic-lite'), '<span class="sub-title">','</span>', '<h1 class="page-title">' . single_cat_title( '', false ) . '</h1>') ;
            }
        }elseif ( is_tag() ){
            if( $ed_prefix ){
                $title = '<h1 class="page-title">' .single_cat_title( '', false ). '</h1>';                                   
            }else{
                $title = sprintf( __( '%1$s Tag: %2$s %3$s', 'chic-lite'), '<span class="sub-title">','</span>', '<h1 class="page-title">' . single_tag_title( '', false ) . '</h1>') ;
            }
        }elseif( is_author() ){
            $title = '<span class="vcard">' . get_the_author() . '</span>';
        }elseif ( is_year() ) {
            if( $ed_prefix ){
                 $title = '<h1 class="page-title">' . get_the_date( _x( 'Y', 'yearly archives date format', 'chic-lite' ) ) . '</h1>';                                   
            }else{
                $title = sprintf( __( '%1$s Year: %2$s %3$s', 'chic-lite'), '<span class="sub-title">','</span>', '<h1 class="pate-title">' . get_the_date( _x( 'Y', 'yearly archives date format', 'chic-lite' ) ) . '</h1>') ;
            }
        }elseif ( is_month() ) {
            if( $ed_prefix ){
                 $title = '<h1 class="page-title">' . get_the_date( _x( 'F Y', 'monthly archives date format', 'chic-lite' ) ) . '</h1>';                                   
            }else{
                $title = sprintf( __( '%1$s Month: %2$s %3$s', 'chic-lite'), '<span class="sub-title">','</span>', '<h1 class="page-title">' . get_the_date( _x( 'F Y', 'monthly archives date format', 'chic-lite' ) ) . '</h1>') ;
            }
        }elseif ( is_day() ) {
            if( $ed_prefix ){
                 $title = '<h1 class="page-title">' . get_the_date( _x( 'F j, Y', 'daily archives date format', 'chic-lite' ) ) . '</h1>';                                   
            }else{
                $title = sprintf( __( '%1$s Day: %2$s %3$s', 'chic-lite'), '<span class="sub-title">','</span>', '<h1 class="page-title">' . get_the_date( _x( 'F j, Y', 'daily archives date format', 'chic-lite' ) ) .  '</h1>') ;
            }
        }elseif ( is_post_type_archive() ) {
            if( $ed_prefix ){
                 $title = '<h1 class="page-title">'  . post_type_archive_title( '', false ) . '</h1>';                             
            }else{
                $title = sprintf( __( '%1$s Archives: %2$s %3$s', 'chic-lite'), '<span class="sub-title">','</span>', '<h1 class="page-title">'  . post_type_archive_title( '', false ) . '</h1>') ;
            }
        }elseif ( is_tax() ) {
            $tax = get_taxonomy( get_queried_object()->taxonomy );
                if( $ed_prefix ){
                     $title = '<h1 class="page-title">' . single_term_title( '', false ) . '</h1>';                                 
                }else{
                    $title = sprintf( __( '%1$s: %2$s', 'chic-lite' ), '<span>' . $tax->labels->singular_name . '</span>', '<h1 class="page-title">' . single_term_title( '', false ) . '</h1>' );
                }
        }else {
            $title = sprintf( __( '%1$sArchives%2$s', 'chic-lite' ), '<h1 class="page-title">', '</h1>' );
        }
    }
    return $title;    
}
endif;
add_filter( 'get_the_archive_title', 'chic_lite_get_the_archive_title' );

if( ! function_exists( 'chic_lite_remove_archive_description' ) ) :
/**
 * filter the_archive_description & get_the_archive_description to show post type archive
 * @param  string $description original description
 * @return string post type description if on post type archive
 */
function chic_lite_remove_archive_description( $description ){
    $ed_shop_archive_description = get_theme_mod( 'ed_shop_archive_description', false );
    if( is_post_type_archive( 'product' ) ) {
        if( ! $ed_shop_archive_description ){
            $description = '';
        }
    }
    return $description;
}
endif;
add_filter( 'get_the_archive_description', 'chic_lite_remove_archive_description' );

if( ! function_exists( 'chic_lite_get_comment_author_link' ) ) :
/**
 * Filter to modify comment author link
 * @link https://developer.wordpress.org/reference/functions/get_comment_author_link/
 */
function chic_lite_get_comment_author_link( $return, $author, $comment_ID ){
    $comment = get_comment( $comment_ID );
    $url     = get_comment_author_url( $comment );
    $author  = get_comment_author( $comment );
 
    if ( empty( $url ) || 'http://' == $url )
        $return = '<span itemprop="name">'. esc_html( $author ) .'</span>';
    else
        $return = '<span itemprop="name"><a href=' . esc_url( $url ) . ' rel="external nofollow noopener" class="url" itemprop="url">' . esc_html( $author ) . '</a></span>';

    return $return;
}
endif;
add_filter( 'get_comment_author_link', 'chic_lite_get_comment_author_link', 10, 3 );

if( ! function_exists( 'chic_lite_filter_post_gallery' ) ) :
/**
 * Filter the output of the gallery. 
*/ 
function chic_lite_filter_post_gallery( $output, $attr, $instance ){
    global $post, $wp_locale;

    $html5 = current_theme_supports( 'html5', 'gallery' );
    $atts = shortcode_atts( array(
    	'order'      => 'ASC',
    	'orderby'    => 'menu_order ID',
    	'id'         => $post ? $post->ID : 0,
    	'itemtag'    => $html5 ? 'figure'     : 'dl',
    	'icontag'    => $html5 ? 'div'        : 'dt',
    	'captiontag' => $html5 ? 'figcaption' : 'dd',
    	'columns'    => 3,
    	'size'       => 'thumbnail',
    	'include'    => '',
    	'exclude'    => '',
    	'link'       => ''
    ), $attr, 'gallery' );
    
    $id = intval( $atts['id'] );
    
    if ( ! empty( $atts['include'] ) ) {
    	$_attachments = get_posts( array( 'include' => $atts['include'], 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $atts['order'], 'orderby' => $atts['orderby'] ) );
    
    	$attachments = array();
    	foreach ( $_attachments as $key => $val ) {
    		$attachments[$val->ID] = $_attachments[$key];
    	}
    } elseif ( ! empty( $atts['exclude'] ) ) {
    	$attachments = get_children( array( 'post_parent' => $id, 'exclude' => $atts['exclude'], 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $atts['order'], 'orderby' => $atts['orderby'] ) );
    } else {
    	$attachments = get_children( array( 'post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $atts['order'], 'orderby' => $atts['orderby'] ) );
    }
    
    if ( empty( $attachments ) ) {
    	return '';
    }
    
    if ( is_feed() ) {
    	$output = "\n";
    	foreach ( $attachments as $att_id => $attachment ) {
    		$output .= wp_get_attachment_link( $att_id, $atts['size'], true ) . "\n";
    	}
    	return $output;
    }
    
    $itemtag = tag_escape( $atts['itemtag'] );
    $captiontag = tag_escape( $atts['captiontag'] );
    $icontag = tag_escape( $atts['icontag'] );
    $valid_tags = wp_kses_allowed_html( 'post' );
    if ( ! isset( $valid_tags[ $itemtag ] ) ) {
    	$itemtag = 'dl';
    }
    if ( ! isset( $valid_tags[ $captiontag ] ) ) {
    	$captiontag = 'dd';
    }
    if ( ! isset( $valid_tags[ $icontag ] ) ) {
    	$icontag = 'dt';
    }
    
    $columns = intval( $atts['columns'] );
    $itemwidth = $columns > 0 ? floor(100/$columns) : 100;
    $float = is_rtl() ? 'right' : 'left';
    
    $selector = "gallery-{$instance}";
    
    $gallery_style = '';
    
    /**
     * Filter whether to print default gallery styles.
     *
     * @since 3.1.0
     *
     * @param bool $print Whether to print default gallery styles.
     *                    Defaults to false if the theme supports HTML5 galleries.
     *                    Otherwise, defaults to true.
     */
    if ( apply_filters( 'use_default_gallery_style', ! $html5 ) ) {
    	$gallery_style = "
    	<style type='text/css'>
    		#{$selector} {
    			margin: auto;
    		}
    		#{$selector} .gallery-item {
    			float: {$float};
    			margin-top: 10px;
    			text-align: center;
    			width: {$itemwidth}%;
    		}
    		#{$selector} img {
    			border: 2px solid #cfcfcf;
    		}
    		#{$selector} .gallery-caption {
    			margin-left: 0;
    		}
    		/* see gallery_shortcode() in wp-includes/media.php */
    	</style>\n\t\t";
    }
    
    $size_class = sanitize_html_class( $atts['size'] );
    $gallery_div = "<div id='$selector' class='gallery galleryid-{$id} gallery-columns-{$columns} gallery-size-{$size_class}'>";
    
    /**
     * Filter the default gallery shortcode CSS styles.
     *
     * @since 2.5.0
     *
     * @param string $gallery_style Default CSS styles and opening HTML div container
     *                              for the gallery shortcode output.
     */
    $output = apply_filters( 'gallery_style', $gallery_style . $gallery_div );
    
    $i = 0; 
    foreach ( $attachments as $id => $attachment ) {
            
    	$attr = ( trim( $attachment->post_excerpt ) ) ? array( 'aria-describedby' => "$selector-$id" ) : '';
    	if ( ! empty( $atts['link'] ) && 'file' === $atts['link'] ) {
    		//$image_output = wp_get_attachment_link( $id, $atts['size'], false, false, false, $attr ); // for attachment url 
            $image_output = "<a href='" . wp_get_attachment_url( $id ) . "' data-fancybox='group{$columns}' data-caption='" . esc_attr( $attachment->post_excerpt ) . "'>";
            $image_output .= wp_get_attachment_image( $id, $atts['size'], false, $attr );
            $image_output .= "</a>";
    	} elseif ( ! empty( $atts['link'] ) && 'none' === $atts['link'] ) {
    		$image_output = wp_get_attachment_image( $id, $atts['size'], false, $attr );
    	} else {
    		$image_output = wp_get_attachment_link( $id, $atts['size'], true, false, false, $attr ); //for attachment page
    	}
    	$image_meta  = wp_get_attachment_metadata( $id );
    
    	$orientation = '';
    	if ( isset( $image_meta['height'], $image_meta['width'] ) ) {
    		$orientation = ( $image_meta['height'] > $image_meta['width'] ) ? 'portrait' : 'landscape';
    	}
    	$output .= "<{$itemtag} class='gallery-item'>";
    	$output .= "
    		<{$icontag} class='gallery-icon {$orientation}'>
    			$image_output
    		</{$icontag}>";
    	if ( $captiontag && trim($attachment->post_excerpt) ) {
    		$output .= "
    			<{$captiontag} class='wp-caption-text gallery-caption' id='$selector-$id'>
    			" . wptexturize($attachment->post_excerpt) . "
    			</{$captiontag}>";
    	}
    	$output .= "</{$itemtag}>";
    	if ( ! $html5 && $columns > 0 && ++$i % $columns == 0 ) {
    		$output .= '<br style="clear: both" />';
    	}
    }
    
    if ( ! $html5 && $columns > 0 && $i % $columns !== 0 ) {
    	$output .= "
    		<br style='clear: both' />";
    }
    
    $output .= "
    	</div>\n";
    
    return $output;
}
endif;
if( class_exists( 'Jetpack' ) ){
    if( !Jetpack::is_module_active( 'carousel' ) ){
        add_filter( 'post_gallery', 'chic_lite_filter_post_gallery', 10, 3 );
    }
}else{
    add_filter( 'post_gallery', 'chic_lite_filter_post_gallery', 10, 3 );
}

if( ! function_exists( 'chic_lite_exclude_cat' ) ) :
/**
 * Exclude post with Category from blog and archive page. 
*/
function chic_lite_exclude_cat( $query ){

    $ed_banner      = get_theme_mod( 'ed_banner_section', 'slider_banner' );
    $slider_type    = get_theme_mod( 'slider_type', 'latest_posts' );
    $slider_cat     = get_theme_mod( 'slider_cat' );
    $posts_per_page = get_theme_mod( 'no_of_slides', 3 );
    $repetitive_posts = get_theme_mod( 'include_repetitive_posts', false );
    
    if( ! is_admin() && $query->is_main_query() && $query->is_home() && $ed_banner == 'slider_banner' && !$repetitive_posts ){
        if( $slider_type === 'cat' && $slider_cat  ){            
            $query->set( 'category__not_in', array( $slider_cat ) );            
        }elseif( $slider_type == 'latest_posts' ){
            $args = array(
                'post_type'           => 'post',
                'post_status'         => 'publish',
                'posts_per_page'      => $posts_per_page,
                'ignore_sticky_posts' => true
            );
            $latest = get_posts( $args );
            $excludes = array();
            foreach( $latest as $l ){
                array_push( $excludes, $l->ID );
            }
            $query->set( 'post__not_in', $excludes );
        }  
    }      
}
endif;
add_filter( 'pre_get_posts', 'chic_lite_exclude_cat' );

if( ! function_exists( 'chic_lite_admin_notice' ) ) :
/**
 * Addmin notice for getting started page
*/
function chic_lite_admin_notice(){
    global $pagenow;
    $theme_args      = wp_get_theme();
    $meta            = get_option( 'chic_lite_admin_notice' );
    $name            = $theme_args->__get( 'Name' );
    $current_screen  = get_current_screen();
    
    if( 'themes.php' == $pagenow && !$meta ){
        
        if( $current_screen->id !== 'dashboard' && $current_screen->id !== 'themes' ){
            return;
        }

        if( is_network_admin() ){
            return;
        }

        if( ! current_user_can( 'manage_options' ) ){
            return;
        } ?>

        <div class="welcome-message notice notice-info">
            <div class="notice-wrapper">
                <div class="notice-text">
                    <h3><?php esc_html_e( 'Congratulations!', 'chic-lite' ); ?></h3>
                    <p><?php printf( __( '%1$s is now installed and ready to use. Click below to see theme documentation, plugins to install and other details to get started.', 'chic-lite' ), esc_html( $name ) ); ?></p>
                    <p><a href="<?php echo esc_url( admin_url( 'themes.php?page=chic-lite-getting-started' ) ); ?>" class="button button-primary"><?php esc_html_e( 'Go to the getting started.', 'chic-lite' ); ?></a></p>
                    <p class="dismiss-link"><strong><a href="?chic_lite_admin_notice=1"><?php esc_html_e( 'Dismiss', 'chic-lite' ); ?></a></strong></p>
                </div>
            </div>
        </div>
    <?php }
}
endif;
add_action( 'admin_notices', 'chic_lite_admin_notice' );

if( ! function_exists( 'chic_lite_update_admin_notice' ) ) :
/**
 * Updating admin notice on dismiss
*/
function chic_lite_update_admin_notice(){
    if ( isset( $_GET['chic_lite_admin_notice'] ) && $_GET['chic_lite_admin_notice'] = '1' ) {
        update_option( 'chic_lite_admin_notice', true );
    }
}
endif;
add_action( 'admin_init', 'chic_lite_update_admin_notice' );

if ( ! function_exists( 'chic_lite_get_fontawesome_ajax' ) ) :
/**
 * Return an array of all icons.
 */
function chic_lite_get_fontawesome_ajax() {
    // Bail if the nonce doesn't check out
    if ( ! isset( $_POST['chic_lite_customize_nonce'] ) || ! wp_verify_nonce( sanitize_key( $_POST['chic_lite_customize_nonce'] ), 'chic_lite_customize_nonce' ) ) {
        wp_die();
    }

    // Do another nonce check
    check_ajax_referer( 'chic_lite_customize_nonce', 'chic_lite_customize_nonce' );

    // Bail if user can't edit theme options
    if ( ! current_user_can( 'edit_theme_options' ) ) {
        wp_die();
    }

    // Get all of our fonts
    $fonts = chic_lite_get_fontawesome_list();
    
    ob_start();
    if( $fonts ){ ?>
        <ul class="font-group">
            <?php 
                foreach( $fonts as $font ){
                    echo '<li data-font="' . esc_attr( $font ) . '"><i class="' . esc_attr( $font ) . '"></i></li>';                        
                }
            ?>
        </ul>
        <?php
    }
    echo ob_get_clean();

    // Exit
    wp_die();
}
endif;
add_action( 'wp_ajax_chic_lite_get_fontawesome_ajax', 'chic_lite_get_fontawesome_ajax' );

if ( ! function_exists( 'chic_lite_dynamic_mce_css' ) ) :
/**
 * Add Editor Style 
 * Add Link Color Option in Editor Style (MCE CSS)
 */
function chic_lite_dynamic_mce_css( $mce_css ){
    $mce_css .= ', ' . add_query_arg( array( 'action' => 'chic_lite_dynamic_mce_css', '_nonce' => wp_create_nonce( 'chic_lite_dynamic_mce_nonce', __FILE__ ) ), admin_url( 'admin-ajax.php' ) );
    return $mce_css;
}
endif;
add_filter( 'mce_css', 'chic_lite_dynamic_mce_css' );
 
if ( ! function_exists( 'chic_lite_dynamic_mce_css_ajax_callback' ) ) : 
/**
 * Ajax Callback
 */
function chic_lite_dynamic_mce_css_ajax_callback(){
 
    /* Check nonce for security */
    $nonce = isset( $_REQUEST['_nonce'] ) ? $_REQUEST['_nonce'] : '';
    if( ! wp_verify_nonce( $nonce, 'chic_lite_dynamic_mce_nonce' ) ){
        die(); // don't print anything
    }
 
    $primary_font    = get_theme_mod( 'primary_font', 'Nunito Sans' );
    $primary_fonts   = chic_lite_get_fonts( $primary_font, 'regular' );
    $secondary_font  = get_theme_mod( 'secondary_font', 'Nanum Myeongjo' );
    $secondary_fonts = chic_lite_get_fonts( $secondary_font, 'regular' );

    $primary_color    = get_theme_mod( 'primary_color', '#e1bdbd' );

    $rgb = chic_lite_hex2rgb( chic_lite_sanitize_hex_color( $primary_color ) );
 
    /* Set File Type and Print the CSS Declaration */
    header( 'Content-type: text/css' );
    echo ':root .mce-content-body {
        --primary-color: ' . chic_lite_sanitize_hex_color( $primary_color ) . ';
        --primary-color-rgb: ' . sprintf( '%1$s, %2$s, %3$s', $rgb[0], $rgb[1], $rgb[2] ) . ';
        --primary-font: ' . esc_html( $primary_fonts['font'] ) . ';
        --secondary-font: ' . esc_html( $secondary_fonts['font'] ) . ';
    }
    
    .mce-content-body blockquote::before {
    background-image: url(\'data:image/svg+xml; utf-8, <svg xmlns="http://www.w3.org/2000/svg" width="16.139" height="12.576" viewBox="0 0 16.139 12.576"><path d="M154.714,262.991c-.462.312-.9.614-1.343.9-.3.2-.612.375-.918.56a2.754,2.754,0,0,1-2.851.133,1.764,1.764,0,0,1-.771-.99,6.549,6.549,0,0,1-.335-1.111,5.386,5.386,0,0,1-.219-1.92,16.807,16.807,0,0,1,.3-1.732,2.392,2.392,0,0,1,.424-.8c.394-.534.808-1.053,1.236-1.56a3.022,3.022,0,0,1,.675-.61,2.962,2.962,0,0,0,.725-.749c.453-.576.923-1.137,1.38-1.71a3.035,3.035,0,0,0,.208-.35c.023-.038.044-.09.079-.107.391-.185.777-.383,1.179-.54.284-.11.5.141.739.234a.316.316,0,0,1-.021.2c-.216.411-.442.818-.663,1.226-.5.918-1.036,1.817-1.481,2.761a7.751,7.751,0,0,0-.915,3.069c-.009.326.038.653.053.98.009.2.143.217.288.2a1.678,1.678,0,0,0,1.006-.491c.2-.2.316-.207.537-.027.283.23.552.479.825.723a.174.174,0,0,1,.06.116,1.424,1.424,0,0,1-.327,1C154.281,262.714,154.285,262.755,154.714,262.991Z" transform="translate(-139.097 -252.358)" fill="' . chic_lite_hash_to_percent23( chic_lite_sanitize_hex_color( $primary_color ) ) . '"/><path d="M222.24,262.76a5.243,5.243,0,0,1-2.138,1.427,1.623,1.623,0,0,0-.455.26,3.112,3.112,0,0,1-2.406.338,1.294,1.294,0,0,1-1.021-1.2,6.527,6.527,0,0,1,.449-2.954c.015-.043.04-.083.053-.127a13.25,13.25,0,0,1,1.295-2.632,14.155,14.155,0,0,1,1.224-1.677c.084.14.132.238.2.324.133.176.3.121.414-.06a1.248,1.248,0,0,0,.1-.23c.055-.149.143-.214.315-.111-.029-.308,0-.607.3-.727.114-.045.295.079.463.131.093-.161.227-.372.335-.6.029-.06-.012-.16-.033-.238-.042-.154-.1-.3-.137-.458a1.117,1.117,0,0,1,.27-.933c.154-.207.286-.431.431-.646a.586.586,0,0,1,1.008-.108,2.225,2.225,0,0,0,.336.306.835.835,0,0,0,.356.087,1.242,1.242,0,0,0,.294-.052c-.067.145-.114.257-.17.364-.7,1.34-1.422,2.665-2.082,4.023-.488,1.005-.891,2.052-1.332,3.08a.628.628,0,0,0-.032.11c-.091.415.055.542.478.461.365-.07.607-.378.949-.463a2.8,2.8,0,0,1,.823-.064c.174.01.366.451.317.687a2.48,2.48,0,0,1-.607,1.26C222.081,262.492,222.011,262.615,222.24,262.76Z" transform="translate(-216.183 -252.301)" fill="' . chic_lite_hash_to_percent23( chic_lite_sanitize_hex_color( $primary_color ) ) . '"/></svg>\');
    }';
    die(); // end ajax process.
}
endif;
add_action( 'wp_ajax_chic_lite_dynamic_mce_css', 'chic_lite_dynamic_mce_css_ajax_callback' );
add_action( 'wp_ajax_no_priv_chic_lite_dynamic_mce_css', 'chic_lite_dynamic_mce_css_ajax_callback' );
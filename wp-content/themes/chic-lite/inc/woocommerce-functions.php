<?php
/**
 * Chic Lite Woocommerce hooks and functions.
 *
 * @link https://docs.woothemes.com/document/third-party-custom-theme-compatibility/
 *
 * @package Chic_Lite
 */

/**
 * Woocommerce related hooks
*/
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content',  'woocommerce_output_content_wrapper_end', 10 );
remove_action( 'woocommerce_sidebar',             'woocommerce_get_sidebar', 10 );

/**
 * Declare Woocommerce Support
*/
function chic_lite_woocommerce_support() {
    global $woocommerce;
    
    add_theme_support( 'woocommerce' );
    
    if( version_compare( $woocommerce->version, '3.0', ">=" ) ) {
        add_theme_support( 'wc-product-gallery-zoom' );
        add_theme_support( 'wc-product-gallery-lightbox' );
        add_theme_support( 'wc-product-gallery-slider' );
    }
}
add_action( 'after_setup_theme', 'chic_lite_woocommerce_support');

/**
 * Woocommerce Sidebar
*/
function chic_lite_wc_widgets_init(){
    register_sidebar( array(
		'name'          => esc_html__( 'Shop Sidebar', 'chic-lite' ),
		'id'            => 'shop-sidebar',
		'description'   => esc_html__( 'Sidebar displaying only in woocommerce pages.', 'chic-lite' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );    
}
add_action( 'widgets_init', 'chic_lite_wc_widgets_init' );

/**
 * Before Content
 * Wraps all WooCommerce content in wrappers which match the theme markup
*/
function chic_lite_wc_wrapper(){    
    ?>
    <div id="primary" class="content-area">
        <main id="main" class="site-main" role="main">
    <?php
}
add_action( 'woocommerce_before_main_content', 'chic_lite_wc_wrapper' );

/**
 * After Content
 * Closes the wrapping divs
*/
function chic_lite_wc_wrapper_end(){
    ?>
        </main>
    </div>
    <?php
    do_action( 'chic_lite_wo_sidebar' );
}
add_action( 'woocommerce_after_main_content', 'chic_lite_wc_wrapper_end' );

/**
 * Callback function for Shop sidebar
*/
function chic_lite_wc_sidebar_cb(){
    if( is_active_sidebar( 'shop-sidebar' ) ){
        echo '<aside id="secondary" class="widget-area" role="complementary" itemscope itemtype="http://schema.org/WPSideBar">';
        dynamic_sidebar( 'shop-sidebar' );
        echo '</aside>'; 
    }
}
add_action( 'chic_lite_wo_sidebar', 'chic_lite_wc_sidebar_cb' );

/**
 * Removes the "shop" title on the main shop page
*/
add_filter( 'woocommerce_show_page_title' , '__return_false' );

if( ! function_exists( 'chic_lite_wc_cart_count' ) ) :
/**
 * Woocommerce Cart Count
 * 
 * @link https://isabelcastillo.com/woocommerce-cart-icon-count-theme-header 
*/
function chic_lite_wc_cart_count(){
    $cart_page = get_option( 'woocommerce_cart_page_id' );
    $count = WC()->cart->cart_contents_count; 
    if( $cart_page ){ ?>
        <div class="cart-block">
            <a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="cart" title="<?php esc_attr_e( 'View your shopping cart', 'chic-lite' ); ?>">
                <i class="fas fa-shopping-cart"></i>
                <span class="number"><?php echo absint( $count ); ?></span>
            </a>
        </div>
    <?php
    }
}
endif;

/**
 * Ensure cart contents update when products are added to the cart via AJAX
 * 
 * @link https://isabelcastillo.com/woocommerce-cart-icon-count-theme-header
 */
function chic_lite_add_to_cart_fragment( $fragments ){
    ob_start();
    $count = WC()->cart->cart_contents_count; ?>
    <a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="cart" title="<?php esc_attr_e( 'View your shopping cart', 'chic-lite' ); ?>">
        <i class="fas fa-shopping-cart"></i>
        <span class="number"><?php echo absint( $count ); ?></span>
    </a>
    <?php
 
    $fragments['a.cart'] = ob_get_clean();
     
    return $fragments;
}
add_filter( 'woocommerce_add_to_cart_fragments', 'chic_lite_add_to_cart_fragment' );

/**
 * Ajax Callback for adding product in cart
 * 
*/
function chic_lite_add_cart_ajax() {
	global $woocommerce;
    
    $product_id = $_POST['product_id'];

	WC()->cart->add_to_cart( $product_id, 1 );
	$count = WC()->cart->cart_contents_count;
	$cart_url = $woocommerce->cart->get_cart_url(); 
    
    ?>
    <a href="<?php echo esc_url( $cart_url ); ?>" rel="bookmark" class="btn-add-to-cart"><?php esc_html_e( 'View Cart', 'chic-lite' ); ?></a>
    <input type="hidden" id="<?php echo esc_attr( 'cart-' . $product_id ); ?>" value="<?php echo esc_attr( $count ); ?>" />
    <?php 
    die();
}
add_action( 'wp_ajax_chic_lite_add_cart_single', 'chic_lite_add_cart_ajax' );
add_action( 'wp_ajax_nopriv_chic_lite_add_cart_single', 'chic_lite_add_cart_ajax' );
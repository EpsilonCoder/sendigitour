<?php

namespace PremiumAddons\Modules\Woocommerce;

use Elementor\Plugin;

use PremiumAddons\Includes\Module_Base;


if ( ! defined( 'ABSPATH' ) ) {
	exit; // If this file is called directly, abort.
}

/**
 * Class Module.
 */
class Module extends Module_Base {

	/**
	 * Class object
	 *
	 * @var instance
	 */
	private static $instance = null;

	/**
	 * Module should load or not.
	 *
	 * @since 4.7.0
	 * @access public
	 *
	 * @return bool true|false.
	 */
	public static function is_enable() {
		return true;
	}

	/**
	 * Get Module Name.
	 *
	 * @since 4.7.0
	 * @access public
	 *
	 * @return string Module name.
	 */
	public function get_name() {
		return 'woocommerce';
	}

	/**
	 * Get Widgets.
	 *
	 * @since 4.7.0
	 * @access public
	 *
	 * @return array Widgets.
	 */
	public function get_widgets() {
		return array(
			'Woo_Products',
		);
	}

	/**
	 * Constructor.
	 */
	public function __construct() {
		parent::__construct();

		// Trigger AJAX Hooks for pagination
		add_action( 'wp_ajax_get_woo_products', array( $this, 'get_woo_products' ) );
		add_action( 'wp_ajax_nopriv_get_woo_products', array( $this, 'get_woo_products' ) );

		// Trigger AJAX Hooks for product view
		add_action( 'wp_ajax_get_woo_product_qv', array( $this, 'get_woo_product_quick_view' ) );
		add_action( 'wp_ajax_nopriv_get_woo_product_qv', array( $this, 'get_woo_product_quick_view' ) );

		// Trigger AJAX Hooks for add to cart
		add_action( 'wp_ajax_premium_woo_add_cart_product', array( $this, 'add_product_to_cart' ) );
		add_action( 'wp_ajax_nopriv_premium_woo_add_cart_product', array( $this, 'add_product_to_cart' ) );
	}

	public function get_woo_products() {

		check_ajax_referer( 'pa-woo-products-nonce', 'nonce' );

		$post_id   = $_POST['pageID'];
		$widget_id = $_POST['elemID'];
		$style_id  = $_POST['skin'];

		$elementor = Plugin::$instance;
		$meta      = $elementor->documents->get( $post_id )->get_elements_data();

		$widget_data = $this->find_element_recursive( $meta, $widget_id );

		$data = array(
			'message'    => __( 'Saved', 'premium-addons-for-elementor' ),
			'ID'         => '',
			'skin_id'    => '',
			'html'       => '',
			'pagination' => '',
		);

		if ( null !== $widget_data ) {

			// Restore default values.
			$widget = $elementor->elements_manager->create_element_instance( $widget_data );

			// Return data and call your function according to your need for ajax call.
			// You will have access to settings variable as well as some widget functions.
			$skin = TemplateBlocks\Skin_Init::get_instance( $style_id );

			// Here you will just need posts based on ajax requst to attache in layout.
			$html = $skin->inner_render( $style_id, $widget );

			$pagination = $skin->page_render( $style_id, $widget );

			$data['ID']         = $widget->get_id();
			$data['skin_id']    = $widget->get_current_skin_id();
			$data['html']       = $html;
			$data['pagination'] = $pagination;
		}

		wp_send_json_success( $data );
	}

	public function find_element_recursive( $elements, $elem_id ) {

		foreach ( $elements as $element ) {
			if ( $elem_id === $element['id'] ) {
				return $element;
			}

			if ( ! empty( $element['elements'] ) ) {
				$element = $this->find_element_recursive( $element['elements'], $elem_id );

				if ( $element ) {
					return $element;
				}
			}
		}

		return false;
	}

	public function get_woo_product_quick_view() {

		check_ajax_referer( 'pa-woo-qv-nonce', 'security' );

		if ( ! isset( $_REQUEST['product_id'] ) ) {
			die();
		}

		$this->quick_view_content_actions();

		$product_id = intval( $_REQUEST['product_id'] );

		// echo $product_id;
		// die();
		// set the main wp query for the product.
		wp( 'p=' . $product_id . '&post_type=product' );

		ob_start();

		// load content template.
		include PREMIUM_ADDONS_PATH . 'modules/woocommerce/templates/quick-view-product.php';

		echo ob_get_clean();

		die();

	}

	public function quick_view_content_actions() {

		add_action( 'premium_woo_qv_image', 'woocommerce_show_product_sale_flash', 10 );
		// Image.
		add_action( 'premium_woo_qv_image', array( $this, 'product_quick_view_image_content' ), 20 );

		// Summary.
		add_action( 'premium_woo_quick_view_product', array( $this, 'product_quick_view_content' ), 10 );

	}

	function product_quick_view_image_content() {

		include PREMIUM_ADDONS_PATH . 'modules/woocommerce/templates/quick-view-product-image.php';
	}

	function add_product_to_cart() {
		$product_id   = isset( $_POST['product_id'] ) ? sanitize_text_field( $_POST['product_id'] ) : 0;
		$variation_id = isset( $_POST['variation_id'] ) ? sanitize_text_field( $_POST['variation_id'] ) : 0;
		$quantity     = isset( $_POST['quantity'] ) ? sanitize_text_field( $_POST['quantity'] ) : 0;

		if ( $variation_id ) {
			WC()->cart->add_to_cart( $product_id, $quantity, $variation_id );
		} else {
			WC()->cart->add_to_cart( $product_id, $quantity );
		}
		die();
	}

	function product_quick_view_content() {

		global $product;

		$post_id = $product->get_id();

		$single_structure = apply_filters(
			'premium_woo_qv_structure',
			array(
				'title',
				'ratings',
				'price',
				'short_desc',
				'meta',
				'add_cart',
			)
		);

		if ( is_array( $single_structure ) && ! empty( $single_structure ) ) {

			foreach ( $single_structure as $value ) {

				switch ( $value ) {
					case 'title':
						echo '<a href="' . esc_url( apply_filters( 'premium_woo_product_title_link', get_permalink( $post_id ) ) ) . '">';
							woocommerce_template_single_title();
						echo '</a>';
						break;
					case 'price':
						woocommerce_template_single_price();
						break;
					case 'ratings':
						woocommerce_template_single_rating();
						break;
					case 'short_desc':
						woocommerce_template_single_excerpt();
						break;
					case 'add_cart':
						woocommerce_template_single_add_to_cart();
						break;
					case 'meta':
						woocommerce_template_single_meta();
						break;
					default:
						break;
				}
			}
		}

	}

	public static function get_instance() {

		if ( ! isset( self::$instance ) ) {

			self::$instance = new self();

		}

		return self::$instance;
	}

}

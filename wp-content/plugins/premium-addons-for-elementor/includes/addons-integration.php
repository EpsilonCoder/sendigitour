<?php

namespace PremiumAddons\Includes;

use PremiumAddons\Includes\Helper_Functions;
use PremiumAddons\Admin\Includes\Admin_Helper;
use PremiumAddons\Modules\Premium_Equal_Height\Module as Equal_Height;
use PremiumAddons\Modules\PA_Display_Conditions\Module as Display_Conditions;
use PremiumAddons\Modules\PremiumSectionFloatingEffects\Module as Floating_Effects;
use PremiumAddons\Modules\Woocommerce\Module as Woocommerce;

if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

/**
 * Class Addons_Integration.
 */
class Addons_Integration {

	/**
	 * Class instance
	 *
	 * @var instance
	 */
	private static $instance = null;

	/**
	 * Modules
	 *
	 * @var modules
	 */
	private static $modules = null;

	/**
	 * Maps Keys
	 *
	 * @var maps
	 */
	private static $maps = null;

	/**
	 * Template Instance
	 *
	 * @var template_instance
	 */
	protected $template_instance;

	/**
	 * Cross-Site CDN URL.
	 *
	 * @since  4.0.0
	 * @var (String) URL
	 */
	public $cdn_url;

	/**
	 * Initialize integration hooks
	 *
	 * @return void
	 */
	public function __construct() {

		self::$modules = Admin_Helper::get_enabled_elements();

		self::$maps = Admin_Helper::get_integrations_settings();

		$this->template_instance = Premium_Template_Tags::getInstance();

		add_action( 'elementor/editor/before_enqueue_styles', array( $this, 'enqueue_editor_styles' ) );

		add_action( 'elementor/widgets/widgets_registered', array( $this, 'widgets_area' ) );

		add_action( 'elementor/editor/before_enqueue_scripts', array( $this, 'enqueue_editor_scripts' ) );

		add_action( 'elementor/preview/enqueue_styles', array( $this, 'enqueue_preview_styles' ) );

		add_action( 'elementor/frontend/after_register_styles', array( $this, 'register_frontend_styles' ) );

		add_action( 'elementor/frontend/after_register_scripts', array( $this, 'register_frontend_scripts' ) );

		add_action( 'wp_ajax_get_elementor_template_content', array( $this, 'get_template_content' ) );

		if ( self::$modules['premium-equal-height'] || self::$modules['premium-blog'] || self::$modules['pa-display-conditions'] ) {

			add_action( 'elementor/controls/controls_registered', array( $this, 'init_pa_controls' ) );

			add_action( 'elementor/editor/after_enqueue_scripts', array( $this, 'after_enqueue_scripts' ) );

			$this->load_pa_extensions();
		}

		$cross_enabled = isset( self::$modules['premium-cross-domain'] ) ? self::$modules['premium-cross-domain'] : 1;

		if ( $cross_enabled ) {

			add_action( 'elementor/editor/before_enqueue_scripts', array( $this, 'enqueue_editor_cp_scripts' ), 99 );

			Addons_Cross_CP::get_instance();

		}

	}

	/**
	 * After Enquque Scripts
	 *
	 * Loads editor scripts for our controls.
	 *
	 * @access public
	 * @return void
	 */
	public function after_enqueue_scripts() {

		wp_enqueue_script(
			'pa-eq-editor',
			PREMIUM_ADDONS_URL . 'assets/editor/js/editor.js',
			array( 'elementor-editor', 'jquery' ),
			PREMIUM_ADDONS_VERSION,
			true
		);

		if ( self::$modules['premium-blog'] || self::$modules['pa-display-conditions'] ) {
			wp_localize_script(
				'pa-eq-editor',
				'PremiumSettings',
				array(
					'ajaxurl' => esc_url( admin_url( 'admin-ajax.php' ) ),
					'nonce'   => wp_create_nonce( 'pa-blog-widget-nonce' ),
				)
			);
		}

		wp_localize_script(
			'pa-eq-editor',
			'PremiumPanelSettings',
			array(
				'papro_installed' => Helper_Functions::check_papro_version(),
				'papro_widgets'   => Admin_Helper::get_pro_elements(),
			)
		);

	}

	/**
	 * Loads plugin icons font
	 *
	 * @since 1.0.0
	 * @access public
	 * @return void
	 */
	public function enqueue_editor_styles() {

		$theme = Helper_Functions::get_elementor_ui_theme();

		wp_enqueue_style(
			'pa-editor',
			PREMIUM_ADDONS_URL . 'assets/editor/css/style.css',
			array(),
			PREMIUM_ADDONS_VERSION
		);

		// Enqueue required style for Elementor dark UI Theme.
		if ( 'dark' === $theme ) {

			wp_add_inline_style(
				'pa-editor',
				'.elementor-panel .elementor-control-section_pa_docs .elementor-panel-heading-title.elementor-panel-heading-title,
				.elementor-control-raw-html.editor-pa-doc a {
					color: #e0e1e3 !important;
				}
				[class^="pa-"]::after,
				[class*=" pa-"]::after {
					color: #fff;
				}
                .premium-promotion-dialog .premium-promotion-btn {
                    background-color: #202124 !important
                }'
			);

		}

		$badge_text = Helper_Functions::get_badge();

		$dynamic_css = sprintf( '[class^="pa-"]::after, [class*=" pa-"]::after { content: "%s"; }', $badge_text );

		wp_add_inline_style( 'pa-editor', $dynamic_css );

	}

	/**
	 * Register Frontend CSS files
	 *
	 * @since 2.9.0
	 * @access public
	 */
	public function register_frontend_styles() {

		$dir    = Helper_Functions::get_styles_dir();
		$suffix = Helper_Functions::get_assets_suffix();

		$is_rtl = is_rtl() ? '-rtl' : '';

		wp_register_style(
			'font-awesome-5-all',
			ELEMENTOR_ASSETS_URL . 'lib/font-awesome/css/all.min.css',
			false,
			PREMIUM_ADDONS_VERSION
		);

		wp_register_style(
			'pa-prettyphoto',
			PREMIUM_ADDONS_URL . 'assets/frontend/' . $dir . '/prettyphoto' . $is_rtl . $suffix . '.css',
			array(),
			PREMIUM_ADDONS_VERSION,
			'all'
		);

		wp_register_style(
			'pa-slick',
			PREMIUM_ADDONS_URL . 'assets/frontend/' . $dir . '/slick' . $is_rtl . $suffix . '.css',
			array(),
			PREMIUM_ADDONS_VERSION,
			'all'
		);

		wp_register_style(
			'premium-addons',
			PREMIUM_ADDONS_URL . 'assets/frontend/' . $dir . '/premium-addons' . $is_rtl . $suffix . '.css',
			array(),
			PREMIUM_ADDONS_VERSION,
			'all'
		);

		wp_register_style(
			'premium-woocommerce',
			PREMIUM_ADDONS_URL . 'assets/frontend/css/premium-woocommerce.css',
			array(),
			PREMIUM_ADDONS_VERSION,
			'all'
		);

	}

	/**
	 * Enqueue Preview CSS files
	 *
	 * @since 2.9.0
	 * @access public
	 */
	public function enqueue_preview_styles() {

		wp_enqueue_style( 'pa-prettyphoto' );

		wp_enqueue_style( 'premium-addons' );

		wp_enqueue_style( 'pa-slick' );

	}

	/**
	 * Load widgets require function
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function widgets_area() {
		$this->widgets_register();
	}

	/**
	 * Requires widgets files
	 *
	 * @since 1.0.0
	 * @access private
	 */
	private function widgets_register() {

		$enabled_elements = self::$modules;

		foreach ( glob( PREMIUM_ADDONS_PATH . 'widgets/*.php' ) as $file ) {

			$slug = basename( $file, '.php' );

			// Fixes the conflict between Lottie widget/addon keys.
			if ( 'premium-lottie' === $slug ) {

				// Check if Lottie widget switcher value was saved before.
				$saved_options = get_option( 'pa_save_settings' );

				$slug = 'premium-lottie-widget';

			}

			$enabled = isset( $enabled_elements[ $slug ] ) ? $enabled_elements[ $slug ] : '';

			if ( filter_var( $enabled, FILTER_VALIDATE_BOOLEAN ) || ! $enabled_elements ) {
				$this->register_addon( $file );
			}
		}

	}

	/**
	 * Register Woocommerce Widgets
	 *
	 * @since 4.0.0
	 * @access private
	 */
	private function woo_widgets_register() {

		$enabled_elements = self::$modules;

		foreach ( glob( PREMIUM_ADDONS_PATH . 'modules/woocommerce/widgets/*.php' ) as $file ) {

			$slug = basename( $file, '.php' );

			$enabled = isset( $enabled_elements[ $slug ] ) ? $enabled_elements[ $slug ] : '';

			if ( filter_var( $enabled, FILTER_VALIDATE_BOOLEAN ) || ! $enabled_elements ) {

				$this->register_addon( $file );
			}
		}
	}


	/**
	 * Registers required JS files
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function register_frontend_scripts() {

		$maps_settings = self::$maps;

		$dir    = Helper_Functions::get_scripts_dir();
		$suffix = Helper_Functions::get_assets_suffix();

		$locale = isset( $maps_settings['premium-map-locale'] ) ? $maps_settings['premium-map-locale'] : 'en';

		wp_register_script(
			'premium-addons',
			PREMIUM_ADDONS_URL . 'assets/frontend/' . $dir . '/premium-addons' . $suffix . '.js',
			array( 'jquery', 'jquery-ui-draggable' ),
			PREMIUM_ADDONS_VERSION,
			true
		);

		wp_register_script(
			'prettyPhoto-js',
			PREMIUM_ADDONS_URL . 'assets/frontend/' . $dir . '/prettyPhoto' . $suffix . '.js',
			array( 'jquery' ),
			PREMIUM_ADDONS_VERSION,
			true
		);

		wp_register_script(
			'pa-vticker',
			PREMIUM_ADDONS_URL . 'assets/frontend/' . $dir . '/vticker' . $suffix . '.js',
			array( 'jquery' ),
			PREMIUM_ADDONS_VERSION,
			true
		);

		wp_register_script(
			'pa-typed',
			PREMIUM_ADDONS_URL . 'assets/frontend/' . $dir . '/typed' . $suffix . '.js',
			array( 'jquery' ),
			PREMIUM_ADDONS_VERSION,
			true
		);

		wp_register_script(
			'pa-countdown',
			PREMIUM_ADDONS_URL . 'assets/frontend/' . $dir . '/jquery-countdown' . $suffix . '.js',
			array( 'jquery' ),
			PREMIUM_ADDONS_VERSION,
			true
		);

		wp_register_script(
			'isotope-js',
			PREMIUM_ADDONS_URL . 'assets/frontend/' . $dir . '/isotope' . $suffix . '.js',
			array( 'jquery' ),
			PREMIUM_ADDONS_VERSION,
			true
		);

		wp_register_script(
			'pa-modal',
			PREMIUM_ADDONS_URL . 'assets/frontend/' . $dir . '/modal' . $suffix . '.js',
			array( 'jquery' ),
			PREMIUM_ADDONS_VERSION,
			true
		);

		wp_register_script(
			'pa-maps',
			PREMIUM_ADDONS_URL . 'assets/frontend/' . $dir . '/premium-maps' . $suffix . '.js',
			array( 'jquery', 'pa-maps-api' ),
			PREMIUM_ADDONS_VERSION,
			true
		);

		wp_register_script(
			'pa-vscroll',
			PREMIUM_ADDONS_URL . 'assets/frontend/' . $dir . '/premium-vscroll' . $suffix . '.js',
			array( 'jquery' ),
			PREMIUM_ADDONS_VERSION,
			true
		);

		wp_register_script(
			'pa-slimscroll',
			PREMIUM_ADDONS_URL . 'assets/frontend/' . $dir . '/jquery-slimscroll' . $suffix . '.js',
			array( 'jquery' ),
			PREMIUM_ADDONS_VERSION,
			true
		);

		wp_register_script(
			'pa-iscroll',
			PREMIUM_ADDONS_URL . 'assets/frontend/' . $dir . '/iscroll' . $suffix . '.js',
			array( 'jquery' ),
			PREMIUM_ADDONS_VERSION,
			true
		);

		wp_register_script(
			'tilt-js',
			PREMIUM_ADDONS_URL . 'assets/frontend/' . $dir . '/universal-tilt' . $suffix . '.js',
			array( 'jquery' ),
			PREMIUM_ADDONS_VERSION,
			true
		);

		wp_register_script(
			'lottie-js',
			PREMIUM_ADDONS_URL . 'assets/frontend/' . $dir . '/lottie' . $suffix . '.js',
			array( 'jquery' ),
			PREMIUM_ADDONS_VERSION,
			true
		);

		wp_register_script(
			'pa-tweenmax',
			PREMIUM_ADDONS_URL . 'assets/frontend/' . $dir . '/TweenMax' . $suffix . '.js',
			array( 'jquery' ),
			PREMIUM_ADDONS_VERSION,
			true
		);

		wp_register_script(
			'premium-woocommerce',
			PREMIUM_ADDONS_URL . 'assets/frontend/' . $dir . '/premium-woocommerce' . $suffix . '.js',
			array( 'jquery' ),
			PREMIUM_ADDONS_VERSION,
			true
		);

		if ( $maps_settings['premium-map-cluster'] ) {
			wp_register_script(
				'google-maps-cluster',
				'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js',
				array(),
				PREMIUM_ADDONS_VERSION,
				false
			);
		}

		if ( $maps_settings['premium-map-disable-api'] && '1' !== $maps_settings['premium-map-api'] ) {
			$api = sprintf( 'https://maps.googleapis.com/maps/api/js?key=%1$s&language=%2$s', $maps_settings['premium-map-api'], $locale );
			wp_register_script(
				'pa-maps-api',
				$api,
				array(),
				PREMIUM_ADDONS_VERSION,
				false
			);
		}

		wp_register_script(
			'pa-slick',
			PREMIUM_ADDONS_URL . 'assets/frontend/' . $dir . '/slick' . $suffix . '.js',
			array( 'jquery' ),
			PREMIUM_ADDONS_VERSION,
			true
		);

		// TODO: remove pa-anime from the pro version.
		wp_register_script(
			'pa-anime',
			PREMIUM_ADDONS_URL . 'assets/frontend/' . $dir . '/anime' . $suffix . '.js',
			array( 'jquery' ),
			PREMIUM_ADDONS_VERSION,
			true
		);

		wp_register_script(
			'pa-feffects',
			PREMIUM_ADDONS_URL . 'assets/frontend/' . $dir . '/premium-floating-effects' . $suffix . '.js',
			array( 'jquery' ),
			PREMIUM_ADDONS_VERSION,
			true
		);

		wp_localize_script(
			'premium-addons',
			'PremiumSettings',
			array(
				'ajaxurl' => esc_url( admin_url( 'admin-ajax.php' ) ),
				'nonce'   => wp_create_nonce( 'pa-blog-widget-nonce' ),
			)
		);

		wp_register_script(
			'pa-eq-height',
			PREMIUM_ADDONS_URL . 'assets/frontend/' . $dir . '/premium-eq-height' . $suffix . '.js',
			array( 'jquery' ),
			PREMIUM_ADDONS_VERSION,
			true
		);

		wp_localize_script(
			'premium-woocommerce',
			'PremiumWooSettings',
			array(
				'ajaxurl'        => esc_url( admin_url( 'admin-ajax.php' ) ),
				'products_nonce' => wp_create_nonce( 'pa-woo-products-nonce' ),
				'qv_nonce'       => wp_create_nonce( 'pa-woo-qv-nonce' ),
			)
		);

		// Localize jQuery with required data for Global Add-ons.
		if ( self::$modules['premium-floating-effects'] ) {
			wp_localize_script(
				'pa-feffects',
				'PremiumFESettings',
				array(
					'papro_installed' => Helper_Functions::check_papro_version(),
				)
			);
		}

	}

	/**
	 * Enqueue editor scripts
	 *
	 * @since 3.2.5
	 * @access public
	 */
	public function enqueue_editor_scripts() {

		$map_enabled = isset( self::$modules['premium-maps'] ) ? self::$modules['premium-maps'] : 1;

		if ( $map_enabled ) {

			$premium_maps_api = self::$maps['premium-map-api'];

			$locale = isset( self::$maps['premium-map-locale'] ) ? self::$maps['premium-map-locale'] : 'en';

			$disable_api = self::$maps['premium-map-disable-api'];

			if ( $disable_api && '1' !== $premium_maps_api ) {

				$api = sprintf( 'https://maps.googleapis.com/maps/api/js?key=%1$s&language=%2$s', $premium_maps_api, $locale );
				wp_enqueue_script(
					'pa-maps-api',
					$api,
					array(),
					PREMIUM_ADDONS_VERSION,
					false
				);

			}

			wp_enqueue_script(
				'pa-maps-finder',
				PREMIUM_ADDONS_URL . 'assets/editor/js/pa-maps-finder.js',
				array( 'jquery' ),
				PREMIUM_ADDONS_VERSION,
				true
			);

		}

	}

	/**
	 * Load Cross Domain Copy Paste JS Files.
	 *
	 * @since 3.21.1
	 */
	public function enqueue_editor_cp_scripts() {

		wp_enqueue_script(
			'premium-xdlocalstorage-js',
			PREMIUM_ADDONS_URL . 'assets/editor/js/xdlocalstorage.js',
			null,
			PREMIUM_ADDONS_VERSION,
			true
		);

		wp_enqueue_script(
			'premium-cross-cp',
			PREMIUM_ADDONS_URL . 'assets/editor/js/premium-cross-cp.js',
			array( 'jquery', 'elementor-editor', 'premium-xdlocalstorage-js' ),
			PREMIUM_ADDONS_VERSION,
			true
		);

		wp_localize_script(
			'jquery',
			'premium_cross_cp',
			array(
				'ajax_url' => admin_url( 'admin-ajax.php' ),
				'nonce'    => wp_create_nonce( 'premium_cross_cp_import' ),
			)
		);
	}

	/**
	 * Get Template Content
	 *
	 * Get Elementor template HTML content.
	 *
	 * @since 3.2.6
	 * @access public
	 */
	public function get_template_content() {

		$template = isset( $_GET['templateID'] ) ? sanitize_text_field( wp_unslash( $_GET['templateID'] ) ) : '';

		if ( empty( $template ) ) {
			return;
		}

		$template_content = $this->template_instance->get_template_content( $template );

		if ( empty( $template_content ) || ! isset( $template_content ) ) {
			wp_send_json_error();
		}

		$data = array(
			'template_content' => $template_content,
		);

		wp_send_json_success( $data );

	}

	/**
	 *
	 * Register addon by file name.
	 *
	 * @access public
	 *
	 * @param  string $file            File name.
	 *
	 * @return void
	 */
	public function register_addon( $file ) {

		$widget_manager = \Elementor\Plugin::instance()->widgets_manager;

		$base  = basename( str_replace( '.php', '', $file ) );
		$class = ucwords( str_replace( '-', ' ', $base ) );
		$class = str_replace( ' ', '_', $class );
		$class = sprintf( 'PremiumAddons\Widgets\%s', $class );

		if ( 'PremiumAddons\Widgets\Premium_Contactform' !== $class ) {
			require $file;
		} else {
			if ( function_exists( 'wpcf7' ) ) {
				require $file;
			}
		}

		if ( 'PremiumAddons\Widgets\Premium_Videobox' === $class ) {
			require_once PREMIUM_ADDONS_PATH . 'widgets/dep/urlopen.php';
		}

		if ( class_exists( $class, false ) ) {
			$widget_manager->register_widget_type( new $class() );
		}
	}

	/**
	 * Registers Premium Addons Custom Controls.
	 *
	 * @since 4.2.5
	 * @access public
	 *
	 * @return void
	 */
	public function init_pa_controls() {

		$control_manager = \Elementor\Plugin::instance();

		// TODO: NEEDS TO BE DYNAMIC.
		if ( self::$modules['premium-equal-height'] ) {

			require_once PREMIUM_ADDONS_PATH . 'includes/controls/premium-select.php';
			$premium_select = __NAMESPACE__ . '\Controls\Premium_Select';
			$control_manager->controls_manager->register_control( $premium_select::TYPE, new $premium_select() );

		}

		if ( self::$modules['premium-blog'] ) {

			require_once PREMIUM_ADDONS_PATH . 'includes/controls/premium-post-filter.php';
			require_once PREMIUM_ADDONS_PATH . 'includes/controls/premium-tax-filter.php';

			$premium_post_filter = __NAMESPACE__ . '\Controls\Premium_Post_Filter';
			$premium_tax_filter  = __NAMESPACE__ . '\Controls\Premium_Tax_Filter';

			$control_manager->controls_manager->register_control( $premium_post_filter::TYPE, new $premium_post_filter() );
			$control_manager->controls_manager->register_control( $premium_tax_filter::TYPE, new $premium_tax_filter() );

		}

		if ( self::$modules['pa-display-conditions'] ) {

			require_once PREMIUM_ADDONS_PATH . 'includes/controls/premium-acf-selector.php';
			$premium_acf_selector = __NAMESPACE__ . '\Controls\Premium_Acf_Selector';
			$control_manager->controls_manager->register_control( $premium_acf_selector::TYPE, new $premium_acf_selector() );

		}

	}

	/**
	 * Load PA Extensions
	 *
	 * @since 4.7.0
	 * @access public
	 */
	public function load_pa_extensions() {

		if ( self::$modules['premium-equal-height'] ) {
			Equal_Height::get_instance();
		}

		if ( self::$modules['pa-display-conditions'] ) {
			Display_Conditions::get_instance();
		}

		if ( self::$modules['premium-floating-effects'] ) {
			Floating_Effects::get_instance();
		}

		if ( class_exists( 'woocommerce' ) && self::$modules['woo-products'] ) {
			Woocommerce::get_instance();
		}

	}

	/**
	 *
	 * Creates and returns an instance of the class
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return object
	 */
	public static function get_instance() {

		if ( ! isset( self::$instance ) ) {

			self::$instance = new self();

		}

		return self::$instance;
	}
}

<?php
/**
 * Class: Module
 * Name : Premium Display Conditions
 * Slug : pa-display-conditions
 */

namespace PremiumAddons\Modules\PA_Display_Conditions;

// PremiumAddons Classes.
use PremiumAddons\Includes\Helper_Functions;
use PremiumAddons\Includes\PA_Controls_Handler;

// Elementor Classes.
use Elementor\Repeater;
use Elementor\Controls_Manager;

// Includes.
require_once PREMIUM_ADDONS_PATH . 'includes/pa-display-conditions/pa-controls-handler.php';

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Module For Premium Display Conditions addon.
 */
class Module {

	/**
	 * Class object
	 *
	 * @var instance
	 */
	private static $instance = null;

	/**
	 * Display conditions.
	 *
	 * Class Constructor Funcion.
	 */
	public function __construct() {

		add_action( 'elementor/element/section/section_advanced/after_section_end', array( $this, 'register_controls' ), 10 );
		add_action( 'elementor/element/column/section_advanced/after_section_end', array( $this, 'register_controls' ), 10 );
		add_action( 'elementor/element/common/_section_style/after_section_end', array( $this, 'register_controls' ), 10 );

	}

	/**
	 * Register PA Display Conditions controls.
	 *
	 * @access public
	 * @param object $element for current element.
	 */
	public function register_controls( $element ) {

		$element->start_controls_section(
			'section_pa_display_conditions',
			array(
				'label' => sprintf( '<i class="pa-extension-icon pa-dash-icon"></i> %s', __( 'Display Conditions', 'premium-addons-for-elementor' ) ),
				'tab'   => Controls_Manager::TAB_ADVANCED,
			)
		);

		$controls_obj = new PA_Controls_Handler();

		$options = $controls_obj::$conditions;

		if ( class_exists( 'ACF' ) ) {
			$options = array_merge(
				array(
					'acf' => array(
						'label'   => __( 'ACF (PRO)', 'premium-addons-for-elementor' ),
						'options' => array(
							'acf_choice'  => __( 'Choice', 'premium-addons-for-elementor' ),
							'acf_text'    => __( 'Text', 'premium-addons-for-elementor' ),
							'acf_boolean' => __( 'True/False', 'premium-addons-for-elementor' ),
						),
					),
				),
				$options
			);
		}

		if ( class_exists( 'woocommerce' ) ) {
			$options = array_merge(
				$options,
				array(
					'woocommerce' => array(
						'label'   => __( 'WooCommerce (PRO)', 'premium-addons-for-elementor' ),
						'options' => array(
							'woo_cat_page'      => __( 'Current Category Page', 'premium-addons-for-elementor' ),
							'woo_product_cat'   => __( 'Current Product Category', 'premium-addons-for-elementor' ),
							'woo_product_price' => __( 'Current Product Price', 'premium-addons-for-elementor' ),
							'woo_product_stock' => __( 'Current Product Stock', 'premium-addons-for-elementor' ),
							'woo_orders'        => __( 'Purchased/In Cart Orders', 'premium-addons-for-elementor' ),
							'woo_category'      => __( 'Purchased/In Cart Categories', 'premium-addons-for-elementor' ),
							'woo_last_purchase' => __( 'Last Purchase In Cart', 'premium-addons-for-elementor' ),
							'woo_total_price'   => __( 'Amount In Cart', 'premium-addons-for-elementor' ),
						),
					),
				)
			);
		}

		$options = apply_filters( 'pa_display_conditions', $options );

		$element->add_control(
			'pa_display_conditions_switcher',
			array(
				'label'              => __( 'Enable Display Conditions', 'premium-addons-for-elementor' ),
				'type'               => Controls_Manager::SWITCHER,
				'return_value'       => 'yes',
				'render_type'        => 'template',
				'prefix_class'       => 'pa-display-conditions-',
				'frontend_available' => true,
			)
		);

		$doc_link = Helper_Functions::get_campaign_link( 'https://premiumaddons.com/docs/elementor-display-conditions-tutorial/', 'editor-page', 'wp-editor', 'get-support' );

		$element->add_control(
			'pa_display_conditions_notice',
			array(
				'type'            => Controls_Manager::RAW_HTML,
				'raw'             => '<a href="' . esc_url( $doc_link ) . '" target="_blank">' . __( 'How to use Premium Display Conditions for Elementor »', 'premium-addons-for-elementor' ) . '</a>',
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
				'condition'       => array(
					'pa_display_conditions_switcher' => 'yes',
				),
			)
		);

		$element->add_control(
			'pa_display_action',
			array(
				'label'     => __( 'Action', 'premium-addons-for-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'show',
				'options'   => array(
					'show' => __( 'Show Element', 'premium-addons-for-elementor' ),
					'hide' => __( 'Hide Element', 'premium-addons-for-elementor' ),
				),
				'condition' => array(
					'pa_display_conditions_switcher' => 'yes',
				),
			)
		);

		$element->add_control(
			'pa_display_when',
			array(
				'label'     => __( 'Display When', 'premium-addons-for-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'any',
				'options'   => array(
					'all' => __( 'All Conditions Are Met', 'premium-addons-for-elementor' ),
					'any' => __( 'Any Condition is Met', 'premium-addons-for-elementor' ),
				),
				'condition' => array(
					'pa_display_conditions_switcher' => 'yes',
				),
			)
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'pa_condition_key',
			array(
				'label'       => __( 'Type', 'premium-addons-for-elementor' ),
				'type'        => Controls_Manager::SELECT,
				'groups'      => $options,
				'default'     => 'browser',
				'label_block' => true,
			)
		);

		$options_conditions = apply_filters(
			'pa_pro_display_conditions',
			array(
				'url_referer',
				'woo_orders',
				'woo_cat_page',
				'woo_category',
				'woo_product_price',
				'woo_product_stock',
				'woo_product_cat',
				'woo_last_purchase',
				'woo_total_price',
				'acf_choice',
				'acf_text',
				'acf_boolean',
			)
		);

		$get_pro = Helper_Functions::get_campaign_link( 'https://premiumaddons.com/pro', 'editor-page', 'wp-editor', 'get-pro' );

		$repeater->add_control(
			'display_conditions_notice',
			array(
				'type'            => Controls_Manager::RAW_HTML,
				'raw'             => __( 'This option is available in Premium Addons Pro.', 'premium-addons-for-elementor' ) . '<a href="' . esc_url( $get_pro ) . '" target="_blank">' . __( 'Upgrade now!', 'premium-addons-for-elementor' ) . '</a>',
				'content_classes' => 'papro-upgrade-notice',
				'condition'       => array(
					'pa_condition_key' => $options_conditions,
				),
			)
		);

		$controls_obj->add_repeater_source_controls( $repeater );

		$repeater->add_control(
			'pa_condition_operator',
			array(
				'type'        => Controls_Manager::SELECT,
				'default'     => 'is',
				'label_block' => true,
				'options'     => array(
					'is'  => __( 'Is', 'premium-addons-for-elementor' ),
					'not' => __( 'Is Not', 'premium-addons-for-elementor' ),
				),
				'condition'   => array(
					'pa_condition_key!' => $options_conditions,
				),
			)
		);

		$controls_obj->add_repeater_compare_controls( $repeater );

		$repeater->add_control(
			'pa_condition_timezone',
			array(
				'label'       => 'Timezone',
				'type'        => Controls_Manager::SELECT,
				'default'     => 'server',
				'label_block' => true,
				'options'     => array(
					'local'  => __( 'Local Time', 'premium-addons-for-elementor' ),
					'server' => __( 'Server Timezone', 'premium-addons-for-elementor' ),
				),
				'condition'   => array(
					'pa_condition_key' => array( 'date_range', 'date', 'day' ),
				),
			)
		);

		$element->add_control(
			'pa_condition_repeater',
			array(
				'label'       => __( 'Conditions', 'premium-addons-for-elementor' ),
				'type'        => Controls_Manager::REPEATER,
				'label_block' => true,
				'fields'      => $repeater->get_controls(),
				'default'     => array(
					array(
						'pa_condition_key'      => 'browser',
						'pa_condition_operator' => 'is',
						'pa_condition_browser'  => 'chrome',
					),
				),
				'title_field' => '<# print( pa_condition_key.replace(/_/i, " ").split(" ").map((s) => s.charAt(0).toUpperCase() + s.substring(1)).join(" ")) #>',
				'condition'   => array(
					'pa_display_conditions_switcher' => 'yes',
				),
			)
		);

		$element->end_controls_section();
	}

	/**
	 * Returns an instance of this class.
	 *
	 * @access public
	 */
	public static function get_instance() {

		if ( ! isset( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}
}

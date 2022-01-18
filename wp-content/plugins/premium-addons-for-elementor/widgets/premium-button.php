<?php
/**
 * Premium Button.
 */

namespace PremiumAddons\Widgets;

// Elementor Classes.
use Elementor\Icons_Manager;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Box_Shadow;

// PremiumAddons Classes.
use PremiumAddons\Includes\Helper_Functions;
use PremiumAddons\Includes\Premium_Template_Tags;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // If this file is called directly, abort.
}

/**
 * Class Premium_Button
 */
class Premium_Button extends Widget_Base {

	/**
	 * Get Elementor Helper Instance.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function getTemplateInstance() {
		$this->template_instance = Premium_Template_Tags::getInstance();
		return $this->template_instance;
	}

	/**
	 * Retrieve Widget Name.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function get_name() {
		return 'premium-addon-button';
	}

	/**
	 * Retrieve Widget Title.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function get_title() {
		return sprintf( '%1$s %2$s', Helper_Functions::get_prefix(), __( 'Button', 'premium-addons-for-elementor' ) );
	}

	/**
	 * Retrieve Widget Icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string widget icon.
	 */
	public function get_icon() {
		return 'pa-button';
	}

	/**
	 * Retrieve Widget Dependent CSS.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return array CSS style handles.
	 */
	public function get_style_depends() {
		return array(
			'premium-addons',
		);
	}

	/**
	 * Retrieve Widget Dependent JS.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return array JS script handles.
	 */
	public function get_script_depends() {
		return array(
			'lottie-js',
			'premium-addons',
		);
	}

	/**
	 * Retrieve Widget Keywords.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget keywords.
	 */
	public function get_keywords() {
		return array( 'cta', 'call', 'link', 'btn' );
	}

	/**
	 * Retrieve Widget Categories.
	 *
	 * @since 1.5.1
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return array( 'premium-elements' );
	}

	/**
	 * Retrieve Widget Support URL.
	 *
	 * @access public
	 *
	 * @return string support URL.
	 */
	public function get_custom_help_url() {
		return 'https://premiumaddons.com/support/';
	}

	/**
	 * Register Button controls.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_controls() { // phpcs:ignore PSR2.Methods.MethodDeclaration.Underscore

		$this->start_controls_section(
			'premium_button_general_section',
			array(
				'label' => __( 'Button', 'premium-addons-for-elementor' ),
			)
		);

		$this->add_control(
			'premium_button_text',
			array(
				'label'       => __( 'Text', 'premium-addons-for-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => array( 'active' => true ),
				'default'     => __( 'Premium Addons', 'premium-addons-for-elementor' ),
				'label_block' => true,
			)
		);

		$this->add_control(
			'premium_button_link_selection',
			array(
				'label'       => __( 'Link Type', 'premium-addons-for-elementor' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'url'  => __( 'URL', 'premium-addons-for-elementor' ),
					'link' => __( 'Existing Page', 'premium-addons-for-elementor' ),
				),
				'default'     => 'url',
				'label_block' => true,
			)
		);

		$this->add_control(
			'premium_button_link',
			array(
				'label'       => __( 'Link', 'premium-addons-for-elementor' ),
				'type'        => Controls_Manager::URL,
				'dynamic'     => array( 'active' => true ),
				'default'     => array(
					'url' => '#',
				),
				'placeholder' => 'https://premiumaddons.com/',
				'label_block' => true,
				'condition'   => array(
					'premium_button_link_selection' => 'url',
				),
			)
		);

		$this->add_control(
			'premium_button_existing_link',
			array(
				'label'       => __( 'Existing Page', 'premium-addons-for-elementor' ),
				'type'        => Controls_Manager::SELECT2,
				'options'     => $this->getTemplateInstance()->get_all_posts(),
				'condition'   => array(
					'premium_button_link_selection' => 'link',
				),
				'multiple'    => false,
				'label_block' => true,
			)
		);

		$this->add_control(
			'premium_button_hover_effect',
			array(
				'label'       => __( 'Hover Effect', 'premium-addons-for-elementor' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'none',
				'options'     => array(
					'none'   => __( 'None', 'premium-addons-for-elementor' ),
					'style1' => __( 'Slide', 'premium-addons-for-elementor' ),
					'style2' => __( 'Shutter', 'premium-addons-for-elementor' ),
					'style3' => __( 'Icon Fade', 'premium-addons-for-elementor' ),
					'style4' => __( 'Icon Slide', 'premium-addons-for-elementor' ),
					'style5' => __( 'In & Out', 'premium-addons-for-elementor' ),
					'style6' => __( 'Grow', 'premium-addons-for-elementor' ),
					'style7' => __( 'Double Layers', 'premium-addons-for-elementor' ),
				),
				'separator'   => 'before',
				'label_block' => true,
			)
		);

		$this->add_control(
			'premium_button_style1_dir',
			array(
				'label'       => __( 'Slide Direction', 'premium-addons-for-elementor' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'bottom',
				'options'     => array(
					'bottom' => __( 'Top to Bottom', 'premium-addons-for-elementor' ),
					'top'    => __( 'Bottom to Top', 'premium-addons-for-elementor' ),
					'left'   => __( 'Right to Left', 'premium-addons-for-elementor' ),
					'right'  => __( 'Left to Right', 'premium-addons-for-elementor' ),
				),
				'condition'   => array(
					'premium_button_hover_effect' => 'style1',
				),
				'label_block' => true,
			)
		);

		$this->add_control(
			'premium_button_style2_dir',
			array(
				'label'       => __( 'Shutter Direction', 'premium-addons-for-elementor' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'shutouthor',
				'options'     => array(
					'shutinhor'    => __( 'Shutter in Horizontal', 'premium-addons-for-elementor' ),
					'shutinver'    => __( 'Shutter in Vertical', 'premium-addons-for-elementor' ),
					'shutoutver'   => __( 'Shutter out Horizontal', 'premium-addons-for-elementor' ),
					'shutouthor'   => __( 'Shutter out Vertical', 'premium-addons-for-elementor' ),
					'scshutoutver' => __( 'Scaled Shutter Vertical', 'premium-addons-for-elementor' ),
					'scshutouthor' => __( 'Scaled Shutter Horizontal', 'premium-addons-for-elementor' ),
					'dshutinver'   => __( 'Tilted Left', 'premium-addons-for-elementor' ),
					'dshutinhor'   => __( 'Tilted Right', 'premium-addons-for-elementor' ),
				),
				'condition'   => array(
					'premium_button_hover_effect' => 'style2',
				),
				'label_block' => true,
			)
		);

		$this->add_control(
			'premium_button_style4_dir',
			array(
				'label'       => __( 'Slide Direction', 'premium-addons-for-elementor' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'bottom',
				'options'     => array(
					'top'    => __( 'Bottom to Top', 'premium-addons-for-elementor' ),
					'bottom' => __( 'Top to Bottom', 'premium-addons-for-elementor' ),
					'left'   => __( 'Left to Right', 'premium-addons-for-elementor' ),
					'right'  => __( 'Right to Left', 'premium-addons-for-elementor' ),
				),
				'label_block' => true,
				'condition'   => array(
					'premium_button_hover_effect' => array( 'style4', 'style7' ),
				),
			)
		);

		$this->add_control(
			'premium_button_style5_dir',
			array(
				'label'       => __( 'Style', 'premium-addons-for-elementor' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'radialin',
				'options'     => array(
					'radialin'  => __( 'Radial In', 'premium-addons-for-elementor' ),
					'radialout' => __( 'Radial Out', 'premium-addons-for-elementor' ),
					'rectin'    => __( 'Rectangle In', 'premium-addons-for-elementor' ),
					'rectout'   => __( 'Rectangle Out', 'premium-addons-for-elementor' ),
				),
				'condition'   => array(
					'premium_button_hover_effect' => 'style5',
				),
				'label_block' => true,
			)
		);

		$this->add_control(
			'mouse_detect',
			array(
				'label'        => __( 'Detect Mouse Position', 'premium-addons-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'prefix_class' => 'premium-mouse-detect-',
				'render_type'  => 'template',
				'separator'    => 'after',
				'condition'    => array(
					'premium_button_hover_effect' => 'style6',
				),
			)
		);

		$this->add_control(
			'premium_button_icon_switcher',
			array(
				'label'       => __( 'Icon', 'premium-addons-for-elementor' ),
				'type'        => Controls_Manager::SWITCHER,
				'description' => __( 'Enable or disable button icon', 'premium-addons-for-elementor' ),
				'condition'   => array(
					'premium_button_hover_effect!' => 'style4',
				),
			)
		);

		$this->add_control(
			'icon_type',
			array(
				'label'       => __( 'Icon Type', 'premium-addons-for-elementor' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'icon'      => __( 'Icon', 'premium-addons-for-elementor' ),
					'animation' => __( 'Lottie Animation', 'premium-addons-for-elementor' ),
				),
				'default'     => 'icon',
				'label_block' => true,
				'condition'   => array(
					'premium_button_hover_effect!' => 'style4',
					'premium_button_icon_switcher' => 'yes',
				),
			)
		);

		$this->add_control(
			'premium_button_icon_selection_updated',
			array(
				'label'            => __( 'Icon', 'premium-addons-for-elementor' ),
				'type'             => Controls_Manager::ICONS,
				'fa4compatibility' => 'premium_button_icon_selection',
				'default'          => array(
					'value'   => 'fas fa-bars',
					'library' => 'fa-solid',
				),
				'condition'        => array(
					'premium_button_icon_switcher' => 'yes',
					'premium_button_hover_effect!' => 'style4',
					'icon_type'                    => 'icon',
				),
				'label_block'      => true,
			)
		);

		$this->add_control(
			'lottie_url',
			array(
				'label'       => __( 'Animation JSON URL', 'premium-addons-for-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => array( 'active' => true ),
				'description' => 'Get JSON code URL from <a href="https://lottiefiles.com/" target="_blank">here</a>',
				'label_block' => true,
				'condition'   => array(
					'premium_button_icon_switcher' => 'yes',
					'premium_button_hover_effect!' => 'style4',
					'icon_type'                    => 'animation',
				),
			)
		);

		$this->add_control(
			'lottie_loop',
			array(
				'label'        => __( 'Loop', 'premium-addons-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'true',
				'default'      => 'true',
				'condition'    => array(
					'premium_button_icon_switcher' => 'yes',
					'premium_button_hover_effect!' => 'style4',
					'icon_type'                    => 'animation',
				),
			)
		);

		$this->add_control(
			'lottie_reverse',
			array(
				'label'        => __( 'Reverse', 'premium-addons-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'true',
				'condition'    => array(
					'premium_button_icon_switcher' => 'yes',
					'premium_button_hover_effect!' => 'style4',
					'icon_type'                    => 'animation',
				),
			)
		);

		$this->add_control(
			'slide_icon_type',
			array(
				'label'       => __( 'Icon Type', 'premium-addons-for-elementor' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'icon'      => __( 'Icon', 'premium-addons-for-elementor' ),
					'animation' => __( 'Lottie Animation', 'premium-addons-for-elementor' ),
				),
				'default'     => 'icon',
				'label_block' => true,
				'condition'   => array(
					'premium_button_hover_effect' => 'style4',
				),
			)
		);

		$this->add_control(
			'premium_button_style4_icon_selection_updated',
			array(
				'label'            => __( 'Icon', 'premium-addons-for-elementor' ),
				'type'             => Controls_Manager::ICONS,
				'fa4compatibility' => 'premium_button_style4_icon_selection',
				'default'          => array(
					'value'   => 'fas fa-bars',
					'library' => 'fa-solid',
				),
				'condition'        => array(
					'slide_icon_type'             => 'icon',
					'premium_button_hover_effect' => 'style4',
				),
				'label_block'      => true,
			)
		);

		$this->add_control(
			'slide_lottie_url',
			array(
				'label'       => __( 'Animation JSON URL', 'premium-addons-for-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => array( 'active' => true ),
				'description' => 'Get JSON code URL from <a href="https://lottiefiles.com/" target="_blank">here</a>',
				'label_block' => true,
				'condition'   => array(
					'slide_icon_type'             => 'animation',
					'premium_button_hover_effect' => 'style4',
				),
			)
		);

		$this->add_control(
			'slide_lottie_loop',
			array(
				'label'        => __( 'Loop', 'premium-addons-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'true',
				'default'      => 'true',
				'condition'    => array(
					'slide_icon_type'             => 'animation',
					'premium_button_hover_effect' => 'style4',
				),
			)
		);

		$this->add_control(
			'slide_lottie_reverse',
			array(
				'label'        => __( 'Reverse', 'premium-addons-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'true',
				'condition'    => array(
					'slide_icon_type'             => 'animation',
					'premium_button_hover_effect' => 'style4',
				),
			)
		);

		$this->add_control(
			'premium_button_icon_position',
			array(
				'label'       => __( 'Icon Position', 'premium-addons-for-elementor' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'before',
				'options'     => array(
					'before' => __( 'Before', 'premium-addons-for-elementor' ),
					'after'  => __( 'After', 'premium-addons-for-elementor' ),
				),
				'label_block' => true,
				'condition'   => array(
					'premium_button_icon_switcher' => 'yes',
					'premium_button_hover_effect!' => 'style4',
				),
			)
		);

		$this->add_responsive_control(
			'premium_button_icon_before_size',
			array(
				'label'     => __( 'Icon Size', 'premium-addons-for-elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'condition' => array(
					'premium_button_icon_switcher' => 'yes',
					'premium_button_hover_effect!' => 'style4',
				),
				'selectors' => array(
					'{{WRAPPER}} .premium-button-text-icon-wrapper i' => 'font-size: {{SIZE}}px',
					'{{WRAPPER}} .premium-button-text-icon-wrapper svg' => 'width: {{SIZE}}px !important; height: {{SIZE}}px !important',
				),
			)
		);

		$this->add_responsive_control(
			'premium_button_icon_style4_size',
			array(
				'label'     => __( 'Icon Size', 'premium-addons-for-elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'condition' => array(
					'premium_button_hover_effect' => 'style4',
				),
				'selectors' => array(
					'{{WRAPPER}} .premium-button-style4-icon-wrapper i' => 'font-size: {{SIZE}}px',
					'{{WRAPPER}} .premium-button-style4-icon-wrapper svg' => 'width: {{SIZE}}px !important; height: {{SIZE}}px !important',
				),
			)
		);

		$icon_spacing = is_rtl() ? 'left' : 'right';

		$icon_spacing_after = is_rtl() ? 'right' : 'left';

		$this->add_responsive_control(
			'premium_button_icon_before_spacing',
			array(
				'label'     => __( 'Icon Spacing', 'premium-addons-for-elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'condition' => array(
					'premium_button_icon_switcher' => 'yes',
					'premium_button_icon_position' => 'before',
					'premium_button_hover_effect!' => array( 'style3', 'style4' ),
				),
				'default'   => array(
					'size' => 15,
				),
				'selectors' => array(
					'{{WRAPPER}} .premium-button-text-icon-wrapper i, {{WRAPPER}} .premium-button-text-icon-wrapper svg' => 'margin-' . $icon_spacing . ': {{SIZE}}px',
				),
				'separator' => 'after',
			)
		);

		$this->add_responsive_control(
			'premium_button_icon_after_spacing',
			array(
				'label'     => __( 'Icon Spacing', 'premium-addons-for-elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'condition' => array(
					'premium_button_icon_switcher' => 'yes',
					'premium_button_icon_position' => 'after',
					'premium_button_hover_effect!' => array( 'style3', 'style4' ),
				),
				'default'   => array(
					'size' => 15,
				),
				'selectors' => array(
					'{{WRAPPER}} .premium-button-text-icon-wrapper i, {{WRAPPER}} .premium-button-text-icon-wrapper svg' => 'margin-' . $icon_spacing_after . ': {{SIZE}}px',
				),
				'separator' => 'after',
			)
		);

		$this->add_responsive_control(
			'premium_button_icon_style3_before_transition',
			array(
				'label'     => __( 'Icon Spacing', 'premium-addons-for-elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'condition' => array(
					'premium_button_icon_switcher' => 'yes',
					'premium_button_icon_position' => 'before',
					'premium_button_hover_effect'  => 'style3',
				),
				'range'     => array(
					'px' => array(
						'min' => -50,
						'max' => 50,
					),
				),
				'selectors' => array(
					'{{WRAPPER}} .premium-button-style3-before:hover i, {{WRAPPER}} .premium-button-style3-before:hover svg' => '-webkit-transform: translateX({{SIZE}}{{UNIT}}); transform: translateX({{SIZE}}{{UNIT}})',
				),
			)
		);

		$this->add_responsive_control(
			'premium_button_icon_style3_after_transition',
			array(
				'label'     => __( 'Icon Spacing', 'premium-addons-for-elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'condition' => array(
					'premium_button_icon_switcher'  => 'yes',
					'premium_button_icon_position!' => 'before',
					'premium_button_hover_effect'   => 'style3',
				),
				'range'     => array(
					'px' => array(
						'min' => -50,
						'max' => 50,
					),
				),
				'selectors' => array(
					'{{WRAPPER}} .premium-button-style3-after:hover i, {{WRAPPER}} .premium-button-style3-after:hover svg' => '-webkit-transform: translateX({{SIZE}}{{UNIT}}); transform: translateX({{SIZE}}{{UNIT}})',
				),
			)
		);

		$this->add_control(
			'premium_button_size',
			array(
				'label'       => __( 'Size', 'premium-addons-for-elementor' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'lg',
				'options'     => array(
					'sm'    => __( 'Small', 'premium-addons-for-elementor' ),
					'md'    => __( 'Medium', 'premium-addons-for-elementor' ),
					'lg'    => __( 'Large', 'premium-addons-for-elementor' ),
					'block' => __( 'Block', 'premium-addons-for-elementor' ),
				),
				'label_block' => true,
				'separator'   => 'before',
			)
		);

		$this->add_responsive_control(
			'premium_button_align',
			array(
				'label'     => __( 'Alignment', 'premium-addons-for-elementor' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => array(
					'left'   => array(
						'title' => __( 'Left', 'premium-addons-for-elementor' ),
						'icon'  => 'eicon-text-align-left',
					),
					'center' => array(
						'title' => __( 'Center', 'premium-addons-for-elementor' ),
						'icon'  => 'eicon-text-align-center',
					),
					'right'  => array(
						'title' => __( 'Right', 'premium-addons-for-elementor' ),
						'icon'  => 'eicon-text-align-right',
					),
				),
				'selectors' => array(
					'{{WRAPPER}} .premium-button-container' => 'text-align: {{VALUE}}',
				),
				'toggle'    => false,
				'default'   => 'center',
				'condition' => array(
					'premium_button_size!' => 'block',
				),
			)
		);

		$this->add_control(
			'premium_button_event_switcher',
			array(
				'label'     => __( 'onclick Event', 'premium-addons-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'premium_button_event_function',
			array(
				'label'     => __( 'Example: myFunction();', 'premium-addons-for-elementor' ),
				'type'      => Controls_Manager::CODE,
				'dynamic'   => array( 'active' => true ),
				'condition' => array(
					'premium_button_event_switcher' => 'yes',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_pa_docs',
			array(
				'label' => __( 'Helpful Documentations', 'premium-addons-for-elementor' ),
			)
		);

		$docs = array(
			'https://premiumaddons.com/docs/button-widget-tutorial' => __( 'Getting started »', 'premium-addons-for-elementor' ),
			'https://premiumaddons.com/docs/how-can-i-open-an-elementor-popup-using-premium-button' => __( 'How to open an Elementor popup using button widget »', 'premium-addons-for-elementor' ),
			'https://premiumaddons.com/docs/how-to-play-pause-a-soundtrack-using-premium-button-widget' => __( 'How to play/pause a soundtrack using button widget »', 'premium-addons-for-elementor' ),
			'https://premiumaddons.com/docs/how-to-use-elementor-widgets-to-navigate-through-carousel-widget-slides/' => __( 'How To Use Premium Button To Navigate Through Carousel Widget Slides »', 'premium-addons-for-elementor' ),
		);

		$doc_index = 1;
		foreach ( $docs as $url => $title ) {

			$doc_url = Helper_Functions::get_campaign_link( $url, 'editor-page', 'wp-editor', 'get-support' );

			$this->add_control(
				'doc_' . $doc_index,
				array(
					'type'            => Controls_Manager::RAW_HTML,
					'raw'             => sprintf( '<a href="%s" target="_blank">%s</a>', $doc_url, $title ),
					'content_classes' => 'editor-pa-doc',
				)
			);

			$doc_index++;

		}

		$this->end_controls_section();

		$this->start_controls_section(
			'premium_button_style_section',
			array(
				'label' => __( 'Button', 'premium-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'premium_button_typo',
				'global'   => array(
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				),
				'selector' => '{{WRAPPER}} .premium-button',
			)
		);

		$this->start_controls_tabs( 'premium_button_style_tabs' );

		$this->start_controls_tab(
			'premium_button_style_normal',
			array(
				'label' => __( 'Normal', 'premium-addons-for-elementor' ),
			)
		);

		$this->add_control(
			'premium_button_text_color_normal',
			array(
				'label'     => __( 'Text Color', 'premium-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => array(
					'default' => Global_Colors::COLOR_SECONDARY,
				),
				'selectors' => array(
					'{{WRAPPER}} .premium-button .premium-button-text-icon-wrapper span'   => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'premium_button_icon_color_normal',
			array(
				'label'     => __( 'Icon Color', 'premium-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => array(
					'default' => Global_Colors::COLOR_SECONDARY,
				),
				'selectors' => array(
					'{{WRAPPER}} .premium-button-text-icon-wrapper i'   => 'color: {{VALUE}}',
					'{{WRAPPER}} .premium-button-text-icon-wrapper svg'   => 'fill: {{VALUE}}; color: {{VALUE}}',
				),
				'condition' => array(
					'premium_button_icon_switcher' => 'yes',
					'icon_type'                    => 'icon',
					'premium_button_hover_effect!' => array( 'style3', 'style4' ),
				),
			)
		);

		$this->add_control(
			'premium_button_background_normal',
			array(
				'label'     => __( 'Background Color', 'premium-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => array(
					'default' => Global_Colors::COLOR_PRIMARY,
				),
				'selectors' => array(
					'{{WRAPPER}} .premium-button, {{WRAPPER}} .premium-button.premium-button-style2-shutinhor:before , {{WRAPPER}} .premium-button.premium-button-style2-shutinver:before , {{WRAPPER}} .premium-button-style5-radialin:before , {{WRAPPER}} .premium-button-style5-rectin:before'  => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'premium_button_border_normal',
				'selector' => '{{WRAPPER}} .premium-button',
			)
		);

		$this->add_control(
			'premium_button_border_radius_normal',
			array(
				'label'      => __( 'Border Radius', 'premium-addons-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .premium-button' => 'border-radius: {{SIZE}}{{UNIT}};',
				),
				'condition'  => array(
					'button_adv_radius!' => 'yes',
				),
			)
		);

		$this->add_control(
			'button_adv_radius',
			array(
				'label'       => __( 'Advanced Border Radius', 'premium-addons-for-elementor' ),
				'type'        => Controls_Manager::SWITCHER,
				'description' => __( 'Apply custom radius values. Get the radius value from ', 'premium-addons-for-elementor' ) . '<a href="https://9elements.github.io/fancy-border-radius/" target="_blank">here</a>',
			)
		);

		$this->add_control(
			'button_adv_radius_value',
			array(
				'label'     => __( 'Border Radius', 'premium-addons-for-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'dynamic'   => array( 'active' => true ),
				'selectors' => array(
					'{{WRAPPER}} .premium-button' => 'border-radius: {{VALUE}};',
				),
				'condition' => array(
					'button_adv_radius' => 'yes',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			array(
				'label'     => __( 'Icon Shadow', 'premium-addons-for-elementor' ),
				'name'      => 'premium_button_icon_shadow_normal',
				'selector'  => '{{WRAPPER}} .premium-button-text-icon-wrapper i',
				'condition' => array(
					'premium_button_icon_switcher' => 'yes',
					'icon_type'                    => 'icon',
					'premium_button_hover_effect!' => array( 'style3', 'style4' ),
				),
			)
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			array(
				'label'    => __( 'Text Shadow', 'premium-addons-for-elementor' ),
				'name'     => 'premium_button_text_shadow_normal',
				'selector' => '{{WRAPPER}} .premium-button-text-icon-wrapper span',
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'label'    => __( 'Button Shadow', 'premium-addons-for-elementor' ),
				'name'     => 'premium_button_box_shadow_normal',
				'selector' => '{{WRAPPER}} .premium-button',
			)
		);

		$this->add_responsive_control(
			'premium_button_margin_normal',
			array(
				'label'      => __( 'Margin', 'premium-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .premium-button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'premium_button_padding_normal',
			array(
				'label'      => __( 'Padding', 'premium-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .premium-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'premium_button_style_hover',
			array(
				'label' => __( 'Hover', 'premium-addons-for-elementor' ),
			)
		);

		$this->add_control(
			'premium_button_text_color_hover',
			array(
				'label'     => __( 'Text Color', 'premium-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => array(
					'default' => Global_Colors::COLOR_PRIMARY,
				),
				'selectors' => array(
					'{{WRAPPER}} .premium-button:hover .premium-button-text-icon-wrapper span'   => 'color: {{VALUE}};',
				),
				'condition' => array(
					'premium_button_hover_effect!' => 'style4',
				),
			)
		);

		$this->add_control(
			'premium_button_icon_color_hover',
			array(
				'label'     => __( 'Icon Color', 'premium-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => array(
					'default' => Global_Colors::COLOR_PRIMARY,
				),
				'selectors' => array(
					'{{WRAPPER}} .premium-button:hover .premium-button-text-icon-wrapper i'   => 'color: {{VALUE}}',
					'{{WRAPPER}} .premium-button:hover .premium-button-text-icon-wrapper svg'   => 'fill: {{VALUE}}; color: {{VALUE}}',
				),
				'condition' => array(
					'premium_button_icon_switcher' => 'yes',
					'icon_type'                    => 'icon',
					'premium_button_hover_effect!' => 'style4',
				),
			)
		);

		$this->add_control(
			'premium_button_style4_icon_color',
			array(
				'label'     => __( 'Icon Color', 'premium-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => array(
					'default' => Global_Colors::COLOR_PRIMARY,
				),
				'selectors' => array(
					'{{WRAPPER}} .premium-button-style4-icon-wrapper'   => 'color: {{VALUE}}',
					'{{WRAPPER}} .premium-button-style4-icon-wrapper svg'   => 'fill: {{VALUE}}',
				),
				'condition' => array(
					'premium_button_hover_effect' => 'style4',
					'slide_icon_type'             => 'icon',
				),
			)
		);

		$this->add_control(
			'premium_button_background_hover',
			array(
				'label'     => __( 'Background Color', 'premium-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => array(
					'default' => Global_Colors::COLOR_TEXT,
				),
				'selectors' => array(
					'{{WRAPPER}} .premium-button-none:hover, {{WRAPPER}} .premium-button-style1:before, {{WRAPPER}} .premium-button-style2-shutouthor:before, {{WRAPPER}} .premium-button-style2-shutoutver:before, {{WRAPPER}} .premium-button-style2-shutinhor, {{WRAPPER}} .premium-button-style2-shutinver, {{WRAPPER}} .premium-button-style2-dshutinhor:before, {{WRAPPER}} .premium-button-style2-dshutinver:before, {{WRAPPER}} .premium-button-style2-scshutouthor:before, {{WRAPPER}} .premium-button-style2-scshutoutver:before, {{WRAPPER}} .premium-button-style3-after:hover, {{WRAPPER}} .premium-button-style3-before:hover, {{WRAPPER}} .premium-button-style4-icon-wrapper, {{WRAPPER}} .premium-button-style5-radialin, {{WRAPPER}} .premium-button-style5-radialout:before, {{WRAPPER}} .premium-button-style5-rectin, {{WRAPPER}} .premium-button-style5-rectout:before, {{WRAPPER}} .premium-button-style6-bg, {{WRAPPER}} .premium-button-style6:before' => 'background-color: {{VALUE}}',
				),
				'condition' => array(
					'premium_button_hover_effect!' => 'style7',

				),
			)
		);

		$this->add_control(
			'first_layer_hover',
			array(
				'label'     => __( 'Layer #1 Color', 'premium-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => array(
					'default' => Global_Colors::COLOR_SECONDARY,
				),
				'selectors' => array(
					'{{WRAPPER}} .premium-button-style7 .premium-button-text-icon-wrapper:before' => 'background-color: {{VALUE}}',
				),
				'condition' => array(
					'premium_button_hover_effect' => 'style7',

				),
			)
		);

		$this->add_control(
			'second_layer_hover',
			array(
				'label'     => __( 'Layer #2 Color', 'premium-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => array(
					'default' => Global_Colors::COLOR_TEXT,
				),
				'selectors' => array(
					'{{WRAPPER}} .premium-button-style7 .premium-button-text-icon-wrapper:after' => 'background-color: {{VALUE}}',
				),
				'condition' => array(
					'premium_button_hover_effect' => 'style7',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'premium_button_border_hover',
				'selector' => '{{WRAPPER}} .premium-button:hover',
			)
		);

		$this->add_control(
			'premium_button_border_radius_hover',
			array(
				'label'      => __( 'Border Radius', 'premium-addons-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .premium-button:hover' => 'border-radius: {{SIZE}}{{UNIT}};',
				),
				'condition'  => array(
					'button_hover_adv_radius!' => 'yes',
				),
			)
		);

		$this->add_control(
			'button_hover_adv_radius',
			array(
				'label'       => __( 'Advanced Border Radius', 'premium-addons-for-elementor' ),
				'type'        => Controls_Manager::SWITCHER,
				'description' => __( 'Apply custom radius values. Get the radius value from ', 'premium-addons-for-elementor' ) . '<a href="https://9elements.github.io/fancy-border-radius/" target="_blank">here</a>',
			)
		);

		$this->add_control(
			'button_hover_adv_radius_value',
			array(
				'label'     => __( 'Border Radius', 'premium-addons-for-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'dynamic'   => array( 'active' => true ),
				'selectors' => array(
					'{{WRAPPER}} .premium-button:hover' => 'border-radius: {{VALUE}};',
				),
				'condition' => array(
					'button_hover_adv_radius' => 'yes',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			array(
				'label'     => __( 'Icon Shadow', 'premium-addons-for-elementor' ),
				'name'      => 'premium_button_icon_shadow_hover',
				'selector'  => '{{WRAPPER}} .premium-button:hover .premium-button-text-icon-wrapper i',
				'condition' => array(
					'premium_button_icon_switcher' => 'yes',
					'icon_type'                    => 'icon',
					'premium_button_hover_effect!' => 'style4',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			array(
				'label'     => __( 'Icon Shadow', 'premium-addons-for-elementor' ),
				'name'      => 'premium_button_style4_icon_shadow_hover',
				'selector'  => '{{WRAPPER}} .premium-button:hover .premium-button-style4-icon-wrapper',
				'condition' => array(
					'premium_button_hover_effect' => 'style4',
					'slide_icon_type'             => 'icon',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			array(
				'label'     => __( 'Text Shadow', 'premium-addons-for-elementor' ),
				'name'      => 'premium_button_text_shadow_hover',
				'selector'  => '{{WRAPPER}} .premium-button:hover .premium-button-text-icon-wrapper span',
				'condition' => array(
					'premium_button_hover_effect!' => 'style4',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'label'    => __( 'Button Shadow', 'premium-addons-for-elementor' ),
				'name'     => 'premium_button_box_shadow_hover',
				'selector' => '{{WRAPPER}} .premium-button:hover',
			)
		);

		$this->add_responsive_control(
			'premium_button_margin_hover',
			array(
				'label'      => __( 'Margin', 'premium-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .premium-button:hover' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'premium_button_padding_hover',
			array(
				'label'      => __( 'Padding', 'premium-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .premium-button:hover' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	/**
	 * Render Button output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {

		$settings = $this->get_settings_for_display();

		$this->add_inline_editing_attributes( 'premium_button_text' );

		$button_text = $settings['premium_button_text'];

		if ( 'url' === $settings['premium_button_link_selection'] ) {
			$button_url = $settings['premium_button_link'];
		} else {
			$button_url = get_permalink( $settings['premium_button_existing_link'] );
		}

		$button_size = 'premium-btn-' . $settings['premium_button_size'];

		$button_event = $settings['premium_button_event_function'];

		if ( ! empty( $settings['premium_button_icon_selection'] ) ) {
			$this->add_render_attribute( 'icon', 'class', $settings['premium_button_icon_selection'] );
			$this->add_render_attribute( 'icon', 'aria-hidden', 'true' );
		}

		$icon_type = $settings['icon_type'];

		if ( 'icon' === $icon_type ) {
			$migrated = isset( $settings['__fa4_migrated']['premium_button_icon_selection_updated'] );
			$is_new   = empty( $settings['premium_button_icon_selection'] ) && Icons_Manager::is_migration_allowed();
		} else {
			$this->add_render_attribute(
				'lottie',
				array(
					'class'               => 'premium-lottie-animation',
					'data-lottie-url'     => $settings['lottie_url'],
					'data-lottie-loop'    => $settings['lottie_loop'],
					'data-lottie-reverse' => $settings['lottie_reverse'],
				)
			);
		}

		if ( 'none' === $settings['premium_button_hover_effect'] ) {
			$style_dir = 'premium-button-none';
		} elseif ( 'style1' === $settings['premium_button_hover_effect'] ) {
			$style_dir = 'premium-button-style1-' . $settings['premium_button_style1_dir'];
		} elseif ( 'style2' === $settings['premium_button_hover_effect'] ) {
			$style_dir = 'premium-button-style2-' . $settings['premium_button_style2_dir'];
		} elseif ( 'style3' === $settings['premium_button_hover_effect'] ) {
			$style_dir = 'premium-button-style3-' . $settings['premium_button_icon_position'];
		} elseif ( 'style4' === $settings['premium_button_hover_effect'] ) {
			$style_dir = 'premium-button-style4-' . $settings['premium_button_style4_dir'];

			$slide_icon_type = $settings['slide_icon_type'];

			if ( 'icon' === $slide_icon_type ) {
				if ( ! empty( $settings['premium_button_style4_icon_selection'] ) ) {
					$this->add_render_attribute( 'slide_icon', 'class', $settings['premium_button_style4_icon_selection'] );
					$this->add_render_attribute( 'slide_icon', 'aria-hidden', 'true' );
				}

				$slide_migrated = isset( $settings['__fa4_migrated']['premium_button_style4_icon_selection_updated'] );
				$slide_is_new   = empty( $settings['premium_button_style4_icon_selection'] ) && Icons_Manager::is_migration_allowed();

			} else {

				$this->add_render_attribute(
					'slide_lottie',
					array(
						'class'               => 'premium-lottie-animation',
						'data-lottie-url'     => $settings['slide_lottie_url'],
						'data-lottie-loop'    => $settings['slide_lottie_loop'],
						'data-lottie-reverse' => $settings['slide_lottie_reverse'],
					)
				);

			}
		} elseif ( 'style5' === $settings['premium_button_hover_effect'] ) {
			$style_dir = 'premium-button-style5-' . $settings['premium_button_style5_dir'];
		} elseif ( 'style6' === $settings['premium_button_hover_effect'] ) {
			$style_dir    = 'premium-button-style6';
			$mouse_detect = $settings['mouse_detect'];
			$this->add_render_attribute( 'style6', 'class', 'premium-button-style6-bg' );
		} elseif ( 'style7' === $settings['premium_button_hover_effect'] ) {
			$style_dir = 'premium-button-style7-' . $settings['premium_button_style4_dir'];
		}

		$this->add_render_attribute(
			'button',
			'class',
			array(
				'premium-button',
				'premium-button-' . $settings['premium_button_hover_effect'],
				$button_size,
				$style_dir,
			)
		);

		if ( ! empty( $button_url ) ) {

			if ( 'url' === $settings['premium_button_link_selection'] ) {
				$this->add_link_attributes( 'button', $button_url );
			} else {
				$this->add_render_attribute( 'button', 'href', $button_url );
			}
		}

		if ( 'yes' === $settings['premium_button_event_switcher'] && ! empty( $button_event ) ) {
			$this->add_render_attribute( 'button', 'onclick', $button_event );
		}

		?>

	<div class="premium-button-container">
		<a <?php echo wp_kses_post( $this->get_render_attribute_string( 'button' ) ); ?>>
			<div class="premium-button-text-icon-wrapper">
				<?php if ( 'yes' === $settings['premium_button_icon_switcher'] ) : ?>
					<?php if ( 'before' === $settings['premium_button_icon_position'] && 'style4' !== $settings['premium_button_hover_effect'] ) : ?>
						<?php if ( 'icon' === $icon_type ) : ?>
							<?php
							if ( $is_new || $migrated ) :
								Icons_Manager::render_icon( $settings['premium_button_icon_selection_updated'], array( 'aria-hidden' => 'true' ) );
							else :
								?>
								<i <?php echo wp_kses_post( $this->get_render_attribute_string( 'icon' ) ); ?>></i>
							<?php endif; ?>
						<?php else : ?>
							<div <?php echo wp_kses_post( $this->get_render_attribute_string( 'lottie' ) ); ?>></div>
						<?php endif; ?>
					<?php endif; ?>
				<?php endif; ?>
				<span <?php echo wp_kses_post( $this->get_render_attribute_string( 'premium_button_text' ) ); ?>>
					<?php echo wp_kses_post( $button_text ); ?>
				</span>
				<?php if ( 'yes' === $settings['premium_button_icon_switcher'] ) : ?>
					<?php if ( 'after' === $settings['premium_button_icon_position'] && 'style4' !== $settings['premium_button_hover_effect'] ) : ?>
						<?php if ( 'icon' === $icon_type ) : ?>
							<?php
							if ( $is_new || $migrated ) :
								Icons_Manager::render_icon( $settings['premium_button_icon_selection_updated'], array( 'aria-hidden' => 'true' ) );
							else :
								?>
								<i <?php echo wp_kses_post( $this->get_render_attribute_string( 'icon' ) ); ?>></i>
							<?php endif; ?>
						<?php else : ?>
							<div <?php echo wp_kses_post( $this->get_render_attribute_string( 'lottie' ) ); ?>></div>
						<?php endif; ?>
					<?php endif; ?>
				<?php endif; ?>
			</div>
			<?php if ( 'style4' === $settings['premium_button_hover_effect'] ) : ?>
				<div class="premium-button-style4-icon-wrapper <?php echo esc_attr( $settings['premium_button_style4_dir'] ); ?>">
					<?php if ( 'icon' === $slide_icon_type ) : ?>
						<?php
						if ( $slide_is_new || $slide_migrated ) :
							Icons_Manager::render_icon( $settings['premium_button_style4_icon_selection_updated'], array( 'aria-hidden' => 'true' ) );
						else :
							?>
							<i <?php echo wp_kses_post( $this->get_render_attribute_string( 'slide_icon' ) ); ?>></i>
						<?php endif; ?>
					<?php else : ?>
						<div <?php echo wp_kses_post( $this->get_render_attribute_string( 'slide_lottie' ) ); ?>></div>
					<?php endif; ?>
				</div>
			<?php endif; ?>
			<?php if ( 'style6' === $settings['premium_button_hover_effect'] && 'yes' === $mouse_detect ) : ?>
				<span <?php echo wp_kses_post( $this->get_render_attribute_string( 'style6' ) ); ?>></span>
			<?php endif; ?>
		</a>
	</div>

		<?php
	}

	/**
	 * Render Button widget output in the editor.
	 *
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function content_template() {
		?>
		<#

		view.addInlineEditingAttributes( 'premium_button_text' );

		var buttonText = settings.premium_button_text,
			buttonUrl,
			styleDir,
			slideIcon,
			mouseDetect,
			buttonSize = 'premium-btn-' + settings.premium_button_size,
			buttonEvent = settings.premium_button_event_function,
			buttonIcon = settings.premium_button_icon_selection,
			hoverEffect = settings.premium_button_hover_effect;

		if( 'url' === settings.premium_button_link_selection ) {
			buttonUrl = settings.premium_button_link.url;
		} else {
			buttonUrl = settings.premium_button_existing_link;
		}

		if ( 'none' === hoverEffect ) {
			styleDir = 'premium-button-none';
		} else if( 'style1' === hoverEffect ) {
			styleDir = 'premium-button-style1-' + settings.premium_button_style1_dir;
		} else if ( 'style2' === hoverEffect ){
			styleDir = 'premium-button-style2-' + settings.premium_button_style2_dir;
		} else if ( 'style3' === hoverEffect ) {
			styleDir = 'premium-button-style3-' + settings.premium_button_icon_position;
		} else if ( 'style4' === hoverEffect ) {
			styleDir = 'premium-button-style4-' + settings.premium_button_style4_dir;

			var slideIconType = settings.slide_icon_type;

			if( 'icon' === slideIconType ) {

				slideIcon = settings.premium_button_style4_icon_selection;

				var slideIconHTML = elementor.helpers.renderIcon( view, settings.premium_button_style4_icon_selection_updated, { 'aria-hidden': true }, 'i' , 'object' ),
					slideMigrated = elementor.helpers.isIconMigrated( settings, 'premium_button_style4_icon_selection_updated' );

			} else {

				view.addRenderAttribute( 'slide_lottie', {
					'class': 'premium-lottie-animation',
					'data-lottie-url': settings.slide_lottie_url,
					'data-lottie-loop': settings.slide_lottie_loop,
					'data-lottie-reverse': settings.slide_lottie_reverse
				});

			}


		} else if ( 'style5' === hoverEffect ) {
			styleDir = 'premium-button-style5-' + settings.premium_button_style5_dir;
		} else if ( 'style6' === hoverEffect ) {
			styleDir = 'premium-button-style6';
			mouseDetect = settings.mouse_detect;
			view.addRenderAttribute( 'style6','class' , 'premium-button-style6-bg' );
		} else if ( 'style7' === hoverEffect ) {
			styleDir = 'premium-button-style7-' + settings.premium_button_style4_dir;
		}

		var iconType = settings.icon_type;

		if( 'icon' === iconType ) {
			var iconHTML = elementor.helpers.renderIcon( view, settings.premium_button_icon_selection_updated, { 'aria-hidden': true }, 'i' , 'object' ),
				migrated = elementor.helpers.isIconMigrated( settings, 'premium_button_icon_selection_updated' );
		} else {

			view.addRenderAttribute( 'lottie', {
				'class': 'premium-lottie-animation',
				'data-lottie-url': settings.lottie_url,
				'data-lottie-loop': settings.lottie_loop,
				'data-lottie-reverse': settings.lottie_reverse
			});

		}

		#>

		<div class="premium-button-container">
			<a class="premium-button {{ buttonSize }} {{ styleDir }} premium-button-{{hoverEffect}}" href="{{ buttonUrl }}" onclick="{{ buttonEvent }}">
				<div class="premium-button-text-icon-wrapper">
					<# if ('yes' === settings.premium_button_icon_switcher) { #>
						<# if( 'before' === settings.premium_button_icon_position &&  'style4' !== hoverEffect ) { #>
							<# if( 'icon' === iconType ) {
								if ( iconHTML && iconHTML.rendered && ( ! buttonIcon || migrated ) ) { #>
									{{{ iconHTML.value }}}
								<# } else { #>
									<i class="{{ buttonIcon }}" aria-hidden="true"></i>
								<# } #>
							<# } else { #>
								<div {{{ view.getRenderAttributeString('lottie') }}}></div>
							<# } #>
						<# } #>
					<# } #>
					<span {{{ view.getRenderAttributeString('premium_button_text') }}}>{{{ buttonText }}}</span>
					<# if ('yes' === settings.premium_button_icon_switcher) { #>
						<# if( 'after' === settings.premium_button_icon_position && 'style4' !== hoverEffect ) { #>
							<# if( 'icon' === iconType ) {
								if ( iconHTML && iconHTML.rendered && ( ! buttonIcon || migrated ) ) { #>
									{{{ iconHTML.value }}}
								<# } else { #>
									<i class="{{ buttonIcon }}" aria-hidden="true"></i>
								<# } #>
							<# } else { #>
								<div {{{ view.getRenderAttributeString('lottie') }}}></div>
							<# } #>
						<# } #>
					<# } #>
				</div>
				<# if( 'style4' === hoverEffect ) { #>
					<div class="premium-button-style4-icon-wrapper {{ settings.premium_button_style4_dir }}">
						<# if ( 'icon' === slideIconType ) { #>
							<# if ( slideIconHTML && slideIconHTML.rendered && ( ! slideIcon || slideMigrated ) ) { #>
								{{{ slideIconHTML.value }}}
							<# } else { #>
								<i class="{{ slideIcon }}" aria-hidden="true"></i>
							<# } #>
						<# } else { #>
							<div {{{ view.getRenderAttributeString('slide_lottie') }}}></div>
						<# } #>
					</div>
				<# } #>
				<# if( 'style6' === hoverEffect  && 'yes' === mouseDetect) { #>
					<span {{{ view.getRenderAttributeString('style6') }}}></span>
				<# } #>
			</a>
		</div>

		<?php
	}
}

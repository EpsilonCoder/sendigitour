<?php
/**
 * Class: Premium_Icon_list
 * Name: Bullet List
 * Slug: premium-addon-icon-list
 */

namespace PremiumAddons\Widgets;

// Elementor Classes.
use Elementor\Icons_Manager;
use Elementor\Control_Media;
use Elementor\Widget_Base;
use Elementor\Utils;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;


// PremiumAddons Classes.
use PremiumAddons\Includes\Helper_Functions;
use PremiumAddons\Includes\Premium_Template_Tags;


if ( ! defined( 'ABSPATH' ) ) {
	exit; // If this file is called directly, abort.
}

/**
 * Class Premium_Icon_List
 */
class Premium_Icon_List extends Widget_Base {

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
		return 'premium-icon-list';
	}

	/**
	 * Retrieve Widget Title.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function get_title() {
		return sprintf( '%1$s %2$s', Helper_Functions::get_prefix(), __( 'Bullet list', 'premium-addons-for-elementor' ) );
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
			'elementor-waypoints',
			'lottie-js',
			'premium-addons',
		);
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
		return 'pa-icon-list';
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
	 * Retrieve Widget Keywords.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget keywords.
	 */
	public function get_keywords() {
		return array( 'icon', 'feature', 'list' );
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
	 * Register Bullet List controls.
	 *
	 * @since 4.0.0
	 * @access protected
	 */
	public function register_controls() { // phpcs:ignore PSR2.Methods.MethodDeclaration.Underscore

		$this->start_controls_section(
			'list_items_section',
			array(
				'label' => __( 'List Items', 'premium-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$repeater_list = new REPEATER();

		$repeater_list->add_control(
			'list_title',
			array(
				'label'       => __( 'Title', 'premium-addons-for-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => array( 'active' => true ),
				'default'     => __( 'List Title', 'premium-addons-for-elementor' ),
				'label_block' => true,
			)
		);

		$repeater_list->add_control(
			'show_icon',
			array(
				'label'        => __( 'Show Bullet', 'premium-addons-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$repeater_list->add_control(
			'icon_type',
			array(
				'label'       => __( 'Bullet Type', 'premium-addons-for-elementor' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'icon',
				'render_type' => 'template',
				'options'     => array(
					'icon'   => __( 'Icon', 'premium-addons-for-elementor' ),
					'image'  => __( 'Image', 'premium-addons-for-elementor' ),
					'lottie' => __( 'Lottie Animation', 'premium-addons-for-elementor' ),
					'text'   => __( 'Text', 'premium-addons-for-elementor' ),
				),
				'condition'   => array(
					'show_icon' => 'yes',
				),
			)
		);

		$repeater_list->add_control(
			'premium_icon_list_font_updated',
			array(
				'label'     => __( 'Icon', 'premium-addons-for-elementor' ),
				'type'      => Controls_Manager::ICONS,
				'default'   => array(
					'value'   => 'fas fa-star',
					'library' => 'fa-solid',
				),
				'condition' => array(
					'show_icon' => 'yes',
					'icon_type' => 'icon',
				),
			)
		);

		$repeater_list->add_control(
			'custom_image',
			array(
				'label'     => __( 'Custom Image', 'premium-addons-for-elementor' ),
				'type'      => Controls_Manager::MEDIA,
				'dynamic'   => array( 'active' => true ),
				'default'   => array(
					'url' => Utils::get_placeholder_image_src(),
				),
				'condition' => array(
					'show_icon' => 'yes',
					'icon_type' => 'image',
				),
			)
		);

		$repeater_list->add_control(
			'list_text_icon',
			array(
				'label'     => __( 'Text', 'premium-addons-for-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => __( 'New', 'premium-addons-for-elementor' ),
				'dynamic'   => array( 'active' => true ),
				'condition' => array(
					'show_icon' => 'yes',
					'icon_type' => 'text',
				),
			)
		);

		$repeater_list->add_control(
			'lottie_url',
			array(
				'label'       => __( 'Animation JSON URL', 'premium-addons-for-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => array( 'active' => true ),
				'description' => 'Get JSON code URL from <a href="https://lottiefiles.com/" target="_blank">here</a>',
				'label_block' => true,
				'render_type' => 'template',
				'condition'   => array(
					'show_icon' => 'yes',
					'icon_type' => 'lottie',
				),
			)
		);

		$repeater_list->add_control(
			'lottie_loop',
			array(
				'label'        => __( 'Loop', 'premium-addons-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'true',
				'default'      => 'true',
				'render_type'  => 'template',
				'condition'    => array(
					'show_icon' => 'yes',
					'icon_type' => 'lottie',
				),
			)
		);

		$repeater_list->add_control(
			'lottie_reverse',
			array(
				'label'        => __( 'Reverse', 'premium-addons-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'true',
				'render_type'  => 'template',
				'condition'    => array(
					'show_icon' => 'yes',
					'icon_type' => 'lottie',
				),
			)
		);

		$repeater_list->add_control(
			'show_list_link',
			array(
				'label'        => __( 'Link', 'premium-addons-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
			)
		);

		$repeater_list->add_control(
			'link_select',
			array(
				'label'       => __( 'Link/URL', 'premium-addons-for-elementor' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'url'           => __( 'URL', 'premium-addons-for-elementor' ),
					'existing_page' => __( 'Existing Page', 'premium-addons-for-elementor' ),
				),
				'default'     => 'url',
				'label_block' => true,
				'condition'   => array(
					'show_list_link' => 'yes',
				),
			)
		);

		$repeater_list->add_control(
			'link',
			array(
				'label'       => __( 'URL', 'premium-addons-for-elementor' ),
				'type'        => Controls_Manager::URL,
				'dynamic'     => array( 'active' => true ),
				'placeholder' => 'https://premiumaddons.com/',
				'label_block' => true,
				'condition'   => array(
					'link_select'    => 'url',
					'show_list_link' => 'yes',
				),
			)
		);

		$repeater_list->add_control(
			'existing_page',
			array(
				'label'       => __( 'Existing Page', 'premium-addons-for-elementor' ),
				'type'        => Controls_Manager::SELECT2,
				'options'     => $this->getTemplateInstance()->get_all_posts(),
				'condition'   => array(
					'link_select'    => 'existing_page',
					'show_list_link' => 'yes',
				),
				'label_block' => true,
			)
		);

		$repeater_list->add_control(
			'link_title',
			array(
				'label'       => __( 'Link Title', 'premium-addons-for-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'condition'   => array(
					'show_list_link' => 'yes',
				),
				'label_block' => true,
			)
		);

		$repeater_list->add_control(
			'show_badge',
			array(
				'label'        => __( 'Badge', 'premium-addons-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'separator'    => 'before',
			)
		);

		$repeater_list->add_control(
			'badge_title',
			array(
				'label'     => __( 'Badge Text', 'premium-addons-for-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => __( 'New', 'premium-addons-for-elementor' ),
				'condition' => array(
					'show_badge' => 'yes',
				),
			)
		);

		$repeater_list->add_control(
			'badge_text_color',
			array(
				'label'     => __( 'Text Color', 'premium-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} {{CURRENT_ITEM}} .premium-bullet-list-badge span' => 'color: {{VALUE}}',
				),
				'condition' => array(
					'show_badge' => 'yes',
				),
			)
		);

		$repeater_list->add_control(
			'badge_background_color',
			array(
				'label'     => __( 'Background', 'premium-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} {{CURRENT_ITEM}} .premium-bullet-list-badge span' => 'background-color: {{VALUE}}',
				),
				'condition' => array(
					'show_badge' => 'yes',
				),
			)
		);

		$repeater_list->add_control(
			'show_global_style',
			array(
				'label'        => __( 'Override Global Style', 'premium-addons-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => 'yes',
				'separator'    => 'before',
			)
		);

		$repeater_list->add_control(
			'list_box_size',
			array(
				'label'      => __( 'Size', 'premium-addons-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em', '%' ),
				'range'      => array(
					'px' => array(
						'min' => 5,
						'max' => 200,
					),
					'em' => array(
						'min' => 5,
						'max' => 30,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} {{CURRENT_ITEM}} .premium-bullet-list-text span, {{WRAPPER}} {{CURRENT_ITEM}} .premium-bullet-list-wrapper i,{{WRAPPER}} {{CURRENT_ITEM}} .premium-bullet-list-wrapper .premium-bullet-list-icon-text p' => 'font-size: {{SIZE}}{{UNIT}} ',
					'{{WRAPPER}} {{CURRENT_ITEM}} .premium-bullet-list-wrapper svg, {{WRAPPER}} {{CURRENT_ITEM}} .premium-bullet-list-wrapper img' => 'width: {{SIZE}}{{UNIT}} !important; height: {{SIZE}}{{UNIT}} !important;',
				),
				'condition'  => array(
					'show_global_style' => 'yes',
				),
			)
		);

		$repeater_list->start_controls_tabs(
			'colors_style_tabs'
		);

		$repeater_list->start_controls_tab(
			'color_normal_state',
			array(
				'label'     => __( 'Normal', 'premium-addons-for-elementor' ),
				'condition' => array(
					'show_global_style' => 'yes',
				),
			)
		);

		$repeater_list->add_control(
			'icon_color',
			array(
				'label'     => __( 'Icon/Text Color', 'premium-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} {{CURRENT_ITEM}} .premium-bullet-list-wrapper i' => 'color: {{VALUE}}',
					'{{WRAPPER}} {{CURRENT_ITEM}} .premium-bullet-list-wrapper svg' => 'fill: {{VALUE}}; color: {{VALUE}}',
					'{{WRAPPER}} .premium-bullet-list-blur:hover {{CURRENT_ITEM}} .premium-bullet-list-wrapper i, {{WRAPPER}} .premium-bullet-list-blur:hover {{CURRENT_ITEM}} .premium-bullet-list-wrapper svg' => 'text-shadow: 0 0 3px {{VALUE}}',
				),
				'condition' => array(
					'show_icon'         => 'yes',
					'icon_type'         => 'icon',
					'show_global_style' => 'yes',
				),
			)
		);

		$repeater_list->add_control(
			'text_icon_color',
			array(
				'label'     => __( 'Icon/Text Color', 'premium-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} {{CURRENT_ITEM}}  .premium-bullet-list-icon-text p' => 'color: {{VALUE}}',
					'{{WRAPPER}} .premium-bullet-list-blur:hover {{CURRENT_ITEM}} .premium-bullet-list-icon-text p' => 'text-shadow: 0 0 3px {{VALUE}};',
				),
				'condition' => array(
					'show_icon'         => 'yes',
					'icon_type'         => 'text',
					'show_global_style' => 'yes',
				),
			)
		);

		$repeater_list->add_control(
			'background_text_icon_color',
			array(
				'label'     => __( 'Icon/Text Background', 'premium-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} {{CURRENT_ITEM}}  .premium-bullet-list-icon-text p' => 'background-color: {{VALUE}}',
				),
				'condition' => array(
					'show_icon'         => 'yes',
					'icon_type'         => 'text',
					'show_global_style' => 'yes',
				),
			)
		);

		$repeater_list->add_control(
			'title_list_color',
			array(
				'label'     => __( 'Title Color', 'premium-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} {{CURRENT_ITEM}} .premium-bullet-list-text span' => 'color: {{VALUE}}',
					'{{WRAPPER}} .premium-bullet-list-blur:hover {{CURRENT_ITEM}} .premium-bullet-list-text span' => 'text-shadow: 0 0 3px {{VALUE}};',
				),
				'condition' => array(
					'show_global_style' => 'yes',
				),
			)
		);

		$repeater_list->add_control(
			'background_color',
			array(
				'label'     => __( 'Background', 'premium-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} {{CURRENT_ITEM}}.premium-bullet-list-content' => 'background-color: {{VALUE}}',
				),
				'condition' => array(
					'show_global_style' => 'yes',
				),
			)
		);

		$repeater_list->end_controls_tab();

		$repeater_list->start_controls_tab(
			'color_hover_state',
			array(
				'label'     => __( 'Hover', 'premium-addons-for-elementor' ),
				'condition' => array(
					'show_global_style' => 'yes',
				),
			)
		);

		$repeater_list->add_control(
			'icon_hover_color',
			array(
				'label'     => __( 'Icon/Text Color', 'premium-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}}  {{CURRENT_ITEM}}.premium-bullet-list-content:hover .premium-bullet-list-wrapper i' => 'color: {{VALUE}}',
					'{{WRAPPER}}  {{CURRENT_ITEM}}.premium-bullet-list-content:hover .premium-bullet-list-wrapper svg' => 'fill: {{VALUE}}; color: {{VALUE}}',
					'{{WRAPPER}} .premium-bullet-list-blur {{CURRENT_ITEM}}.premium-bullet-list-content:hover .premium-bullet-list-wrapper i, {{WRAPPER}} .premium-bullet-list-blur {{CURRENT_ITEM}}.premium-bullet-list-content:hover .premium-bullet-list-wrapper svg' => 'text-shadow: none !important; color: {{VALUE}} !important',
				),
				'condition' => array(
					'show_icon'         => 'yes',
					'icon_type'         => 'icon',
					'show_global_style' => 'yes',
				),
			)
		);

		$repeater_list->add_control(
			'text_icon_hover_color',
			array(
				'label'     => __( 'Icon/Text Color', 'premium-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} {{CURRENT_ITEM}}.premium-bullet-list-content:hover .premium-bullet-list-icon-text p' => 'color: {{VALUE}}',
					'{{WRAPPER}} .premium-bullet-list-blur {{CURRENT_ITEM}}.premium-bullet-list-content:hover .premium-bullet-list-icon-text p' => 'text-shadow: none !important; color: {{VALUE}} !important;',
				),
				'condition' => array(
					'show_icon'         => 'yes',
					'icon_type'         => 'text',
					'show_global_style' => 'yes',
				),
			)
		);

		$repeater_list->add_control(
			'background_text_icon_hover_color',
			array(
				'label'     => __( 'Icon/Text Background ', 'premium-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => array(
					'default' => Global_Colors::COLOR_PRIMARY,
				),
				'selectors' => array(
					'{{WRAPPER}} {{CURRENT_ITEM}}.premium-bullet-list-content:hover .premium-bullet-list-icon-text p' => 'background-color: {{VALUE}}',
				),
				'condition' => array(
					'show_icon'         => 'yes',
					'icon_type'         => 'text',
					'show_global_style' => 'yes',
				),
			)
		);

		$repeater_list->add_control(
			'title_hover_color',
			array(
				'label'     => __( 'Title Color', 'premium-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} {{CURRENT_ITEM}}.premium-bullet-list-content:hover .premium-bullet-list-text span' => 'color: {{VALUE}}',
					'{{WRAPPER}} .premium-bullet-list-blur {{CURRENT_ITEM}}.premium-bullet-list-content:hover .premium-bullet-list-text span' => 'text-shadow: none !important; color: {{VALUE}} !important;',
				),
				'condition' => array(
					'show_global_style' => 'yes',
				),
			)
		);

		$repeater_list->add_control(
			'background_hover_color',
			array(
				'label'     => __( 'Background', 'premium-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} {{CURRENT_ITEM}}.premium-bullet-list-content:hover' => 'background-color: {{VALUE}}',
				),
				'condition' => array(
					'show_global_style' => 'yes',
				),
			)
		);

		$repeater_list->end_controls_tab();

		$repeater_list->end_controls_tabs();

		$this->add_control(
			'list',
			array(
				'label'       => __( 'List Items', 'premium-addons-for-elementor' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater_list->get_controls(),
				'render_type' => 'template',
				'default'     => array(
					array(
						'list_title'                     => 'List Title #1',
						'premium_icon_list_font_updated' => array(
							'value'   => 'fas fa-star',
							'library' => 'fa-solid',
						),
					),
					array(
						'list_title'                     => 'List Title  #2',
						'premium_icon_list_font_updated' => array(
							'value'   => 'far fa-smile',
							'library' => 'fa-regular',
						),

					),
					array(
						'list_title'                     => 'List Title  #3',
						'premium_icon_list_font_updated' => array(
							'value'   => 'fa fa-check',
							'library' => 'fa-solid',
						),
					),
				),
				'title_field' => '<# if ( "icon" === icon_type ) { #> {{{ elementor.helpers.renderIcon( this, premium_icon_list_font_updated, {}, "i", "panel" ) }}}<#} else if( "text" === icon_type ) { #> {{list_text_icon}} <# } else if( "image" === icon_type) {#> <img class="editor-pa-img" src="{{custom_image.url}}"><# } #> {{{ list_title }}}',
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'display_options_section',
			array(
				'label' => __( 'Display Options', 'premium-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'list_overflow',
			array(
				'label'       => __( 'List Overflow', 'premium-addons-for-elementor' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'visible' => __( 'Visible', 'premium-addons-for-elementor' ),
					'hidden'  => __( 'Hidden', 'premium-addons-for-elementor' ),
				),
				'default'     => 'hidden',
				'render_type' => 'template',
				'selectors'   => array(
					'{{WRAPPER}} .premium-bullet-list-content' => 'overflow: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'overflow_render_notice',
			array(
				'raw'             => __( 'Please note that bullet connector option only appears when overflow set to visible.', 'premium-addons-for-elementor' ),
				'type'            => Controls_Manager::RAW_HTML,
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
			)
		);

		$this->add_responsive_control(
			'layout_type',
			array(
				'label'       => __( 'Layout Type', 'premium-addons-for-elementor' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'row'    => __( 'Inline', 'premium-addons-for-elementor' ),
					'column' => __( 'Block', 'premium-addons-for-elementor' ),

				),
				'render_type' => 'template',
				'default'     => 'column',
				'selectors'   => array(
					'{{WRAPPER}}  .premium-bullet-list-box ' => 'flex-direction: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'premium_icon_list_align',
			array(
				'label'       => __( 'Alignment', 'premium-addons-for-elementor' ),
				'type'        => Controls_Manager::CHOOSE,
				'render_type' => 'template',
				'options'     => array(
					'flex-start' => array(
						'title' => __( 'Left', 'premium-addons-for-elementor' ),
						'icon'  => 'eicon-text-align-left',
					),
					'center'     => array(
						'title' => __( 'Center', 'premium-addons-for-elementor' ),
						'icon'  => 'eicon-text-align-center',
					),
					'flex-end'   => array(
						'title' => __( 'Right', 'premium-addons-for-elementor' ),
						'icon'  => 'eicon-text-align-right',
					),
				),
				'selectors'   => array(
					'{{WRAPPER}} .premium-bullet-list-content , {{WRAPPER}} .premium-bullet-list-box ' => 'justify-content:{{VALUE}};',
					'{{WRAPPER}} .premium-bullet-list-divider , {{WRAPPER}} .premium-bullet-list-wrapper-top ' => 'align-self:{{VALUE}};',
				),
				'toggle'      => false,
				'default'     => 'flex-start',
			)
		);

		$this->add_control(
			'icon_postion',
			array(
				'label'       => __( 'Bullet Position', 'premium-addons-for-elementor' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'row'         => __( 'Before', 'premium-addons-for-elementor' ),
					'column'      => __( 'Top', 'premium-addons-for-elementor' ),
					'row-reverse' => __( 'After', 'premium-addons-for-elementor' ),
				),
				'render_type' => 'template',
				'default'     => 'row',
				'selectors'   => array(
					'{{WRAPPER}} .premium-bullet-list-text' => 'display:flex;flex-direction: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'top_icon_align',
			array(
				'label'     => __( 'Bullet Alignment', 'premium-addons-for-elementor' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => array(
					'flex-start' => array(
						'title' => __( 'Left', 'premium-addons-for-elementor' ),
						'icon'  => 'eicon-text-align-left',
					),
					'center'     => array(
						'title' => __( 'Center', 'premium-addons-for-elementor' ),
						'icon'  => 'eicon-text-align-center',
					),
					'flex-end'   => array(
						'title' => __( 'Right', 'premium-addons-for-elementor' ),
						'icon'  => 'eicon-text-align-right',
					),
				),
				'toggle'    => false,
				'selectors' => array(
					'{{WRAPPER}} .premium-bullet-list-wrapper-top'      => 'align-self: {{VALUE}} !important',
				),
				'condition' => array(
					'icon_postion' => 'column',
				),
			)
		);

		$this->add_responsive_control(
			'inline_icon_align',
			array(
				'label'     => __( 'Bullet Alignment', 'premium-addons-pro' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => array(
					'flex-start' => array(
						'title' => __( 'Top', 'premium-addons-pro' ),
						'icon'  => 'eicon-arrow-up',
					),
					'center'     => array(
						'title' => __( 'Center', 'premium-addons-pro' ),
						'icon'  => 'eicon-text-align-justify',
					),
					'flex-end'   => array(
						'title' => __( 'Bottom', 'premium-addons-pro' ),
						'icon'  => 'eicon-arrow-down',
					),
				),
				'default'   => 'center',
				'toggle'    => false,
				'selectors' => array(
					'{{WRAPPER}} .premium-bullet-list-wrapper' => 'align-self: {{VALUE}};',
				),
				'condition' => array(
					'icon_postion!' => 'column',
				),
			)
		);

		$this->add_responsive_control(
			'badge_align_h',
			array(
				'label'     => __( 'Badge Alignment', 'premium-addons-for-elementor' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => array(
					'8' => array(
						'title' => __( 'Right', 'premium-addons-for-elementor' ),
						'icon'  => 'fas fa-long-arrow-alt-right',
					),
					'3' => array(
						'title' => __( 'Left', 'premium-addons-for-elementor' ),
						'icon'  => 'fas fa-long-arrow-alt-left',
					),
				),
				'default'   => '8',
				'toggle'    => false,
				'selectors' => array(
					'{{WRAPPER}} .premium-bullet-list-text' => 'order:5 ;',
					'{{WRAPPER}} .premium-bullet-list-badge' => 'order:{{VALUE}} ;',
				),
				'separator' => 'after',
			)
		);

		$this->add_control(
			'show_divider',
			array(
				'label'        => __( 'Divider', 'premium-addons-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
			)
		);

		$this->add_control(
			'show_connector',
			array(
				'label'        => __( 'Bullet Connector', 'premium-addons-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'condition'    => array(
					'layout_type'        => 'column',
					'icon_postion!'      => 'column',
					'hover_effect_type!' => 'grow',
					'list_overflow'      => 'visible',
				),
			)
		);

		$this->add_control(
			'premium_icon_list_animation_switcher',
			array(
				'label' => __( 'Animation', 'premium-addons-for-elementor' ),
				'type'  => Controls_Manager::SWITCHER,
			)
		);

		$this->add_control(
			'premium_icon_list_animation',
			array(
				'label'              => __( 'Entrance Animation', 'premium-addons-for-elementor' ),
				'type'               => Controls_Manager::ANIMATION,
				'default'            => '',
				'label_block'        => true,
				'frontend_available' => true,
				'render_type'        => 'template',
				'condition'          => array(
					'premium_icon_list_animation_switcher' => 'yes',
				),
			)
		);

		$this->add_control(
			'premium_icon_list_animation_duration',
			array(
				'label'     => __( 'Animation Duration', 'premium-addons-for-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '',
				'options'   => array(
					'slow' => __( 'Slow', 'premium-addons-for-elementor' ),
					''     => __( 'Normal', 'premium-addons-for-elementor' ),
					'fast' => __( 'Fast', 'premium-addons-for-elementor' ),
				),
				'condition' => array(
					'premium_icon_list_animation_switcher' => 'yes',
					'premium_icon_list_animation!'         => '',
				),
			)
		);

		$this->add_control(
			'premium_icon_list_animation_delay',
			array(
				'label'              => __( 'Animation Delay in Between (s)', 'premium-addons-for-elementor' ),
				'type'               => Controls_Manager::NUMBER,
				'default'            => 0,
				'step'               => 0.1,
				'condition'          => array(
					'premium_icon_list_animation_switcher' => 'yes',
					'premium_icon_list_animation!'         => '',
				),
				'frontend_available' => true,
			)
		);

		$this->add_control(
			'hover_effect_type',
			array(
				'label'       => __( 'Hover Effect', 'premium-addons-for-elementor' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'none'            => __( 'None', 'premium-addons-for-elementor' ),
					'blur'            => __( 'Blur', 'premium-addons-for-elementor' ),
					'grow'            => __( 'Grow', 'premium-addons-for-elementor' ),
					'linear gradient' => __( 'Text Gradient', 'premium-addons-for-elementor' ),
				),
				'render_type' => 'template',
				'default'     => 'none',
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'      => 'gradient_color',
				'types'     => array( 'gradient' ),
				'condition' => array(
					'hover_effect_type' => 'linear gradient',
				),
				'selector'  => '{{WRAPPER}}  a[data-text]::before ,{{WRAPPER}} .premium-bullet-list-gradient-effect::before',
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
			'https://premiumaddons.com/docs/icon-list-widget-tutorial/' => __( 'Getting started »', 'premium-addons-for-elementor' ),
			'https://www.youtube.com/watch?v=MPeXJiZ14sI' => __( 'Check the video tutorial »', 'premium-addons-for-elementor' ),
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

		$this->register_style_controls();
	}

	/**
	 * Register Style Control
	 *
	 * @since 4.0.0
	 * @access private
	 */
	private function register_style_controls() {

		$this->start_controls_section(
			'list_style_section',
			array(
				'label' => __( ' General ', 'premium-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'list_items_color',
			array(
				'label'     => __( 'Background Color', 'premium-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					' {{WRAPPER}}  .premium-bullet-list-content' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'list_items_hover_color',
			array(
				'label'     => __( 'Hover Background Color', 'premium-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .premium-bullet-list-content:hover ' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'list_items_shadow',
				'selector' => '{{WRAPPER}} .premium-bullet-list-content',
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'list_items_shadow_hover',
				'label'    => 'Hover Box Shadow',
				'selector' => '{{WRAPPER}} .premium-bullet-list-content:hover',
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'list_item_border',
				'label'    => __( 'Border', 'premium-addons-for-elementor' ),
				'selector' => '{{WRAPPER}} .premium-bullet-list-content ',
			)
		);

		$this->add_responsive_control(
			'list_item_border_radius',
			array(
				'label'      => __( 'Border Radius', 'premium-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'default'    => array(
					'top'    => 0,
					'right'  => 0,
					'bottom' => 0,
					'left'   => 0,
				),
				'selectors'  => array(
					'{{WRAPPER}} .premium-bullet-list-content ' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'list_item_margin',
			array(
				'label'      => __( 'Margin', 'premium-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .premium-bullet-list-content ' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'list_items_padding',
			array(
				'label'      => __( 'Padding', 'premium-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .premium-bullet-list-content ' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'icon_style_section',
			array(
				'label' => __( 'Bullet', 'premium-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'icon_render_notice',
			array(
				'raw'  => __( 'Options below will be applied on items with no style options set individually from the repeater.', 'premium-addons-for-elementor' ),
				'type' => Controls_Manager::RAW_HTML,
			)
		);

		$this->add_responsive_control(
			'icon_size',
			array(
				'label'      => __( 'Size', 'premium-addons-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em' ),
				'range'      => array(
					'px' => array(
						'min' => 1,
						'max' => 200,
					),
					'em' => array(
						'min' => 1,
						'max' => 30,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}}  .premium-bullet-list-wrapper i , {{WRAPPER}}  .premium-bullet-list-wrapper .premium-bullet-list-icon-text p' => 'font-size: {{SIZE}}{{UNIT}} ',
					'{{WRAPPER}}  .premium-bullet-list-wrapper svg, {{WRAPPER}}  .premium-bullet-list-wrapper img'    => 'width: {{SIZE}}{{UNIT}} !important; height: {{SIZE}}{{UNIT}} !important',
				),
			)
		);

		$this->add_control(
			'icon_color_render_notice',
			array(
				'raw'       => __( 'Color options below will be applied on Font Awesome and Text.', 'premium-addons-for-elementor' ),
				'type'      => Controls_Manager::RAW_HTML,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'icon_color',
			array(
				'label'     => __( 'Color', 'premium-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => array(
					'default' => Global_Colors::COLOR_PRIMARY,
				),
				'selectors' => array(
					'{{WRAPPER}} .premium-bullet-list-wrapper i, {{WRAPPER}} .premium-bullet-list-icon-text p' => 'color: {{VALUE}}',
					'{{WRAPPER}} .premium-bullet-list-wrapper svg' => 'fill: {{VALUE}}; color: {{VALUE}}',
					'{{WRAPPER}} .premium-bullet-list-blur:hover .premium-bullet-list-wrapper i, {{WRAPPER}} .premium-bullet-list-blur:hover .premium-bullet-list-wrapper svg, {{WRAPPER}} .premium-bullet-list-blur:hover .premium-bullet-list-wrapper .premium-bullet-list-icon-text p' => 'text-shadow: 0 0 3px {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'icon_hover_color',
			array(
				'label'     => __( 'Hover Color', 'premium-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => array(
					'default' => Global_Colors::COLOR_PRIMARY,
				),
				'selectors' => array(
					'{{WRAPPER}} .premium-bullet-list-content:hover .premium-bullet-list-wrapper i ,{{WRAPPER}} .premium-bullet-list-content:hover .premium-bullet-list-icon-text p' => 'color: {{VALUE}}',
					'{{WRAPPER}} .premium-bullet-list-blur .premium-bullet-list-content:hover .premium-bullet-list-wrapper i, {{WRAPPER}} .premium-bullet-list-blur .premium-bullet-list-content:hover  .premium-bullet-list-icon-text p' => 'text-shadow: none !important; color: {{VALUE}} !important;',
					'{{WRAPPER}} .premium-bullet-list-content:hover .premium-bullet-list-wrapper svg' => 'fill: {{VALUE}}; color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'background_render_notice',
			array(
				'raw'       => __( 'Background Color options below will be applied on all bullet types.', 'premium-addons-for-elementor' ),
				'type'      => Controls_Manager::RAW_HTML,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'icon_background_color',
			array(
				'label'     => __( 'Background', 'premium-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}}  .premium-bullet-list-wrapper i , {{WRAPPER}}  .premium-bullet-list-wrapper svg, {{WRAPPER}}  .premium-bullet-list-wrapper img , {{WRAPPER}}  .premium-bullet-list-icon-text p' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'icon_background_hover_color',
			array(
				'label'     => __( ' Hover Background', 'premium-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .premium-bullet-list-content:hover .premium-bullet-list-wrapper i,{{WRAPPER}} .premium-bullet-list-content:hover .premium-bullet-list-wrapper svg ,{{WRAPPER}} .premium-bullet-list-content:hover .premium-bullet-list-wrapper img ,  {{WRAPPER}} .premium-bullet-list-content:hover  .premium-bullet-list-icon-text p' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'typo_text_render_notice',
			array(
				'raw'       => __( 'Typography option below will be applied on text.', 'premium-addons-for-elementor' ),
				'type'      => Controls_Manager::RAW_HTML,
				'separator' => 'before',
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'text_icon_typography',
				'selector' => ' {{WRAPPER}}  .premium-bullet-list-icon-text p',
				'global'   => array(
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'      => 'border',
				'selector'  => '{{WRAPPER}} .premium-bullet-list-content .premium-bullet-list-wrapper i , {{WRAPPER}} .premium-bullet-list-content .premium-bullet-list-wrapper svg , {{WRAPPER}} .premium-bullet-list-content .premium-bullet-list-wrapper img ,{{WRAPPER}} .premium-bullet-list-content .premium-bullet-list-wrapper .premium-bullet-list-icon-text p',
				'separator' => 'before',
			)
		);

		$this->add_responsive_control(
			'icon_border_radius',
			array(
				'label'      => __( 'Border Radius', 'premium-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .premium-bullet-list-content .premium-bullet-list-wrapper i ,{{WRAPPER}} .premium-bullet-list-content .premium-bullet-list-wrapper .premium-bullet-list-icon-text p, {{WRAPPER}} .premium-bullet-list-content .premium-bullet-list-wrapper svg , {{WRAPPER}} .premium-bullet-list-content .premium-bullet-list-wrapper img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'icon_margin',
			array(
				'label'      => __( 'Margin', 'premium-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .premium-bullet-list-wrapper ' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'separator'  => 'before',
			)
		);

		$this->add_responsive_control(
			'icon_padding',
			array(
				'label'      => __( 'Padding', 'premium-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .premium-bullet-list-content .premium-bullet-list-wrapper i,{{WRAPPER}} .premium-bullet-list-content .premium-bullet-list-wrapper .premium-bullet-list-icon-text p , {{WRAPPER}} .premium-bullet-list-content .premium-bullet-list-wrapper svg , {{WRAPPER}} .premium-bullet-list-content .premium-bullet-list-wrapper img' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'title_style_section',
			array(
				'label' => __( 'Title', 'premium-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'title_render_notice',
			array(
				'raw'  => __( 'Options below will be applied on items with no style options set individually from the repeater.', 'premium-addons-for-elementor' ),
				'type' => Controls_Manager::RAW_HTML,
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'list_title_typography',
				'selector' => ' {{WRAPPER}} .premium-bullet-list-text span ',
				'global'   => array(
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				),

			)
		);

		$this->add_control(
			'title_color',
			array(
				'label'     => __( 'Color', 'premium-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => array(
					'default' => Global_Colors::COLOR_PRIMARY,
				),
				'selectors' => array(
					' {{WRAPPER}}  .premium-bullet-list-text span' => 'color: {{VALUE}}',
					' {{WRAPPER}} .premium-bullet-list-blur:hover .premium-bullet-list-text span' => 'text-shadow: 0 0 3px {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'title_hover_color',
			array(
				'label'     => __( 'Hover Color', 'premium-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => array(
					'default' => Global_Colors::COLOR_PRIMARY,
				),
				'selectors' => array(
					'{{WRAPPER}} .premium-bullet-list-content:hover .premium-bullet-list-text span' => 'color: {{VALUE}}',
					'{{WRAPPER}} .premium-bullet-list-blur .premium-bullet-list-content:hover .premium-bullet-list-text span' => 'text-shadow: none !important; color: {{VALUE}} !important;',
				),
			)
		);

		$this->add_group_control(
			Group_Control_text_Shadow::get_type(),
			array(
				'name'     => 'list_title_shadow',
				'selector' => '{{WRAPPER}} .premium-bullet-list-text span',
			)
		);

		$this->add_responsive_control(
			'list_title_margin',
			array(
				'label'      => __( 'Margin', 'premium-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .premium-bullet-list-text ' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'badge_style_section',
			array(
				'label' => __( 'Badge', 'premium-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'badge_title_typography',
				'selector' => ' {{WRAPPER}}  .premium-bullet-list-badge span',
				'global'   => array(
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				),
			)
		);

		$this->add_control(
			'badge_color_render_notice',
			array(
				'raw'       => __( 'Color options below will be applied on badge with no style options set individually from the repeater.', 'premium-addons-for-elementor' ),
				'type'      => Controls_Manager::RAW_HTML,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'badge_text_style_color',
			array(
				'label'     => __( 'Text Color', 'premium-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => array(
					'default' => Global_Colors::COLOR_PRIMARY,
				),
				'selectors' => array(
					'{{WRAPPER}} .premium-bullet-list-badge span' => 'color: {{VALUE}}',
				),
				'default'   => '#fff',
			)
		);

		$this->add_control(
			'badge_background_style_color',
			array(
				'label'     => __( 'Background', 'premium-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => array(
					'default' => Global_Colors::COLOR_PRIMARY,
				),
				'default'   => '#6ec1e4',
				'selectors' => array(
					'{{WRAPPER}} .premium-bullet-list-badge span' => 'background-color: {{VALUE}}',
				),
				'separator' => 'after',
			)
		);

		$this->add_responsive_control(
			'badge_border_radius',
			array(
				'label'      => __( 'Badge Radius', 'premium-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'default'    => array(
					'top'    => 2,
					'right'  => 2,
					'bottom' => 2,
					'left'   => 2,
				),
				'selectors'  => array(
					'{{WRAPPER}} .premium-bullet-list-badge span ' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_text_Shadow::get_type(),
			array(
				'name'     => 'Badge_text_shadow',
				'selector' => '{{WRAPPER}} .premium-bullet-list-badge span',
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'Badge_box_shadow',
				'selector' => '{{WRAPPER}} .premium-bullet-list-badge span',
			)
		);

		$this->add_responsive_control(
			'Badge_margin',
			array(
				'label'      => __( 'Margin', 'premium-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'default'    => array(
					'top'    => 0,
					'right'  => 0,
					'bottom' => 0,
					'left'   => 5,
				),
				'selectors'  => array(
					'{{WRAPPER}} .premium-bullet-list-badge ' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'Badge_padding',
			array(
				'label'      => __( 'Padding', 'premium-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'default'    => array(
					'top'    => 2,
					'right'  => 5,
					'bottom' => 2,
					'left'   => 5,
				),
				'selectors'  => array(
					'{{WRAPPER}} .premium-bullet-list-badge span ' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'divider_style_section',
			array(
				'label'     => __( ' Divider ', 'premium-addons-for-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'show_divider' => 'yes',
				),
			)
		);

		$this->add_control(
			'list_divider_type',
			array(
				'label'     => __( 'Divider Style', 'premium-addons-for-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => array(
					'solid'  => __( 'Solid', 'premium-addons-for-elementor' ),
					'double' => __( 'Double', 'premium-addons-for-elementor' ),
					'dotted' => __( 'Dotted', 'premium-addons-for-elementor' ),
					'dashed' => __( 'Dashed', 'premium-addons-for-elementor' ),
					'groove' => __( 'Groove', 'premium-addons-for-elementor' ),
				),
				'default'   => 'solid',
				'selectors' => array(
					'{{WRAPPER}} .premium-bullet-list-divider:not(:last-child):after' => 'border-top-style: {{VALUE}};',
					'{{WRAPPER}} .premium-bullet-list-divider-inline:not(:last-child):after' => 'border-left-style: {{VALUE}};',
				),
				'condition' => array(
					'show_divider' => 'yes',
				),
			)
		);

		$this->add_responsive_control(
			'list_divider_width',
			array(
				'label'       => __( ' Width', 'premium-addons-for-elementor' ),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => array( 'px', 'em' ),
				'range'       => array(
					'px' => array(
						'min' => 0,
						'max' => 600,
					),
					'em' => array(
						'min' => 0,
						'max' => 30,
					),
				),
				'label_block' => true,
				'selectors'   => array(
					'{{WRAPPER}}  .premium-bullet-list-divider:not(:last-child):after' => 'width:{{SIZE}}{{UNIT}};',
					'{{WRAPPER}}  .premium-bullet-list-divider-inline:not(:last-child):after ' => 'border-left-width: {{SIZE}}{{UNIT}};',
				),
				'condition'   => array(
					'show_divider' => 'yes',
				),
			)
		);

		$this->add_responsive_control(
			'list_divider_height',
			array(
				'label'       => __( ' Height', 'premium-addons-for-elementor' ),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => array( 'px', 'em' ),
				'range'       => array(
					'px' => array(
						'min' => 0,
						'max' => 600,
					),
					'em' => array(
						'min' => 0,
						'max' => 30,
					),
				),
				'label_block' => true,
				'selectors'   => array(
					'{{WRAPPER}}  .premium-bullet-list-divider:not(:last-child):after ' => 'border-top-width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}}  .premium-bullet-list-divider-inline:not(:last-child):after' => 'height: {{SIZE}}{{UNIT}};',
				),
				'condition'   => array(
					'show_divider' => 'yes',
				),
			)
		);

		$this->add_control(
			'list_divider_color',
			array(
				'label'     => __( 'Color', 'premium-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => array(
					'default' => Global_Colors::COLOR_SECONDARY,
				),
				'default'   => '#ddd',
				'selectors' => array(
					'{{WRAPPER}}  .premium-bullet-list-divider:not(:last-child):after ' => 'border-top-color: {{VALUE}};',
					'{{WRAPPER}}  .premium-bullet-list-divider-inline:not(:last-child):after ' => 'border-left-color: {{VALUE}};',
				),
				'condition' => array(
					'show_divider' => 'yes',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'connector_style_section',
			array(
				'label'     => __( ' Connector ', 'premium-addons-for-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'layout_type'        => 'column',
					'icon_postion!'      => 'column',
					'show_connector'     => 'yes',
					'hover_effect_type!' => 'grow',
					'list_overflow'      => 'visible',
				),
			)
		);

		$this->add_control(
			'icon_connector_type',
			array(
				'label'     => __( 'Style', 'premium-addons-for-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => array(
					'solid'  => __( 'Solid', 'premium-addons-for-elementor' ),
					'double' => __( 'Double', 'premium-addons-for-elementor' ),
					'dotted' => __( 'Dotted', 'premium-addons-for-elementor' ),
					'dashed' => __( 'Dashed', 'premium-addons-for-elementor' ),
					'groove' => __( 'Groove', 'premium-addons-for-elementor' ),
				),
				'default'   => 'solid',
				'selectors' => array(
					'{{WRAPPER}} li.premium-bullet-list-content:not(:last-of-type) .premium-bullet-list-connector .premium-icon-connector-content:after ' => 'border-right-style: {{VALUE}};',
				),
				'condition' => array(
					'show_connector' => 'yes',
				),
			)
		);

		$this->add_responsive_control(
			'icon_connector_width',
			array(
				'label'       => __( ' Width', 'premium-addons-for-elementor' ),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => array( 'px', 'em' ),
				'range'       => array(
					'px' => array(
						'min' => 0,
						'max' => 600,
					),
					'em' => array(
						'min' => 0,
						'max' => 30,
					),
				),
				'label_block' => true,
				'selectors'   => array(
					'{{WRAPPER}}  li.premium-bullet-list-content:not(:last-of-type) .premium-bullet-list-connector .premium-icon-connector-content:after' => 'border-right-width: {{SIZE}}{{UNIT}};',
				),
				'condition'   => array(
					'show_connector' => 'yes',
				),
			)
		);

		$this->add_responsive_control(
			'icon_connector_height',
			array(
				'label'       => __( ' Height', 'premium-addons-for-elementor' ),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => array( 'px', 'em' ),
				'default'     => array(
					'unit' => 'px',
					'size' => 28,
				),
				'range'       => array(
					'px' => array(
						'min' => 0,
						'max' => 600,
					),
					'em' => array(
						'min' => 0,
						'max' => 30,
					),
				),
				'label_block' => true,
				'selectors'   => array(
					'{{WRAPPER}}  li.premium-bullet-list-content:not(:last-of-type) .premium-bullet-list-connector .premium-icon-connector-content:after' => 'height: {{SIZE}}{{UNIT}};',
				),
				'condition'   => array(
					'show_connector' => 'yes',
				),
			)
		);

		$this->add_control(
			'icon_connector_color',
			array(
				'label'     => __( 'Color', 'premium-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => array(
					'default' => Global_Colors::COLOR_SECONDARY,
				),
				'default'   => '#ddd',
				'selectors' => array(
					'{{WRAPPER}}  li.premium-bullet-list-content:not(:last-of-type) .premium-bullet-list-connector .premium-icon-connector-content:after' => 'border-color: {{VALUE}};',
				),
				'condition' => array(
					'show_connector' => 'yes',
				),
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Render Bullet List output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 3.21.2
	 * @access protected
	 */
	protected function render() {

		$settings = $this->get_settings_for_display();

		$this->add_render_attribute( 'box', 'class', 'premium-bullet-list-box' );

		if ( 'blur' === $settings['hover_effect_type'] ) {

			$this->add_render_attribute( 'box', 'class', 'premium-bullet-list-blur' );

		}

		$animation_switch = $settings['premium_icon_list_animation_switcher'];

		if ( 'yes' === $animation_switch ) {

			$animation_class = $settings['premium_icon_list_animation'];

			if ( '' !== $settings['premium_icon_list_animation_duration'] ) {
				$animation_dur = 'animated-' . $settings['premium_icon_list_animation_duration'];
			} else {
				$animation_dur = 'animated-';
			}

			$this->add_render_attribute(
				'box',
				'data-list-animation',
				array(
					$animation_class,
					$animation_dur,
				)
			);
		}

		?>
			<ul <?php echo wp_kses_post( $this->get_render_attribute_string( 'box' ) ); ?>>
		<?php

		$delay = 0;

		if ( $settings['list'] ) {
			foreach ( $settings['list'] as $index => $item ) {

				$text_icon = $this->get_repeater_setting_key( 'list_text_icon', 'list', $index );

				$text_badge = $this->get_repeater_setting_key( 'badge_title', 'list', $index );

				$this->add_inline_editing_attributes( $text_icon, 'basic' );

				$this->add_inline_editing_attributes( $text_badge, 'basic' );

				$item_link = 'link_' . $index;

				$separator_link_type = $item['link_select'];

				$link_url = ( 'url' === $separator_link_type ) ? $item['link']['url'] : get_permalink( $item['existing_page'] );

				if ( 'yes' === $item['show_list_link'] ) {

					$this->add_render_attribute(
						$item_link,
						array(
							'class' => 'premium-bullet-list-link',
							'title' => esc_attr( $item['link_title'] ),
						)
					);

					if ( ! empty( $item['link']['is_external'] ) ) {
						$this->add_render_attribute( $item_link, 'target', '_blank' );
					}

					if ( ! empty( $item['link']['nofollow'] ) ) {
						$this->add_render_attribute( $item_link, 'rel', 'nofollow' );
					}

					if ( ! empty( $item['link']['url'] ) || ! empty( $item['existing_page'] ) ) {
						$this->add_render_attribute( $item_link, 'href', $link_url );
					}
				}

				$lottie_key = 'icon_lottie_' . $index;

				if ( 'lottie' === $item['icon_type'] ) {

					$this->add_render_attribute(
						$lottie_key,
						array(
							'class'               => 'premium-lottie-animation',
							'data-lottie-url'     => $item['lottie_url'],
							'data-lottie-loop'    => $item['lottie_loop'],
							'data-lottie-reverse' => $item['lottie_reverse'],
						)
					);
				}

				$list_content_key = 'content_index_' . $index;

				$this->add_render_attribute(
					$list_content_key,
					'class',
					array(
						'premium-bullet-list-content',
						'elementor-repeater-item-' . $item['_id'],
					)
				);
				if ( 'yes' === $animation_switch ) {

					$this->add_render_attribute(
						$list_content_key,
						'data-delay',
						array(
							$delay,
						)
					);

					$delay = $delay + $settings['premium_icon_list_animation_delay'] * 1000;
				}
				if ( 'row' === $settings['layout_type'] ) {
					$this->add_render_attribute(
						$list_content_key,
						'class',
						array(
							'premium-bullet-list-content-inline',
						)
					);
				}

				if ( 'grow' === $settings['hover_effect_type'] ) {

					$this->add_render_attribute(
						$list_content_key,
						'class',
						array(
							'premium-bullet-list-content-grow-effect',
						)
					);
				}
				if ( 'column' === $settings['layout_type'] ) {

					if ( 'flex-start' === $settings['premium_icon_list_align'] ) {
						$this->add_render_attribute(
							$list_content_key,
							'class',
							array(
								'premium-bullet-list-content-grow-lc',
							)
						);
					} elseif ( 'flex-end' === $settings['premium_icon_list_align'] ) {
						$this->add_render_attribute(
							$list_content_key,
							'class',
							array(
								'premium-bullet-list-content-grow-rc',
							)
						);
					} else {
						$this->add_render_attribute(
							$list_content_key,
							'class',
							array(
								'premium-bullet-list-content-grow-cc',
							)
						);
					}
				}
				?>

			<li <?php echo wp_kses_post( $this->get_render_attribute_string( $list_content_key ) ); ?>>
				<div class="premium-bullet-list-text">
				<?php
				if ( 'yes' === $item['show_icon'] ) {

					$wrapper_class = 'premium-bullet-list-wrapper';

					$this->add_render_attribute( 'wrapper', 'class', $wrapper_class );

					if ( 'column' === $settings['icon_postion'] ) {

						$wrapper_top_class = 'premium-bullet-list-wrapper-top ';

						$this->add_render_attribute( 'wrapper', 'class', $wrapper_top_class );

					}

					if ( 'linear gradient' === $settings['hover_effect_type'] ) {
						$this->add_render_attribute( 'title', 'class', 'premium-bullet-list-gradient-effect' );
					}

					?>
				<div <?php echo wp_kses_post( $this->get_render_attribute_string( 'wrapper' ) ); ?>>
					<?php if ( 'yes' === $settings['show_connector'] && 'column' === $settings['layout_type'] && 'column' !== $settings['icon_postion'] && 'grow' !== $settings['hover_effect_type'] && 'visible' === $settings['list_overflow'] ) { ?>
						<div class="premium-bullet-list-connector">
							<div class="premium-icon-connector-content"></div>
						</div>
						<?php
					}

					if ( 'icon' === $item['icon_type'] ) {
						Icons_Manager::render_icon( $item['premium_icon_list_font_updated'], array( 'aria-hidden' => 'true' ) );
					} elseif ( 'text' === $item['icon_type'] ) {
						?>
						<div class="premium-bullet-list-icon-text">
							<p <?php echo wp_kses_post( $this->get_render_attribute_string( $text_icon ) ); ?>>
								<?php echo wp_kses_post( $item['list_text_icon'] ); ?>
							</p>
						</div>
						<?php
					} elseif ( 'image' === $item['icon_type'] ) {
						if ( ! empty( $item['custom_image']['url'] ) ) {
							$alt = Control_Media::get_image_alt( $item['custom_image'] );
							echo '<img src="' . esc_url( $item['custom_image']['url'] ) . '" alt="' . esc_attr( $alt ) . '">';
						}
					} else {
						echo '<div ' . wp_kses_post( $this->get_render_attribute_string( $lottie_key ) ) . '></div>';
					}
					?>
				</div>
				<?php } ?>

				<?php echo '<span ' . wp_kses_post( $this->get_render_attribute_string( 'title' ) ) . '  data-text="' . esc_attr( $item['list_title'] ) . '"> ' . wp_kses_post( $item['list_title'] ) . ' </span>'; ?>

				</div>

				<?php if ( 'yes' === $item['show_badge'] ) { ?>
					<div class="premium-bullet-list-badge">
						<span <?php echo wp_kses_post( $this->get_render_attribute_string( $text_badge ) ); ?>>
							<?php echo wp_kses_post( $item['badge_title'] ); ?>
						</span>
					</div>
				<?php } ?>

				<?php if ( 'yes' === $item['show_list_link'] ) { ?>
					<a <?php echo wp_kses_post( $this->get_render_attribute_string( $item_link ) ); ?> ></a>
				<?php } ?>

			</li>

				<?php
				if ( 'yes' === $settings['show_divider'] ) {
					$layout        = $settings['layout_type'];
					$divider_class = 'premium-bullet-list-divider';
					if ( 'row' === $layout ) {
						$divider_class .= '-inline';
					}

					$this->add_render_attribute( 'divider', 'class', $divider_class );
					?>
						<div <?php echo wp_kses_post( $this->get_render_attribute_string( 'divider' ) ); ?>></div>
					<?php
				}
			}
		}
		?>
		</ul>
		<?php
	}

	/**
	 * Render Bullet List widget output in the editor.
	 *
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	 *
	 * @since 3.21.2
	 * @access protected
	 */
	protected function content_template() {
		?>
		<#
		view.addRenderAttribute( 'box', 'class', 'premium-bullet-list-box');

		if( 'blur' === settings.hover_effect_type){

			view.addRenderAttribute( 'box', 'class', 'premium-bullet-list-blur');

		}

		animationSwitch = settings.premium_icon_list_animation_switcher ;

		if( 'yes' == animationSwitch  ) {

			animationClass = settings.premium_icon_list_animation;

			if( '' !== settings.premium_icon_list_animation_duration ) {

				animationDur = 'animated-' + settings.premium_icon_list_animation_duration;

			} else {
				animationDur = 'animated-';
			}
			view.addRenderAttribute( 'box', 'data-list-animation',
				[
					animationClass,
					animationDur,
				]
			);
		}
		#>

		<ul {{{ view.getRenderAttributeString('box') }}}>

			<#
			var delay=0;

			_.each( settings.list, function( item ,index ) {

				var textIcon  = view.getRepeaterSettingKey( 'list_text_icon', 'list', index );
				var textBadge  = view.getRepeaterSettingKey( 'badge_title', 'list', index );

				view.addInlineEditingAttributes( textIcon, 'basic' );
				view.addInlineEditingAttributes( textBadge, 'basic' );

				var itemLink = 'link_' + index;

				var separatorLinkType, linkUrl, linkTitle;

				separatorLinkType = item.link_select;

				linkUrl= 'url' ===  separatorLinkType  ? item.link.url : item.existing_page;

				if( 'yes' === item.show_list_link ) {

					view.addRenderAttribute(itemLink, {
						'class' : 'premium-bullet-list-link',
						'title' : item.link_title
					});

					if( '' != item.link.is_external ) {
						view.addRenderAttribute(itemLink, 'target', '_blank');
					}
					if( '' != item.link.nofollow ) {
						view.addRenderAttribute(itemLink, 'rel', 'nofollow');
					}
					if( ('' != item.link.url) || ('' != item.existing_page) ) {
						view.addRenderAttribute(itemLink, 'href', linkUrl);
					}
				}

				var lottieKey = 'icon_lottie_' + index;

				if( 'lottie' === item.icon_type ) {
					view.addRenderAttribute( lottieKey, {
						'class':  'premium-lottie-animation',
						'data-lottie-url': item.lottie_url,
						'data-lottie-loop': item.lottie_loop,
						'data-lottie-reverse': item.lottie_reverse
					});

				}

				var listContentKey = 'content_index_' + index;

				view.addRenderAttribute( listContentKey, 'class',
					[
						'premium-bullet-list-content' ,
						'elementor-repeater-item-' + item._id
					]
				);
				if( 'yes' == animationSwitch  ) {

					view.addRenderAttribute( listContentKey, 'data-delay',
						[
							delay
						]
					);

					delay += settings.premium_icon_list_animation_delay * 1000;
				}

				if ( 'row' === settings.layout_type ) {

					view.addRenderAttribute( listContentKey, 'class',
						[
							'premium-bullet-list-content-inline'
						]
					);

				}

				if ( 'grow' === settings.hover_effect_type ){

					view.addRenderAttribute( listContentKey, 'class',
						[
							'premium-bullet-list-content-grow-effect'
						]
					);

				}
				if ( 'column' === settings.layout_type ) {
					if('flex-start' === settings.premium_icon_list_align) {
						view.addRenderAttribute( listContentKey, 'class',
							[
								'premium-bullet-list-content-grow-lc'
							]
						);
					}
					else if( 'flex-end' === settings.premium_icon_list_align ) {
						view.addRenderAttribute( listContentKey, 'class',
							[
								'premium-bullet-list-content-grow-rc'
							]
						);
					}
					else {
						view.addRenderAttribute( listContentKey, 'class',
							[
								'premium-bullet-list-content-grow-cc'
							]
						);
					}
				}

				var gradient_effect_class ='';

				if (settings.hover_effect_type === 'linear gradient'){

					gradient_effect_class =  'premium-bullet-list-gradient-effect';

				}
			#>
			<li {{{ view.getRenderAttributeString( listContentKey ) }}}>

				<div class="premium-bullet-list-text">
					<# if ( 'yes' === item.show_icon ) {
						var wrapper_top_class;

						if( 'column' === settings.icon_postion ) {
							wrapper_top_class = 'premium-bullet-list-wrapper-top';
						}
					#>
					<div class="premium-bullet-list-wrapper {{wrapper_top_class}}">
						<# if ('yes' === settings.show_connector && 'column' === settings.layout_type && 'column' !== settings.icon_postion && 'grow' !== settings.hover_effect_type && 'visible' === settings.list_overflow) { #>
							<div class="premium-bullet-list-connector">
								<div class="premium-icon-connector-content"></div>
							</div>
						<# }

						if ( 'icon' == item.icon_type ) {

						var iconHTML = elementor.helpers.renderIcon( view, item.premium_icon_list_font_updated, {
							'aria-hidden': true
							}, 'i' , 'object' );

						#>
							{{{ iconHTML.value }}}
						<#
						} else if ( 'image' === item.icon_type ) {
							if ( item.custom_image.url ) {

								var image = {
									id: item.custom_image.id,
									url: item.custom_image.url,
									size: item.thumbnail_size,
									dimension: item.thumbnail_custom_dimension,
									model: view.getEditModel()
								};

								var image_url = elementor.imagesManager.getImageUrl( image );
						#>
							<img src="{{ image_url }}"/>
						<#
							}
						} else if ( 'text' === item.icon_type) { #>
							<div class="premium-bullet-list-icon-text">
								<p {{{ view.getRenderAttributeString( textIcon ) }}}>{{{item.list_text_icon}}}</p>
							</div>
						<# } else { #>
							<div {{{ view.getRenderAttributeString( lottieKey ) }}}></div>
						<# } #>
					</div>
				<# } #>

				<span class="{{{ gradient_effect_class }}}" data-text="{{{ item.list_title }}}" >{{{ item.list_title }}}</span>
				</div>

				<# if ( 'yes' === item.show_badge ){ #>
				<div class="premium-bullet-list-badge">
					<span  {{{ view.getRenderAttributeString( textBadge ) }}} >{{{ item.badge_title }}}</span>
				</div>
				<# } #>

				<# if ( 'yes' === item.show_list_link ) {
					linkType=item.link_select;

					url = 'url' === linkType ? item.link.url : item.existing_page;
				#>
					<a class="premium-bullet-list-link" {{{ view.getRenderAttributeString( itemLink ) }}} ></a>
				<# } #>
			</li>
			<#
			if( 'yes' === settings.show_divider ) {
				var dividerClass ='premium-bullet-list-divider';
				if( 'row' === settings.layout_type ) {
					dividerClass += '-inline';
				}
			#>
			<div class=" {{dividerClass}}"></div>
			<# }
			});
			#>
		</ul>

		<?php
	}

}

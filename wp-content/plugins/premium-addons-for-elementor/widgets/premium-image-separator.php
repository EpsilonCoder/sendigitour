<?php
/**
 * Premium Image Separator.
 */

namespace PremiumAddons\Widgets;

// Elementor Classes.
use Elementor\Modules\DynamicTags\Module as TagsModule;
use Elementor\Widget_Base;
use Elementor\Utils;
use Elementor\Control_Media;
use Elementor\Controls_Manager;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Icons_Manager;
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Text_Shadow;

// PremiumAddons Classes.
use PremiumAddons\Includes\Helper_Functions;
use PremiumAddons\Includes\Premium_Template_Tags;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // If this file is called directly, abort.
}

/**
 * Class Premium_Image_Separator
 */
class Premium_Image_Separator extends Widget_Base {

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
		return 'premium-addon-image-separator';
	}

	/**
	 * Retrieve Widget Title.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function get_title() {
		return sprintf( '%1$s %2$s', Helper_Functions::get_prefix(), __( 'Image Separator', 'premium-addons-for-elementor' ) );
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
		return 'pa-image-separator';
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
		return array( 'divider', 'section', 'shape' );
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
	 * Register Image Controls controls.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_controls() { // phpcs:ignore PSR2.Methods.MethodDeclaration.Underscore

		$this->start_controls_section(
			'premium_image_separator_general_settings',
			array(
				'label' => __( 'Image Settings', 'premium-addons-for-elementor' ),
			)
		);

		$this->add_control(
			'separator_type',
			array(
				'label'   => __( 'Separator Type', 'premium-addons-for-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'icon'      => __( 'Icon', 'premium-addons-for-elementor' ),
					'image'     => __( 'Image', 'premium-addons-for-elementor' ),
					'animation' => __( 'Lottie Animation', 'premium-addons-for-elementor' ),
				),
				'default' => 'image',
			)
		);

		$this->add_control(
			'separator_icon',
			array(
				'label'     => __( 'Select an Icon', 'premium-addons-for-elementor' ),
				'type'      => Controls_Manager::ICONS,
				'default'   => array(
					'value'   => 'fas fa-grip-lines',
					'library' => 'fa-solid',
				),
				'condition' => array(
					'separator_type' => 'icon',
				),
			)
		);

		$this->add_control(
			'premium_image_separator_image',
			array(
				'label'       => __( 'Image', 'premium-addons-for-elementor' ),
				'description' => __( 'Choose the separator image', 'premium-addons-for-elementor' ),
				'type'        => Controls_Manager::MEDIA,
				'dynamic'     => array( 'active' => true ),
				'default'     => array(
					'url' => Utils::get_placeholder_image_src(),
				),
				'label_block' => true,
				'condition'   => array(
					'separator_type' => 'image',
				),
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
					'separator_type' => 'animation',
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
					'separator_type' => 'animation',
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
					'separator_type' => 'animation',
				),
			)
		);

		$this->add_control(
			'lottie_hover',
			array(
				'label'        => __( 'Only Play on Hover', 'premium-addons-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'true',
				'condition'    => array(
					'separator_type' => 'animation',
				),
			)
		);

		$this->add_responsive_control(
			'premium_image_separator_image_size',
			array(
				'label'      => __( 'Width/Size', 'premium-addons-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em', '%' ),
				'default'    => array(
					'unit' => 'px',
					'size' => 200,
				),
				'range'      => array(
					'px' => array(
						'min' => 1,
						'max' => 800,
					),
					'em' => array(
						'min' => 1,
						'max' => 30,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .premium-image-separator-container img'    => 'width: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .premium-image-separator-container i'      => 'font-size: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .premium-image-separator-container svg'    => 'width: {{SIZE}}{{UNIT}} !important;',
				),
			)
		);

		$this->add_responsive_control(
			'premium_image_separator_image_height',
			array(
				'label'      => __( 'Height', 'premium-addons-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em' ),
				'range'      => array(
					'px' => array(
						'min' => 1,
						'max' => 500,
					),
					'em' => array(
						'min' => 1,
						'max' => 30,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .premium-image-separator-container img'    => 'height: {{SIZE}}{{UNIT}} !important',
				),
				'condition'  => array(
					'separator_type' => 'image',
				),
			)
		);

		$this->add_responsive_control(
			'image_fit',
			array(
				'label'     => __( 'Image Fit', 'premium-addons-for-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => array(
					'cover'   => __( 'Cover', 'premium-addons-for-elementor' ),
					'fill'    => __( 'Fill', 'premium-addons-for-elementor' ),
					'contain' => __( 'Contain', 'premium-addons-for-elementor' ),
				),
				'default'   => 'fill',
				'selectors' => array(
					'{{WRAPPER}} .premium-image-separator-container img' => 'object-fit: {{VALUE}}',
				),
				'condition' => array(
					'separator_type' => 'image',
				),
			)
		);

		$this->add_responsive_control(
			'premium_image_separator_image_gutter',
			array(
				'label'       => __( 'Gutter (%)', 'premium-addons-for-elementor' ),
				'type'        => Controls_Manager::NUMBER,
				'default'     => -50,
				'description' => __( '-50% is default. Increase to push the image outside or decrease to pull the image inside.', 'premium-addons-for-elementor' ),
				'selectors'   => array(
					'{{WRAPPER}} .premium-image-separator-container' => 'transform: translateY( {{VALUE}}% );',
				),
			)
		);

		$this->add_control(
			'premium_image_separator_image_align',
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
				'default'   => 'center',
				'toggle'    => false,
				'selectors' => array(
					'{{WRAPPER}} .premium-image-separator-container'   => 'text-align: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'premium_image_separator_link_switcher',
			array(
				'label'       => __( 'Link', 'premium-addons-for-elementor' ),
				'type'        => Controls_Manager::SWITCHER,
				'description' => __( 'Add a custom link or select an existing page link', 'premium-addons-for-elementor' ),
			)
		);

		$this->add_control(
			'premium_image_separator_link_type',
			array(
				'label'       => __( 'Link/URL', 'premium-addons-for-elementor' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'url'  => __( 'URL', 'premium-addons-for-elementor' ),
					'link' => __( 'Existing Page', 'premium-addons-for-elementor' ),
				),
				'default'     => 'url',
				'label_block' => true,
				'condition'   => array(
					'premium_image_separator_link_switcher'  => 'yes',
				),
			)
		);

		$this->add_control(
			'premium_image_separator_existing_page',
			array(
				'label'       => __( 'Existing Page', 'premium-addons-for-elementor' ),
				'type'        => Controls_Manager::SELECT2,
				'options'     => $this->getTemplateInstance()->get_all_posts(),
				'multiple'    => false,
				'label_block' => true,
				'condition'   => array(
					'premium_image_separator_link_switcher' => 'yes',
					'premium_image_separator_link_type' => 'link',
				),
			)
		);

		$this->add_control(
			'premium_image_separator_image_link',
			array(
				'label'       => __( 'URL', 'premium-addons-for-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => array(
					'active'     => true,
					'categories' => array(
						TagsModule::POST_META_CATEGORY,
						TagsModule::URL_CATEGORY,
					),
				),
				'label_block' => true,
				'condition'   => array(
					'premium_image_separator_link_switcher' => 'yes',
					'premium_image_separator_link_type' => 'url',
				),
			)
		);

		$this->add_control(
			'premium_image_separator_image_link_text',
			array(
				'label'       => __( 'Link Title', 'premium-addons-for-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'condition'   => array(
					'premium_image_separator_link_switcher' => 'yes',
				),
			)
		);

		$this->add_control(
			'link_new_tab',
			array(
				'label'     => __( 'Open Link in New Tab', 'premium-addons-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes',
				'condition' => array(
					'premium_image_separator_link_switcher' => 'yes',
				),
			)
		);

		$this->add_control(
			'mask_switcher',
			array(
				'label'     => __( 'Mask Image Shape', 'premium-addons-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'condition' => array(
					'separator_type!' => 'icon',
				),
			)
		);

		$this->add_control(
			'mask_image',
			array(
				'label'       => __( 'Mask Image', 'premium-addons-for-elementor' ),
				'type'        => Controls_Manager::MEDIA,
				'description' => __( 'Use PNG image with the shape you want to mask around feature image.', 'premium-addons-for-elementor' ),
				'selectors'   => array(
					'{{WRAPPER}} .premium-image-separator-container img, {{WRAPPER}} .premium-image-separator-container svg' => 'mask-image: url("{{URL}}"); -webkit-mask-image: url("{{URL}}");',
				),
				'condition'   => array(
					'separator_type!' => 'icon',
					'mask_switcher'   => 'yes',
				),
			)
		);

		$this->add_control(
			'mask_size',
			array(
				'label'     => __( 'Mask Size', 'premium-addons-for-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => array(
					'contain' => __( 'Contain', 'premium-addons-for-elementor' ),
					'cover'   => __( 'Cover', 'premium-addons-for-elementor' ),
				),
				'default'   => 'contain',
				'selectors' => array(
					'{{WRAPPER}} .premium-image-separator-container img, .premium-image-separator-container svg' => 'mask-size: {{VALUE}}; -webkit-mask-size: {{VALUE}}',
				),
				'condition' => array(
					'separator_type!' => 'icon',
					'mask_switcher'   => 'yes',
				),
			)
		);

		$this->add_control(
			'mask_position_cover',
			array(
				'label'     => __( 'Mask Position', 'premium-addons-for-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => array(
					'center center' => __( 'Center Center', 'premium-addons-for-elementor' ),
					'center left'   => __( 'Center Left', 'premium-addons-for-elementor' ),
					'center right'  => __( 'Center Right', 'premium-addons-for-elementor' ),
					'top center'    => __( 'Top Center', 'premium-addons-for-elementor' ),
					'top left'      => __( 'Top Left', 'premium-addons-for-elementor' ),
					'top right'     => __( 'Top Right', 'premium-addons-for-elementor' ),
					'bottom center' => __( 'Bottom Center', 'premium-addons-for-elementor' ),
					'bottom left'   => __( 'Bottom Left', 'premium-addons-for-elementor' ),
					'bottom right'  => __( 'Bottom Right', 'premium-addons-for-elementor' ),
				),
				'default'   => 'center center',
				'selectors' => array(
					'{{WRAPPER}} .premium-image-separator-container img, .premium-image-separator-container svg' => 'mask-position: {{VALUE}}; -webkit-mask-position: {{VALUE}}',
				),
				'condition' => array(
					'separator_type!' => 'icon',
					'mask_switcher'   => 'yes',
					'mask_size'       => 'cover',
				),
			)
		);

		$this->add_control(
			'mask_position_contain',
			array(
				'label'     => __( 'Mask Position', 'premium-addons-for-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => array(
					'center center' => __( 'Center Center', 'premium-addons-for-elementor' ),
					'top center'    => __( 'Top Center', 'premium-addons-for-elementor' ),
					'bottom center' => __( 'Bottom Center', 'premium-addons-for-elementor' ),
				),
				'default'   => 'center center',
				'selectors' => array(
					'{{WRAPPER}} .premium-image-separator-container img, .premium-image-separator-container svg' => 'mask-position: {{VALUE}}; -webkit-mask-position: {{VALUE}}',
				),
				'condition' => array(
					'separator_type!' => 'icon',
					'mask_switcher'   => 'yes',
					'mask_size'       => 'contain',
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

		$title = __( 'Getting started »', 'premium-addons-for-elementor' );

		$doc_url = Helper_Functions::get_campaign_link( 'https://premiumaddons.com/docs/image-separator-widget-tutorial/', 'editor-page', 'wp-editor', 'get-support' );

		$this->add_control(
			'doc_1',
			array(
				'type'            => Controls_Manager::RAW_HTML,
				'raw'             => sprintf( '<a href="%s" target="_blank">%s</a>', $doc_url, $title ),
				'content_classes' => 'editor-pa-doc',
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'premium_image_separator_style',
			array(
				'label' => __( 'Separator', 'premium-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			array(
				'name'      => 'css_filters',
				'selector'  => '{{WRAPPER}} .premium-image-separator-container',
				'condition' => array(
					'separator_type!' => 'icon',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			array(
				'name'      => 'hover_css_filters',
				'label'     => __( 'Hover CSS Filters', 'premium-addons-for-elementor' ),
				'selector'  => '{{WRAPPER}} .premium-image-separator-container:hover',
				'condition' => array(
					'separator_type!' => 'icon',
				),
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
					'{{WRAPPER}} .premium-image-separator-container i' => 'color: {{VALUE}}',
					'{{WRAPPER}} .premium-image-separator-container > svg' => 'fill: {{VALUE}}; color: {{VALUE}}',
				),
				'condition' => array(
					'separator_type' => 'icon',
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
					'{{WRAPPER}} .premium-image-separator-container i:hover' => 'color: {{VALUE}}',
					'{{WRAPPER}} .premium-image-separator-container > svg:hover' => 'fill: {{VALUE}}; color: {{VALUE}}',
				),
				'condition' => array(
					'separator_type' => 'icon',
				),
			)
		);

		$this->add_control(
			'icon_background_color',
			array(
				'label'     => __( 'Background Color', 'premium-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => array(
					'default' => Global_Colors::COLOR_SECONDARY,
				),
				'selectors' => array(
					'{{WRAPPER}} .premium-image-separator-container i, {{WRAPPER}} .premium-image-separator-container > svg' => 'background-color: {{VALUE}}',
				),
				'condition' => array(
					'separator_type' => 'icon',
				),
			)
		);

		$this->add_control(
			'icon_hover_background_color',
			array(
				'label'     => __( 'Hover Background Color', 'premium-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => array(
					'default' => Global_Colors::COLOR_SECONDARY,
				),
				'selectors' => array(
					'{{WRAPPER}} .premium-image-separator-container i:hover, {{WRAPPER}} .premium-image-separator-container > svg:hover' => 'background-color: {{VALUE}}',
				),
				'condition' => array(
					'separator_type' => 'icon',
				),
			)
		);

		$this->add_responsive_control(
			'separator_border_radius',
			array(
				'label'      => __( 'Border Radius', 'premium-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .premium-image-separator-container i, {{WRAPPER}} .premium-image-separator-container img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
				'condition'  => array(
					'separator_adv_radius!' => 'yes',
					'separator_type!'       => 'animation',
				),
			)
		);

		$this->add_control(
			'separator_adv_radius',
			array(
				'label'       => __( 'Advanced Border Radius', 'premium-addons-for-elementor' ),
				'type'        => Controls_Manager::SWITCHER,
				'description' => __( 'Apply custom radius values. Get the radius value from ', 'premium-addons-for-elementor' ) . '<a href="https://9elements.github.io/fancy-border-radius/" target="_blank">here</a>',
				'condition'   => array(
					'separator_type!' => 'animation',
				),
			)
		);

		$this->add_control(
			'separator_adv_radius_value',
			array(
				'label'     => __( 'Border Radius', 'premium-addons-for-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'dynamic'   => array( 'active' => true ),
				'selectors' => array(
					'{{WRAPPER}} .premium-image-separator-container i, {{WRAPPER}} .premium-image-separator-container img' => 'border-radius: {{VALUE}};',
				),
				'condition' => array(
					'separator_adv_radius' => 'yes',
					'separator_type!'      => 'animation',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			array(
				'name'      => 'separator_shadow',
				'label'     => __( 'Icon Shadow', 'premium-addons-for-elementor' ),
				'selector'  => '{{WRAPPER}} .premium-image-separator-container i',
				'condition' => array(
					'separator_type' => 'icon',
				),
			)
		);

		$this->add_responsive_control(
			'icon_padding',
			array(
				'label'      => __( 'Padding', 'premium-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .premium-image-separator-container i, {{WRAPPER}} .premium-image-separator-container svg' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
				'condition'  => array(
					'separator_type' => 'icon',
				),
			)
		);

		$this->end_controls_section();

	}

	/**
	 * Render Image Separator widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {

		$settings = $this->get_settings_for_display();

		$type = $settings['separator_type'];

		if ( 'yes' === $settings['premium_image_separator_link_switcher'] ) {
			$link_type = $settings['premium_image_separator_link_type'];

			if ( 'url' === $link_type ) {
				$url = $settings['premium_image_separator_image_link'];
			} else {
				$url = get_permalink( $settings['premium_image_separator_existing_page'] );
			}

			$this->add_render_attribute(
				'link',
				array(
					'class' => 'premium-image-separator-link',
					'href'  => $url,
				)
			);

			if ( 'yes' === $settings['link_new_tab'] ) {
				$this->add_render_attribute( 'link', 'target', '_blank' );
			}

			if ( ! empty( $settings['premium_image_separator_image_link_text'] ) ) {
				$this->add_render_attribute( 'link', 'title', $settings['premium_image_separator_image_link_text'] );
			}
		}

		if ( 'image' === $type ) {
			$alt = esc_attr( Control_Media::get_image_alt( $settings['premium_image_separator_image'] ) );
		} elseif ( 'animation' === $type ) {
			$this->add_render_attribute(
				'separator_lottie',
				array(
					'class'               => 'premium-lottie-animation',
					'data-lottie-url'     => $settings['lottie_url'],
					'data-lottie-loop'    => $settings['lottie_loop'],
					'data-lottie-reverse' => $settings['lottie_reverse'],
					'data-lottie-hover'   => $settings['lottie_hover'],
				)
			);
		}
		?>

	<div class="premium-image-separator-container">
		<?php if ( 'image' === $type ) : ?>
			<img src="<?php echo esc_attr( $settings['premium_image_separator_image']['url'] ); ?>" alt="<?php echo esc_attr( $alt ); ?>">
			<?php
		elseif ( 'icon' === $type ) :
			Icons_Manager::render_icon( $settings['separator_icon'], array( 'aria-hidden' => 'true' ) );
		else :
			?>
			<div <?php echo wp_kses_post( $this->get_render_attribute_string( 'separator_lottie' ) ); ?>></div>
		<?php endif; ?>
		<?php if ( 'yes' === $settings['premium_image_separator_link_switcher'] && ! empty( $url ) ) : ?>
			<a <?php echo wp_kses_post( $this->get_render_attribute_string( 'link' ) ); ?>></a>
		<?php endif; ?>
	</div>
		<?php
	}

	/**
	 * Render Image Separtor widget output in the editor.
	 *
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function content_template() {
		?>
		<#
			var type        = settings.separator_type,
				linkSwitch  = settings.premium_image_separator_link_switcher;

			if( 'image' === type ) {
				var imgUrl = settings.premium_image_separator_image.url;
			} else if ( 'icon' === type ) {
				var iconHTML = elementor.helpers.renderIcon( view, settings.separator_icon, { 'aria-hidden': true }, 'i' , 'object' );
			} else {

				view.addRenderAttribute( 'separator_lottie', {
					'class': 'premium-lottie-animation',
					'data-lottie-url': settings.lottie_url,
					'data-lottie-loop': settings.lottie_loop,
					'data-lottie-reverse': settings.lottie_reverse,
					'data-lottie-hover': settings.lottie_hover
				});

			}

			if( 'yes' === linkSwitch ) {
				var linkType = settings.premium_image_separator_link_type,
					linkTitle = settings.premium_image_separator_image_link_text,
					linkUrl = ( 'url' == linkType ) ? settings.premium_image_separator_image_link : settings.premium_image_separator_existing_page;

				view.addRenderAttribute( 'link', 'class', 'premium-image-separator-link' );
				view.addRenderAttribute( 'link', 'href', linkUrl );

				if( '' !== linkTitle ) {
					view.addRenderAttribute( 'link', 'title', linkTitle );
				}

			}

		#>

		<div class="premium-image-separator-container">
			<# if( 'image' === type ) { #>
				<img alt="image separator" src="{{ imgUrl }}">
			<# } else if( 'icon' === type ) { #>
				{{{ iconHTML.value }}}
			<# } else { #>
				<div {{{ view.getRenderAttributeString('separator_lottie') }}}></div>
			<# } #>
			<# if( 'yes' === linkSwitch ) { #>
				<a {{{ view.getRenderAttributeString( 'link' ) }}}></a>
			<# } #>
		</div>

		<?php
	}
}

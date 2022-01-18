<?php
/**
 * PA WooCommerce Skin Grid - Default.
 *
 * @package PA
 */

namespace PremiumAddons\Modules\Woocommerce\Skins;

use Elementor\Controls_Manager;
use Elementor\Skin_Base as Elementor_Skin_Base;
use Elementor\Widget_Base;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Text_Shadow;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // If this file is called directly, abort.
}

/**
 * Class Skin_Grid_Base
 *
 * @property Products $parent
 */
abstract class Skin_Base extends Elementor_Skin_Base {

	/**
	 * Register control actions.
	 *
	 * @since 4.7.0
	 * @access protected
	 */
	protected function _register_controls_actions() {

		// Product Rating Style
		add_action( 'elementor/element/premium-woo-products/section_image_style/after_section_end', array( $this, 'register_product_rating_style' ) );

		// Product Price Style
		add_action( 'elementor/element/premium-woo-products/section_image_style/after_section_end', array( $this, 'register_product_price_style' ) );

		add_action( 'elementor/element/premium-woo-products/section_image_style/after_section_end', array( $this, 'register_quick_view_modal_style_controls' ), 20 );

	}

	/**
	 * Register Quick View Style Controls.
	 *
	 * @since 4.7.0
	 * @param Widget_Base $widget widget object.
	 * @access public
	 */
	public function register_quick_view_modal_style_controls() {

		$this->start_controls_section(
			'quick_view_modal_style',
			array(
				'label' => __( 'Quick View Modal', 'premium-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'lightbox_overlay_color',
			array(
				'label'     => __( 'Overlay Color', 'premium-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.premium-woo-quick-view-{{ID}} .premium-woo-quick-view-back' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'lightbox_bg_color',
			array(
				'label'     => __( 'Background Color', 'premium-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.premium-woo-quick-view-{{ID}} #premium-woo-quick-view-modal .premium-woo-lightbox-content' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'lightbox_padding',
			array(
				'label'      => __( 'Padding', 'premium-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'.premium-woo-quick-view-{{ID}} .premium-woo-lightbox-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'lightbox_border',
				'selector' => '.premium-woo-quick-view-{{ID}} .premium-woo-lightbox-content',
			)
		);

		$this->add_control(
			'lightbox_border_radius',
			array(
				'label'      => __( 'Border Radius', 'premium-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'.premium-woo-quick-view-{{ID}} .premium-woo-lightbox-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'close_icon_color',
			array(
				'label'     => __( 'Close Icon Color', 'premium-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'separator' => 'before',
				'selectors' => array(
					'.premium-woo-quick-view-{{ID}} #premium-woo-quick-view-close' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'close_icon_size',
			array(
				'label'     => __( 'Close Icon Size', 'premium-addons-for-elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'min' => 10,
						'max' => 50,
					),
				),
				'selectors' => array(
					'.premium-woo-quick-view-{{ID}} #premium-woo-quick-view-close' => 'font-size: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();
	}

	public function register_product_price_style() {

		$this->start_controls_section(
			'section_price_style',
			array(
				'label' => __( 'Price', 'premium-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			array(
				'name'     => 'price_text_shadow',
				'selector' => '{{WRAPPER}} .premium-woocommerce li.product .price',
			)
		);

		$this->add_responsive_control(
			'price_spacing',
			array(
				'label'      => __( 'Margin', 'premium-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .premium-woocommerce li.product .price' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->start_controls_tabs(
			'price_style_tabs'
		);

		$this->start_controls_tab(
			'price_tab',
			array(
				'label' => __( 'Price', 'premium-addons-for-elementor' ),
			)
		);

		$this->add_control(
			'price_color',
			array(
				'label'     => __( 'Price Color', 'premium-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => array(
					'default' => Global_Colors::COLOR_TEXT,
				),
				'selectors' => array(
					'{{WRAPPER}} .premium-woocommerce li.product .price' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'price_typography',
				'global'   => array(
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				),
				'selector' => '{{WRAPPER}} .premium-woocommerce li.product .price',
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'slashed_price_tab',
			array(
				'label' => __( 'Slashed', 'premium-addons-for-elementor' ),
			)
		);

		$this->add_control(
			'slashed_price_color',
			array(
				'label'     => __( 'Slashed Price Color', 'premium-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => array(
					'default' => Global_Colors::COLOR_TEXT,
				),
				'selectors' => array(
					'{{WRAPPER}} .premium-woocommerce li.product .price del' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'slashed_price_typography',
				'global'   => array(
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				),
				'selector' => '{{WRAPPER}} .premium-woocommerce li.product .price del',
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

	}

	public function register_product_rating_style() {

		$this->start_controls_section(
			'section_rating_style',
			array(
				'label' => __( 'Rating', 'premium-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'star_color',
			array(
				'label'     => __( 'Star Color', 'elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .premium-woocommerce li.product div.star-rating' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'empty_star_color',
			array(
				'label'     => __( 'Empty Star Color', 'elementor-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .premium-woocommerce li.product div.star-rating::before' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'star_size',
			array(
				'label'     => __( 'Star Size', 'elementor-pro' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => array(
					'unit' => 'em',
				),
				'range'     => array(
					'em' => array(
						'min'  => 0,
						'max'  => 4,
						'step' => 0.1,
					),
				),
				'selectors' => array(
					'{{WRAPPER}} .premium-woocommerce li.product .star-rating' => 'font-size: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_responsive_control(
			'rating_spacing',
			array(
				'label'      => __( 'Bottom Spacing', 'elementor-pro' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em' ),
				'range'      => array(
					'em' => array(
						'min'  => 0,
						'max'  => 5,
						'step' => 0.1,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}}  .premium-woocommerce li.product .star-rating' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->end_controls_section();

	}

}

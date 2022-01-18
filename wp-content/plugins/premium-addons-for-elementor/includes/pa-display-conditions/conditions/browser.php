<?php
/**
 * Browser Condition Handler.
 */

namespace PremiumAddons\Includes\PA_Display_Conditions\Conditions;

// Elementor Classes.
use Elementor\Controls_Manager;

// PA Classes.
use PremiumAddons\Includes\Helper_Functions;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Class Browser
 */
class Browser extends Condition {

	/**
	 * Get Controls Options.
	 *
	 * @access public
	 * @since 4.7.0
	 *
	 * @return array|void  controls options
	 */
	public function get_control_options() {

		return array(
			'label'       => __( 'Value', 'premium-addons-for-elementor' ),
			'type'        => Controls_Manager::SELECT2,
			'default'     => 'chrome',
			'label_block' => true,
			'options'     => array(
				'opera'   => __( 'Opera', 'premium-addons-for-elementor' ),
				'edge'    => __( 'Microsoft Edge', 'premium-addons-for-elementor' ),
				'chrome'  => __( 'Google Chrome', 'premium-addons-for-elementor' ),
				'safari'  => __( 'Safari', 'premium-addons-for-elementor' ),
				'firefox' => __( 'Mozilla Firefox', 'premium-addons-for-elementor' ),
				'ie'      => __( 'Internet Explorer', 'premium-addons-for-elementor' ),
			),
			'multiple'    => true,
			'condition'   => array(
				'pa_condition_key' => 'browser',
			),
		);
	}

	/**
	 * Compare Condition Value.
	 *
	 * @access public
	 * @since 4.7.0
	 *
	 * @param array       $settings      element settings.
	 * @param string      $operator      condition operator.
	 * @param string      $value         condition value.
	 * @param string      $compare_val   compare value.
	 * @param string|bool $tz        time zone.
	 *
	 * @return bool|void
	 */
	public function compare_value( $settings, $operator, $value, $compare_val, $tz ) {

		$user_agent = isset( $_SERVER['HTTP_USER_AGENT'] ) ? filter_var( wp_unslash( $_SERVER['HTTP_USER_AGENT'] ), FILTER_SANITIZE_STRING ) : '';

		$user_agent = Helper_Functions::get_browser_name( $user_agent );

		$condition_result = is_array( $value ) && ! empty( $value ) ? in_array( $user_agent, $value, true ) : $value === $user_agent;

		return Helper_Functions::get_final_result( $condition_result, $operator );

	}

}

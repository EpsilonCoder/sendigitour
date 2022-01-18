<?php
/*
Plugin Name: Premium Addons for Elementor
Description: Premium Addons for Elementor plugin includes widgets and addons like Blog Post Grid, Gallery, WooCommerce Listing , Carousel, Modal Popup, Google Maps, Pricing Tables, Lottie Animations, Countdown, Testimonials.
Plugin URI: https://premiumaddons.com
Version: 4.8.3
Elementor tested up to: 3.5.3
Elementor Pro tested up to: 3.5.2
Author: Leap13
Author URI: https://leap13.com/
Text Domain: premium-addons-for-elementor
Domain Path: /languages
License: GNU General Public License v3.0
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit; // No access of directly access.
}

// Define Constants.
define( 'PREMIUM_ADDONS_VERSION', '4.8.3' );
define( 'PREMIUM_ADDONS_URL', plugins_url( '/', __FILE__ ) );
define( 'PREMIUM_ADDONS_PATH', plugin_dir_path( __FILE__ ) );
define( 'PREMIUM_ADDONS_FILE', __FILE__ );
define( 'PREMIUM_ADDONS_BASENAME', plugin_basename( PREMIUM_ADDONS_FILE ) );
define( 'PREMIUM_ADDONS_STABLE_VERSION', '4.8.2' );

/*
 * Load plugin core file
 */
require_once PREMIUM_ADDONS_PATH . 'includes/class-pa-core.php';

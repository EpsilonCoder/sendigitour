<?php
/**
 * Chic Lite functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Chic_Lite
 */

//define theme version
$chic_lite_theme_data = wp_get_theme();
if( ! defined( 'CHIC_LITE_THEME_VERSION' ) ) define( 'CHIC_LITE_THEME_VERSION', $chic_lite_theme_data->get( 'Version' ) );
if( ! defined( 'CHIC_LITE_THEME_NAME' ) ) define( 'CHIC_LITE_THEME_NAME', $chic_lite_theme_data->get( 'Name' ) );
if( ! defined( 'CHIC_LITE_THEME_TEXTDOMAIN' ) ) define( 'CHIC_LITE_THEME_TEXTDOMAIN', $chic_lite_theme_data->get( 'TextDomain' ) );

/**
 * Custom Functions.
 */
require get_template_directory() . '/inc/custom-functions.php';

/**
 * Standalone Functions.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Template Functions.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Custom functions for selective refresh.
 */
require get_template_directory() . '/inc/partials.php';

/**
 * Fontawesome
 */
require get_template_directory() . '/inc/fontawesome.php';

/**
 * Custom Controls
 */
require get_template_directory() . '/inc/custom-controls/custom-control.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer/customizer.php';

/**
 * Newsletter .
 */
require get_template_directory() . '/inc/newsletter-functions.php';

/**
 * Widgets
 */
require get_template_directory() . '/inc/widgets.php';

/**
 * Metabox
 */
require get_template_directory() . '/inc/metabox.php';

/**
 * Typography Functions
 */
require get_template_directory() . '/inc/typography.php';

/**
 * Dynamic Styles
 */
require get_template_directory() . '/css/style.php';

/**
 * Plugin Recommendation
*/
require get_template_directory() . '/inc/tgmpa/recommended-plugins.php';

/**
 * Getting Started
*/
require get_template_directory() . '/inc/getting-started/getting-started.php';

/**
 * Add theme compatibility function for woocommerce if active
*/
if( chic_lite_is_woocommerce_activated() ){
    require get_template_directory() . '/inc/woocommerce-functions.php';    
}

/**
 * Toolkit Filters
*/
if( chic_lite_is_rara_theme_companion_activated() )
require get_template_directory() . '/inc/toolkit-functions.php';

/**
 * Add theme compatibility function for Delicious Recipes if active
*/
if( chic_lite_is_delicious_recipe_activated() ){
    require get_template_directory() . '/inc/recipe-functions.php';    
}
<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

// BEGIN ENQUEUE PARENT ACTION
// AUTO GENERATED - Do not modify or remove comment markers above or below:

//Load text domain for translation-ready
load_theme_textdomain('blush', get_stylesheet_directory() . '/languages');

if ( !function_exists( 'blush_chld_thm_cfg_parent_css' ) ):
    function blush_chld_thm_cfg_parent_css() {
		wp_enqueue_style( 'blush-parent-style', get_template_directory_uri() . '/style.css' );
		wp_enqueue_style('blush-child-style',get_stylesheet_directory_uri() . '/style.css',array('parent-style'));
		wp_enqueue_style('default-style-css', get_stylesheet_directory_uri()."/css/blush-default.css" );
	}
endif; 
add_action( 'wp_enqueue_scripts', 'blush_chld_thm_cfg_parent_css', 999 );

// END ENQUEUE PARENT ACTION 

function my_customize_register() {     
	global $wp_customize;
	//$wp_customize->remove_section( 'aneeq_general_settings' );  //Modify this line as needed 
	//$wp_customize->remove_section( 'upgrade_aneeq_premium' );  //Modify this line as needed 
	$wp_customize->remove_control( 'aneeq_skin_theme_color' );  //Modify this line as needed 
} 
add_action( 'customize_register', 'my_customize_register', 11 );

?>

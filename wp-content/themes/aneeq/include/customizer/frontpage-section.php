<?php
/**
 * Front Page Options.
 *
 * @package Aneeq
 */

$aneeq_default = aneeq_get_default_theme_options();

// Add Panel.
$wp_customize->add_panel( 'front_page_panel', array(
	'title'      => __( 'Frontpage Sections', 'aneeq' ),
	'priority'   => 100,
	'capability' => 'edit_theme_options',
	)
);

/**
* Section Customizer Options.
*/
require get_template_directory() . '/include/customizer/frontpage-sections/slider.php';
require get_template_directory() . '/include/customizer/frontpage-sections/service.php';
require get_template_directory() . '/include/customizer/frontpage-sections/blog.php';
require get_template_directory() . '/include/customizer/frontpage-sections/testimonial.php';
require get_template_directory() . '/include/customizer/frontpage-sections/wooproduct.php';
<?php
/**
 * Default theme options.
 *
 * @package Aneeq
 */

if ( ! function_exists( 'aneeq_get_default_theme_options' ) ) :

	/**
	 * Get default theme options.
	 *
	 * @since 1.0.0
	 *
	 * @return array Default theme options.
	 */
function aneeq_get_default_theme_options() {

	$aneeq_defaults = array();

    // Homepage Options
	$aneeq_defaults['enable_frontpage_content'] 		= true;

	// Featured Slider Section
	$aneeq_defaults['enable_aneeq_slider_section']		= false;
	$aneeq_defaults['aneeq_number_of_slider_items']		= 3;
	$aneeq_defaults['aneeq_slider_content_type']		= 'slider_page';
	//$aneeq_defaults['slider_button']					= esc_html__( 'Read More', 'aneeq' );

	// Our Services Section
	$aneeq_defaults['enable_aneeq_services_section']	= false;
	$aneeq_defaults['aneeq_services_sec_title']			= esc_html__( 'Services We Offer', 'aneeq' );
	$aneeq_defaults['aneeq_number_of_items']			= 3;
	$aneeq_defaults['aneeq_services_content_type']		= 'services_page';

	// Blog Section
	$aneeq_defaults['enable_blog_section']				= false;
	$aneeq_defaults['aneeq_blog_section_title']			= esc_html__( 'Latest News', 'aneeq' );
	$aneeq_defaults['aneeq_blog_category']	   			= 0; 
	$aneeq_defaults['aneeq_blog_number']				= 3;
	$aneeq_defaults['aneeq_blog_column_layout']			= 'col-md-4';
	

	// Woo Section
	$aneeq_defaults['enable_woo_section']				= false;
	$aneeq_defaults['aneeq_woo_section_title']			= esc_html__( 'Featured Products', 'aneeq' );
	
	
	//Call To Action Section	
	$aneeq_defaults['enable_aneeq_testimonial_section']	   	= false;
	$aneeq_defaults['aneeq_testimonials_content_type']	  	= 'testimonial_page';
	
	$aneeq_defaults['aneeq_testimonial_sec_title']	  	 	= esc_html__( 'What People Say', 'aneeq' );
	//$aneeq_defaults['aneeq_testimonial_client_name']	  	= esc_html__( 'John Smith', 'aneeq' );
	$aneeq_defaults['aneeq_testimonial_designation']		= esc_html__( 'Marketing Department', 'aneeq' );
	$aneeq_defaults['aneeq_testimonial_link']	 		    = '#';

	// Pass through filter.
	$aneeq_defaults = apply_filters( 'aneeq_filter_default_theme_options', $aneeq_defaults );
	return $aneeq_defaults;
}

endif;

/**
*  Get theme options
*/
if ( ! function_exists( 'aneeq_get_option' ) ) :

	/**
	 * Get theme option
	 *
	 * @since 1.0.0
	 *
	 * @param string $key Option key.
	 * @return mixed Option value.
	 */
	function aneeq_get_option( $key ) {

		$aneeq_default_options = aneeq_get_default_theme_options();
		if ( empty( $key ) ) {
			return;
		}

		$aneeq_theme_options = (array)get_theme_mod( 'theme_options' );
		$aneeq_theme_options = wp_parse_args( $aneeq_theme_options, $aneeq_default_options );

		$value = null;

		if ( isset( $aneeq_theme_options[ $key ] ) ) {
			$value = $aneeq_theme_options[ $key ];
		}

		return $value;

	}

endif;
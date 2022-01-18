<?php 
	// Service Title
	function aneeq_register_servicetitle_text_partials( $wp_customize ){
		$wp_customize->selective_refresh->add_partial( 'theme_options[aneeq_services_sec_title]', array(
			'selector'            => '.service-section .section-title',
			'settings'            => 'theme_options[aneeq_services_sec_title]',
			'render_callback' 	  => 'aneeq_services_sec_title_render_callback',
		) );
	}
	add_action( 'customize_register', 'aneeq_register_servicetitle_text_partials' );
		
	function aneeq_services_sec_title_render_callback() {
		return get_theme_mod( 'theme_options[aneeq_services_sec_title]' );
	}
	// Blog Title
	function aneeq_register_blogtitle_text_partials( $wp_customize ){
		$wp_customize->selective_refresh->add_partial( 'theme_options[aneeq_blog_section_title]', array(
			'selector'            => '.blog-section .blog-title',
			'settings'            => 'theme_options[aneeq_blog_section_title]',
			'render_callback' 	  => 'aneeq_blog_sec_title_render_callback',
		) );
	}
	add_action( 'customize_register', 'aneeq_register_blogtitle_text_partials' );
		
	function aneeq_blog_sec_title_render_callback() {
		return get_theme_mod( 'theme_options[aneeq_blog_section_title]' );
	}
	// Testimonial Title
	function aneeq_register_testimonialtitle_text_partials( $wp_customize ){
		$wp_customize->selective_refresh->add_partial( 'theme_options[aneeq_testimonial_sec_title]', array(
			'selector'            => '.testimonial-content .testimonial-titles',
			'settings'            => 'theme_options[aneeq_testimonial_sec_title]',
			'render_callback' 	  => 'aneeq_testimonial_sec_title_render_callback',
		) );
	}
	add_action( 'customize_register', 'aneeq_register_testimonialtitle_text_partials' );
		
	function aneeq_testimonial_sec_title_render_callback() {
		return get_theme_mod( 'theme_options[aneeq_testimonial_sec_title]' );
	}
	
	// Woo Title
	function aneeq_register_wootitle_text_partials( $wp_customize ){
		$wp_customize->selective_refresh->add_partial( 'theme_options[aneeq_woo_section_title]', array(
			'selector'            => '.section-woocommerce .woo-title',
			'settings'            => 'theme_options[aneeq_woo_section_title]',
			'render_callback' 	  => 'aneeq_woo_sec_title_render_callback',
		) );
	}
	add_action( 'customize_register', 'aneeq_register_wootitle_text_partials' );
		
	function aneeq_woo_sec_title_render_callback() {
		return get_theme_mod( 'theme_options[aneeq_woo_section_title]' );
	}
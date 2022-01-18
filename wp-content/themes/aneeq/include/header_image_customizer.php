<?php
//customizer header settings
function aneeq_header_image_customizer( $wp_customize ) {
	$wp_customize->add_section( 'header_image' , array(
			'title'      => __('Custom Header Settings','aneeq'),
			'priority'   => 20,
		) );
		$wp_customize->add_setting(
		'aneeq_header_one_name', array(
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field',
		));
		$wp_customize->add_control('aneeq_header_one_name', array(
			'label'   => __('Header Headline','aneeq'),
			'section' => 'header_image',
			'type'    => 'text',
			'priority'   => 140,
		));
		$wp_customize->add_setting('aneeq_header_one_text'
			, array(
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field',
		));
		$wp_customize->add_control( 'aneeq_header_one_text', array(
			'label'   => __('Header Text','aneeq'),
			'section' => 'header_image',
			'type'    => 'text',
			'priority'   => 140,
		));
}
add_action( 'customize_register', 'aneeq_header_image_customizer' );
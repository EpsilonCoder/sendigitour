<?php
/**
 * Featured Slider options.
 *
 * @package aneeq
 */

$aneeq_default = aneeq_get_default_theme_options();

// Featured Slider Section
$wp_customize->add_section( 'aneeq_section_slider',
	array(
		'title'      => __( 'Slider Section', 'aneeq' ),
		'priority'   => 100,
		'capability' => 'edit_theme_options',
		'panel'      => 'front_page_panel',
		)
);

// 1. Enable Featured Slider Section
$wp_customize->add_setting('theme_options[enable_aneeq_slider_section]', 
	array(
	'default' 			=> $aneeq_default['enable_aneeq_slider_section'],
	'type'              => 'theme_mod',
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'aneeq_checkbox_sanitize'
	)
);

$wp_customize->add_control('theme_options[enable_aneeq_slider_section]', 
	array(		
	'label' 	=> __('Enable Featured Slider Section', 'aneeq'),
	'section' 	=> 'aneeq_section_slider',
	'settings'  => 'theme_options[enable_aneeq_slider_section]',
	'type' 		=> 'checkbox',
	)
);


// 2. Number of items
$wp_customize->add_setting('theme_options[aneeq_number_of_slider_items]', 
	array(
	'default' 			=> $aneeq_default['aneeq_number_of_slider_items'],
	'type'              => 'theme_mod',
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'aneeq_sanitize_number_range'
	)
);

$wp_customize->add_control('theme_options[aneeq_number_of_slider_items]', 
	array(
	'label'       => __('Number Of Slides', 'aneeq'),
	'description' => __('Save & Refresh the customizer to see its effect. Maximum is 3.', 'aneeq'),
	'section'     => 'aneeq_section_slider',   
	'settings'    => 'theme_options[aneeq_number_of_slider_items]',
	'type'        => 'number',
	'active_callback' => 'aneeq_slider_sec_active',
	'input_attrs' => array(
			'min'	=> 1,
			'max'	=> 3,
			'step'	=> 1,
		),
	)
);


// 3. Content Type
$wp_customize->add_setting('theme_options[aneeq_slider_content_type]', 
	array(
	'default' 			=> $aneeq_default['aneeq_slider_content_type'],
	'type'              => 'theme_mod',
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'aneeq_sanitize_select_box'
	)
);

$wp_customize->add_control('theme_options[aneeq_slider_content_type]', 
	array(
	'label'       => __('Content Type', 'aneeq'),
	'description' => __('Note: Add Featured Image Into Pages & Posts', 'aneeq'),
	'section'     => 'aneeq_section_slider',   
	'settings'    => 'theme_options[aneeq_slider_content_type]',
	'type'        => 'select',
	'active_callback' => 'aneeq_slider_sec_active',
	'choices'	  => array(
			'slider_page'	  => __('Page','aneeq'),
			'slider_post'	  => __('Post','aneeq'),
		),
	)
);

$aneeq_number_of_slider_items = aneeq_get_option( 'aneeq_number_of_slider_items' );

for( $aneeq_i=1; $aneeq_i<=$aneeq_number_of_slider_items; $aneeq_i++ ){

	// A. Page
	$wp_customize->add_setting('theme_options[aneeq_slider_page_'.$aneeq_i.']', 
		array(
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'aneeq_dropdown_pages'
		)
	);

	$wp_customize->add_control('theme_options[aneeq_slider_page_'.$aneeq_i.']', 
		array(
		'label'       => sprintf( __('Select Page #%1$s', 'aneeq'), $aneeq_i),
		'description' => sprintf( __('Recommended slide image resolution is 1900x800px.', 'aneeq'), $aneeq_i),
		'section'     => 'aneeq_section_slider',   
		'settings'    => 'theme_options[aneeq_slider_page_'.$aneeq_i.']',
		'type'        => 'dropdown-pages',
		'active_callback' => 'aneeq_slider_callback_page',
		)
	);

	// B. Posts
	$wp_customize->add_setting('theme_options[aneeq_slider_post_'.$aneeq_i.']', 
		array(
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'aneeq_dropdown_pages'
		)
	);

	$wp_customize->add_control('theme_options[aneeq_slider_post_'.$aneeq_i.']', 
		array(
		'label'       => sprintf( __('Select Post #%1$s', 'aneeq'), $aneeq_i),
		'description' => sprintf( __('Recommended slide image resolution is 1900x800px.', 'aneeq'), $aneeq_i),
		'section'     => 'aneeq_section_slider',   
		'settings'    => 'theme_options[aneeq_slider_post_'.$aneeq_i.']',
		'type'        => 'select',
		'choices'	  => aneeq_dropdown_posts(),
		'active_callback' => 'aneeq_slider_callback_post',
		)
	);
	
	// C. Button
	$wp_customize->add_setting('theme_options[aneeq_slider_button_'.$aneeq_i.']', 
		array(
		'default'			=> 'Read More',
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'sanitize_text_field'
		)
	);

	$wp_customize->add_control('theme_options[aneeq_slider_button_'.$aneeq_i.']', 
		array(
		'label'       => sprintf( __('Button Text #%1$s', 'aneeq'), $aneeq_i),
		'section'     => 'aneeq_section_slider',   
		'settings'    => 'theme_options[aneeq_slider_button_'.$aneeq_i.']',
		'type'        => 'text',
		'active_callback' => 'aneeq_slider_sec_active',
		)
	);
}
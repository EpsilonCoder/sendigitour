<?php
/**
 * Our Services options.
 *
 * @package aneeq
 */

$aneeq_default = aneeq_get_default_theme_options();

// Our Services Section
$wp_customize->add_section( 'aneeq_section_services',
	array(
		'title'      => __( 'Service Section', 'aneeq' ),
		'priority'   => 100,
		'capability' => 'edit_theme_options',
		'panel'      => 'front_page_panel',
		)
);

// 1. Enable Our Services Section
$wp_customize->add_setting('theme_options[enable_aneeq_services_section]', 
	array(
	'default' 			=> $aneeq_default['enable_aneeq_services_section'],
	'type'              => 'theme_mod',
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'aneeq_checkbox_sanitize'
	)
);

$wp_customize->add_control('theme_options[enable_aneeq_services_section]', 
	array(		
	'label' 	=> __('Enable Our Services Section', 'aneeq'),
	'section' 	=> 'aneeq_section_services',
	'settings'  => 'theme_options[enable_aneeq_services_section]',
	'type' 		=> 'checkbox',	
	)
);

// 2. Section Title
$wp_customize->add_setting('theme_options[aneeq_services_sec_title]', 
	array(
	'default'           => $aneeq_default['aneeq_services_sec_title'],
	'type'              => 'theme_mod',
	'capability'        => 'edit_theme_options',	
	'sanitize_callback' => 'sanitize_text_field'
	)
);

$wp_customize->add_control('theme_options[aneeq_services_sec_title]', 
	array(
	'label'       => __('Section Title', 'aneeq'),
	'section'     => 'aneeq_section_services',   
	'settings'    => 'theme_options[aneeq_services_sec_title]',	
	'active_callback' => 'aneeq_service_sec_active',		
	'type'        => 'text'
	)
);

// 3. Number of items
$wp_customize->add_setting('theme_options[aneeq_number_of_items]', 
	array(
	'default' 			=> $aneeq_default['aneeq_number_of_items'],
	'type'              => 'theme_mod',
	'capability'        => 'edit_theme_options',	
	'sanitize_callback' => 'aneeq_sanitize_number_range'
	)
);

$wp_customize->add_control('theme_options[aneeq_number_of_items]', 
	array(
	'label'       => __('Number Of Items', 'aneeq'),
	'description' => __('Save & Refresh the customizer to see its effect. Maximum is 3.', 'aneeq'),
	'section'     => 'aneeq_section_services',   
	'settings'    => 'theme_options[aneeq_number_of_items]',		
	'type'        => 'number',
	'active_callback' => 'aneeq_service_sec_active',
	'input_attrs' => array(
			'min'	=> 1,
			'max'	=> 3,
			'step'	=> 1,
		),
	)
);

// 4. Content Type
$wp_customize->add_setting('theme_options[aneeq_services_content_type]', 
	array(
	'default' 			=> $aneeq_default['aneeq_services_content_type'],
	'type'              => 'theme_mod',
	'capability'        => 'edit_theme_options',	
	'sanitize_callback' => 'aneeq_sanitize_select_box'
	)
);

$wp_customize->add_control('theme_options[aneeq_services_content_type]', 
	array(
	'label'       => __('Content Type', 'aneeq'),
	'section'     => 'aneeq_section_services',   
	'settings'    => 'theme_options[aneeq_services_content_type]',		
	'type'        => 'select',
	'active_callback' => 'aneeq_service_sec_active',
	'choices'	  => array(
			'services_page'	  	=> __('Page','aneeq'),
			'services_post'	  	=> __('Post','aneeq'),
		),
	)
);

$aneeq_number_of_items = aneeq_get_option( 'aneeq_number_of_items' );

for( $aneeq_i=1; $aneeq_i<=$aneeq_number_of_items; $aneeq_i++ ){

	// A. Icon
	$wp_customize->add_setting('theme_options[aneeq_services_icon_'.$aneeq_i.']', 
		array(
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',	
		'sanitize_callback' => 'sanitize_text_field'
		)
	);

	$wp_customize->add_control('theme_options[aneeq_services_icon_'.$aneeq_i.']', 
		array(
		'label'       => sprintf( __('Select Icon #%1$s', 'aneeq'), $aneeq_i),
		'description' => sprintf( __('Please input icon as eg: fa fa-globe. Find Font Aawesome icons %1$shere%2$s', 'aneeq'), '<a href="' . esc_url( 'https://fontawesome.com/v4.7.0/icons/' ) . '" target="_blank">', '</a>' ),
		'section'     => 'aneeq_section_services',   
		'settings'    => 'theme_options[aneeq_services_icon_'.$aneeq_i.']',		
		'active_callback' => 'aneeq_service_sec_active',			
		'type'        => 'text',
		)
	);

	// B. Page
	$wp_customize->add_setting('theme_options[aneeq_services_page_'.$aneeq_i.']', 
		array(
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',	
		'sanitize_callback' => 'aneeq_dropdown_pages'
		)
	);

	$wp_customize->add_control('theme_options[aneeq_services_page_'.$aneeq_i.']', 
		array(
		'label'       => sprintf( __('Select Page #%1$s', 'aneeq'), $aneeq_i),
		'section'     => 'aneeq_section_services',   
		'settings'    => 'theme_options[aneeq_services_page_'.$aneeq_i.']',		
		'type'        => 'dropdown-pages',
		'active_callback' => 'aneeq_services_callback_page',
		)
	);

	// C. Posts
	$wp_customize->add_setting('theme_options[aneeq_services_post_'.$aneeq_i.']', 
		array(
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',	
		'sanitize_callback' => 'aneeq_dropdown_pages'
		)
	);

	$wp_customize->add_control('theme_options[aneeq_services_post_'.$aneeq_i.']', 
		array(
		'label'       => sprintf( __('Select Post #%1$s', 'aneeq'), $aneeq_i),
		'section'     => 'aneeq_section_services',   
		'settings'    => 'theme_options[aneeq_services_post_'.$aneeq_i.']',		
		'type'        => 'select',
		'choices'	  => aneeq_dropdown_posts(),
		'active_callback' => 'aneeq_services_callback_post',
		)
	);
}
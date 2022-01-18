<?php
/**
 * Home Page Options.
 *
 * @package aneeq
 */

$aneeq_default = aneeq_get_default_theme_options();

// Latest Blog Section
$wp_customize->add_section( 'section_home_wooproduct',
	array(
		'title'      => __( 'Woocommerce Section', 'aneeq' ),
		'priority'   => 100,
		'capability' => 'edit_theme_options',
		'panel'      => 'front_page_panel',
		)
);
// Enable Blog Section
$wp_customize->add_setting('theme_options[enable_woo_section]', 
	array(
	'default' 			=> $aneeq_default['enable_woo_section'],
	'type'              => 'theme_mod',
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'aneeq_checkbox_sanitize'
	)
);

$wp_customize->add_control('theme_options[enable_woo_section]', 
	array(		
	'label' 	=> __('Enable Woocommerce Section', 'aneeq'),
	'section' 	=> 'section_home_wooproduct',
	'settings'  => 'theme_options[enable_woo_section]',
	'type' 		=> 'checkbox',	
	)
);

// Section Title
$wp_customize->add_setting('theme_options[aneeq_woo_section_title]', 
	array(
	'default'           => $aneeq_default['aneeq_woo_section_title'],
	'type'              => 'theme_mod',
	'capability'        => 'edit_theme_options',	
	'sanitize_callback' => 'sanitize_text_field'
	)
);

$wp_customize->add_control('theme_options[aneeq_woo_section_title]', 
	array(
	'label'       => __('Section Title', 'aneeq'),
	'section'     => 'section_home_wooproduct',   
	'settings'    => 'theme_options[aneeq_woo_section_title]',	
	'active_callback' => 'aneeq_woo_active',		
	'type'        => 'text'
	)
);

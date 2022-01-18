<?php
/**
 * Home Page Options.
 *
 * @package aneeq
 */

$aneeq_default = aneeq_get_default_theme_options();

// Latest Blog Section
$wp_customize->add_section( 'section_home_blog',
	array(
		'title'      => __( 'Blog Section', 'aneeq' ),
		'priority'   => 100,
		'capability' => 'edit_theme_options',
		'panel'      => 'front_page_panel',
		)
);
// Enable Blog Section
$wp_customize->add_setting('theme_options[enable_blog_section]', 
	array(
	'default' 			=> $aneeq_default['enable_blog_section'],
	'type'              => 'theme_mod',
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'aneeq_checkbox_sanitize'
	)
);

$wp_customize->add_control('theme_options[enable_blog_section]', 
	array(		
	'label' 	=> __('Enable Blog Section', 'aneeq'),
	'section' 	=> 'section_home_blog',
	'settings'  => 'theme_options[enable_blog_section]',
	'type' 		=> 'checkbox',	
	)
);

// Section Title
$wp_customize->add_setting('theme_options[aneeq_blog_section_title]', 
	array(
	'default'           => $aneeq_default['aneeq_blog_section_title'],
	'type'              => 'theme_mod',
	'capability'        => 'edit_theme_options',	
	'sanitize_callback' => 'sanitize_text_field'
	)
);

$wp_customize->add_control('theme_options[aneeq_blog_section_title]', 
	array(
	'label'       => __('Section Title', 'aneeq'),
	'section'     => 'section_home_blog',   
	'settings'    => 'theme_options[aneeq_blog_section_title]',	
	'active_callback' => 'aneeq_blog_active',		
	'type'        => 'text'
	)
);

// Setting  Blog Category.
$wp_customize->add_setting( 'theme_options[aneeq_blog_category]',
	array(
	'default'           => $aneeq_default['aneeq_blog_category'],
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'absint',
	)
);
$wp_customize->add_control(
	new Aneeq_Dropdown_Taxonomies_Control( $wp_customize, 'theme_options[aneeq_blog_category]',
		array(
		'label'    => __( 'Select Category', 'aneeq' ),
		'section'  => 'section_home_blog',
		'settings' => 'theme_options[aneeq_blog_category]',	
		'active_callback' => 'aneeq_blog_active',		
		'priority' => 100,
		)
	)
);

// Blog Number.
$wp_customize->add_setting( 'theme_options[aneeq_blog_number]',
	array(
		'default'           => $aneeq_default['aneeq_blog_number'],
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'aneeq_sanitize_number_range',
		)
);
$wp_customize->add_control( 'theme_options[aneeq_blog_number]',
	array(
		'label'       => __( 'Number of Posts', 'aneeq' ),
		'description' => __('Maximum number of post to show is 3.', 'aneeq'),
		'section'     => 'section_home_blog',
		'active_callback' => 'aneeq_blog_active',	
		'type'        => 'number',
		'priority'    => 100,
		'input_attrs' => array( 'min' => 1, 'max' => 3, 'step' => 1, 'style' => 'width: 115px;' ),
		
	)
);

//Service Column Layout
$wp_customize->add_setting( 'theme_options[aneeq_blog_column_layout]', 
	array(
		'default'     		=> $aneeq_default['aneeq_blog_column_layout'],
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'aneeq_sanitize_radio'
	)
);
$wp_customize->add_control('theme_options[aneeq_blog_column_layout]', 
	array(
		'type'      => 'radio',
		'label'     => __('Column Settings (Only For Desktop)', 'aneeq'),
		'section'   => 'section_home_blog',
		'active_callback' => 'aneeq_blog_active',
		'priority'  => 100,
		'choices'   => array(
			'col-md-4'     	=> __( '3 Column', 'aneeq' ),
			'col-md-6'      => __( '2 Column', 'aneeq' ),						
		),
		//'active_callback' => 'aneeq_blog_active',
	)
);	
			
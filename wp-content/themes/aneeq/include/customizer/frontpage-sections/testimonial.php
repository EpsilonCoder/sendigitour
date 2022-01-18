<?php
/**
 * testimonial options.
 *
 * @package aneeq
 */

$aneeq_default = aneeq_get_default_theme_options();

// Call to action section
$wp_customize->add_section( 'aneeq_section_testimonial',
	array(
		'title'      => __( 'Testimonial Section', 'aneeq' ),
		'priority'   => 100,
		'capability' => 'edit_theme_options',
		'panel'      => 'front_page_panel',
		)
);

// 1. Enable Call to action section
$wp_customize->add_setting('theme_options[enable_aneeq_testimonial_section]', 
	array(
	'default' 			=> $aneeq_default['enable_aneeq_testimonial_section'],
	'type'              => 'theme_mod',
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'aneeq_checkbox_sanitize'
	)
);

$wp_customize->add_control('theme_options[enable_aneeq_testimonial_section]', 
	array(		
	'label' 	=> __('Enable Testimonial section', 'aneeq'),
	'section' 	=> 'aneeq_section_testimonial',
	'settings'  => 'theme_options[enable_aneeq_testimonial_section]',
	'type' 		=> 'checkbox',	
	)
);

// 2. Title
$wp_customize->add_setting('theme_options[aneeq_testimonial_sec_title]', 
	array(
	'default' 			=> $aneeq_default['aneeq_testimonial_sec_title'],
	'type'              => 'theme_mod',
	'capability'        => 'edit_theme_options',	
	'sanitize_callback' => 'sanitize_text_field'
	)
);

$wp_customize->add_control('theme_options[aneeq_testimonial_sec_title]', 
	array(
	'label'       => __('Title', 'aneeq'),
	'section'     => 'aneeq_section_testimonial',   
	'settings'    => 'theme_options[aneeq_testimonial_sec_title]',
	'active_callback' => 'aneeq_testimonial_sec_active',		
	'type'        => 'text'
	)
);

// 3. Content Type
$wp_customize->add_setting('theme_options[aneeq_testimonials_content_type]', 
	array(
	'default' 			=> $aneeq_default['aneeq_testimonials_content_type'],
	'type'              => 'theme_mod',
	'capability'        => 'edit_theme_options',	
	'sanitize_callback' => 'aneeq_sanitize_select_box'
	)
);

$wp_customize->add_control('theme_options[aneeq_testimonials_content_type]', 
	array(
	'label'       => __('Content Type', 'aneeq'),
	'section'     => 'aneeq_section_testimonial',   
	'settings'    => 'theme_options[aneeq_testimonials_content_type]',		
	'type'        => 'select',
	'active_callback' => 'aneeq_testimonial_sec_active',
	'choices'	  => array(
			'testimonial_page'	  	=> __('Page','aneeq'),
			'testimonial_post'	  	=> __('Post','aneeq'),
		),
	)
);


// 4. Page
$wp_customize->add_setting('theme_options[aneeq_testimonial_page_1]', 
	array(
	'type'              => 'theme_mod',
	'capability'        => 'edit_theme_options',	
	'sanitize_callback' => 'aneeq_dropdown_pages'
	)
);

$wp_customize->add_control('theme_options[aneeq_testimonial_page_1]', 
	array(
	'label'       => sprintf( __('Select Page #%1$s', 'aneeq'), 1),
	'section'     => 'aneeq_section_testimonial',   
	'settings'    => 'theme_options[aneeq_testimonial_page_1]',		
	'type'        => 'dropdown-pages',
	'active_callback' => 'aneeq_testimonial_callback_page',
	)
);

// 5. Posts
$wp_customize->add_setting('theme_options[aneeq_testimonial_post_1]', 
	array(
	'type'              => 'theme_mod',
	'capability'        => 'edit_theme_options',	
	'sanitize_callback' => 'aneeq_dropdown_pages'
	)
);

$wp_customize->add_control('theme_options[aneeq_testimonial_post_1]', 
	array(
	'label'       => sprintf( __('Select Post #%1$s', 'aneeq'), 1),
	'section'     => 'aneeq_section_testimonial',   
	'settings'    => 'theme_options[aneeq_testimonial_post_1]',		
	'type'        => 'select',
	'choices'	  => aneeq_dropdown_posts(),
	'active_callback' => 'aneeq_testimonial_callback_post',
	)
);


/* // 6. Client Name
$wp_customize->add_setting('theme_options[aneeq_testimonial_client_name]', 
	array(
	'default' 			=> $aneeq_default['aneeq_testimonial_client_name'],
	'type'              => 'theme_mod',
	'capability'        => 'edit_theme_options',	
	'sanitize_callback' => 'sanitize_text_field'
	)
);

$wp_customize->add_control('theme_options[aneeq_testimonial_client_name]', 
	array(
	'label'       => __('Client Title', 'aneeq'),
	'section'     => 'aneeq_section_testimonial',   
	'settings'    => 'theme_options[aneeq_testimonial_client_name]',	
	'active_callback' => 'aneeq_testimonial_sec_active',	
	'type'        => 'text'
	)
); */
// 7. Designation
$wp_customize->add_setting('theme_options[aneeq_testimonial_designation]', 
	array(
	'default' 			=> $aneeq_default['aneeq_testimonial_designation'],
	'type'              => 'theme_mod',
	'capability'        => 'edit_theme_options',	
	'sanitize_callback' => 'sanitize_text_field'
	)
);

$wp_customize->add_control('theme_options[aneeq_testimonial_designation]', 
	array(
	'label'       => __('Client Designation', 'aneeq'),
	'section'     => 'aneeq_section_testimonial',   
	'settings'    => 'theme_options[aneeq_testimonial_designation]',	
	'active_callback' => 'aneeq_testimonial_sec_active',	
	'type'        => 'text'
	)
);

// 8. Site Link
$wp_customize->add_setting('theme_options[aneeq_testimonial_link]', 
	array(
	'default' 			=> $aneeq_default['aneeq_testimonial_link'],
	'type'              => 'theme_mod',
	'capability'        => 'edit_theme_options',	
	'sanitize_callback' => 'esc_url_raw'
	)
);

$wp_customize->add_control('theme_options[aneeq_testimonial_link]', 
	array(
	'label'       => __('Website Link', 'aneeq'),
	'section'     => 'aneeq_section_testimonial',   
	'settings'    => 'theme_options[aneeq_testimonial_link]',	
	'active_callback' => 'aneeq_testimonial_sec_active',	
	'type'        => 'url'
	)
);
<?php
/**
 * Site Title Setting
 *
 * @package Chic_Lite
 */

function chic_lite_customize_register( $wp_customize ) {
	
    $wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
    $wp_customize->get_setting( 'background_color' )->transport = 'refresh';
    $wp_customize->get_setting( 'background_image' )->transport = 'refresh';
	
	if( isset( $wp_customize->selective_refresh ) ){
		$wp_customize->selective_refresh->add_partial( 'blogname', array(
			'selector'        => '.site-title a',
			'render_callback' => 'chic_lite_customize_partial_blogname',
		) );
		$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
			'selector'        => '.site-description',
			'render_callback' => 'chic_lite_customize_partial_blogdescription',
		) );
	}
    
    /** Site Title Font */
    $wp_customize->add_setting( 
        'site_title_font', 
        array(
            'default' => array(                                			
                'font-family' => 'Nanum Myeongjo',
                'variant'     => 'regular',
            ),
            'sanitize_callback' => array( 'Chic_Lite_Fonts', 'sanitize_typography' )
        ) 
    );

	$wp_customize->add_control( 
        new Chic_Lite_Typography_Control( 
            $wp_customize, 
            'site_title_font', 
            array(
                'label'       => __( 'Site Title Font', 'chic-lite' ),
                'description' => __( 'Site title and tagline font.', 'chic-lite' ),
                'section'     => 'title_tagline',
                'priority'    => 60, 
            ) 
        ) 
    );
    
    /** Site Logo Size */
    $wp_customize->add_setting(
        'site_logo_size',
        array(
            'capability' => 'edit_theme_options',
            'sanitize_callback' => 'chic_lite_sanitize_number_absint',
            'default' => 70,
            'transport'     => 'postMessage', 
        )
    );

    $wp_customize->add_control(
        'site_logo_size',
        array(
            'type' => 'number',
            'section' => 'title_tagline', 
            'label' => __( 'Set the width(px) of your Site Logo', 'chic-lite' ),
        )
    );
    
    /** Site Title Font Size*/
    $wp_customize->add_setting( 
        'site_title_font_size', 
        array(
            'default'           => 30,
            'sanitize_callback' => 'chic_lite_sanitize_number_absint',
        ) 
    );
    
    $wp_customize->add_control(
		new Chic_Lite_Slider_Control( 
			$wp_customize,
			'site_title_font_size',
			array(
				'section'	  => 'title_tagline',
				'label'		  => __( 'Site Title Font Size', 'chic-lite' ),
				'description' => __( 'Change the font size of your site title.', 'chic-lite' ),
                'priority'    => 65,
                'choices'	  => array(
					'min' 	=> 10,
					'max' 	=> 200,
					'step'	=> 1,
				)                 
			)
		)
	);
    
}
add_action( 'customize_register', 'chic_lite_customize_register' );
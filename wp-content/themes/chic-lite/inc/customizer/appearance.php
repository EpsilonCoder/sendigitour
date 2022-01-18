<?php
/**
 * Appearance Settings
 *
 * @package Chic_Lite
 */

function chic_lite_customize_register_appearance( $wp_customize ) {

    /** Appearance Settings */
    $wp_customize->add_panel( 
        'appearance_settings',
         array(
            'priority'    => 50,
            'capability'  => 'edit_theme_options',
            'title'       => __( 'Appearance Settings', 'chic-lite' ),
            'description' => __( 'Customize Typography, Header Image & Background Image', 'chic-lite' ),
        ) 
    );
/** Typography */
    $wp_customize->add_section(
        'typography_settings',
        array(
            'title'    => __( 'Typography', 'chic-lite' ),
            'priority' => 15,
            'panel'    => 'appearance_settings',
        )
    );
    
    /** Primary Font */
    $wp_customize->add_setting(
        'primary_font',
        array(
            'default'           => 'Nunito Sans',
            'sanitize_callback' => 'chic_lite_sanitize_select'
        )
    );

    $wp_customize->add_control(
        new Chic_Lite_Select_Control(
            $wp_customize,
            'primary_font',
            array(
                'label'       => __( 'Primary Font', 'chic-lite' ),
                'description' => __( 'Primary font of the site.', 'chic-lite' ),
                'section'     => 'typography_settings',
                'choices'     => chic_lite_get_all_fonts(), 
            )
        )
    );
    
    /** Secondary Font */
    $wp_customize->add_setting(
        'secondary_font',
        array(
            'default'           => 'Nanum Myeongjo',
            'sanitize_callback' => 'chic_lite_sanitize_select'
        )
    );

    $wp_customize->add_control(
        new Chic_Lite_Select_Control(
            $wp_customize,
            'secondary_font',
            array(
                'label'       => __( 'Secondary Font', 'chic-lite' ),
                'description' => __( 'Secondary font of the site.', 'chic-lite' ),
                'section'     => 'typography_settings',
                'choices'     => chic_lite_get_all_fonts(), 
            )
        )
    );
    
    /** Font Size*/
    $wp_customize->add_setting( 
        'font_size', 
        array(
            'default'           => 18,
            'sanitize_callback' => 'chic_lite_sanitize_number_absint'
        ) 
    );
    
    $wp_customize->add_control(
        new Chic_Lite_Slider_Control( 
            $wp_customize,
            'font_size',
            array(
                'section'     => 'typography_settings',
                'label'       => __( 'Font Size', 'chic-lite' ),
                'description' => __( 'Change the font size of your site.', 'chic-lite' ),
                'choices'     => array(
                    'min'   => 10,
                    'max'   => 50,
                    'step'  => 1,
                )                 
            )
        )
    );

    /** Move Background Image section to appearance panel */
    $wp_customize->get_section( 'background_image' )->panel    = 'appearance_settings';
    $wp_customize->get_section( 'background_image' )->priority = 10;

}

add_action( 'customize_register', 'chic_lite_customize_register_appearance' );

<?php
/**
 * Color Setting
 *
 * @package Chic_Lite
 */

function chic_lite_customize_register_color( $wp_customize ) {
    
    /** Primary Color*/
    $wp_customize->add_setting( 
        'primary_color', 
        array(
            'default'           => '#e1bdbd',
            'sanitize_callback' => 'sanitize_hex_color',
        ) 
    );

    $wp_customize->add_control( 
        new WP_Customize_Color_Control( 
            $wp_customize, 
            'primary_color', 
            array(
                'label'       => __( 'Primary Color', 'chic-lite' ),
                'description' => __( 'Primary color of the theme.', 'chic-lite' ),
                'section'     => 'colors',
                'priority'    => 5,
            )
        )
    );  
}
add_action( 'customize_register', 'chic_lite_customize_register_color' );
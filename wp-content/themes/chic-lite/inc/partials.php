<?php
/**
 * Chic Lite Customizer Partials
 *
 * @package Chic_Lite
 */

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function chic_lite_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function chic_lite_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

if( ! function_exists( 'chic_lite_get_read_more' ) ) :
/**
 * Display blog readmore button
*/
function chic_lite_get_read_more(){
    return esc_html( get_theme_mod( 'read_more_text', __( 'Continue Reading', 'chic-lite' ) ) );    
}
endif;

if( ! function_exists( 'chic_lite_get_related_title' ) ) :
/**
 * Display blog readmore button
*/
function chic_lite_get_related_title(){
    return esc_html( get_theme_mod( 'related_post_title', __( 'You may also like...', 'chic-lite' ) ) );
}
endif;

if( ! function_exists( 'chic_lite_get_banner_title' ) ) :
/**
 * Display Banner Title
*/
function chic_lite_get_banner_title(){
    return esc_html( get_theme_mod( 'banner_title', __( 'Find Your Best Holiday', 'chic-lite' ) ) );
}
endif;

if( ! function_exists( 'chic_lite_get_banner_sub_title' ) ) :
/**
 * Display Banner SubTitle
*/
function chic_lite_get_banner_sub_title(){
    return wpautop( wp_kses_post( get_theme_mod( 'banner_subtitle', __( 'Find great adventure holidays and activities around the planet.', 'chic-lite' ) ) ) );
}
endif;

if( ! function_exists( 'chic_lite_get_banner_button' ) ) :
/**
 * Display Banner Button Label
*/
function chic_lite_get_banner_button(){
    return esc_html( get_theme_mod( 'banner_button', __( 'Read More', 'chic-lite' ) ) );
}
endif;

if( ! function_exists( 'chic_lite_get_footer_copyright' ) ) :
/**
 * Footer Copyright
*/
function chic_lite_get_footer_copyright(){
    $copyright = get_theme_mod( 'footer_copyright' );

    if( $copyright ){
        echo wp_kses_post( $copyright );
    }else{
        esc_html_e( '&copy; Copyright', 'chic-lite' );
        echo date_i18n( esc_html__( ' Y', 'chic-lite' ) );
        echo ' <a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html( get_bloginfo( 'name' ) ) . '</a>. ';
        esc_html_e( 'All Rights Reserved. ', 'chic-lite' );
    }
}
endif;

if( ! function_exists( 'chic_lite_get_related_portfolio_title' ) ) :
/**
 * Display Related portfolio title
*/
function chic_lite_get_related_portfolio_title(){
    return esc_html( get_theme_mod( 'related_portfolio_title', __( 'Related Projects', 'chic-lite' ) ) );
}
endif;
<?php

if( ! function_exists( 'chic_lite_newsletter_bg_image_size' ) ) :
    function chic_lite_newsletter_bg_image_size(){
        return 'full';
    }
endif;
add_filter( 'bt_newsletter_img_size', 'chic_lite_newsletter_bg_image_size' );

if( ! function_exists( 'chic_lite_newsletter_bg_color' ) ) :
    function chic_lite_newsletter_bg_color(){
        return '#dde9ed';
    }
endif;
add_filter( 'bt_newsletter_bg_color_setting', 'chic_lite_newsletter_bg_color' );

if( ! function_exists( 'chic_lite_add_inner_div' ) ) :
    function chic_lite_add_inner_div(){
        return true;
    }
endif;
add_filter( 'bt_newsletter_shortcode_inner_wrap_display', 'chic_lite_add_inner_div' );

if( ! function_exists( 'chic_lite_start_inner_div' ) ) :
    function chic_lite_start_inner_div(){
        echo '<div class="newsletter-inner-wrapper">';
    }
endif;
add_action( 'bt_newsletter_shortcode_inner_wrap_start', 'chic_lite_start_inner_div' );

if( ! function_exists( 'chic_lite_end_inner_div' ) ) :
    function chic_lite_end_inner_div(){
        echo '</div>';
    }
endif;
add_action( 'bt_newsletter_shortcode_inner_wrap_close', 'chic_lite_end_inner_div' );
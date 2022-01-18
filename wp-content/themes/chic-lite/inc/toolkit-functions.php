<?php
/**
 * Toolkit Filters
 *
 * @package Chic_Lite
 */
 
if( ! function_exists( 'chic_lite_default_image_text_image_size' ) ) :
    function chic_lite_default_image_text_image_size(){
        $return = 'chic-lite-blog';

        return $return;
    }
endif;
add_filter( 'raratheme_it_img_size', 'chic_lite_default_image_text_image_size' );
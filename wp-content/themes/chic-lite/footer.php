<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Chic_Lite
 */

    /**
     * After Content
     * 
     * @hooked chic_lite_content_end - 20
    */
    do_action( 'chic_lite_before_footer' );    
    
    if ( ! is_single() ) chic_lite_newsletter();

    /**
     * Footer
     * 
     * @hooked chic_lite_instagram_section - 40
     * @hooked chic_lite_footer_start  - 25
     * @hooked chic_lite_footer_top    - 30
     * @hooked chic_lite_footer_bottom - 40
     * @hooked chic_lite_footer_end    - 50
    */
    do_action( 'chic_lite_footer' );
    
    /**
     * After Footer
     * 
     * @hooked chic_lite_back_to_top - 15
     * @hooked chic_lite_page_end    - 20
    */
    do_action( 'chic_lite_after_footer' );

    wp_footer(); ?>

</body>
</html>

<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Chic_Lite
 */

?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php

		/**
         * @hooked chic_lite_entry_first_header - 10
	     * @hooked chic_lite_post_thumbnail - 20
	    */
	    do_action( 'chic_lite_before_page_entry_content' );

        /**
         * Entry Content
         * 
         * @hooked chic_lite_entry_content - 15
        */
        do_action( 'chic_lite_page_entry_content' );    
    ?>
</article><!-- #post-<?php the_ID(); ?> -->

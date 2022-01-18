<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Chic_Lite
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); echo ' itemscope itemtype="https://schema.org/Blog"'; ?>>
    
	<?php   

    /**
     * @hooked chic_lite_entry_first_header - 10
     * @hooked chic_lite_post_thumbnail - 20
    */
    do_action( 'chic_lite_before_post_entry_content' );

    /**
     * @hooked chic_lite_entry_content  - 15
     * @hooked chic_lite_entry_footer   - 20
    */
    do_action( 'chic_lite_post_entry_content' );

    ?>
</article><!-- #post-<?php the_ID(); ?> -->

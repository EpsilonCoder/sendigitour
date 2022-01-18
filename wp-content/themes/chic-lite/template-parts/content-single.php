<?php
/**
 * Template part for displaying single post
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Chic_Lite
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    
	<?php 
    chic_lite_single_layout();

    echo '<div class="content-wrap">';
    /**
     * @hooked chic_lite_entry_content  - 15
     * @hooked chic_lite_entry_footer   - 20
    */
    do_action( 'chic_lite_single_post_entry_content' );
    echo '</div>';

    ?>
</article><!-- #post-<?php the_ID(); ?> -->
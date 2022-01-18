<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Chic_Lite
 */

get_header(); ?>
    <div id="primary" class="content-area">	
    	<main id="main" class="site-main">

    	<?php
    	while ( have_posts() ) : the_post();

    		get_template_part( 'template-parts/content', 'single' );

    	endwhile; // End of the loop.
    	?>

    	</main><!-- #main -->
        
        <?php
        /**
         * @hooked chic_lite_author               - 15
         * @hooked chic_lite_navigation           - 20 
         * @hooked chic_lite_newsletter           - 30
         * @hooked chic_lite_related_posts        - 35
         * @hooked chic_lite_comment              - 15/45
        */
        do_action( 'chic_lite_after_post_content' );
        ?>
    </div><!-- #primary -->

<?php
get_sidebar();
get_footer();

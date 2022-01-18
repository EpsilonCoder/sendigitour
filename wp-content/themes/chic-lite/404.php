<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 * @package Chic_Lite
 */

get_header(); ?>
<div id="primary" class="content-area">
    
    <main id="main" class="site-main">
        <section class="error-404 not-found">
            <header class="page-header">
                <h1 class="page-title"><?php esc_html_e( 'Uh-Oh...', 'chic-lite' ); ?></h1>
            </header>
            <div class="page-content">
                <p class="error-text"><?php esc_html_e( 'The page you are looking for may have been moved, deleted, or possibly never existed.', 'chic-lite' ); ?></p>
                <div class="error-num">404</div>
                <a class="btn-readmore" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Take me to the home page', 'chic-lite' ); ?></a>
                <?php get_search_form(); ?>
            </div><!-- .page-content -->
        </section>
    </main><!-- #main -->
    
    <?php 
    /**
     * @see chic_lite_latest_posts
    */
    do_action( 'chic_lite_latest_posts' );
    ?>
</div><!-- #primary -->
    
<?php    
get_footer();
<?php
/**
 * Template part for displaying a message that posts cannot be found
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Chic_Lite
 */

global $wp_query, $post; ?>

<section class="no-results not-found">
	<header class="page-header">
		<?php if( is_home() && $wp_query->found_posts == 0 && $post ){ ?>
            <h2 class="page-title"><?php esc_html_e( 'Add More Posts', 'chic-lite' ); ?></h2>		  
		<?php }else{ ?>
            <h2 class="page-title"><?php esc_html_e( 'Nothing Found', 'chic-lite' ); ?></h2>
        <?php } ?>
	</header><!-- .page-header -->

	<div class="page-content">
		<?php
		if ( is_home() && current_user_can( 'publish_posts' ) ) : 
            if( $wp_query->found_posts == 0 && $post ){ ?>
                <p><?php
    				printf(
    					wp_kses(
    						/* translators: 1: link to WP admin new post page. */
    						__( 'Your blog posts are displayed in the slider. To display blog post here, <a href="%1$s">please publish more blog posts.</a>', 'chic-lite' ),
    						array(
    							'a' => array(
    								'href' => array(),
    							),
    						)
    					),
    					esc_url( admin_url( 'post-new.php' ) )
    				);
    			?></p>
                
            <?php
            }else{        
        ?>
            <p><?php
				printf(
					wp_kses(
						/* translators: 1: link to WP admin new post page. */
						__( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'chic-lite' ),
						array(
							'a' => array(
								'href' => array(),
							),
						)
					),
					esc_url( admin_url( 'post-new.php' ) )
				);
			?></p>

		<?php }
		
        elseif ( is_search() ) : ?>

			<p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'chic-lite' ); ?></p>
			<?php
				get_search_form();

		else : ?>

			<p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'chic-lite' ); ?></p>
			<?php
				get_search_form();

		endif; ?>
	</div><!-- .page-content -->
</section><!-- .no-results -->

<?php
/**
 * Single Portfolio
*/
get_header();

while ( have_posts() ) : the_post(); 
    $term_list = get_the_term_list( get_the_ID(), 'rara_portfolio_categories' ); ?>
    
    <div class="portfolio-holder">
    	
        <figure class="post-thumbnail">
    		<?php the_post_thumbnail( 'full' ); ?>
    	</figure>
    	
        <header class="entry-header">
    		<?php 
                if( $term_list ) echo '<div class="portfolio-cat">' . $term_list . '</div>'; 
                the_title( '<h1 class="entry-title">', '</h1>' );
            ?>    		
    	</header>    	
        <div class="entry-content">
    		<?php the_content(); ?>
    	</div><!-- .entry-content -->
        
    </div>
    <?php 
    
    chic_lite_navigation();
     
    $args = array(
        'post_type'      => 'rara-portfolio',
        'posts_status'   => 'publish',
        'posts_per_page' => 3,
        'post__not_in'   => array( get_the_ID() ),
        'orderby'        => 'rand'
    );
    
    $related_title = get_theme_mod( 'related_portfolio_title', __( 'Related Projects', 'chic-lite' ) );
    
    $qry = new WP_Query( $args );
    if( $qry->have_posts() ){ ?>    
        <div class="related-portfolio">
        	<?php if( $related_title ) echo '<div class="related-portfolio-title">' . esc_html( $related_title ) . '</div>'; ?>            
        	
            <div class="portfolio-img-holder">
        		<?php 
                    while( $qry->have_posts() ){ 
                        $qry->the_post();
                        if( has_post_thumbnail() ){ ?>
                            <div class="portfolio-item">
                    			<div class="portfolio-item-inner">
                    				<a href="<?php the_permalink(); ?>">
                    					<?php the_post_thumbnail( 'chic-lite-blog' ); ?>
                    				</a>
                    				<div class="portfolio-text-holder">
                    					<?php 
                                            $term_list = get_the_term_list( get_the_ID(), 'rara_portfolio_categories' );
                                            if( $term_list ) echo '<div class="portfolio-cat">' . $term_list . '</div>';
                                            
                                            the_title( '<div class="portfolio-img-title"><a href="' . esc_url( get_permalink() ) . '">', '</a></div>' ); 
                                        ?>
                    				</div>
                    			</div>
                    		</div>
                            <?php
                        } 
                    } 
                ?>
        	</div>
        </div>
    <?php
    wp_reset_postdata();
    }
        
endwhile; 
get_footer();
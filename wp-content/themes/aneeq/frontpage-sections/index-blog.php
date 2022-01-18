<?php 
/**
 * Template part for displaying Blog Section
 *
 *@package aneeq
 */

$aneeq_blog_section_title       = aneeq_get_option( 'aneeq_blog_section_title' );
$aneeq_blog_category 		    = aneeq_get_option( 'aneeq_blog_category' );
$aneeq_blog_number		  		= aneeq_get_option( 'aneeq_blog_number' );
$aneeq_blog_column_layout		= aneeq_get_option( 'aneeq_blog_column_layout' );
get_header(); ?>
	
	
<section class="blog-section">
	<div class="container">
		<?php if( !empty($aneeq_blog_section_title) ):?>
			<div class="row">
				<div class="col-md-12 col-xs-12">
					<div class="dividerHeading">
						<h2 class="blog-title"><?php echo esc_html($aneeq_blog_section_title);?></h2> 
					</div>
				</div>	
			</div>
		<?php endif;?>
	
		<div class="row super_sub_content">
			<?php
				$aneeq_blog_args = array(
					'posts_per_page' =>absint( $aneeq_blog_number ),
					'post_type' => 'post',
					'post_status' => 'publish',
					'paged' => 1,
					);

				if ( absint( $aneeq_blog_category ) > 0 ) {
					$aneeq_blog_args['cat'] = absint( $aneeq_blog_category );
				}
				
				// Fetch posts.
				$aneeq_the_query = new WP_Query( $aneeq_blog_args );
				
			?>
			
			<?php if ( $aneeq_the_query->have_posts() ) : 
				while ( $aneeq_the_query->have_posts() ) : $aneeq_the_query->the_post(); ?>
				
					<div class="<?php echo esc_attr($aneeq_blog_column_layout); ?> col-sm-6 col-xs-12">
						<div class="post-slide">
							<?php if(has_post_thumbnail()): ?>
								<div class="post-img">
									<?php the_post_thumbnail('full');?>
								</div>
							<?php endif; ?>
							
							<h3 class="post-title"><a href="<?php the_permalink();?>"><?php the_title(); ?></a></h3>
							<div class="post-date">
								<i class="fa fa-calendar"></i> <?php the_time('F j, Y'); ?>
							</div>
							<?php
								$aneeq_excerpt = aneeq_the_excerpt( 20 );
								echo wp_kses_post( wpautop( $aneeq_excerpt ) );
							?>
							<a class="readmore" href="<?php the_permalink(); ?>" target="_new"><?php esc_html_e('Read more','aneeq'); ?></a>
						</div>
					</div>
				<?php endwhile;?>
				<?php wp_reset_postdata(); ?>
			<?php endif;?>
		</div>
	</div>
</section>
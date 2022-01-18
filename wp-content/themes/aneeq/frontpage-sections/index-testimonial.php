<?php 
/**
 * Template part for displaying testimonial Section
 *
 *@package aneeq
 */
	$aneeq_testimonial_sec_title        	 = aneeq_get_option( 'aneeq_testimonial_sec_title' );
	$aneeq_testimonials_content_type   		 = aneeq_get_option( 'aneeq_testimonials_content_type' );
	
	//$aneeq_testimonial_client_name      	 = aneeq_get_option( 'aneeq_testimonial_client_name' );
	$aneeq_testimonial_designation       	 = aneeq_get_option( 'aneeq_testimonial_designation' );
	$aneeq_testimonial_link       			 = aneeq_get_option( 'aneeq_testimonial_link' );
	
	if( $aneeq_testimonials_content_type == 'testimonial_page' ) :
		$aneeq_testimonial_pages[] = aneeq_get_option( 'aneeq_testimonial_page_1'); 
	elseif( $aneeq_testimonials_content_type == 'testimonial_post' ) :
		$aneeq_testimonial_posts[] = aneeq_get_option( 'aneeq_testimonial_post_1' );
	endif;
?>

<section class="testimonial-content rollIn animated bg-color">
	<div class="container">
		<?php if ( !empty($aneeq_testimonial_sec_title ) ) : ?>
			<div class="row">
				<div class="col-md-12 col-xs-12">
					<div class="dividerHeading">
						<h2 class="testimonial-titles"><?php echo esc_html($aneeq_testimonial_sec_title); ?></h2>
					</div>
				</div>
			</div>
		<?php endif;?>
		<!-- Testimonial Page -->
		<?php if( $aneeq_testimonials_content_type == 'testimonial_page' ) : ?>
			<div class="testimonial">
				<?php $aneeq_page_testimonial_args = array (
					'post_type'     => 'page',
					'post_per_page' => count( $aneeq_testimonial_pages ),
					'post__in'      => $aneeq_testimonial_pages,
					'orderby'       =>'post__in',
				);  

				$aneeq_loop = new WP_Query($aneeq_page_testimonial_args);                        
				if ( $aneeq_loop->have_posts() ) :
					while ($aneeq_loop->have_posts()) : $aneeq_loop->the_post(); ?>  
					
					<?php if(has_post_thumbnail()):?>
						<div class="tpic">
							<?php the_post_thumbnail('full');?>
						</div>
					<?php endif; ?>
						<p class="description">
							<?php the_content(); ?>
						</p>
					<cite class="testimonial-title">
							<?php the_title(); ?>

						<?php if ( !empty($aneeq_testimonial_designation) )  :?>
							<small class="designation"><?php echo esc_html($aneeq_testimonial_designation); ?></small>
						<?php endif;?>
					</cite>
					<span class="site-url">
						<a href ="<?php echo esc_url($aneeq_testimonial_link); ?>" class="website">
							<?php echo esc_html($aneeq_testimonial_link); ?>
						</a>
					</span>
					
					<?php endwhile;?>
					<?php wp_reset_postdata(); ?>
				<?php endif;?>
			</div>
		<?php else: ?>
			<!-- Testimonial Post -->
			<div class="testimonial">
				<?php $aneeq_post_testimonial_args = array (
					'post_type'     => 'post',
					'post_per_page' => count( $aneeq_testimonial_posts ),
					'post__in'      => $aneeq_testimonial_posts,
					'orderby'       =>'post__in',
					'ignore_sticky_posts' => true,
				);  

				$aneeq_loop = new WP_Query($aneeq_post_testimonial_args);
				if ( $aneeq_loop->have_posts() ) :
					while ($aneeq_loop->have_posts()) : $aneeq_loop->the_post(); ?>
					
					<?php if(has_post_thumbnail()):?>
						<div class="tpic">
							<?php the_post_thumbnail('full');?>
						</div>
					<?php endif; ?>
						<p class="description">
							<?php the_content(); ?>
						</p>
					<cite class="testimonial-title">
						<?php if ( !empty($aneeq_testimonial_client_name ) ) : ?>
							<?php echo esc_html($aneeq_testimonial_client_name); ?>
						<?php endif;?>
						
						<?php if ( !empty($aneeq_testimonial_designation) )  :?>
							<small class="designation"><?php echo esc_html($aneeq_testimonial_designation); ?></small>
						<?php endif;?>
					</cite>
					<span class="site-url">
						<a href ="<?php echo esc_url($aneeq_testimonial_link); ?>" class="website">
							<?php echo esc_html($aneeq_testimonial_link); ?>
						</a>
					</span>
					
					<?php endwhile;?>
					<?php wp_reset_postdata(); ?>
				<?php endif;?>
			</div>
		<?php endif; ?>
	</div>
</section>
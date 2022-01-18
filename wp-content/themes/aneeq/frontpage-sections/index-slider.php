<?php 
/**
 * Template part for displaying Slider Section
 *
 *@package aneeq
 */
$aneeq_slider_content_type        = aneeq_get_option( 'aneeq_slider_content_type' );
$aneeq_number_of_slider_items     = aneeq_get_option( 'aneeq_number_of_slider_items' );

if( $aneeq_slider_content_type == 'slider_page' ) :
	for( $aneeq_i=1; $aneeq_i<=$aneeq_number_of_slider_items; $aneeq_i++ ) :
		$aneeq_slider_posts[] = aneeq_get_option( 'aneeq_slider_page_'.$aneeq_i );
	endfor;  
elseif( $aneeq_slider_content_type == 'slider_post' ) :
	for( $aneeq_i=1; $aneeq_i<=$aneeq_number_of_slider_items; $aneeq_i++ ) :
		$aneeq_slider_posts[] = aneeq_get_option( 'aneeq_slider_post_'.$aneeq_i );
	endfor;
endif;
?>
<!-- slider wrapper start -->
<div class="slider-wrapper">
	<!-- slider page -->
	<?php if( $aneeq_slider_content_type == 'slider_page' ) : ?>
		<div id="aneeq-slider" class="owl-carousel owl-theme">
			<?php $aneeq_page_slider_args = array (
				'post_type'     => 'page',
				'post_per_page' => count( $aneeq_slider_posts ),
				'post__in'      => $aneeq_slider_posts,
				'orderby'       =>'post__in',
			);  
			
			$aneeq_loop = new WP_Query($aneeq_page_slider_args);
			if ( $aneeq_loop->have_posts() ) :
				$aneeq_i=-1; $aneeq_j=0;  
				while ($aneeq_loop->have_posts()) : $aneeq_loop->the_post(); $aneeq_i++; $aneeq_j++;
				$aneeq_slider_buttons[$aneeq_j] = aneeq_get_option( 'aneeq_slider_button_'.$aneeq_j );
				
				$aneeq_class='';
				if ($aneeq_i==0) {
					$aneeq_class='display-block';
				} else{
					$aneeq_class='display-none';}
				?>
				<div class="item <?php echo esc_attr($aneeq_class); ?>">
					<?php the_post_thumbnail( 'full' ) ?>
					<div class="container slide-caption text-left">
						<div>
							<h1 class="slide-title"><?php the_title();?></h1>
						</div>
						<div class="slide-description">
						<?php
							$aneeq_excerpt = aneeq_the_excerpt( 30 );
							echo wp_kses_post( wpautop( $aneeq_excerpt ) ); 
						?>
						</div>
						<?php if( !empty( $aneeq_slider_buttons[$aneeq_j] ) ) : ?>
						<div class="slide-read-more btn-area">
							<a href="<?php the_permalink(); ?>" target="_blank" class="slide-btn"><?php echo esc_html( $aneeq_slider_buttons[$aneeq_j] );?></a>
						</div>
						<?php endif; ?>
					</div>
				</div>
				<?php endwhile;?>
				<?php wp_reset_postdata();
			endif;?>
		</div>
		
	<?php else : ?>
	<!-- slider post -->
		<div id="aneeq-slider" class="owl-carousel owl-theme">
			 <?php $aneeq_post_slider_args = array (
				'post_type'     => 'post',
				'post_per_page' => count( $aneeq_slider_posts ),
				'post__in'      => $aneeq_slider_posts,
				'orderby'       =>'post__in',
				'ignore_sticky_posts' => true,
			);
			
			$aneeq_loop = new WP_Query($aneeq_post_slider_args);
			if ( $aneeq_loop->have_posts() ) :
				$aneeq_i=-1; $aneeq_j=0;
				while ($aneeq_loop->have_posts()) : $aneeq_loop->the_post(); $aneeq_i++; $aneeq_j++;
				$aneeq_slider_buttons[$aneeq_j] = aneeq_get_option( 'aneeq_slider_button_'.$aneeq_j );
				
				$aneeq_class='';
				if ($aneeq_i==0) {
					$aneeq_class='display-block';
				} else{
					$aneeq_class='display-none';}
				?>
				<div class="item <?php echo esc_attr($aneeq_class); ?>">
					<?php the_post_thumbnail( 'full' ) ?>
					<div class="container slide-caption text-left">
						<div>
							<h1 class="slide-title"><?php the_title();?></h1>
						</div>
						<div class="slide-description">
							<?php
								$aneeq_excerpt = aneeq_the_excerpt( 30 );
								echo wp_kses_post( wpautop( $aneeq_excerpt ) ); 
							?>
						</div>
						 <?php if( !empty( $aneeq_slider_buttons[$aneeq_j] ) ) : ?>
						<div class="slide-read-more btn-area">
							<a href="<?php the_permalink(); ?>" target="_blank" class="slide-btn"><?php echo esc_html( $aneeq_slider_buttons[$aneeq_j] );?></a>
						</div>
						<?php endif; ?>
					</div>
				</div>
				<?php endwhile;?>
				<?php wp_reset_postdata();
			endif;?>
		</div>
	<?php endif; ?>
</div>
<!-- slider wrapper end -->
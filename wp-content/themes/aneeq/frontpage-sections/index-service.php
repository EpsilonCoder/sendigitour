<!-- service section start -->
<?php 
/**
 * Template part for displaying our_servicess Section
 *
 *@package aneeq
 */

    $aneeq_services_sec_title    		 = aneeq_get_option( 'aneeq_services_sec_title' );
    $aneeq_services_content_type         = aneeq_get_option( 'aneeq_services_content_type' );
    $aneeq_number_of_items               = aneeq_get_option( 'aneeq_number_of_items' );

    if( $aneeq_services_content_type == 'services_page' ) :
        for( $aneeq_i=1; $aneeq_i<=$aneeq_number_of_items; $aneeq_i++ ) :
            $aneeq_services_pages[] = aneeq_get_option( 'aneeq_services_page_'.$aneeq_i );
        endfor;  
    elseif( $aneeq_services_content_type == 'services_post' ) :
        for( $aneeq_i=1; $aneeq_i<=$aneeq_number_of_items; $aneeq_i++ ) :
            $aneeq_services_posts[] = aneeq_get_option( 'aneeq_services_post_'.$aneeq_i );
        endfor;
    endif;
?>
	<section class="service-section">
	
		<?php if( !empty($aneeq_services_sec_title) ): ?>
		<div class="container">
			<div class="row">
				<div class="col-md-12 col-xs-12">
					<div class="dividerHeading">
						<h2 class="section-title"><?php echo esc_html($aneeq_services_sec_title);?></h2>
					</div>
				</div>
			</div>
		</div>
		<?php endif;?>
		<!-- Service Page -->
		<?php if( $aneeq_services_content_type == 'services_page' ) : ?>
			<div class="container">
				<?php $aneeq_page_service_args = array (
					'post_type'     => 'page',
					'post_per_page' => count( $aneeq_services_pages ),
					'post__in'      => $aneeq_services_pages,
					'orderby'       =>'post__in',
				);  

				$aneeq_loop = new WP_Query($aneeq_page_service_args);
				if ( $aneeq_loop->have_posts() ) :
				$aneeq_i=-1; $aneeq_j=0;  
					while ($aneeq_loop->have_posts()) : $aneeq_loop->the_post(); $aneeq_i++; $aneeq_j++;
					$aneeq_services_icons[$aneeq_j] = aneeq_get_option( 'aneeq_services_icon_'.$aneeq_j ); ?>
						<div class="col-md-4 col-sm-6 col-xs-12">
							<div class="serviceBox_2">
								<?php if( !empty( $aneeq_services_icons[$aneeq_j] ) ) : ?>
									<div class="service-icon">
										<i class="<?php echo esc_attr( $aneeq_services_icons[$aneeq_j] )?>"></i>
									</div>
								<?php endif; ?>
								<div class="service-content">
									<h3 class="service-title"><a href="<?php the_permalink();?>"><?php the_title();?></a></h3>
									<?php
										$aneeq_excerpt = aneeq_the_excerpt( 20 );
										echo wp_kses_post( wpautop( $aneeq_excerpt ) );
									?>
								</div>
							</div>
						</div>
					<?php endwhile;?>
				<?php wp_reset_postdata(); ?>
				<?php endif;?>
			</div>
			
		<?php else: ?>
			<!-- Service Post -->
			<div class="container">
				<?php $aneeq_post_service_args = array (
					'post_type'     => 'post',
					'post_per_page' => count( $aneeq_services_posts ),
					'post__in'      => $aneeq_services_posts,
					'orderby'       =>'post__in',
					'ignore_sticky_posts' => true,
				);  

				$aneeq_loop = new WP_Query($aneeq_post_service_args);
				if ( $aneeq_loop->have_posts() ) :
				$aneeq_i=-1; $aneeq_j=0;  
					while ($aneeq_loop->have_posts()) : $aneeq_loop->the_post(); $aneeq_i++; $aneeq_j++;
					$aneeq_services_icons[$aneeq_j] = aneeq_get_option( 'aneeq_services_icon_'.$aneeq_j ); ?>  
						<div class="col-md-4 col-sm-6 col-xs-12">
							<div class="serviceBox_2">
								<?php if( !empty( $aneeq_services_icons[$aneeq_j] ) ) : ?>
									<div class="service-icon">
										<i class="<?php echo esc_attr( $aneeq_services_icons[$aneeq_j] )?>"></i>
									</div>
								<?php endif; ?>
								<div class="service-content">
									<h3 class="service-title"><a href="<?php the_permalink();?>"><?php the_title();?></a></h3>
									<?php
										$aneeq_excerpt = aneeq_the_excerpt( 20 );
										echo wp_kses_post( wpautop( $aneeq_excerpt ) );
									?>
								</div>
							</div>
						</div>
					<?php endwhile;?>
				<?php wp_reset_postdata(); ?>
				<?php endif;?>
			</div>
		<?php endif;?>
	</section>
<!-- service section end -->
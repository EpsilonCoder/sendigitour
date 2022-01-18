<?php 
/**
 * Template part for displaying Woo Section
 *
 *@package aneeq
 */
 
if ( class_exists( 'WooCommerce' ) ) {
	$aneeq_woo_section_title   = aneeq_get_option( 'aneeq_woo_section_title' );
	get_header(); ?>

	<section class="section-woocommerce">
		<div class="container">
			<?php if( !empty($aneeq_woo_section_title) ):?>
			<div class="row">
				<div class="col-md-12 col-xs-12">
					<div class="dividerHeading">
						<h2 class="woo-title"><?php echo esc_html($aneeq_woo_section_title);?></h2> 
					</div>
				</div>
			</div>
			<?php endif;?>
			
			<div class="row super_sub_content">
				<?php
					$aneeq_woo_args = array(
						'posts_per_page' => 3,				
						'post_type' 	 => 'product',
						'post_status'	 => 'publish',
						'paged' => 1,
						);
					
					// Fetch posts.
					$aneeq_the_query = new WP_Query( $aneeq_woo_args );
				?>
				
				<?php if ( $aneeq_the_query->have_posts() ) : 			
					while ( $aneeq_the_query->have_posts() ) : $aneeq_the_query->the_post(); global $product; ?>
			
					<div id="wooproduct-slider" class="col-md-4 col-sm-6 col-xs-12">
						<div class="products woocommerce-post-slide">
							<div class="item-img">
								<a href="<?php the_permalink(); ?>" title="" tabindex="-1">
									<?php the_post_thumbnail('woocommerce_thumbnail'); ?>
									<?php if ( $product->is_on_sale() ) : ?>

									<?php echo apply_filters( 'aneeq_woocommerce_sale_flash', '<span class="onsale">' . esc_html__( 'On Sale!', 'aneeq' ) . '</span>', $post, $product ); ?>
									<?php endif; ?>

									<div class="add-to-cart">
										<?php woocommerce_template_loop_add_to_cart( $aneeq_loop->post, $product ); ?>
									</div>
								</a>
							</div>
						
							<!-- hide ratting div if no rating added-->
							<?php if($product->get_average_rating()) { ?>
							<ul class="woocommerce rating">
								<li>
									<?php if ($aneeq_average = $product->get_average_rating()) : ?>
									<?php echo '<div class="star-rating" title="'.sprintf(__( 'Rated %s out of 5', 'aneeq' ), $aneeq_average).'"><span style="width:'.( ( $aneeq_average / 5 ) * 100 ) . '%"><strong itemprop="ratingValue" class="rating">'.$aneeq_average.'</strong> '.__( 'out of 5', 'aneeq' ).'</span></div>'; ?>
									<?php endif; ?>
								</li>
							</ul>
							<?php } ?>

							<h3><a href="<?php the_permalink(); ?>" title="" tabindex="-1"><?php the_title(); ?></a></h3>
							<span class="price"><?php echo $product->get_price_html(); ?></span>
						</div>
					</div>	
					<?php endwhile;?>
					<?php wp_reset_postdata(); ?>
				<?php endif;?>
			</div>
		</div>
	</section>
	<!-- Woo commerce Section -->
	<div class="clearfix"></div>
<?php } ?>
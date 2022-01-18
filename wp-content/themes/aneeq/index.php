<?php get_header(); ?>
        <!-- Breadcrumbs-->
			<?php get_template_part('breadcrumb'); ?>
		<!-- Breadcrumbs index.php file-->

		<section id="main-content" class="content right_sidebar" <?php post_class(); ?>>
			<div class="container">
				<div class="row">
					<?php
					// Intialize Variable
					$aneeq_layout_style = "col-md-12 col-sm-12 col-xs-12";
					$aneeq_page_layout_style = get_theme_mod('aneeq_page_layout_style', 'rightsidebar');
					
					// Check Sidebar Column Condition
					if( $aneeq_page_layout_style == "rightsidebar" || $aneeq_page_layout_style == "leftsidebar" && is_active_sidebar( 'sidebar-widget' )  ) {
						$aneeq_layout_style = "col-md-8 col-sm-6 col-xs-12";
					}
					?>
					<?php if($aneeq_page_layout_style == "leftsidebar") { ?>
						<?php if ( is_active_sidebar( 'sidebar-widget' ) ) { ?>
							<!--Sidebar Widget-->
							<div class="col-md-4 col-sm-6 col-xs-12">
								<div class="sidebar">
									<?php dynamic_sidebar('sidebar-widget') ?>
								</div>
							</div>
						<?php } ?>
					<?php } ?>
					<div class="<?php echo esc_attr($aneeq_layout_style); ?>">
						<div class="blog_large">
							<?php
							if(have_posts()) :
								while (have_posts()) : the_post();
									$aneeq_url = wp_get_attachment_url( get_post_thumbnail_id($post->ID), 'thumbnail' ); 						
									?>
									<article class="post">	
										<?php if($aneeq_url != NULL) {  ?>
											<figure class="post_img">
												<a href="<?php the_permalink(); ?>">
													<?php the_post_thumbnail('full');  ?>
												</a>
											</figure>
										<?php } ?>
										<div class="post_date">
											<span class="day"><?php echo get_the_date('j'); ?></span>
											<span class="month"><?php echo get_the_date('M'); ?></span>
										</div>
										<div class="post_content">
											<div class="post_meta">
												<h2>
													<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
												</h2>
												<div class="metaInfo">
													<span><i class="fa fa-user"></i> <?php esc_html_e('By','aneeq') ?> <a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>"><?php the_author(); ?></a> </span>
													<?php
													if( get_the_tags() ){
														echo '<span><i class="fa fa-tag"></i> <a href="#">';
														ucwords( the_tags( '',', ','' ) );
														echo '</a> </span>';
													} ?>
												</div>
											</div>
											<?php the_content(); ?>
										</div>
									</article>
									<?php 	
								endwhile;
							endif;
							// Reset Post Data
							wp_reset_postdata();
							?>
						</div>
						<div style="text-align: center;" class="col-lg-12 col-md-12 col-sm-12">
							<?php 	
								the_posts_pagination( array(
									'type'		=> 'list',						
									'mid_size'  => 2,
									'prev_text' => __( 'Back', 'aneeq' ),
									'next_text' => __( 'Next', 'aneeq' ),
								) ); 
							?>
						</div>
					</div>
					<?php if($aneeq_page_layout_style == "rightsidebar") { ?>
						<?php if ( is_active_sidebar( 'sidebar-widget' ) ) { ?>
							<!--Sidebar Widget-->
							<div class="col-md-4 col-sm-6 col-xs-12">
								<div class="sidebar">
									<?php dynamic_sidebar('sidebar-widget') ?>
								</div>
							</div>
						<?php } ?>
					<?php } ?>
				</div>
			</div>
		</section>
<?php get_footer(); ?>
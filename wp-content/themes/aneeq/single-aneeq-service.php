<?php
/**
 * Single Blog Post File
 */
?>
<?php get_header();	?>
	<!-- Breadcrumbs -->
		<?php get_template_part('breadcrumb'); ?>
	<!-- Breadcrumbs -->
	
	<section class="site-content">
		<div class="container">
			<div class="row">
				<?php
				// Intialize Variable
				$aneeq_layout_style = "col-md-12 col-sm-12 col-xs-12";
				$aneeq_page_layout_style = get_theme_mod('aneeq_blog_single_page_layout', 'fullwidth');
				
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
					<div class="blog_single blog_large">
						<?php
						if(have_posts()) :
							while (have_posts()) : the_post(); ?>
								<article class="post">
									<div class="post_date">
										<span class="day"><?php echo get_the_date('j'); ?></span>
										<span class="month"><?php echo get_the_date('M'); ?></span>
									</div>
									<div class="post_content">
										<div class="post_meta">
											<h2>
												<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
											</h2>
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
			</div><!--/.row-->
		</div> <!--/.container-->
	</section>

<?php get_footer(); ?>
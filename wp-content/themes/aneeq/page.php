<?php get_header(); ?>
	<!-- Breadcrumbs-->
		<?php get_template_part('breadcrumb'); ?>
	<!-- Breadcrumbs page.php file -->

	<section id="main-content" class="content right_sidebar">
		<div class="container">
			<div class="row">
				<?php
				// Intialize Variable
				$aneeq_layout_style = "col-md-12 col-sm-12 col-xs-12";
				$aneeq_general_page_layout = get_theme_mod('aneeq_general_page_layout', 'fullwidth');
				
				// Check Sidebar Column Condition
				if( $aneeq_general_page_layout == "rightsidebar" || $aneeq_general_page_layout == "leftsidebar" && is_active_sidebar( 'sidebar-widget' )  ) {
					$aneeq_layout_style = "col-md-8 col-sm-6 col-xs-12";
				}
				?>
				<?php if($aneeq_general_page_layout == "leftsidebar") { ?>
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
								?>
								<article>
									<?php the_content(); ?>
								</article>
								<?php 	
							endwhile;
							// Reset Post Data
							wp_reset_postdata();
						endif;					
						?>
					</div>
				</div>
				<?php if($aneeq_general_page_layout == "rightsidebar") { ?>
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
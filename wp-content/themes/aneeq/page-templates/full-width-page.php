<?php
/**
 *
 * Template Name: Full Width Page
 *
 */

get_header();
?>
	<section id="main-content" class="content">
		<div class="container">
			<div class="row">
				<div class="col-md-12 col-sm-6 col-xs-12">
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
			</div>
		</div>
	</section>
<?php
get_footer();

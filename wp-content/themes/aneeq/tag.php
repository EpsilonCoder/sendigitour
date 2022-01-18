<?php /*
	Tag Archive
*/ ?>
<?php get_header(); ?>

	<!--breadcrumb section start-->
	<section class="page_head">
		<div class="container">
			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12">
					<div class="page_title">
						<h2><?php esc_html_e('Tag Archive', 'aneeq') ?> : <?php single_tag_title(); ?></h2>
					</div>
					<nav id="breadcrumbs">
						<ul>
							<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e('Home', 'aneeq'); ?></a>/</li>
							<li><?php single_tag_title(); ?></li>
						</ul>
					</nav>
				</div>
			</div>
		</div>
	</section>
	<div class="navigation">
		<div class="alignleft"><?php next_posts_link( 'Prev Older Entries', 'aneeq' ); ?></div>
		<div class="alignright"><?php previous_posts_link( 'Newer Entries Next', 'aneeq' ); ?></div>
	</div>
	<!--breadcrumb section End-->
	<section class="site-content">
		<div class="container">
			<div class="row">
				<div class="col-md-8 col-sm-8 col-xs-12">
					<div class="blog_large">
						<?php
						// Fetch All Post 
						if( have_posts()) :
							while ( have_posts()) : the_post();
							
							$aneeq_post_slide = get_post_meta( $post->ID, 'aneeq_all_post_slides_settings_'.$post->ID, true);
							//blog option settings
							$aneeq_option_settings = get_option('aneeq_blog_settings');
							//feature img url
							$aneeq_url = wp_get_attachment_url( get_post_thumbnail_id($post->ID), 'thumbnail' ); 
						?>
							<article class="post">							
								<figure class="post_img">
									<a href="<?php the_permalink(); ?>">
										<?php if($aneeq_url != NULL) { the_post_thumbnail(); } ?>
									</a>
								</figure>							
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
											<span><i class="fa fa-user"></i> <?php esc_html_e('By', 'aneeq') ?> <a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>"><?php the_author(); ?></a> </span>
											<?php if (has_category()) : ?>	
												<span><i class="fa fa-th-list"></i>
													<a href="#"><?php the_category('&nbsp;,&nbsp');?></a> 
												</span>
											<?php endif; ?>
											<?php
											if( get_the_tags() ){
												echo '<span><i class="fa fa-tag"></i> <a href="#">';
												ucwords( the_tags( '',', ','' ) );
												echo '</a> </span>';
											} ?>
											<span><i class="fa fa-comments"></i> <a href="<?php comments_link(); ?>"> <?php comments_number( 'No Comments', '1 Comment', '% Comments' ); ?></a></span>
										</div>
									</div>
									<?php the_content(); ?>
								</div>
							</article>
						<?php
							endwhile;
							// Reset Post Data
							wp_reset_postdata();
						endif;
						?>
					</div>
					<div style="text-align: center;" class="col-md-12 col-sm-12 col-xs-12">
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
				<!--Sidebar Widget-->
				<div class="col-md-4 col-sm-4 col-xs-12">
					<div class="sidebar">
						<?php dynamic_sidebar('sidebar-widget') ?>
					</div>
				</div>
				<!--Sidebar Widget-->
			</div>
		</div>					
	</section>
<?php get_footer(); ?>
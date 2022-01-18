<?php
/**
 * Single Blog Post File
 */
?>
<?php get_header();	?>
	<!-- Breadcrumbs -->
		<?php get_template_part('breadcrumb'); ?>
	<!-- Breadcrumbs  -->
	
	<!-- Single.php File  -->
	<section id="main-content" class="site-content">
		<div class="container">
			<div class="row">
				<?php
				// Intialize Variable
				$aneeq_layout_style = "col-md-12 col-sm-12 col-xs-12";
 				$aneeq_blog_single_page_layout = get_theme_mod('aneeq_blog_single_page_layout', 'fullwidth');
				
				// Check Sidebar Column Condition
				if( $aneeq_blog_single_page_layout == "rightsidebar" || $aneeq_blog_single_page_layout == "leftsidebar" && is_active_sidebar( 'sidebar-widget' )  ) {
					$aneeq_layout_style = "col-md-8 col-sm-6 col-xs-12";
				}
				?>
				<?php if($aneeq_blog_single_page_layout == "leftsidebar") { ?>
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
							while (have_posts()) : the_post();
						
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
														<a href="#"><?php the_category('&nbsp;,&nbsp'); ?></a> 
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
										<?php
										//Fetch content
										the_content(); 
										//page link
										wp_link_pages(); 
										?>
									</div>
								</article>
								<div class="about_author">
									<div class="author_desc">
										<?php $aneeq_user = wp_get_current_user(); ?>
										<img src="<?php echo esc_url(get_avatar_url( get_the_author_meta( 'ID' ), 32 )); ?>" alt="about author">
									</div>
									<div class="author_bio">
										<h3 class="author_name"><a href="#"><?php the_author(); ?></a></h3>
										<h4><?php echo esc_html(get_the_author_meta( 'user_email' )); ?></h4>
										<p class="author_det">
											<?php 
											if( get_the_author_meta( 'description' ) ){
												echo wpautop( get_the_author_meta( 'description' ) ); 
											} else {
												echo "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. ";
											}										
											?>
										</p>
									</div>
								</div>
								<nav class="post-nav">
									<ul class="pager">
										<li class="previous"><?php previous_post_link( '%link', __( '&laquo; Prev Post', 'aneeq' ) ); ?></li>
										<li class="next"><?php next_post_link( '%link', __( 'Next Post &raquo;', 'aneeq' ) ); ?></li>
									</ul>
								</nav>
								<?php 	
								//get comments
								if ( is_singular() ) wp_enqueue_script( "comment-reply" );
								comments_template();
								
								paginate_comments_links( array(
									'prev_text' => __('&laquo','aneeq'),
									'next_text' => __('&raquo','aneeq')
								) );
							endwhile;
						endif;
						// Reset Post Data
						wp_reset_postdata();
						?>
					</div>
				</div>
				<?php if($aneeq_blog_single_page_layout == "rightsidebar") { ?>
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
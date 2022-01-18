<div class="main-container">
	
	<?php
	
	// Category Description
	if ( is_category() ) {
		get_template_part( 'templates/grid/category', 'description' );
	}

	// Blog Grid
	echo '<ul class="blog-grid">';
	
	if ( have_posts() ) :

		// Loop Start
		while ( have_posts() ) :

			the_post();

			// if is preview (boat post)
			if ( ! ( ashe_is_preview() && get_the_ID() == 19 ) ) :

			$post_class = ( true == ashe_options('blog_page_show_dropcaps') ) ? 'blog-post clear-fix ashe-dropcaps' : 'blog-post clear-fix';

			echo '<li>';

			?>
			<article id="post-<?php the_ID(); ?>" <?php post_class($post_class); ?>>
				
				<div class="post-media">
					<a href="<?php echo esc_url( get_permalink() ); ?>"></a>
					<?php the_post_thumbnail('ashe-list-thumbnail'); ?>
				</div>

				<div class="post-content-wrap">
					<header class="post-header">

				 		<?php

						$category_list = get_the_category_list( ',&nbsp;&nbsp;' );

						if ( ashe_options( 'blog_page_show_categories' ) === true && $category_list ) {
							echo '<div class="post-categories">' . $category_list . ' </div>';
						}

						?>

						<?php if ( get_the_title() ) : ?>
						<h2 class="post-title">
							<a href="<?php esc_url( the_permalink() ); ?>"><?php the_title(); ?></a>
						</h2>
						<?php endif; ?>
						
						<?php if ( ashe_options( 'blog_page_show_author' ) || ashe_options( 'blog_page_show_date' ) || ashe_options( 'blog_page_show_comments' ) ) : ?>
						<div class="post-meta clear-fix">

							<?php if ( ashe_options( 'blog_page_show_author' ) === true ) : ?>
							<span class="post-author"><?php the_author_posts_link(); ?></span>
							<?php endif; ?>

							<?php if ( ashe_options( 'blog_page_show_date' ) === true ) : ?>			
							<span class="meta-sep">/</span>
							<span class="post-date"><?php the_time( get_option( 'date_format' ) ); ?></span>
							<?php endif; ?>

							<?php if ( ashe_options( 'blog_page_show_comments' ) === true && comments_open() ) : ?>
							<span class="meta-sep">/</span>
								<?php comments_popup_link( esc_html__( '0 Comments', 'ashe' ), esc_html__( '1 Comment', 'ashe' ), '% '. esc_html__( 'Comments', 'ashe' ), 'post-comments'); ?>
							<?php endif; ?>
							
						</div>
						<?php endif; ?>
						
					</header>

					<?php if ( ashe_options( 'blog_page_post_description' ) !== 'none' ) : ?>

					<div class="post-content">
						<?php

						if ( ashe_options( 'blog_page_post_description' ) === 'content' ) {
							the_content('');
						} elseif ( ashe_options( 'blog_page_post_description' ) === 'excerpt' ) {
							ashe_excerpt( 33 );												
						}
						
						?>
					</div>

					<?php endif; ?>

					<div class="read-more">
						<a href="<?php echo esc_url( get_permalink() ); ?>"><?php esc_html_e( 'read more','ashe' ); ?></a>
					</div>

					<?php ashe_post_sharing(); ?>
					
				</div>

			</article>

			<?php

			echo '</li>';

			endif;

		endwhile; // Loop End

	else:

	?>

	<div class="no-result-found">
		<h3><?php esc_html_e( 'Nothing Found!', 'ashe' ); ?></h3>
		<p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'ashe' ); ?></p>
		<div class="ashe-widget widget_search">
			<?php get_search_form(); ?>
		</div> 
		
	</div>

	<?php
	
	endif; // have_posts()

	echo '</ul>';

	?>

	<?php get_template_part( 'templates/grid/blog', 'pagination' ); ?>

</div><!-- .main-container -->
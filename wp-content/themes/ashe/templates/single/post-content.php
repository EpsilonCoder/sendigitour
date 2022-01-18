<?php $post_class = ( true == ashe_options('blog_page_show_dropcaps') ) ? 'blog-post ashe-dropcaps' : 'blog-post'; ?>

<article id="post-<?php the_ID(); ?>" <?php post_class($post_class); ?>>

<?php

if ( have_posts() ) :

	// Loop Start
	while ( have_posts() ) :

		the_post();

?>	



	<?php if ( ashe_options( 'single_page_show_featured_image' ) === true ) : ?>
	<div class="post-media">
		<?php the_post_thumbnail('ashe-full-thumbnail'); ?>
	</div>
	<?php endif; ?>

	<header class="post-header">

		<?php

		$category_list = get_the_category_list( ',&nbsp;&nbsp;' );
		if ( ashe_options( 'single_page_show_categories' ) === true && $category_list ) {
			echo '<div class="post-categories">' . $category_list . ' </div>';
		}

		?>

		<?php if ( get_the_title() ) : ?>
		<h1 class="post-title"><?php the_title(); ?></h1>
		<?php endif; ?>

		<?php if ( ashe_options( 'single_page_show_date' ) || ashe_options( 'single_page_show_comments' ) ) : ?>
		<div class="post-meta clear-fix">

			<?php if ( ashe_options( 'single_page_show_date' ) === true ) : ?>
				<span class="post-date"><?php the_time( get_option( 'date_format' ) ); ?></span>
			<?php endif; ?>
			
			<span class="meta-sep">/</span>
			
			<?php
			if ( ashe_post_sharing_check() && ashe_options( 'single_page_show_comments' ) === true ) {
				comments_popup_link( esc_html__( '0 Comments', 'ashe' ), esc_html__( '1 Comment', 'ashe' ), '% '. esc_html__( 'Comments', 'ashe' ), 'post-comments');
			}
			?>

		</div>
		<?php endif; ?>

	</header>

	<div class="post-content">

		<?php

		// The Post Content
		the_content('');

		// Post Pagination
		$defaults = array(
			'before' => '<p class="single-pagination">'. esc_html__( 'Pages:', 'ashe' ),
			'after' => '</p>'
		);

		wp_link_pages( $defaults );

		?>
	</div>

	<footer class="post-footer">

		<?php 

		// The Tags
		$tag_list = get_the_tag_list( '<div class="post-tags">','','</div>');
		
		if ( $tag_list ) {
			echo ''. $tag_list;
		}

		?>

		<?php if ( ashe_options( 'single_page_show_author' ) === true ) : ?>
		<span class="post-author"><?php esc_html_e( 'By', 'ashe' ); ?>&nbsp;<?php the_author_posts_link(); ?></span>
		<?php endif; ?>

		<?php
			
		if ( ashe_post_sharing_check() ) {
			ashe_post_sharing();
		} else if ( ashe_options( 'single_page_show_comments' ) === true ) {
			comments_popup_link( esc_html__( '0 Comments', 'ashe' ), esc_html__( '1 Comment', 'ashe' ), '% '. esc_html__( 'Comments', 'ashe' ), 'post-comments');
		}

		?>
		
	</footer>

<?php

	endwhile; // Loop End
endif; // have_posts()

?>

</article>
<?php 

global $paged;
global $wp_query;
$pages = $wp_query->max_num_pages;
$range = 2;
$showitems = ( $range * 2 ) + 1;
$post_pagination = ashe_options( 'blog_page_post_pagination' );

if ( empty( $paged ) ) {
	$paged = 1;
}

if ( ! $pages ) {
	$pages = 1;
}

if ( $pages == 1 ) {
	return;
}

// Check for WooCommerce
if ( class_exists( 'WooCommerce' ) ) {
	if ( is_shop() ) {
		$post_pagination = 'numeric';
	}
}

?>

<nav class="blog-pagination clear-fix <?php echo esc_attr( $post_pagination ); ?>" data-max-pages="<?php echo esc_attr( $wp_query->max_num_pages ); ?>" data-loading="<?php esc_attr_e( 'Loading...', 'ashe' ); ?>" >

<?php

// Numeric Pagination
if ( $post_pagination === 'numeric' ) {

	//  Previous Page
	if ( $paged > 1 ) {
		echo '<a href="'. esc_url( get_pagenum_link( $paged - 1 ) ) .'" class="numeric-prev-page" ><i class="fa fa-long-arrow-left"></i></a>';
	}
	
	// Pagination
	for ( $i = 1; $i <= $pages; $i++ ) {
		if ( 1 != $pages &&( !( $i >= $paged + $range + 1 || $i <= $paged - $range - 1 ) || $pages <= $showitems ) ) {
			if ( $paged == $i ) {
				echo '<span class="numeric-current-page">'. $i .'</span>';
			} else {
				echo '<a href="'. esc_url( get_pagenum_link( $i ) ). '">'. $i .'</a>';
			}
		}
	}

	// Next Page
	if ( $paged < $pages ) {
		echo '<a href="'. esc_url( get_pagenum_link( $paged + 1 ) ).'" class="numeric-next-page" ><i class="fa fa-long-arrow-right"></i></a>';
	}

// Default Pagination
} elseif ( $post_pagination === 'default' ) {

	if ( get_next_posts_link() ) {
		echo '<div class="previous-page">';
			next_posts_link( '<i class="fa fa-long-arrow-left"></i>&nbsp;'.esc_html__( 'Older Posts', 'ashe' ) );
		echo '</div>';
	}
	
	if ( get_previous_posts_link() ) {
		echo '<div class="next-page">';
			previous_posts_link( esc_html__( 'Newer Posts', 'ashe' ).'&nbsp;<i class="fa fa-long-arrow-right"></i>' );
		echo '</div>';
	}

// Load More / Infinite Scroll
} else {
	next_posts_link( esc_html__( 'Load More', 'ashe' ) );
}

?>

</nav>
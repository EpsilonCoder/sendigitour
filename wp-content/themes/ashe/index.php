<?php 

get_header();

if ( is_home() ) {

	// Featured Slider, Carousel
	if ( ashe_options( 'featured_slider_label' ) === true && ashe_options( 'featured_slider_location' ) !== 'front' ) {
		if ( ashe_options( 'featured_slider_source' ) === 'posts' ) {
			get_template_part( 'templates/header/featured', 'slider' );
		} else {
			get_template_part( 'templates/header/featured', 'slider-custom' );
		}
	}

	// Featured Links, Banners
	if ( ashe_options( 'featured_links_label' ) === true && ashe_options( 'featured_links_location' ) !== 'front' ) {
		get_template_part( 'templates/header/featured', 'links' ); 
	}

}

?>

<div class="main-content clear-fix<?php echo esc_attr(ashe_options( 'general_content_width' )) === 'boxed' ? ' boxed-wrapper': ''; ?>" data-layout="<?php echo esc_attr( ashe_options( 'general_home_layout' ) ); ?>" data-sidebar-sticky="<?php echo esc_attr( ashe_options( 'general_sidebar_sticky' ) ); ?>">
	
	<?php
	
	// Sidebar Left
	get_template_part( 'templates/sidebars/sidebar', 'left' ); 

	// Blog Feed Wrapper
	if ( strpos( ashe_options( 'general_home_layout' ), 'list' ) === 0 ) {
		get_template_part( 'templates/grid/blog', 'list' );
	} else {
		get_template_part( 'templates/grid/blog', 'grid' );
	}

	// Sidebar Right
	get_template_part( 'templates/sidebars/sidebar', 'right' ); 

	?>

</div>

<?php get_footer(); ?>
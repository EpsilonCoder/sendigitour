<?php

// check if available
if ( ashe_options( 'main_nav_show_sidebar' ) === false || ashe_options( 'main_nav_label' ) === false ) {
	return;
}

?>

<div class="sidebar-alt-wrap">
	<div class="sidebar-alt-close image-overlay"></div>
	<aside class="sidebar-alt">

		<div class="sidebar-alt-close-btn">
			<span></span>
			<span></span>
		</div>

		<?php

		if ( ashe_is_preview() ) {
			ashe_preview_alt_sidebar();
		} else {
			if ( ! is_active_sidebar( 'sidebar-alt' ) ) {
				echo '<div ="ashe-widget"><p>'. esc_html__( 'No Widgets found in the Sidebar Alt!', 'ashe' ) .'</p></div>';
			} else {
				dynamic_sidebar( 'sidebar-alt' );
			}
		}

		?>
		
	</aside>
</div>